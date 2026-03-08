<?php

namespace App\Http\Controllers\Creator;

use App\Http\Controllers\Controller;
use App\Models\Sale;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class SalesController extends Controller
{
    public function index()
    {
        $sales = Sale::where('seller_id', Auth::id())
            ->with(['product', 'buyer'])
            ->latest()
            ->paginate(10);

        return view('Creator.sales', compact('sales'));
    }

    /**
     * Display pending escrow payments for the creator
     */
    public function escrow()
    {
        $pendingSales = Sale::where('seller_id', Auth::id())
            ->where('status', 'escrow_locked')
            ->with(['product', 'buyer'])
            ->latest()
            ->paginate(10);

        $completedSales = Sale::where('seller_id', Auth::id())
            ->where('status', 'completed')
            ->with(['product', 'buyer'])
            ->latest()
            ->take(5)
            ->get();

        $totalPending = Sale::where('seller_id', Auth::id())
            ->where('status', 'escrow_locked')
            ->sum('amount');

        return view('Creator.escrow', compact('pendingSales', 'completedSales', 'totalPending'));
    }

    /**
     * Ensure seller is registered as FedaPay customer
     */
    private function ensureSellerIsRegistered($seller)
    {
        try {
            \FedaPay\FedaPay::setApiKey(config('fedapay.secret_key'));
            \FedaPay\FedaPay::setEnvironment(config('fedapay.environment'));

            // Create a customer record for the seller in FedaPay
            // This ensures the seller can receive payouts
            $phoneNumber = trim($seller->phone_number);
            $phoneNumber = preg_replace('/^\+?(229)?/', '', $phoneNumber);
            if (str_starts_with($phoneNumber, '0')) {
                $phoneNumber = substr($phoneNumber, 1);
            }

            $fedaPayCustomer = \FedaPay\Customer::create([
                'firstname' => $seller->firstname,
                'lastname' => $seller->lastname,
                'email' => $seller->email,
                'phone_number' => [
                    'number' => '+229' . $phoneNumber,
                    'country' => $seller->country,
                ],
            ]);

            \Illuminate\Support\Facades\Log::info("FedaPay customer created/verified for seller #{$seller->id}, Customer ID: {$fedaPayCustomer->id}");
            return $fedaPayCustomer;
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::warning("Could not create/verify FedaPay customer for seller #{$seller->id}: " . $e->getMessage());
            // Continue anyway, FedaPay might auto-create
            return null;
        }
    }

    /**
     * Confirm delivery and release the escrow payment
     */
    public function confirmDelivery(Sale $sale)
    {
        // Make sure this sale belongs to the authenticated creator
        if ($sale->seller_id !== Auth::id()) {
            return redirect()
                ->route('creator.escrow')
                ->with('error', 'Action non autorisée.');
        }

        if ($sale->status !== 'escrow_locked') {
            return redirect()
                ->route('creator.escrow')
                ->with('error', "Ce paiement n'est pas en attente.");
        }

        // We use simulated payout because FedaPay requires special authorization for real payouts
        return $this->processSimulatedPayout($sale);
    }

    /**
     * Simulated payout logic with platform commission
     */
    private function processSimulatedPayout(Sale $sale)
    {
        try {
            $amount = $sale->amount;
            $commissionRate = 0.02;  // 2%
            $commissionAmount = $amount * $commissionRate;
            $netAmount = $amount - $commissionAmount;

            $seller = $sale->seller;

            Log::info('--- SIMULATED PAYOUT START ---');
            Log::info("Sale ID: #{$sale->id}");
            Log::info("Product: {$sale->product->nom}");
            Log::info("Seller: {$seller->firstname} {$seller->lastname} (#{$seller->id})");
            Log::info("Buyer ID: #{$sale->buyer_id}");
            Log::info('Gross Amount: ' . number_format($amount, 0) . ' XOF');
            Log::info('Platform Commission (2%): ' . number_format($commissionAmount, 0) . ' XOF');
            Log::info('Net Amount to Seller: ' . number_format($netAmount, 0) . ' XOF');
            Log::info('--- SIMULATED PAYOUT END ---');

            // Update sale status
            $sale->update(['status' => 'completed']);

            return redirect()
                ->route('creator.escrow')
                ->with('success', 'Livraison confirmée (Simulation) ! Le paiement de ' . number_format($netAmount, 0) . ' XOF (après 2% de commission) a été libéré sur votre compte fictif.');
        } catch (\Exception $e) {
            Log::error("Simulated Payout Error for sale #{$sale->id}: " . $e->getMessage());
            return redirect()
                ->route('creator.escrow')
                ->with('error', 'Erreur lors de la simulation du virement : ' . $e->getMessage());
        }
    }

    /**
     * Original FedaPay payout logic (kept for future use)
     */
    private function processFedaPayPayout(Sale $sale)
    {
        // Configure FedaPay
        \FedaPay\FedaPay::setApiKey(config('fedapay.secret_key'));
        \FedaPay\FedaPay::setEnvironment(config('fedapay.environment'));

        try {
            $seller = $sale->seller;

            // Validate that seller has required payout information
            if (!$seller->phone_number) {
                Log::warning("Payout blocked for sale #{$sale->id}: Seller #{$seller->id} has no phone number");
                return redirect()
                    ->route('creator.escrow')
                    ->with('error', 'Impossible de traiter le paiement : votre numéro de téléphone est manquant.');
            }

            // Clean phone number
            $phoneNumber = trim($seller->phone_number);
            $phoneNumber = preg_replace('/^\+?(229)?/', '', $phoneNumber);
            if (str_starts_with($phoneNumber, '0')) {
                $phoneNumber = substr($phoneNumber, 1);
            }
            $fullPhoneNumber = '+229' . $phoneNumber;

            Log::info("Attempting real FedaPay payout for sale #{$sale->id}");

            // First, try to create the customer in FedaPay
            $this->ensureSellerIsRegistered($seller);

            $payout = \FedaPay\Payout::create([
                'amount' => (int) $sale->amount,
                'currency' => ['iso' => 'XOF'],
                'mode' => 'mtn',
                'description' => 'Libération escrow : ' . $sale->product->nom,
                'customer' => [
                    'firstname' => $seller->firstname,
                    'lastname' => $seller->lastname,
                    'email' => $seller->email,
                    'phone_number' => [
                        'number' => $fullPhoneNumber,
                        'country' => $seller->country,
                    ],
                ],
            ]);

            $payout->sendNow();

            // Update sale status
            $sale->update(['status' => 'completed']);

            Log::info("Real payout sent for sale #{$sale->id}");

            return redirect()
                ->route('creator.escrow')
                ->with('success', 'Livraison confirmée ! Le paiement de ' . number_format($sale->amount, 0) . ' XOF a été libéré via FedaPay.');
        } catch (\Exception $e) {
            Log::error("FedaPay Payout Error for sale #{$sale->id}: " . $e->getMessage());
            return redirect()
                ->route('creator.escrow')
                ->with('error', 'Erreur FedaPay : ' . $e->getMessage());
        }
    }
}

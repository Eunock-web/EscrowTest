<?php

namespace App\Http\Controllers\Creator;

use App\Http\Controllers\Controller;
use App\Models\Sale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
     * Confirm delivery and release the escrow payment
     */
    public function confirmDelivery(Sale $sale)
    {
        // Make sure this sale belongs to the authenticated creator
        if ($sale->seller_id !== Auth::id()) {
            return redirect()->route('creator.escrow')
                ->with('error', 'Action non autorisée.');
        }

        if ($sale->status !== 'escrow_locked') {
            return redirect()->route('creator.escrow')
                ->with('error', 'Ce paiement n\'est pas en attente.');
        }

        $sale->update(['status' => 'completed']);

        return redirect()->route('creator.escrow')
            ->with('success', 'Livraison confirmée ! Le paiement de ' . number_format($sale->amount, 0) . ' XOF a été libéré.');
    }
}

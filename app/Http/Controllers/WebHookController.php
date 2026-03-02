<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WebHookController extends Controller
{
    //fonction pour la gestion du webhook
    public function handle(Request $request)
    {
        $payload = $request->getContent();
        $sigHeader = $request->header('X-FedaPay-Signature');
        $endpointSecret = config('fedapay.webhook_secret');

        try {
            $event = \FedaPay\Webhook::constructEvent(
                $payload,
                $sigHeader,
                $endpointSecret
            );

            \Illuminate\Support\Facades\Log::info("FedaPay Webhook received: " . $event->type);

            if ($event->type == 'transaction.approved') {
                $transaction = $event->data; // This is the transaction object
                
                $metadata = $transaction->custom_metadata;
                $productId = $metadata['product_id'] ?? null;
                $buyerId = $metadata['buyer_id'] ?? null;

                // Logic similar to callback but server-to-server
                if ($productId && $buyerId) {
                    $product = \App\Models\Product::find($productId);
                    
                    $existingSale = \App\Models\Sale::where('product_id', $productId)
                        ->where('buyer_id', $buyerId)
                        ->where('status', 'escrow_locked')
                        ->first();

                    if (!$existingSale) {
                        \App\Models\Sale::create([
                            'product_id' => $product->id,
                            'seller_id' => $product->user_id,
                            'buyer_id' => $buyerId,
                            'amount' => $product->prix,
                            'status' => 'escrow_locked',
                        ]);
                        \Illuminate\Support\Facades\Log::info("Sale recorded via Webhook.");
                    }
                }
                
                // Always log the event
                \App\Models\PaymentLog::create([
                    'transaction_id' => $transaction->id,
                    'status' => $transaction->status,
                    'payload' => $transaction->toArray(),
                    'product_id' => $productId,
                    'buyer_id' => $buyerId,
                ]);
            }

            return response()->json(['status' => 'success']);

        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error("Webhook Error: " . $e->getMessage());
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 400);
        }
    }
}

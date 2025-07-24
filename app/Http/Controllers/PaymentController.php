<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\PaymentIntent;

class PaymentController extends Controller
{
    /**
     * Summary of createPaymentIntent
     * @param \Illuminate\Http\Request $request
     */
    public function createPaymentIntent(Request $request)
    {
        // Step 1: Validate input
        $validated = $request->validate([
            'amount' => 'required|numeric|min:1',
            'currency' => 'required|string|size:3',
        ]);

        try {
            // Step 2: Set Stripe Secret Key
            Stripe::setApiKey(config('services.stripe.secret'));

            // Step 3: Create Payment Intent
            $paymentIntent = PaymentIntent::create([
                'amount' => $validated['amount'], // amount in smallest currency unit (e.g., cents)
                'currency' => strtolower($validated['currency']),
                'automatic_payment_methods' => ['enabled' => true],
            ]);

            return response()->json([
                'clientSecret' => $paymentIntent->client_secret,
            ]);
        } catch (\Stripe\Exception\ApiErrorException $e) {
            // Handle Stripe-specific errors
            Log::error('Stripe API error: ' . $e->getMessage());
            return response()->json(['error' => 'Payment failed. Try again later.'], 500);
        } catch (\Exception $e) {
            // Handle unexpected errors
            Log::error('Payment Intent creation failed: ' . $e->getMessage());
            return response()->json(['error' => 'Something went wrong. Please contact support.'], 500);
        }
    }
}

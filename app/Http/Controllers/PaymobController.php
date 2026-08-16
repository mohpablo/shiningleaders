<?php

namespace App\Http\Controllers;

use App\Models\payment;
use App\Models\subscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PaymobController extends Controller
{
    public function callback(Request $request)
    {
        Log::info('PayMob callback received', $request->all());

        $orderId = $request->input('order_id');
        $transactionId = $request->input('transaction_id');
        $success = filter_var($request->input('success'), FILTER_VALIDATE_BOOLEAN);
        $status = $success ? 'success' : 'failed';
        $merchantOrderId = $request->input('merchant_order_id');

        if (!$merchantOrderId) {
            return response()->json(['error' => 'missing merchant_order_id'], 400);
        }

        $payment = payment::where('paymob_order_id', $merchantOrderId)->first();
        if (!$payment) {
            Log::warning('PayMob callback could not find payment', ['merchant_order_id' => $merchantOrderId]);
            return response()->json(['error' => 'payment not found'], 404);
        }

        $payment->status = $status;
        $payment->paymob_transaction_id = $transactionId;
        $payment->failure_reason = $request->input('failure_reason');
        $payment->save();

        $subscription = $payment->subscription;
        if ($status === 'success' && $subscription) {
            $subscription->status = 'active';
            $subscription->save();
        }

        return response()->json(['success' => true]);
    }
}

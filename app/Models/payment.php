<?php

namespace App\Models;

use Database\Factories\PaymentFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['subscription_id', 'amount', 'paymob_order_id', 'paymob_transaction_id', 'status', 'failure_reason'])]
class payment extends Model
{
    /** @use HasFactory<PaymentFactory> */
    use HasFactory;

    public function subscription()
    {
        return $this->belongsTo(subscription::class);
    }
}

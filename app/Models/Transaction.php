<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'payment_method_id',
        'transactionable_id',
        'transactionable_type',
        'type',
        'sent_amount',
        'receive_amount',
        'note',
        'transaction_date',
        'reference'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function paymentmethod()
    {
        return $this->belongsTo(PaymentMethod::class, 'payment_method_id', 'id');
    }
    public function transactionable()
    {
        return $this->morphTo();
    }

    public static function boot()
    {
        parent::boot();
        // Automatically delete the related BankTransaction when an Expense is deleted
        static::deleted(function ($expense) {
            $expense->transactions()->delete();
        });
    }

}

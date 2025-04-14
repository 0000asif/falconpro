<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'branch_name',
        'account_number',
        'balance',
        'opening_date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    public function transactions()
    {
        return $this->morphOne(Transaction::class, 'transactionable');
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

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalaryRecord extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'employee_id',
        'payment_method_id',
        'payment_month',
        'payment_year',
        'salary_amount',
        'status',
        'payment_date',
        'note',
        'bonous'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function staff()
    {
        return $this->belongsTo(Employee::class, 'employee_id', 'id');
    }

    public function paymentmethod()
    {
        return $this->belongsTo(PaymentMethod::class, 'payment_method_id', 'id');
    }

    public function transactions()
    {
        return $this->morphMany(Transaction::class, 'transactionable');
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

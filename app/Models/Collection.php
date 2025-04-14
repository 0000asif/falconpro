<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Collection extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'project_id',
        'payment_method_id',
        'amount',
        'date',
        'note',
        'reference',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function paymentmethod()
    {
        return $this->belongsTo(PaymentMethod::class, 'payment_method_id', 'id');
    }

    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id', 'id');
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

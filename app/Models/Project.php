<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'lead_id',
        'project_name',
        'fb_link',
        'categorie_id',
        'domain_name',
        'project_amount',
        'extra_amount',
        'advance_amount',
        'start_date',
        'end_date',
        'working_days',
        'delivery_date',
        'server_bill',
        'bill_type',
        'bill_amount',
        'project_document_file',
        'contract_document',
        'payment_method_id',
        'status',
        'note',
    ];

    public function category()
    {
        return $this->belongsTo(ProjectCategory::class, 'categorie_id', 'id');
    }

    public function lead()
    {
        return $this->belongsTo(Leads::class, 'lead_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function projectNote()
    {
        return $this->hasMany(ProjectNote::class);
    }

    public function collection()
    {
        return $this->hasMany(collection::class);
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

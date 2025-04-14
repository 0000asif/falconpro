<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientInvoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'work_order_id',
        'image',
        'total_qty',
        'total_amount',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function workOrder()
    {
        return $this->belongsTo(WorkOrder::class);
    }
    public function items()
    {
        return $this->hasMany(ClientInvoiceItem::class);
    }
    
}

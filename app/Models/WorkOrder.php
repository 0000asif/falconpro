<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkOrder extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'work_order_number',
        'company_order_number',
        'client_id',
        'vendor_id',
        'company_id',
        'state_id',
        'zip_code',
        'address',
        'status_id',
        'due_date',
        'invoice',
        'total_qty',
        'grand_total',
        'file',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function state()
    {
        return $this->belongsTo(State::class);
    }

    
    public function status()
    {
        return $this->belongsTo(Status::class, 'status_id', 'id');
    }
    public function items()
    {
        return $this->hasMany(WorkOrderItem::class, 'work_order_id', 'id');
    }
    public function comments()
    {
        return $this->hasMany(Note::class, 'work_order_id', 'id');
    }

    public function bids()
    {
        return $this->hasMany(Bid::class, 'work_order_id', 'id');
    }
    public function vendorinvoice()
    {
        return $this->hasMany(VendorInvoice::class, 'work_order_id', 'id');
    }
    public function clientinvoice()
    {
        return $this->hasMany(ClientInvoice::class, 'work_order_id', 'id');
    }
}

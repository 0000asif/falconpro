<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;


    protected $fillable = [
        'user_id',
        'name',
        'image',
        'city',
        'state_id',
        'zip_code',
        'address',
        'status',
    ];
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    public function city()
    {
        return $this->belongsTo(City::class, 'city_id', 'id');
    }
    public function state()
    {
        return $this->belongsTo(State::class, 'state_id', 'id');
    }
    // Relationship with Work Orders
    public function workOrders()
    {
        return $this->hasMany(WorkOrder::class, 'company_id', 'id');
    }

    // Relationship with Clients through Work Orders
    public function clients()
    {
        return $this->hasManyThrough(Client::class, WorkOrder::class, 'company_id', 'id', 'id', 'client_id');
    }

    // Relationship with Vendors through Work Orders
    public function vendors()
    {
        return $this->hasManyThrough(Vendor::class, WorkOrder::class, 'company_id', 'id', 'id', 'vendor_id');
    }
}
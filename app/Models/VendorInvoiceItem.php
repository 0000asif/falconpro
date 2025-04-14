<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VendorInvoiceItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'vendor_invoice_id',
        'type_id',
        'description',
        'qty',
        'unit_price',
        'total_price',
    ];

    public function vendorInvoice()
    {
        return $this->belongsTo(VendorInvoice::class, 'vendor_invoice_id', 'id');
    }

    public function type()
    {
        return $this->belongsTo(Type::class);
    }
}

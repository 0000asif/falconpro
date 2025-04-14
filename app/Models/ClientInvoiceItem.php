<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientInvoiceItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_invoice_id',
        'type_id',
        'description',
        'qty',
        'unit_price',
        'total_price',
    ];

    public function clientInvoice()
    {
        return $this->belongsTo(ClientInvoice::class);
    }

    public function type()
    {
        return $this->belongsTo(Type::class);
    }
}

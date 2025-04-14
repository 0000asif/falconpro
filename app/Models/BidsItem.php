<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BidsItem extends Model
{
    use HasFactory;


    protected $fillable = [
        'bid_id',
        'type_id',
        'description',
        'qty',
        'unit_price',
        'total_price',
    ];

    public function bid()
    {
        return $this->belongsTo(Bid::class);
    }

    public function type()
    {
        return $this->belongsTo(Type::class);
    }
}

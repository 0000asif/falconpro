<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkOrderItem extends Model
{
    use HasFactory;
    protected $fillable = [
        'work_order_id',
        'type_id',
        'description',
        'qty',
        'unit_price',
        'total_price',
    ];

    public function workOrder()
    {
        return $this->belongsTo(WorkOrder::class);
    }

    public function type()
    {
        return $this->belongsTo(Type::class);
    }
}

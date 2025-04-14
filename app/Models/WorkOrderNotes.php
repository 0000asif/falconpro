<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkOrderNotes extends Model
{
    use HasFactory;
    protected $fillable = ['work_order_id', 'user_id', 'note_text', 'visible_to'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    public function workOrder()
    {
        return $this->belongsTo(WorkOrder::class, 'work_order_id', 'id');
    }
}

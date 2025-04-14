<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'work_order_id',
        'content',
        'image',
        'status',
        'show_to_vendor'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function workorder()
    {
        return $this->belongsTo(WorkOrder::class, 'work_order_id', 'id');
    }
}

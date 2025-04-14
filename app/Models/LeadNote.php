<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeadNote extends Model
{
    use HasFactory;


    protected $fillable = [
        'user_id',
        'leads_id',
        'note',
        'schedule_date',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function lead()
    {
        return $this->belongsTo(Leads::class, 'leads_id', 'id');
    }

}

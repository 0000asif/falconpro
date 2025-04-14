<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'lead_id',
        'employee_id',
        'title',
        'charge',
        'start_date',
        'complete_date',
        'description',
        'note',
        'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function lead()
    {
        return $this->belongsTo(Leads::class, 'lead_id', 'id');
    }
    public function staff()
    {
        return $this->belongsTo(Employee::class, 'employee_id', 'id');
    }

}

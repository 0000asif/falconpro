<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IncomeExpenceCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function income_expences()
    {
        return $this->hasMany(IncomeExpence::class, 'income_expence_category_id', 'id');
    }
}

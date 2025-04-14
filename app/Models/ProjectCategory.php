<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'category_name'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }


}

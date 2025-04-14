<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Leads extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'project_categorie_id',
        'name',
        'mobile',
        'address',
        'fb_link',
    ];

    public function category()
    {
        return $this->belongsTo(ProjectCategory::class, 'project_categorie_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function leadNotes()
    {
        return $this->hasMany(LeadNote::class);
    }
    
}

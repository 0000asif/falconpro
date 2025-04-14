<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectNote extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'project_id',
        'note_title',
        'note_details',
        'status',
        'extra_charge'
    ];

    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id', 'id');
    }
}

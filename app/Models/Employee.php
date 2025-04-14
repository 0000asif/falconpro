<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'designation_id',
        'company_id',
        'name',
        'email',
        'phone',
        'description',
        'image',
        'salary',
        'join_date',
        'join_month',
        'join_year',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function designation()
    {
        return $this->belongsTo(Designation::class, 'designation_id', 'id');
    }
    public function salaryRecords()
    {
        return $this->hasMany(SalaryRecord::class);
    }
    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id', 'id');
    }
}

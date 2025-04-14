<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'name',
        'phone',
        'email',
        'company_id',
        'expertise',
        'address',
        'city_id',
        'state_id',
        'zip_code',
        'status'
    ];
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function expertise()
    {
        return $this->belongsTo(Expertise::class, 'expertise_id', 'id');
    }
    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id', 'id');
    }
    public function city()
    {
        return $this->belongsTo(City::class, 'city_id', 'id');
    }
    public function state()
    {
        return $this->belongsTo(State::class, 'state_id', 'id');
    }
}
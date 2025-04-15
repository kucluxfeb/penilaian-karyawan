<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $fillable = ['division_id', 'user_id', 'fullname', 'nip', 'gender', 'birth_place', 'birth_date', 'address', 'photo'];

    public function division()
    {
        return $this->belongsTo(Division::class);
    }

    public function assessments()
    {
        return $this->hasMany(Assessment::class);
    }

    public function journals()
    {
        return $this->hasMany(Journals::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

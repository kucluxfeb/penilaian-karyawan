<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $fillable = ['division_id', 'fullname', 'nip', 'gender', 'birth_place', 'birth_date', 'address'];

    public function division()
    {
        return $this->belongsTo(Division::class);
    }

    public function assessments()
    {
        return $this->hasMany(Assessment::class);
    }
}

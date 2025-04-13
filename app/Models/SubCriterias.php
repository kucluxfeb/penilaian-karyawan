<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubCriterias extends Model
{
    protected $fillable = ['criteria_id', 'name', 'weight'];

    public function criteria()
    {
        return $this->belongsTo(Criteria::class);
    }

    public function assessmentDetails()
    {
        return $this->hasMany(Assessment_Detail::class);
    }
}

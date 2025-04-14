<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Assessment extends Model
{
    protected $fillable = ['employee_id', 'user_id', 'period', 'score'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function assessmentDetails()
    {
        return $this->hasMany(AssessmentDetail::class);
    }
}

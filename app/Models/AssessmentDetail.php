<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AssessmentDetail extends Model
{
    protected $fillable = ['assessment_id', 'sub_criteria_id', 'value'];

    public function assessment()
    {
        return $this->belongsTo(Assessment::class);
    }

    public function subCriteria()
    {
        return $this->belongsTo(SubCriterias::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Journals extends Model
{
    protected $fillable = ['employee_id', 'date', 'activity', 'problem', 'solution', 'note'];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Criteria extends Model
{
    protected $fillable = ['code', 'name', 'weight', 'type'];

    public function subCriteria()
    {
        return $this->hasMany(Sub_Criteria::class);
    }
}

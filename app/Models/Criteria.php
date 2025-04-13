<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Criteria extends Model
{
    protected $fillable = ['code', 'name', 'weight', 'type'];

    public function subCriterias()
    {
        return $this->hasMany(SubCriterias::class);
    }
}

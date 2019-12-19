<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DiseaseReport extends Model
{
    protected $fillable = [
        'title',
        'count',
        'disease_id'
    ];
}

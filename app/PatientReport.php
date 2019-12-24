<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PatientReport extends Model
{
    protected $fillable = [
        'title',
        'count',
        'patient_id'
    ];
}

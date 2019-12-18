<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PatientReport extends Model
{
    protected $fillable = [
        'fio',
        'count',
        'patient_id'
    ];
}

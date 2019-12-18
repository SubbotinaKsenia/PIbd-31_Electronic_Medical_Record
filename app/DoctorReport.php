<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DoctorReport extends Model
{
    protected $fillable = [
        'fio',
        'count',
        'doctor_id'
    ];
}

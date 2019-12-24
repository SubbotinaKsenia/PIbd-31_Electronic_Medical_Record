<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DoctorReport extends Model
{
    protected $fillable = [
        'title',
        'count',
        'doctor_id'
    ];
}

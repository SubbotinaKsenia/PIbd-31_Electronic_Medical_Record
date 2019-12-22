<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DoctorServices extends Model
{
    protected $fillable = [
        'id',
        'fio',
        'services'
    ];
}

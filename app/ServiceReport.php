<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ServiceReport extends Model
{
    protected $fillable = [
        'title',
        'count',
        'service_id'
    ];
}

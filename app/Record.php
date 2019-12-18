<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Record extends Model
{
    protected $fillable = [
        'service_id',
        'doctor_id',
        'patient_id',
        'date',
        'is_reserved',
    ];

    public function doctor()
    {
        return $this->belongsTo(User::class, 'doctor_id', 'id')->withTimestamps();
    }

    public function patient()
    {
        return $this->belongsTo(User::class, 'patient_id', 'id')->withTimestamps();
    }

    public function service()
    {
        return $this->belongsTo(Service::class, 'service_id', 'id')->withTimestamps();
    }
}

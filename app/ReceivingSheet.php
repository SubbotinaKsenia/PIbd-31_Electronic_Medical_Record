<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReceivingSheet extends Model
{
    protected $fillable = [
        'doctor_id',
        'patient_id',
        'date',
        'description',
    ];

    public function doctor()
    {
        return $this->belongsTo(User::class, 'doctor_id', 'id');
    }

    public function patient()
    {
        return $this->belongsTo(User::class, 'patient_id', 'id');
    }

    public function symptoms()
    {
        return $this->belongsToMany(Symptom::class)->withTimestamps();
    }

    public function drugs()
    {
        return $this->belongsToMany(Drug::class)->withTimestamps();
    }

    public function diseases()
    {
        return $this->belongsToMany(Disease::class)->withTimestamps();
    }
}

<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'fio',
        'email',
        'password',
        'type',
        'token'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'token',
    ];

    public function recordsDoctor()
    {
        return $this->hasMany(Record::class, 'doctor_id', 'id')->withTimestamps();
    }

    public function recordsPatient()
    {
        return $this->hasMany(Record::class, 'patient_id', 'id')->withTimestamps();
    }

    public function receivingsheetsDoctor()
    {
        return $this->hasMany(ReceivingSheet::class, 'doctor_id', 'id')->withTimestamps();
    }

    public function receivingsheetsPatient()
    {
        return $this->hasMany(ReceivingSheet::class, 'patient_id', 'id')->withTimestamps();
    }
}

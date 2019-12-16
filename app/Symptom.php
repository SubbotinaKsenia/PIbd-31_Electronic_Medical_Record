<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Symptom extends Model
{
    protected $fillable = [
        'title',
        'description',
    ];

    public function receivingsheets()
    {
        return $this->belongsToMany(ReceivingSheet::class)->withTimestamps();
    }
}

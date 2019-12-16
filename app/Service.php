<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $fillable = [
        'title',
        'description',
        'price',
    ];

    public function records()
    {
        return $this->hasMany(Record::class, 'service_id', 'id');
    }
}

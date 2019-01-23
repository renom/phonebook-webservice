<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $fillable = ['surname', 'name', 'patronymic'];
    
    public function phones()
    {
        return $this->belongsToMany('App\Phone')->withTimestamps();
    }
}

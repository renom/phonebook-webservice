<?php

namespace App;

class Contact extends Model
{
    protected $fillable = ['surname', 'name', 'patronymic'];
    protected $arrayable = ['id', 'surname', 'name', 'patronymic', 'updated_at', 'created_at'];
    protected $with = ['phones'];

    public function phones()
    {
        return $this->hasMany('App\Phone')->without('contact');
    }
}

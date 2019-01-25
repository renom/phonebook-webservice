<?php

namespace App;

class Contact extends Model
{
    protected $fillable = ['surname', 'name', 'patronymic'];
    protected $appends = ['fullname'];
    protected $with = ['phones'];
    protected $arrayable = ['id', 'fullname', 'surname', 'name', 'patronymic', 'updated_at', 'created_at', 'phones'];

    public function phones()
    {
        return $this->hasMany('App\Phone')->without('contact');
    }
    
    public function getFullnameAttribute()
    {
        return implode(' ', array_filter([$this->surname, $this->name, $this->patronymic])) ?: null;
    }
}

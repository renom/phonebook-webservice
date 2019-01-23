<?php

namespace App;

class Phone extends Model
{
    protected $fillable = ['contact_id', 'number'];
    protected $arrayable = ['id', 'number', 'updated_at', 'created_at'];
    protected $with = ['contact'];

    public function contact()
    {
        return $this->belongsTo('App\Contact');
    }
}

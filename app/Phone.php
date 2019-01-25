<?php

namespace App;

class Phone extends Model
{
    protected $fillable = ['contact_id', 'number'];
    protected $with = ['contact'];
    protected $arrayable = ['id', 'number', 'updated_at', 'created_at', 'contact'];

    public function contact()
    {
        return $this->belongsTo('App\Contact')->without('phones');
    }
}

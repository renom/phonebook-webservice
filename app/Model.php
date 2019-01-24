<?php

namespace App;

class Model extends \Illuminate\Database\Eloquent\Model
{
    // a field order for serialization
    protected $arrayable = [];
    
    protected function getArrayableAttributes()
    {
        $attributes = parent::getArrayableAttributes();
        
        if (!empty($this->arrayable)) {
            $result = [];
            foreach ($this->arrayable as $field) {
                if (isset($attributes[$field])) {
                    $result[$field] = $attributes[$field];
                }
            }
            return $result;
        } else {
            return $attributes;
        }
    }
}

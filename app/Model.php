<?php

namespace App;

class Model extends \Illuminate\Database\Eloquent\Model
{
    // a field order for serialization
    protected $arrayable = [];
    
    public function toArray()
    {
        $attributes = parent::toArray();
        
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
    
    public function scopeSort($query, $sort)
    {
        if ($sort[0] === '-') {
            $column = substr($sort, 1);
            $direction = 'desc';
        } else {
            $column = $sort;
            $direction = 'asc';
        }
        
        return $query->orderBy($column, $direction);
    }
}

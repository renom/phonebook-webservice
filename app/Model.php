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
    
    public function scopeSort($query, $sort, $columns = [])
    {
        if ($sort[0] === '-') {
            $column = substr($sort, 1);
            $direction = 'desc';
        } else {
            $column = $sort;
            $direction = 'asc';
        }
        
        if (isset($columns[$column])) {
            return $query->orderBy($columns[$column], $direction);
        } else {
            return $query->orderBy($column, $direction);
        }
    }
}

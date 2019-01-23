<?php

namespace App;

class Model extends \Illuminate\Database\Eloquent\Model
{
    // a field order for serialization
    protected $arrayable = [];
    
    protected function getArrayableItems(array $values)
    {
        $values = parent::getArrayableItems($values);
        
        if (!empty($this->arrayable)) {
            $result = [];
            foreach ($this->arrayable as $field) {
                if (isset($values[$field])) {
                    $result[$field] = $values[$field];
                }
            }
            return $result;
        } else {
            return $values;
        }
    }
}

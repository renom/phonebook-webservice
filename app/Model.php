<?php

namespace App;

class Model extends \Illuminate\Database\Eloquent\Model
{
    // a field order for serialization
    protected $arrayable = [];
    
    protected function getArrayableItems(array $values)
    {
        $items = parent::getArrayableItems($values);
        
        if (!empty($this->arrayable)) {
            $result = [];
            foreach ($this->arrayable as $field) {
                if (isset($items[$field])) {
                    $result[$field] = $items[$field];
                }
            }
            return $result;
        } else {
            return $items;
        }
    }
}

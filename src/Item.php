<?php

namespace GaspariLab\ActionableList;

class Item
{
    /**
     * @var array  $values   An array of the values (each value is a column).
     */
    protected $values = [];

    /**
     * Set values for this item.
     *
     * @param array  $values
     *
     * @return self
     */
    public function addValues($values)
    {
        if (! is_array($values)) {
            $values = [$values];
        }
        
        $this->values = array_merge($this->values, $values);
        
        return $this;
    }
}

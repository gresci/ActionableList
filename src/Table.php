<?php

/**
 * Table is a wrapper for ItemList.
 * It allows you to call static methods which automatically create new instances of ItemList.
 */

namespace GaspariLab\ActionableList;

class Table
{
    /**
     * Quickly create a new Instance of ItemList.
     *
     * @return \GaspariLab\ActionableList\ItemList
     */
    public static function make($columns = false, $items = false)
    {
        return new ItemList($columns, $items);
    }

    /**
     * Handle dynamic method calls into the ItemList.
     *
     * @param  string  $method
     * @param  array  $parameters
     * @return mixed
     */
    public function __call($method, $parameters)
    {
        return $this->make()->$method(...$parameters);
    }

    /**
     * Handle dynamic static method calls into the method.
     *
     * @param  string  $method
     * @param  array  $parameters
     * @return mixed
     */
    public static function __callStatic($method, $parameters)
    {
        return (new static)->$method(...$parameters);
    }
}

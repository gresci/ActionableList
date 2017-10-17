<?php

namespace GaspariLab\ActionableList;

use Illuminate\Support\HtmlString;

class ItemList
{
    /**
     * @var array  $columns             List of columns which the table is made of.
     */
    protected $columns = [];

    /**
     * @var array  $items               The items inside of the table.
     */
    protected $items = [];

    /**
     * @var array  $actions             List of action buttons for each item of the list.
     */
    protected $actions = [];

    /**
     * @var array  $multipleActions     List of action buttons for multiple selected items.
     */
    protected $multipleActions = [];

    /**
     * Quickly set columns and items for the table.
     *
     * @param array|false   $columns   The list of columns.
     * @param array|false   $items     The list of array.
     *
     * @return self
     */
    public function __construct($columns = false, $items = false)
    {
        $columns === false ?: $this->setColumns($columns);
        $items === false ?: $this->setItems($items);
    }

    /**
     * Gets the columns of the table.
     *
     * @return array
     */
    public function getColumns()
    {
        return $this->columns;
    }

    /**
     * Sets the columns of the table.
     *
     * @param  array|string|Column  $columns
     *
     * @return self
     */
    public function setColumns($columns)
    {
        $this->columns = [];

        return $this->addColumns(array_wrap($columns));
    }

    /**
     * Add an array of columns (as strings, or arrays with name + slug + sortable name values, or already
     * instantiated Column objects) to the existing list of columns.
     *
     * @param  array  $columns
     *
     * @return self
     */
    public function addColumns(array $columns)
    {
        // This cycle modifies the $columns array, keeping any non-numeric index as it is.
        foreach ($columns as $key => $value) {
            // If the value is a string, just create a column with that name.
            if (is_string($value)) {
                // If the array key is a string, set is as the slug. Otherwise, keep the automatically generated slug.
                $slug = is_string($key) ? $key : false;

                $columns[$key] = new Column($value, $slug, $key);
            }

            // If the value is an array, pass his values into the constructor of the column.
            if (is_array($value)) {
                $columns[$key] = new Column(...$value);
            }

            // If the value is an instance of Column, put it as is.
            if ($value instanceof Column) {
                $columns[$key] = $value;
            }
        }

        // Merge using array_values to remove non-numeric indexes from the columns array.
        $this->columns = array_merge($this->columns, array_values($columns));

        return $this;
    }

    /**
     * Add a column to the existing list of columns.
     * You can pass a string to create a column with that name, or an array with the slug as the key and the
     * title of the column as the value, or an already instantiated Column class.
     *
     * @param  string|array|Column  $columns
     *
     * @return self
     */
    public function addColumn($columns)
    {
        return $this->addColumns(array_wrap($columns));
    }

    /**
     * Get the items of the table.
     *
     * @return array
     */
    public function getItems()
    {
        return $this->items;
    }

    /**
     * Set the items of the table. It must be called after specifying the columns.
     *
     * @param  array  $items
     *
     * @return self
     */
    public function setItems($items)
    {
        $this->items = [];

        return $this->addItems($items);
    }

    /**
     * Add a single item to the table.
     *
     * @param  array  $items
     *
     * @return self
     */
    public function addItem($item)
    {
        return $this->addItems([$item]);
    }

    /**
     * Add the items to the table. It must be called after specifying the columns.
     *
     * @param  array  $items   Multidimensional array which contains arrays of data for each row.
     *
     * @return self
     */
    public function addItems($items)
    {
        if (! is_array($items)) {
            throw new \Exception('$items must be a multidimensional array.');
        }

        foreach ($items as $item) {
            if (! is_array($items)) {
                throw new \Exception('$items must be a multidimensional array.');
            }

            if (count($item) > count($this->columns)) {
                throw new \Exception('You cannot specify more items than the columns available.');
            }
        }

        // Merge using array_values to remove non-numeric indexes from the columns array
        $this->items = array_merge($this->items, array_values($items));

        return $this;
    }

    /**
     * Return if the table has action buttons.
     *
     * @return bool
     */
    public function hasActions()
    {
        return ! empty($this->actions);
    }

    /**
     * Return if the table allows multiple selection.
     *
     * @return bool
     */
    public function hasMultipleActions()
    {
        return ! empty($this->multipleActions);
    }

    /**
     * Set the buttons of the table.
     *
     * @param  array|string  $actions
     *
     * @return self
     */
    public function setActions($actions)
    {
        $this->actions = [];

        return $this->addActions($actions);
    }

    /**
     * Add buttons to the table.
     *
     * @param  array|string  $actions
     *
     * @return self
     */
    public function addActions($actions)
    {
        if (! is_array($actions)) {
            $actions = [$actions];
        }

        // Merge using array_values to remove non-numeric indexes from the columns array
        $this->actions = array_merge($this->actions, array_values($actions));

        return $this;
    }

    /**
     * Return the HTML for the table.
     *
     * @return bool
     */
    public function getHTML()
    {
        $view = view('actionablelist::table', [
            'table' => $this,
        ]);

        return new HtmlString($view);
    }

    /**
     * Dynamically retrieve attributes of the ItemList.
     *
     * @param  string  $key
     * @return mixed
     */
    public function __get($key)
    {
        // We expose the attributes this way to make them read-only.
        if (in_array($key, ['columns', 'items', 'actions'])) {
            return $this->{$key};
        }

        return null;
    }

    /**
     * The __isset magic method is triggered whenever an inaccessible attribute (for example those exposed via __get)
     * is called inside of an empty() or isset() construct.
     *
     * @param  string  $key
     * @return bool
     */
    public function __isset($key)
    {
        return ! empty($this->{$key});
    }
}

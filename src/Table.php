<?php

namespace GaspariLab\ActionableList;

use InvalidArgumentException;

class Table
{
    /**
     * @var array  $columns             List of columns which the table is made of.
     */
    protected $columns = [];

    /**
     * @var array  $datasets            The datasets inside of the table.
     */
    protected $datasets = [];

    /**
     * Quickly set the columns, the formatters and the rows of the table.
     *
     * @param array  $columns     The list of columns.
     * @param array  $formatters  The list of closures, strings or Htmlables that return formatters of the cells.
     * @param array  $datasets    The datasets to show in the table.
     *
     * @return self
     */
    protected function make($columns = [], $formatters = [], $dataset = null)
    {
        // Create the columns of the table
        $this->addColumns($columns);

        if (count($this->columns) !== count($formatters)) {
            throw new InvalidArgumentException('The column and the formatter arrays are not of the same length.');
        }

        // Assign the formatter to the columns
        $this->addFormatters($formatters);

        // Add the dataset
        if ($dataset !== null) {
            $this->addDataset($dataset);
        }

        return $this;
    }

    /**
     * Gets the columns of the table.
     *
     * @return array
     */
    protected function getColumns()
    {
        return $this->columns;
    }

    /**
     * Add an array of columns (as strings, or arrays with name + slug + sortable name values, or already
     * instantiated Column objects) to the existing list of columns.
     *
     * @param  array|string|Column  $columns
     *
     * @return self
     */
    protected function addColumns($columns)
    {
        // If a single column is passed, wrap it into an array.
        $columns = array_wrap($columns);

        // This cycle modifies the $columns array, keeping any non-numeric index as it is.
        foreach ($columns as $key => $value) {
            if (is_array($value)) {
                // If the value is an array, pass his values into the constructor of the column.
                $columns[$key] = new Column(...$value);
            } elseif ($value instanceof Column) {
                // If the value is an instance of Column, put it as is.
                $columns[$key] = $value;
            } else {
                // If the value is something else, just create a column with that as a parameter.

                // If the array key is a string, set is as the slug. Otherwise, keep the automatically generated slug.
                $slug = is_string($key) ? $key : false;

                $columns[$key] = new Column($value, $slug, $key);
            }
        }

        // Merge using array_values to remove non-numeric indexes from the columns array.
        $this->columns = array_merge($this->columns, array_values($columns));

        return $this;
    }

    /**
     * Add a formatter (an anonymous function, a string, an Htmlable) for each column of the table.
     *
     * @param  array  $formatters  An array of formatters for each column.
     *
     * @return self
     */
    protected function addFormatters(array $formatters)
    {
        foreach ($formatters as $key => $formatter) {
            $this->columns[$key]->setFormatter($formatter);
        }

        return $this;
    }

    /**
     * Add one iterable dataset to the table.
     *
     * @param  iterable  $dataset  The iterable dataset (e.g.: a Collection, an Eloquent collection, an array...).
     *
     * @return self
     */
    protected function addDataset(iterable $dataset)
    {
        $this->datasets[] = $dataset;

        return $this;
    }

    /**
     * Add more than one iterable dataset to the table.
     *
     * @param  array  $datasets  The iterable datasets, wrapped in an array.
     *
     * @return self
     */
    protected function addDatasets(array $datasets = [])
    {
        foreach ($datasets as $dataset) {
            $this->addDataset($dataset);
        }

        return $this;
    }

    /**
     * Get the output of a cell by column id and row id.
     *
     * @param int $columnKey    The column index.
     * @param int $rowKey       The row index.
     * @return mixed
     */
    protected function getCell($columnKey, $rowKey)
    {
        $data = [];

        // For each dataset, take the row.
        foreach ($this->datasets as $dataset) {
            $data[] = $dataset[$rowKey];
        }

        return $this->columns[$columnKey]->getCellOutput($data);
    }

    /**
     * Returns a Generator which can be cycled with a foreach loop.
     */
    protected function getRows()
    {
        // Cycle the first dataset
        foreach ($this->datasets[0] as $n => $firstData) {
            $combined = [];

            // Combine the nth-element from every dataset into an array.
            foreach ($this->datasets as $dataset) {
                $combined[] = $dataset[$n];
            }

            yield $n => $combined;
        }
    }

    /**
     * Dynamically retrieve attributes of the table.
     *
     * @param  string  $key
     * @return mixed
     */
    public function __get($key)
    {
        // We expose the protected attributes this way to make them read-only.
        return $this->{$key};
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

    /**
     * Handle dynamic method calls into the table.
     *
     * @param  string  $method
     * @param  array  $parameters
     * @return mixed
     */
    public function __call($method, $parameters)
    {
        return $this->$method(...$parameters);
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

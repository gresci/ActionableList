<?php

namespace GaspariLab\ActionableList;

class Column
{
    /**
     * @var bool   $hasActions   Specifies if the column contains action buttons or has actual content.
     */
    protected $hasActions = false;

    /**
     * @var string  $name   The full name of the column.
     */
    protected $name = '';

    /**
     * @var string  $slug   The slug of the column. Useful for HTML class names or IDs.
     */
    protected $slug = '';

    /**
     * @var string|null  $sortableName   The name for the sorting of this column.
     */
    protected $sortableName = null;

    /**
     * Quickly set values on column instantiation.
     *
     * @param string|bool   $name           The full name of the column.
     * @param string|bool   $slug           The slug of the full name for the column.
     * @param string|bool   $sortableName   The name for sorting purposes (e.g.: database column name).
     *
     * @return self
     */
    public function __construct($name = '', $slug = false, $sortableName = false)
    {
        // If the name is false, automatically set the column as an "actions" column (i.e.: a column
        // without content which is not orderable)
        if ($name === false) {
            $this->setHasActions();
        } else {
            // Otherwise, call the appropriate methods for settings the properties of the columns.
            $this->setName($name);

            if ($slug !== false) {
                $this->setSlug($slug);
            }

            if ($sortableName !== false) {
                $this->setSortableName($sortableName);
            }
        }
    }

    /**
     * Set if the column has action buttons or it has actual content.
     *
     * @param  bool $hasActions  True if the column doesn't have content but only buttons.
     *
     * @return self
     */
    public function setHasActions(bool $hasActions = true)
    {
        $this->hasActions = $hasActions;

        return $this;
    }

    /**
     * Sets the full name of the column.
     *
     * @param string   $name   The full name of the column.
     *
     * @return self
     */
    public function setName(string $name)
    {
        $this->name = $name;

        // If the slug is not set yet create the slug automatically.
        if ($this->slug === '') {
            $this->slug = str_slug($name);
        }

        return $this;
    }

    /**
     * Sets the slug for the column. Useful for HTML class names or IDs.
     *
     * @param string|bool   $slug   The slug of the full name for the column.
     *
     * @return self
     */
    public function setSlug(string $slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Sets the sorting name for the column (for example, a database column name or a URL fragment name).
     * Set to null to disable sorting for this column.
     *
     * @param string   $sortableName   The name for sorting purposes (e.g.: database column name).
     *
     * @return self
     */
    public function setSortableName(string $sortableName = null)
    {
        $this->sortableName = $sortableName;

        return $this;
    }

    /**
     * Dynamically retrieve attributes of the column.
     *
     * @param  string  $key
     * @return mixed
     */
    public function __get($key)
    {
        return $this->{$key};
    }

    /**
     * Dynamically set attributes of the column.
     *
     * @param  string  $key
     * @param  mixed  $value
     * @return void
     */
    public function __set($key, $value)
    {
        $this->{'set' . ucfirst($key)}($value);
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

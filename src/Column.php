<?php

namespace GaspariLab\ActionableList;

class Column
{
    /**
     * @var bool   $hasContent   Specifies if the column has content or if it's empty (for example, it only contains
     *                           action buttons).
     */
    protected $hasContent = true;
    
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
    public function __construct($name = false, $slug = false, $sortableName = false)
    {
        $name === false ?: $this->setName($name);
        $slug === false ?: $this->setSlug($slug);
        $sortableName === false ?: $this->setSortableName($sortableName);
    }
    
    /**
     * Sets the full name of the column.
     *
     * @param  bool $hasContent  Set if the column has content or not (for example, if it only contains action buttons).
     *
     * @return self
     */
    public function setContent(bool $hasContent)
    {
        $this->hasContent = $hasContent;
        
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
}

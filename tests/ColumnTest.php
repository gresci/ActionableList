<?php

namespace GaspariLab\ActionableList\Tests;

use PHPUnit\Framework\TestCase;
use GaspariLab\ActionableList\Column;

class ColumnTest extends TestCase
{
    public function test_fluently_set_values_with_setters()
    {
        $column = new Column();
        
        $column->setName('Title')
            ->setSlug('slug_title')
            ->setSortableName('sort_title')
            ->setContent(true);
        
        $this->assertTrue($column->name === 'Title');
        $this->assertTrue($column->slug === 'slug_title');
        $this->assertTrue($column->sortableName === 'sort_title');
        $this->assertTrue($column->hasContent === true);
    }
    
    public function test_set_values_directly_to_properties()
    {
        $column = new Column();
        
        $column->name = 'Title';
        $column->slug = 'slug_title';
        $column->sortableName = 'sort_title';
        
        $this->assertTrue($column->name === 'Title');
        $this->assertTrue($column->slug === 'slug_title');
        $this->assertTrue($column->sortableName === 'sort_title');
    }
    
    public function test_set_values_via_constructor()
    {
        $column = new Column('The title', 'the-slug', 'table.name');
        
        $this->assertTrue($column->name === 'The title');
        $this->assertTrue($column->slug === 'the-slug');
        $this->assertTrue($column->sortableName === 'table.name');
    }
}

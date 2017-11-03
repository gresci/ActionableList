<?php

namespace GaspariLab\ActionableList\Tests;

use PHPUnit\Framework\TestCase;
use GaspariLab\ActionableList\Column;
use GaspariLab\ActionableList\Table;

class TableTest extends TestCase
{
    public function test_set_columns_array()
    {
        $columns = ['one', 'two', 'three'];

        $table = new Table();
        $table->addColumns($columns);

        $this->assertTrue(count($table->getColumns()) === 3);
    }

    public function test_add_column_string()
    {
        $table = new Table();
        $table->addColumns('testing');

        $this->assertTrue(count($table->getColumns()) === 1);
    }

    public function test_add_columns()
    {
        $table = new Table();

        $table->addColumns(['one', 'two']);
        $this->assertTrue(count($table->getColumns()) === 2);

        $table->addColumns(['three', 'four']);
        $this->assertTrue(count($table->getColumns()) === 4);

        $table->addColumns('five');
        $this->assertTrue(count($table->getColumns()) === 5);
    }

    public function test_columns_property_exposes_same_array_as_getColumns()
    {
        $table = new Table();
        $table->addColumns(['one', 'two', 'three']);

        $this->assertTrue($table->getColumns() === $table->columns);
    }

    public function test_check_if_adding_column_via_string_sets_the_correct_slug()
    {
        // Try the automatic generation of the slug
        $table = new Table();
        $table->addColumns('A Name Without The Slug?');

        $this->assertTrue($table->columns[0]->name === 'A Name Without The Slug?');
        $this->assertTrue($table->columns[0]->slug === 'a-name-without-the-slug');

        // Try setting a custom slug
        $table = new Table();
        $table->addColumns(['the-slug' => 'The Name!']);

        $this->assertTrue($table->columns[0]->name === 'The Name!');
        $this->assertTrue($table->columns[0]->slug === 'the-slug');
    }

    protected function getTestTable()
    {
        return Table::make([
            'qty' => 'Quantity',
            'color' => 'Color',
            'animals.name' => 'Animal',
        ], [
            function ($arr) {
                return $arr[0];
            },
            function ($color) {
                return 'The color is '.$color[1];
            },
            function () {
                return 'This is a table';
            }
        ], [
            ['3', 'red', 'dog'],
            ['5', 'blue', 'cat'],
            ['16', 'yellow', 'bird'],
        ]);
    }

    public function test_set_dataset_via_constructor()
    {
        $this->assertTrue(count($this->getTestTable()->columns) === 3);
    }

    public function test_instancing_columns_via_constructor()
    {
        $this->assertTrue($this->getTestTable()->columns[0] instanceof Column);
    }

    public function test_get_cell_from_table()
    {
        $table = $this->getTestTable();

        $this->assertTrue($table->getCell(1, 0) === 'The color is red');
    }
}

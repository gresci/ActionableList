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
        $table->setColumns($columns);

        $this->assertTrue(count($table->getColumns()) === 3);
    }

    public function test_set_column_string()
    {
        $table = new Table();
        $table->setColumns('testing');

        $this->assertTrue(count($table->getColumns()) === 1);
    }

    public function test_add_columns()
    {
        $table = new Table();

        $table->setColumns(['one', 'two']);
        $this->assertTrue(count($table->getColumns()) === 2);

        $table->addColumns(['three', 'four']);
        $this->assertTrue(count($table->getColumns()) === 4);

        $table->addColumn('five');
        $this->assertTrue(count($table->getColumns()) === 5);
    }

    public function test_columns_property_exposes_same_array_as_getColumns()
    {
        $table = new Table();
        $table->setColumns(['one', 'two', 'three']);

        $this->assertTrue($table->getColumns() === $table->columns);
    }

    public function test_check_if_adding_column_via_string_sets_the_correct_slug()
    {
        // Try the automatic generation of the slug
        $table = new Table();
        $table->addColumn('A Name Without The Slug?');

        $this->assertTrue($table->columns[0]->name === 'A Name Without The Slug?');
        $this->assertTrue($table->columns[0]->slug === 'a-name-without-the-slug');

        // Try setting a custom slug
        $table = new Table();
        $table->addColumn(['the-slug' => 'The Name!']);

        $this->assertTrue($table->columns[0]->name === 'The Name!');
        $this->assertTrue($table->columns[0]->slug === 'the-slug');
    }

    public function test_set_items()
    {
        $table = new Table();
        $table->setColumns(['Quantity', 'Color', 'Animal']);

        $items = [
            ['one', 'red', 'cat'],
            ['two', 'green', 'bird'],
            ['three', 'blue', 'dog'],
        ];
        $table->setItems($items);
        $this->assertTrue($table->items === $items);

        // Test adding new items
        $table->addItems([
            ['four', 'yellow', 'giraffe'],
            ['five', 'violet', 'cow'],
        ]);
        $this->assertTrue($table->items[3] === ['four', 'yellow', 'giraffe']);
        $this->assertTrue($table->items[4] === ['five', 'violet', 'cow']);

        // Test adding a single item
        $table->addItem(['six', 'brown', 'elephants']);
        $this->assertTrue($table->items[5] === ['six', 'brown', 'elephants']);
    }

    public function test_adding_bigger_item_than_columns()
    {
        $this->expectException(\Exception::class);

        $table = new Table();
        $table->setColumns(['one', 'two']);

        // Items have more columns than specified
        $items = [
            ['one', 'red', 'cat', 'funny'],
            ['two', 'green', 'bird', 'sad'],
        ];

        $table->setItems($items);
    }

    public function test_set_items_via_constructor()
    {
        $table = new Table([
            'qty' => 'Quantity',
            'color' => 'Color',
            'animals.name' => 'Animal',
        ], [
            ['one', 'red', 'cat'],
            ['two', 'green', 'bird'],
            ['three', 'blue', 'dog'],
        ]);

        $this->assertTrue(count($table->columns) === 3);
        $this->assertTrue($table->columns[0] instanceof Column);
        $this->assertTrue(count($table->items) === 3);
    }
}

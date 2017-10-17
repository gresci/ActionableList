<?php

namespace GaspariLab\ActionableList\Tests;

use PHPUnit\Framework\TestCase;
use GaspariLab\ActionableList\Column;
use GaspariLab\ActionableList\ItemList;

class ItemListTest extends TestCase
{
    public function test_set_columns_array()
    {
        $columns = ['one', 'two', 'three'];

        $itemlist = new ItemList();
        $itemlist->setColumns($columns);

        $this->assertTrue(count($itemlist->getColumns()) === 3);
    }

    public function test_set_column_string()
    {
        $itemlist = new ItemList();
        $itemlist->setColumns('testing');

        $this->assertTrue(count($itemlist->getColumns()) === 1);
    }

    public function test_add_columns()
    {
        $itemlist = new ItemList();

        $itemlist->setColumns(['one', 'two']);
        $this->assertTrue(count($itemlist->getColumns()) === 2);

        $itemlist->addColumns(['three', 'four']);
        $this->assertTrue(count($itemlist->getColumns()) === 4);

        $itemlist->addColumn('five');
        $this->assertTrue(count($itemlist->getColumns()) === 5);
    }

    public function test_columns_property_exposes_same_array_as_getColumns()
    {
        $itemlist = new ItemList();
        $itemlist->setColumns(['one', 'two', 'three']);

        $this->assertTrue($itemlist->getColumns() === $itemlist->columns);
    }

    public function test_set_items()
    {
        $itemlist = new ItemList();
        $itemlist->setColumns(['Quantity', 'Color', 'Animal']);

        $items = [
            ['one', 'red', 'cat'],
            ['two', 'green', 'bird'],
            ['three', 'blue', 'dog'],
        ];
        $itemlist->setItems($items);
        $this->assertTrue($itemlist->items === $items);

        // Test adding new items
        $itemlist->addItems([
            ['four', 'yellow', 'giraffe'],
            ['five', 'violet', 'cow'],
        ]);
        $this->assertTrue($itemlist->items[3] === ['four', 'yellow', 'giraffe']);
        $this->assertTrue($itemlist->items[4] === ['five', 'violet', 'cow']);

        // Test adding a single item
        $itemlist->addItem(['six', 'brown', 'elephants']);
        $this->assertTrue($itemlist->items[5] === ['six', 'brown', 'elephants']);
    }

    public function test_adding_bigger_item_than_columns()
    {
        $this->expectException(\Exception::class);

        $itemlist = new ItemList();
        $itemlist->setColumns(['one', 'two']);

        // Items have more columns than specified
        $items = [
            ['one', 'red', 'cat', 'funny'],
            ['two', 'green', 'bird', 'sad'],
        ];

        $itemlist->setItems($items);
    }

    public function test_set_items_via_constructor()
    {
        $itemlist = new ItemList([
            'qty' => 'Quantity',
            'color' => 'Color',
            'animals.name' => 'Animal',
        ], [
            ['one', 'red', 'cat'],
            ['two', 'green', 'bird'],
            ['three', 'blue', 'dog'],
        ]);

        $this->assertTrue(count($itemlist->columns) === 3);
        $this->assertTrue($itemlist->columns[0] instanceof Column);
        $this->assertTrue(count($itemlist->items) === 3);
    }
}

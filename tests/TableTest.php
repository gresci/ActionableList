<?php

namespace GaspariLab\ActionableList\Tests;

use PHPUnit\Framework\TestCase;
use GaspariLab\ActionableList\Table;

class TableTest extends TestCase
{
    public function test_call_itemlist_function()
    {
        $table = new Table();
        $this->assertTrue($table->getColumns() === []);
    }

    public function test_call_itemlist_function_statically()
    {
        $this->assertTrue(Table::getColumns() === []);
    }
}

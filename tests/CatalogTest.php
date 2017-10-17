<?php

namespace GaspariLab\ActionableList\Tests;

use PHPUnit\Framework\TestCase;
use GaspariLab\ActionableList\Catalog;

class CatalogTest extends TestCase
{
    public function test_call_itemlist_function()
    {
        $catalog = new Catalog();
        $this->assertTrue($catalog->getColumns() === []);
    }

    public function test_call_itemlist_function_statically()
    {
        $this->assertTrue(Catalog::getColumns() === []);
    }
}

<?php

namespace Test\Unit;

use Test\TestCase;
use Taskforcedev\CrudApi\Helpers\CrudApi;

class ModelHelperTest extends TestCase
{
    public function testGetModelWithoutNamespaceReturnsFalse()
    {
        $crudApi = new CrudApi(['namespace' => null]);

        $this->assertFalse($crudApi->getModel());
    }
}
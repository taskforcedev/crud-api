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

    public function testGetModelUser()
    {
        $namespace = 'Test\\Models\\';

        $options = [
            'namespace' => $namespace,
            'model' => 'User',
        ];

        $crudApi = new CrudApi($options);

        $fqModel = $crudApi->getModel();

        $this->assertEquals($namespace . 'User', $fqModel);
    }

    public function testUserGetModelCanBeInstantiated()
    {
        $namespace = 'Test\\Models\\';

        $options = [
            'namespace' => $namespace,
            'model' => 'User',
        ];

        $crudApi = new CrudApi($options);

        $fqModel = $crudApi->getModel();
        $model = new $fqModel;
        $this->assertEquals('Test\\Models\\User', get_class($model));
    }
}
<?php

namespace Test\Unit;

use Test\TestCase;
use \Mockery as m;
use Taskforcedev\CrudApi\Helpers\CrudApi;
use Taskforcedev\CrudApi\Helpers\Model as ModelHelper;


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

    public function testAdditionalModelCanBeInstantiated()
    {
        $namespace = 'Test\\Models\\';

        $options = [
            'namespace' => $namespace,
            'model' => 'AdditionalModel',
        ];

        $crudApi = new CrudApi($options);

        $modelHelper = m::mock('\Taskforcedev\CrudApi\Helpers\Model[getAdditionalNamespaces]', [$crudApi]);
        $modelHelper->shouldReceive('getAdditionalNamespaces')->once()->andReturn(['Test\\AnotherNamespace\\']);
        $crudApi->modelHelper = $modelHelper;

        $fqModel = $crudApi->getModel();
        $model = new $fqModel;
        $this->assertEquals('Test\\AnotherNamespace\\AdditionalModel', get_class($model));
    }

    public function testInstanceMethodReturnsTheSpecifiedInstance()
    {
        $namespace = 'Test\\Models\\';

        $options = [
            'namespace' => $namespace,
            'model' => 'AdditionalModel',
        ];

        $crudApi = new CrudApi($options);
        $modelHelper = new ModelHelper($crudApi);
        $testInstance = 'testing';
        $crudApi->setInstance($testInstance);
        $instance = $modelHelper->instance();
        $this->assertEquals($testInstance, $instance, 'Given an instance, modelHelper instance() should return that instance.');
    }

    public function testInstanceMethodReturnsAnInstanceOfAModel()
    {
        $options = [
            'namespace' => 'Test\\AnotherNamespace\\',
            'model' => 'AdditionalModel',
        ];

        $crudApi = new CrudApi($options);
        $modelHelper = new ModelHelper($crudApi);
        $instance = $modelHelper->instance();
        $class = get_class($instance);
        $this->assertEquals('Test\\AnotherNamespace\\AdditionalModel', $class, 'Given an instance, modelHelper instance() should return that instance.');
    }

    public function testGetModelReturnsFalseIfNoModelExists()
    {
        $options = [
            'namespace' => 'Test\\AnotherNamespace\\',
            'model' => 'NonExistantModel',
        ];

        $crudApi = new CrudApi($options);
        $modelHelper = m::mock('\Taskforcedev\CrudApi\Helpers\Model[getAdditionalNamespaces]', [$crudApi]);
        $modelHelper->shouldReceive('getAdditionalNamespaces')->once()->andReturn([]);
        $crudApi->modelHelper = $modelHelper;
        $output = $crudApi->getModel();
        $this->assertFalse($output, 'getModel should return false if asked for non-existant model.');
    }
}
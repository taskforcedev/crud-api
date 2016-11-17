<?php

namespace Test\Unit;

use Test\TestCase;
use Taskforcedev\CrudApi\Helpers\CrudApi;

class CrudApiHelperTest extends TestCase
{
    public function testGetRelatedFieldForUserId()
    {
        $crudApi = new CrudApi(['namespace' => null]);
        $related_field = $crudApi->getRelatedField('user_id');
        $this->assertEquals('user', $related_field);
    }

    public function testGetRelatedFieldForOrganisationId()
    {
        $crudApi = new CrudApi(['namespace' => null]);
        $related_field = $crudApi->getRelatedField('organisation_id');
        $this->assertEquals('organisation', $related_field);
    }

    public function testGetModelDisplayNameWithoutAnInstance()
    {
        $options = [
            'namespace' => null,
            'model' => 'user'
        ];
        $crudApi = new CrudApi($options);
        $display = $crudApi->getModelDisplayName();
        $this->assertEquals('User', $display);
    }

    public function testRenderFieldsWithSimpleFieldListAsCreateForm()
    {
        $fields = ['name', 'password', 'post_code'];
        $options = [
            'namespace' => null,
            'model' => 'user'
        ];
        $crudApi = new CrudApi($options);
        $render = $crudApi->renderFields('form-create', $fields);

        $hasName = strpos($render, 'name');

        var_dump($render, $hasName !== false);

        //$this->assertTrue();
    }
}
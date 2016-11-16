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
        var_dump($display);
        $this->assertEquals('User', $display);
    }
}
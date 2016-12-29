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
            'model' => 'User'
        ];
        $crudApi = new CrudApi($options);
        $display = $crudApi->getModelDisplayName();
        $this->assertEquals('User', $display);
    }

    public function testAuthorUserModelBinding()
    {
        $crudApi = new CrudApi(['namespace' => 'Test\\Models\\', 'model' => 'Post']);
        $related_field = $crudApi->getRelatedField('author_id');
        $this->assertEquals('author', $related_field);
        $relation = $crudApi->getRelatedModel($related_field);
        $class = get_class($relation);
        $this->assertEquals('Test\\Models\\User', $class);
    }
}
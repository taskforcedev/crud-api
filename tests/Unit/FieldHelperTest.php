<?php

namespace Test\Unit;

use Test\Models\Post;
use Test\Models\User;
use Test\TestCase;
use Taskforcedev\CrudApi\Helpers\CrudApi;

class FieldHelperTest extends TestCase
{
    public function testFieldHelperReturnsPrimaryFieldOfNameWhenNoDefaultSpecified()
    {
        $options = [
            'namespace' => 'Test\\Models',
            'model' => 'post'
        ];
        $crudApi = new CrudApi($options);
        $fieldHelper = $crudApi->fieldHelper;

        $item = new Post();

        $config = require __DIR__ . '/../../src/config/crudapi.php';

        $primary_field = $fieldHelper->getPrimaryField($item, $config);

        $this->assertEquals('name', $primary_field);
    }

    public function testFieldHelperReturnsOverriddenModelDefaultField()
    {
        $options = [
            'namespace' => 'Test\\Models',
            'model' => 'user'
        ];
        $crudApi = new CrudApi($options);
        $fieldHelper = $crudApi->fieldHelper;

        $item = new User();

        $config = [
            'models' => [
                'fields' => [
                    'default' => 'name',
                    'primary' => [
                        'User' => 'forename,surname'
                    ],
                ],
            ],
        ];

        $primary_field = $fieldHelper->getPrimaryField($item, $config);

        $this->assertEquals('forename,surname', $primary_field);
    }
}
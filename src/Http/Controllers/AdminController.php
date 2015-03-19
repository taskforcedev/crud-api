<?php

namespace Taskforcedev\CrudAPI\Http\Controllers;

use Illuminate\Http\Request;
use Taskforcedev\CrudAPI\Models\CrudModel;

/**
 * Class AdminController
 *
 * @package Taskforcedev\CrudAPI\Http\Controllers
 */
class AdminController extends Controller
{
    /**
     * @param string $model The model to list.
     */
    public function index($model)
    {
        $class = $this->getModel($model);
        $data = [
            'items' => $class->all(),
            'model' => $model,
            'fields' => $class->getFields()
        ];

        return view('crudapi::admin.index', $data);
    }
}

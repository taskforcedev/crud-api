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
        $model = $this->getModel($model);
        $data = $model->all();

        return view('crud-api::admin.index', $data);
    }
}

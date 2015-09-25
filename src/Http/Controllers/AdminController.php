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
        
        if (is_null($class)) {
            return response("No items found for this class {$class}", 404);
        }

        $items = $class->all();

        $pagination_enabled = config('crudapi.pagination.enabled');
        $pagination_perpage = config('crudapi.pagination.perPage');

        if ($pagination_enabled) {
            $items = $class->paginate($pagination_perpage);
        } else {
            $items = $class->all();
        }

        $data = [
            'items' => $items,
            'model' => $model,
            'fields' => $class->getFields()
        ];

        return view('crudapi::admin.index', $data);
    }
}

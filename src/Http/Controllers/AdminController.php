<?php namespace Taskforcedev\CrudAPI\Http\Controllers;

use \Auth;
use Illuminate\Http\Request;
use Taskforcedev\CrudAPI\Models\CrudModel;
use Taskforcedev\LaravelSupport\Http\Controllers\Controller;

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
        $admin = $this->canAdministrate();
        if ($admin != true) {
            return response("Unauthorised", 401);
        }

        $class = $this->getModel($model);

        if (is_null($class)) {
            return response("No items found for this model {$model}", 404);
        }

        $pagination_enabled = config('crudapi.pagination.enabled');
        $perPage = config('crudapi.pagination.perPage');

        if ($pagination_enabled) {
            $items = $class->paginate($perPage);
        } else {
            $items = $class->all();
        }

        $fields = ( method_exists($class, 'getFields') ? $class->getFields() : $class->getFillable() );

        $data = $this->buildData();
        $data['items'] = $items;
        $data['model'] = $model;
        $data['fields'] = $fields;

        return view('crudapi::admin.index', $data);
    }
}

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
     * @return mixed
     */
    public function index(Request $request, $model)
    {
        if (!Auth::check()) {
            return response("Unauthorised", 401);
        }
        $user = Auth::user();

        if ($user->cannot('administrate')) {
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

        $fields = $class->getFillable();

        $data = $this->buildData();
        $data['items'] = $items;
        $data['model'] = $model;
        $data['fields'] = $fields;
        $data['uiframework'] = config('crudapi.framework', 'bs3');
        $data['timestamps'] = config('crudapi.admin.showTimestamps', false);
        $data['show_ids'] = config('crudapi.admin.showIds', false);

        return view('crudapi::admin.index', $data);
    }
}

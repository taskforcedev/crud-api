<?php

namespace Taskforcedev\CrudAPI\Http\Controllers;

use \Auth;
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
        $admin = $this->checkAdmin();
        if ($admin != true) {
            return response("Unauthorised", 401);
        }
        
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

        $fields = ( method_exists($class, 'getFields') ? $class->getFields() : $class->getFillable() );
        $data = [
            'items' => $items,
            'model' => $model,
            'fields' => $fields
        ];

        return view('crudapi::admin.index', $data);
    }
    
    public function checkAdmin()
    {
        if (!Auth::check()) {
            return false;
        }
        
        $user = Auth::user();
        
        if (method_exists($user, 'can')) {
            /* Attempt to use sentry style permissions to identify permissions */
            try {
                $admin = $user->can('administrate');
                return $admin;
            } catch (\Exception $e) {
                return false;
            }
        }
        
        return false;
    }
}

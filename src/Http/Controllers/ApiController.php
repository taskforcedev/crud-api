<?php

namespace Taskforcedev\CrudAPI\Http\Controllers;

use Auth;
use Exception;
use Illuminate\Http\Request;
use Taskforcedev\CrudAPI\Models\CrudModel;

/**
 * Class ApiController
 *
 * @package Taskforcedev\CrudAPI\Http\Controllers
 */
class ApiController extends Controller
{
    private $user;

    public function __construct()
    {
        $this->user = Auth::user();
    }

    /**
     * Return all items for a given model.
     *
     * @param string $model The model to query.
     *
     * @return mixed
     */
    public function index($model)
    {
        $model = $this->getModel($model);

        try {
            $results = $model->all();
            return $results;
        } catch (Exception $e) {
            return response($e->getMessage(), 500);
        }
    }

    /**
     * Show an individual model item by id.
     *
     * @param string  $model The model to query.
     * @param integer $id    Item Id.
     *
     * @return mixed
     */
    public function show($model, $id)
    {
        $model = $this->getModel($model);
        try {
            return $model->where('id', $id)->firstOrFail();
        } catch (Exception $e) {
            return response('Not Found.', 404);
        }
    }

    /**
     * Stores an entry in the database after validation and hashing.
     * @param  string  $model   Model to store.
     * @param  Request $request Request instance.
     * @return Object           Returns the json of the created object (if successful).
     */
    public function store($model, Request $request)
    {
        $class = $this->getModel($model);

        $data = $request->all();

        if (!Auth::user()) {
            return response('You are not logged in.', 400);
        }

        /* Validate Model data */
        if (!method_exists($class, 'validate')) {
            return response('Unable to validate model data.', 400);
        }

        /* If User has can method (ACL checking):  Check user has access */
        $permission = 'insert-' . $model;
        if (!$this->permissionCheck($permission)) {
            return response('Unauthorised.', 401);
        }

        /* Ensure data is valid */
        $valid = $model->validate($data);
        if (!$valid) {
            return response('Model data is invalid', 400);
        }

        /* Sanitize passwords */
        if (array_key_exists('password', $data)) {
            $data['password'] = \Hash::make($data['password']);
        }

        /* Create the item */
        return $model::create($data);
    }

    /**
     * Delete an item.
     * @param string  $model The model from which to delete.
     * @param integer $id    The id of the item to delete.
     */
    public function destroy($model, $id)
    {
        $model = $this->getModel($model);

        /* If User has can method (ACL checking):  Check user has access */
        $permission = 'delete-' . $model;
        if (!$this->permissionCheck($permission)) {
            return response('Unauthorised.', 401);
        }

        return $model->where('id', $id)->delete();
    }

    public function permissionCheck($permission)
    {
        if (method_exists($this->user, 'can')) {
            return $this->user->can($permission);
        }
    }
}

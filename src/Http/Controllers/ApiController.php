<?php

namespace Taskforcedev\CrudAPI\Http\Controllers;

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
        $model = $this->getModel($model);

        $data = $request->all();

        /* Validate Model data */
        if (!method_exists($model, 'validate')) {
            return response('Unable to validate model data', 400);
        }

        /* Ensure data is valid */
        $valid = $model->validate($data);
        if (!$valid) { return response('Model data is invalid', 400); }

        /* Sanitize passwords */
        if (array_key_exists('password', $data)) {
            $data['password'] = \Hash::make($data['password']);
        }

        /* Create the item */
        return $model::create($data);
    }
}

<?php namespace Taskforcedev\CrudAPI\Http\Controllers;

use Auth;
use Exception;
use Validator;
use Illuminate\Http\Request;
use Taskforcedev\CrudAPI\Models\CrudModel;
use Taskforcedev\LaravelSupport\Http\Controllers\Controller;

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
        $user = Auth::user();

        $permission = 'list-' . lcfirst($model) . 's';

        if ($user->cannot($permission)) {
            return response('Unauthorised.', 401);
        }

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
        $class = $this->getModel($model);

        $user = Auth::user();
        $permission = 'view-' . $model;

        if ($user->cannot($permission, $id)) {
            return response('Unauthorised.', 401);
        }

        try {
            return $class->where('id', $id)->firstOrFail();
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
        if (!Auth::user()) {
            return response('You are not logged in.', 400);
        }

        $class = $this->getModel($model);

        $data = $request->all();

        /* If User has can method (ACL checking):  Check user has access */
        $permission = 'create-' . $model;
        $user = Auth::user();

        if ($user->cannot($permission)) {
            return response('Unauthorised.', 401);
        }

        /* Validate Model data */
        $validated = $this->validateModelData($class, $data);
        if ($validated !== true) {
            return $validated;
        }

        /* Sanitize passwords */
        if (array_key_exists('password', $data)) {
            $data['password'] = \Hash::make($data['password']);
        }

        /* Create the item */
        return $class::create($data);
    }

    /**
     * Delete an item.
     * @param string  $model The model from which to delete.
     * @param integer $id    The id of the item to delete.
     */
    public function destroy($model, $id)
    {
        if (!Auth::check()) {
            return response('You must be logged in and authorised to perform this action.', 401);
        }

        $class = $this->getModel($model);

        /* If User has can method (ACL checking):  Check user has access */
        $permission = 'delete-' . $model;
        $user = Auth::user();

        if (!$user->can($permission, $id)) {
            return response('Unauthorised.', 401);
        }

        return $class->where('id', $id)->delete();
    }

    /**
     * Validates if data matches models validation.
     * @param object $model The model to perform validation on.
     * @param mixed  $data  The data to validate.
     * @return bool
     */
    private function validateModelData($model, $data)
    {
        if (method_exists($model, 'validate')) {
            return $model->validate($data);
        }

        if (property_exists($model, 'validation')) {
            /* Build Validator manually */
            $validation = $model->validation;
            $validator = Validator::make($data, $validation);
            if ($validator->fails()) {
                return response('Model data is not valid.', 400);
            } else {
                return true;
            }
        }

        return response('Unable to validate model data.', 400);
    }
}

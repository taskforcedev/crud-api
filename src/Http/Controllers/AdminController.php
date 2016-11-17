<?php

namespace Taskforcedev\CrudApi\Http\Controllers;

use Auth;
use Validator;
use Illuminate\Http\Request;
use Taskforcedev\LaravelSupport\Http\Controllers\Controller;
use Taskforcedev\CrudApi\Helpers\CrudApi;

/**
 * Class AdminController.
 */
class AdminController extends Controller
{
    public $apiHelper;

    public function __construct()
    {
        $this->apiHelper = new CrudApi();
    }

    public function index($model)
    {
        if (!Auth::check()) {
            return redirect('/');
        }

        $this->apiHelper->setModel($model);
        $fqModel = $this->apiHelper->getModel();

        if (Auth::user()->cannot('create', $fqModel)) {
            return redirect('/');
        }

        if ($fqModel === false) {
            return response('Model does not exist', 404);
        }

        $instance = new $fqModel();
        $this->apiHelper->setInstance($instance);

        $data = $this->buildData();

        $data['apiHelper'] = $this->apiHelper;
        $data['model'] = $model;
        $data['instance'] = $instance;
        $data['fields'] = $instance->getFillable();
        $data['results'] = $fqModel::all();

        return view('crudapi::admin.bs4.index', $data);
    }

    public function store(Request $request, $model)
    {
        $this->apiHelper->setModel($model);
        $fqModel = $this->apiHelper->getModel();

        if ($fqModel === false) {
            return response('Model does not exist', 404);
        }

        $instance = new $fqModel();
        $fields = $instance->getFillable();

        /* Validation */
        $this->validate($request, $instance->validation);

        $fqModel::create($request->only($fields));

        return response('Item Created', 200);
    }

    public function update(Request $request, $model)
    {
        $this->apiHelper->setModel($model);
        $fqModel = $this->apiHelper->getModel();

        if ($fqModel === false) {
            return response('Model does not exist', 404);
        }

        $instance = new $fqModel();
        $fields = $instance->getFillable();

        // Get the item
        $id = $request->get('id');

        try {
            $item = $fqModel::where('id', $id)->firstOrFail();

            foreach ($fields as $f) {
                if ($request->has($f)) {
                    $value = $request->get($f);
                    $item->$f = $value;
                }
            }

            // Check the item will still be valid
            $validator = Validator::make($item->toArray(), $instance->validation);

            if ($validator->fails()) {
                return response('Model validation failed.', 406);
            }

            $item->save();

            return response('Item Updated', 200);
        } catch (ModelNotFoundException $e) {
            return response('Not found', 404);
        }
    }

    public function delete(Request $request, $model)
    {
        $this->apiHelper->setModel($model);
        $fqModel = $this->apiHelper->getModel();

        if ($fqModel === false) {
            return response('Model does not exist', 404);
        }

        // Get the item
        $id = $request->get('id');

        try {
            $item = $fqModel::where('id', $id)->firstOrFail();
            $item->delete();

            return response('Item Deleted', 200);
        } catch (ModelNotFoundException $e) {
            return response('Not found', 404);
        }
    }
}

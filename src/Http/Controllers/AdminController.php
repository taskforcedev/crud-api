<?php namespace Taskforcedev\CrudAPI\Http\Controllers;

use \Auth;
use \Validator;
use Illuminate\Http\Request;
use Taskforcedev\LaravelSupport\Http\Controllers\Controller;
use Taskforcedev\CrudAPI\Helpers\CrudApi;

/**
 * Class AdminController
 *
 * @package Taskforcedev\CrudAPI\Http\Controllers
 */
class AdminController extends Controller
{
    /**
     * Qualify the model name to it's matching class
     * @param $model
     */
    private function qualifyModel($model)
    {
        $crudApi = new CrudApi();
        $crudApi->setModel($model);
        return $crudApi->getModel();
    }

    public function index($model)
    {
        $fqModel = $this->qualifyModel($model);

        $exists = class_exists($fqModel);
        if (!$exists) {
            return response('Model does not exist', 404);
        }

        $apiHelper = new CrudApi();
        $apiHelper->setModel($model);

        $instance = new $fqModel;
        $apiHelper->setInstance($instance);

        $items = $fqModel::all();
        $apiHelper->setCollection($items);

        $data = $this->buildData();

        $data['apiHelper'] = $apiHelper;
        $data['model'] = $model;
        $data['instance'] = $instance;
        $data['fields'] = $instance->getFillable();
        $data['results'] = $fqModel::all();

        return view('crudapi::admin.bs4.index', $data);
    }

    public function store(Request $request, $model)
    {
        $fqModel = 'App\\' . ucfirst($model);

        $exists = class_exists($fqModel);
        $instance = new $fqModel;

        $fields = $instance->getFillable();

        if (!$exists) {
            return response('Model does not exist', 404);
        }

        /* Validation */
        $this->validate($request, $instance->validation);

        $fqModel::create($request->only($fields));

        return response('Item Created', 200);
    }

    public function update(Request $request, $model)
    {
        $fqModel = 'App\\' . ucfirst($model);

        $exists = class_exists($fqModel);
        $instance = new $fqModel;

        $fields = $instance->getFillable();

        if (!$exists) {
            return response('Model does not exist', 404);
        }

        // Get the item
        $id = $request->get('id');

        try {
            $item = $fqModel::where('id', $id)->firstOrFail();

            foreach ($fields as $f)
            {
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
        $fqModel = 'App\\' . ucfirst($model);

        $exists = class_exists($fqModel);
        $instance = new $fqModel;

        $fields = $instance->getFillable();

        if (!$exists) {
            return response('Model does not exist', 404);
        }

        // Get the item
        $id = $request->get('id');

        try {
            $item = $fqModel::where('id', $id)->firstOrFail();

            foreach ($fields as $f)
            {
                if ($request->has($f)) {
                    $value = $request->get($f);
                    $item->$f = $value;
                }
            }

            $item->delete();

            return response('Item Deleted', 200);
        } catch (ModelNotFoundException $e) {
            return response('Not found', 404);
        }
    }
}

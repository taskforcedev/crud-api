<?php

namespace Taskforcedev\CrudAPI\Http\Controllers;

use Illuminate\Http\Request;
use Taskforcedev\CrudAPI\Models\CrudModel;

class ApiController extends Controller
{
    private $namespace;

    public function __construct()
    {
        $this->namespace = $this->getModelNamespace();
    }

    public function index($model)
    {
        $model = $this->getModel($model);
        
        try {
            $results = $model->all();
            return $results;
        } catch (Exception $e) {
            return response($e->getMessage, 500);
        }
    }

    public function show($model, $id)
    {
        $model = $this->getModel($model);
        try {
            $model->where('id', $id)->firstOrFail();
        } catch (Exception $e) {
            return response('Not Found.', 404);
        }
    }

    public function store($model)
    {
        // TODO
        $model = $this->getModel($model);
    }

    public function create($model)
    {
        $model = $this->getModel($model);
    }

    private function qualify($model)
    {
        return $this->namespace . '\\' . $model;
    }

    private function getModel($model)
    {
        $model = $this->qualify($model);
        return new $model;
    }
}

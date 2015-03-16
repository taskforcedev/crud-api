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
        $model = $this->qualify($model);
        
        try {
            $results = (new $model)->all();
            return $results;
        } catch (Exception $e) {
            return response($e->getMessage, 500);
        }

        

        // TODO
		//var_dump($this->fq_model);
        //$model = new $this->fq_model;
        //var_dump($model->newQuery()->where('id', 1)->firstOrFail());
    }

    public function show($model, $id)
    {
        $model = $this->qualify($model);
        var_dump($model);
    }

    public function store()
    {
        // TODO
    }

    public function create()
    {
        // TODO
    }

    public function qualify($model)
    {
        return $this->namespace . '\\' . $model;
    }
}

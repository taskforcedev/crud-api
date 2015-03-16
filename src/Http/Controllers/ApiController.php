<?php

namespace Taskforcedev\CrudAPI\Http\Controllers;

use Illuminate\Http\Request;
use Taskforcedev\CrudAPI\Models\CrudModel;

class ApiController extends Controller
{
    private $request;
    private $model;

    public function __construct(Request $request)
    {
        $this->request = $request;
        $valid = $this->validateModel();

        if (!$valid) {
            return response("Required field model was not passed", 400);
        }

        /* Attempt to resolve the Model */
    }

    public function index()
    {
        // TODO
        $test = $this->determineNamespace();
        var_dump($test);
    }

    public function show()
    {
        // TODO
    }

    public function store()
    {
        // TODO
    }

    public function create()
    {
        // TODO
    }

    /**
     * Validates that the request has the model field populated
     */
    private function validateModel()
    {
        return $this->request->has('model');
    }
}

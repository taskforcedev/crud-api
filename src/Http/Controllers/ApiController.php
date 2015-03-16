<?php

namespace Taskforcedev\CrudAPI\Http\Controllers;

use Illuminate\Http\Request;
use Taskforcedev\CrudAPI\Models\CrudModel;

class ApiController extends Controller
{
    private $request;
    private $model;
    private $fq_model;

    public function __construct(Request $request)
    {
        $this->request = $request;
        $valid = $this->validateModel();

        if (!$valid) {
            return response("Required field model was not passed.", 400);
        }

        $namespace = $this->getModelNamespace();

        if (!isset($namespace)) {
            return response("Namespace is invalid.", 400);
        }

        /* Attempt to resolve the Model */
        $this->fq_model = $namespace . '\\' . $this->request->input('model');
    }

    public function index()
    {
        // TODO
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

<?php

namespace Taskforcedev\CrudAPI\Http\Controllers;

use Illuminate\Http\Request;
use Taskforcedev\CrudAPI\Models\CrudApiModel;

class ApiController extends Controller
{
    private $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
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

    private function validate()
    {
        
    }
}

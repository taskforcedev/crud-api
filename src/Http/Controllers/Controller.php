<?php

namespace Taskforcedev\CrudAPI\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesCommands;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;

/**
 * Class Controller
 *
 * @package Taskforcedev\CrudAPI\Http\Controllers
 */
abstract class Controller extends BaseController
{
    use DispatchesCommands, ValidatesRequests;

    protected $namespace;

    public function __construct()
    {
        $this->namespace = $this->getModelNamespace();
    }

    /**
     * Gets the namespace of the applications models (from user config).
     * @return mixed
     */
    protected function getModelNamespace()
    {
        return config('crudapi.model_ns');
    }

    /**
     * Fully qualifies the model name based on configuration.
     * @param  string $model The name of the model.
     * @return string        Fully qualified model name.
     */
    protected function qualify($model)
    {
        return $this->namespace . '\\' . $model;
    }

    /**
     * Return the model based on it's name.
     * @param  string $model The name of the model.
     * @return Object        A new fully qualified model instance.
     */
    protected function getModel($model)
    {
        $model = $this->qualify($model);
        return new $model;
    }
}

<?php

namespace Taskforcedev\CrudAPI\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesCommands;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Console\AppNamespaceDetectorTrait;

/**
 * Class Controller
 *
 * @package Taskforcedev\CrudAPI\Http\Controllers
 */
abstract class Controller extends BaseController
{
    use DispatchesCommands, ValidatesRequests, AppNamespaceDetectorTrait;

    /**
     * Gets the namespace of the applications models (from user config).
     * @return mixed
     */
    protected function getModelNamespace()
    {
        try {
            $ns = $this->getAppNamespace();
            return $ns;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Fully qualifies the model name based on configuration.
     * @param  string $model The name of the model.
     * @return string        Fully qualified model name.
     */
    protected function qualify($model)
    {
        return $this->getModelNamespace() . $model;
    }

    /**
     * Return the model based on its name.
     * @param  string $model The name of the model.
     * @return Object        A new fully qualified model instance.
     */
    protected function getModel($model)
    {
        $model = $this->qualify($model);
        if (!class_exists($model)) {
            return null;
        }
        return new $model;
    }
}

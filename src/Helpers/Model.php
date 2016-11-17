<?php

namespace Taskforcedev\CrudApi\Helpers;

/**
 * Class Model.
 */
class Model
{
    public $crudApi;

    /**
     * Model constructor.
     *
     * @param CrudApi $crudApi
     */
    public function __construct(CrudApi $crudApi)
    {
        $this->crudApi = $crudApi;
    }

    /**
     * Get a model from the currently set namespace and model.
     *
     * If the model does not exist from the base namespace it will also
     * look in the namespace\Models as a secondary convention.
     *
     * @return false|string
     */
    public function getModel($model = null)
    {
        if ($model === null) {
            $model = $this->crudApi->model;
        }

        if ($model === null) {
            return false;
        }

        // If namespace is not detected or set then set to the laravel default of App.
        if ($this->crudApi->namespace === null) {
            $this->crudApi->setNamespace('App');
        }

        $fqModel = $this->crudApi->namespace.$model;

        if (!class_exists($fqModel)) {
            $fqModel = $this->crudApi->namespace.'Models\\'.$model;
            if (!class_exists($fqModel)) {
                return false;
            }
        }

        return $fqModel;
    }

    public function instance()
    {
        if ($this->crudApi->instance === null) {
            $fq = $this->getModel();
            $instance = new $fq();
            $this->crudApi->setInstance($instance);
        }

        return $this->crudApi->instance;
    }
}
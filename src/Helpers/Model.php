<?php

namespace Taskforcedev\CrudApi\Helpers;

/**
 * Class Model
 *
 * @package Taskforcedev\CrudApi\Helpers
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
    public function getModel()
    {
        var_dump($this->crudApi->model);
        $fqModel = $this->crudApi->namespace . $this->crudApi->model;

        if (!class_exists($fqModel)) {
            $fqModel = $this->namespace . 'Models\\'.$this->model;
            if (!class_exists($fqModel)) {
                return false;
            }
        }

        return $fqModel;
    }
}
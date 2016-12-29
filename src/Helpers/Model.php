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

        // Make Sure model name is uppercased.
        $model = ucfirst($model);

        // If namespace is not detected or set then set to the laravel default of App.
        if ($this->crudApi->namespace === null) {
            $this->crudApi->setNamespace('App\\');
        }


        // Test conventional namespace model combinations
        $conventions = [
            $this->crudApi->namespace . $model,
            $this->crudApi->namespace . 'Models\\' . $model
        ];

        foreach ($conventions as $fqModel) {
            if (class_exists($fqModel)) {
                return $fqModel;
            }
        }

        try {
            // If not conventional, try configurable
            $additionalNamespaces = $this->getAdditionalNamespaces();
            if (!empty($additionalNamespaces)) {
                foreach ($additionalNamespaces as $ns) {
                    $fqModel = $ns . $model;
                    if (class_exists($fqModel)) {
                        return $fqModel;
                    }
                }
            }
        } catch (\Exception $e) {
            return false;
        }

        return false;
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

    public function getAdditionalNamespaces()
    {
        return config('crudapi.models.namespaces');
    }
}

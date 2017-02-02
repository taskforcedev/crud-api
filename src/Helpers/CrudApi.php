<?php

namespace Taskforcedev\CrudApi\Helpers;

use Illuminate\Console\DetectsApplicationNamespace;

class CrudApi
{
    use DetectsApplicationNamespace;

    public $model;
    public $instance;
    public $namespace;
    public $modelHelper;
    public $fieldHelper;

    /**
     * CrudApi Helper.
     * @param array $options
     */
    public function __construct($options = [])
    {
        /* Set the namespace */
        if (array_key_exists('namespace', $options)) {
            $this->namespace = $options['namespace'];
        } else {
            $this->namespace = $this->getAppNamespace();
        }

        /* Set the model */
        if (array_key_exists('model', $options)) {
            $this->model = $options['model'];
        }

        $this->modelHelper = new Model($this);
        $this->fieldHelper = new Field($this);
    }

    /**
     * Set the Crud API Model Helper.
     * @param object $modelHelper Model Helper Object.
     */
    public function setModelHelper($modelHelper)
    {
        $this->modelHelper = $modelHelper;
    }

    /**
     * Set the namespace to search within.
     *
     * @param string $namespace
     */
    public function setNamespace($namespace)
    {
        $this->namespace = $namespace;
    }

    /**
     * Set the model to work with.
     *
     * @param string $model Model name.
     *
     * @return $this
     */
    public function setModel($model)
    {
        $this->model = $model;

        return $this;
    }

    /**
     * Set a model instance from which to work.
     *
     * @param Object $item Model instance
     *
     * @return $this
     */
    public function setInstance($item)
    {
        $this->instance = $item;

        return $this;
    }

    /**
     * Get Fields
     *
     * Get a models fillable fields.
     *
     * @return array
     */
    public function getFields()
    {
        $model = $this->getModelInstance();
        $fields = $model->getFillable();
        $filtered_fields = [];

        foreach ($fields as $f) {
            if ($f !== 'password' && $f !== 'Password') {
                $filtered_fields[] = $f;
            }
        }

        return $filtered_fields;
    }

    /**
     * Get a models display name.
     * @return string
     */
    public function getModelDisplayName()
    {
        $instance = $this->getModelInstance();
        $display = isset($instance->display) ? $instance->display : ucfirst($this->model);

        return $display;
    }

    /**
     * Get an instance of a model.
     * @return bool
     */
    public function getModelInstance()
    {
        if ($this->instance !== null) {
            return $this->instance;
        }
        $model = $this->getModel();
        if ($model === false) {
            return false;
        }
        $instance = new $model();

        return $instance;
    }

    /**
     * Generate a modal for a model.
     * @param string $type Modal type (edit, create, delete).
     * @return object
     */
    public function modal($type)
    {
        $trimmed_item = $this->trimmedModel();

        $modalId = $type.$trimmed_item.'Modal';

        $display = $this->getModelDisplayName();

        $modal = (object) [
            'id' => $modalId,
            'title' => ucfirst($type).' '.$display,
            'url' => $this->modalUrl($type),
        ];

        return $modal;
    }

    /**
     * Get the modals url.
     *
     * @param $type
     *
     * @return string
     */
    private function modalUrl($type)
    {
        switch ($type) {
        case 'edit':
            $action = 'update';
            break;
        default:
            $action = $type;
            break;
        }

        return route('crudapi.'.$action.'.item', $this->model);
    }

    /**
     * Get the name of the javascript method for a model.
     *
     * @param $method
     *
     * @return string
     */
    public function jsMethodName($method)
    {
        // Method == create
        $jsMethod = $method.$this->trimmedModel();

        return $jsMethod;
    }

    /**
     * Render fields.
     * @param $type
     * @param array $fields
     */
    public function renderFields($type, $fields = [])
    {
        if (empty($fields)) {
            $fields = $this->getFields();
        }
        $output = '';

        switch ($type) {
        case 'form-create':
            $output .= $this->fieldHelper->formCreate($fields);
            break;
        case 'form-edit':
            $output .= $this->fieldHelper->formEdit($fields);
            break;
        case 'table-headings':
            $output .= $this->fieldHelper->tableHeadings($fields);
            break;
        case 'table-content':
            $output .= $this->fieldHelper->tableContent($fields, $this->instance);
            break;
            // JavaScript Variables
        case 'js-var':
            foreach ($fields as $f) {
                $output .= 'var '.$f.' = '.$this->instance->$f.'; ';
            }
            break;
        case 'js-modal-create':
            foreach ($fields as $f) {
                $output .= '"'.$f.'": $(\'#createItem'.$f.'\').val(), ';
            }
            break;
        default:
            return;
                break;
        }

        echo $output;
    }

    public function trimmedModel()
    {
        return strpos($this->model, ' ') !== false ? implode('', explode(' ', $this->model)) : $this->model;
    }

    public function getRelatedOptions($relation)
    {
        $output = '';

        if (!method_exists($relation, 'toOptions')) {
            $relationItems = $relation::all();
            foreach ($relationItems as $item) {
                if (!isset($item->name)) {
                    // Error - there is no toOptions or name property.
                } else {
                    $output .= '<option value="'.$item->id.'">'.$item->name.'</option>';
                }
            }
        } else {
            $output .= $relation->toOptions();
        }

        return $output;
    }

    public function getRelatedModel($f)
    {
        $field = $this->getRelatedField($f);
        $model = $this->getModel($field);

        $modelAliases = [
            'author' => 'user',
        ];

        // If class doesn't exist, check if is in aliases array.
        if (!class_exists($model)) {
            if (array_key_exists($field, $modelAliases)) {
                $aliasedModel = $modelAliases[$field];
                $model = $this->getModel($aliasedModel);
            }
        }

        // Model could not be found, try via it's converted name.
        if (!class_exists($model)) {
            // Convert from DB format to Pascal
            $words = explode('_', $field);
            foreach ($words as $i => $w) {
                $words[$i] = ucfirst($w);
            }
            $formatted = implode('', $words);
            $model = 'App\\'.$formatted;
            if (!class_exists($model)) {
                return false;
            }
        }

        return new $model();
    }

    public function getRelatedDisplay($f)
    {
        $related_field = $this->getRelatedField($f);

        $field = $this->instance->$related_field;

        $class = get_class($field);

        switch ($class) {
        case 'App\\Helpers\\CrudApi':
            break;
        case 'App\\Indicator':
            return $field->indicator;
                break;
        case 'Taskforcedev\\CrudApi\\Helpers\\CrudApi':
            return false;
                break;
        default:
            return $field->name;
                break;
        }
    }

    /**
     * Allow certain methods to be passed through to the specified
     * helper in order to make methods easier to remember.
     *
     * @param $method
     * @param $args
     *
     * @method string getRelatedField
     * @method string getPrimaryField
     * @method bool isIdField
     * @method mixed getModel
     *
     * @return bool
     */
    public function __call($method, $args)
    {
        switch ($method) {
            case 'getRelatedField':
                return $this->fieldHelper->getRelatedField($args[0]);
            case 'getPrimaryField':
                return $this->fieldHelper->getPrimaryField($args[0]);
            case 'isIdField':
                return $this->fieldHelper->isIdField($args[0]);
            case 'getModel':
                if (isset($args[0])) {
                    return $this->modelHelper->getModel($args[0]);
                } else {
                    return $this->modelHelper->getModel();
                }
            default:
                break;
        }
    }
}

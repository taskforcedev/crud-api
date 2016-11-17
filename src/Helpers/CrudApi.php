<?php

namespace Taskforcedev\CrudApi\Helpers;

use Illuminate\Console\AppNamespaceDetectorTrait;

class CrudApi
{
    use AppNamespaceDetectorTrait;

    public $model;
    public $instance;
    public $namespace;
    public $modelHelper;
    public $fieldHelper;

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
     * @param $model
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
     * @param $item
     *
     * @return $this
     */
    public function setInstance($item)
    {
        $this->instance = $item;

        return $this;
    }

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

    public function getModelDisplayName()
    {
        $instance = $this->getModelInstance();
        $display = isset($instance->display) ? $instance->display : ucfirst($this->model);

        return $display;
    }

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

    public function jsMethodName($method)
    {
        // Method == create
        $jsMethod = $method.$this->trimmedModel();

        return $jsMethod;
    }

    public function renderFields($type)
    {
        $fields = $this->getFields();
        $instance = $this->getModelInstance();
        $output = '';

        switch ($type) {
        case 'form-create':
            foreach ($fields as $f) {
                $ucF = ucfirst($f);

                $input_attr = [
                    'class' => 'form-control',
                    'id' => 'createItem'.$f,
                    'name' => $f,
                ];

                $output .= '<fieldset class="form-group">';

                $output .= '<label for="'.$input_attr['id'].'">'.$ucF.'</label>';

                if ($this->fieldHelper->isIdField($f)) {
                    $input_attr['type'] = 'select';

                    $output .= '<select ';
                    foreach ($input_attr as $attr => $value) {
                        $output .= "{$attr}='{$value}'";
                    }

                    $relation = $this->getRelatedModel($f);
                    $output .= '>';

                    $output .= $this->getRelatedOptions($relation);

                    $output .= '</select>';
                } else {
                    $input_attr['type'] = 'text';

                    $output .= '<input ';
                    foreach ($input_attr as $attr => $value) {
                        $output .= "{$attr}='{$value}'";
                    }
                    $output .= '>';
                }

                $output .= '</fieldset>';
            }
            break;
        case 'form-edit':
            foreach ($fields as $f) {
                $ucF = ucfirst($f);

                $input_attr = [
                    'class' => 'form-control',
                    'id' => 'editItem'.$ucF,
                    'name' => $f,
                ];

                $output .= '<fieldset class="form-group">';

                $output .= '<label for="'.$input_attr['id'].'">'.$ucF.'</label>';

                if ($this->fieldHelper->isIdField($f)) {
                    $input_attr['type'] = 'select';

                    $output .= '<select ';
                    foreach ($input_attr as $attr => $value) {
                        $output .= "{$attr}='{$value}'";
                    }

                    $relation = $this->getRelatedModel($f);
                    $output .= '>';

                    $output .= $this->getRelatedOptions($relation);
                    $output .= '</select>';
                } else {
                    $input_attr['type'] = 'text';

                    $output .= '<input ';
                    foreach ($input_attr as $attr => $value) {
                        $output .= "{$attr}='{$value}'";
                    }
                    $output .= '>';
                }

                $output .= '</fieldset>';
            }
            break;
        case 'table-headings':
            foreach ($fields as $f) {
                $output .= '<th>'.ucfirst($f).'</th>';
            }
            break;
        case 'table-content':
            foreach ($fields as $f) {
                if ($this->fieldHelper->isIdField($f)) {
                    $display = $this->getRelatedDisplay($f);
                    $output .= '<td>'.$display.'</td>';
                } else {
                    $output .= '<td>'.$this->instance->$f.'</td>';
                }
            }
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
     * @return bool
     */
    public function __call($method, $args)
    {
        switch ($method) {
            case 'getRelatedField':
                return $this->fieldHelper->getRelatedField($args[0]);
            case 'getPrimaryField':
                return $this->fieldHelper->getPrimaryField($args[0]);
                break;
            case 'isIdField':
                return $this->fieldHelper->isIdField($args[0]);
                break;
            case 'getModel':
                if (isset($args[0])) {
                    return $this->modelHelper->getModel($args[0]);
                } else {
                    return $this->modelHelper->getModel();
                }

                break;
            default:
                break;
        }
    }
}

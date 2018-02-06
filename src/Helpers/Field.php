<?php

namespace Taskforcedev\CrudApi\Helpers;

/**
 * Class Field.
 */
class Field
{
    public $crudApi;

    /**
     * Field constructor.
     *
     * @param CrudApi $crudApi
     */
    public function __construct(CrudApi $crudApi)
    {
        $this->crudApi = $crudApi;
    }

    /**
     * Determine if the field is an id field.
     *
     * @param $field
     *
     * @return bool
     */
    public function isIdField($field)
    {
        return strpos($field, '_id') === false ? false : true;
    }

    /**
     * Parse a relation field name into the relation name.
     *
     * @param string $field Field name
     *
     * @return string
     */
    public function getRelatedField($field)
    {
        $relation = str_replace('_id', '', $field);

        return $relation;
    }

    /**
     * Retrieve the models primary field for display purposes.
     *
     * @param            $item   Model to retrieve primary field of
     * @param null|array $config CrudApi Configuration
     *
     * @return string
     */
    public function getPrimaryField($item, $config = null)
    {
        /* If config is not overridden then load crudapi config */
        if ($config === null) {
            $config = config('crudapi');
        }
        if (!isset($config['models']['fields']['default'])) {
            $defaultField = 'name';
        } else {
            $defaultField = $config['models']['fields']['default'];
        }

        /* Get the items Class */
        $class = get_class($item);

        $stripped_class = str_replace($this->crudApi->namespace, '', $class);
        // if class starts with a \ remove it.
        if (substr($stripped_class, 0, 1) == '\\') {
            $stripped_class = substr($stripped_class, 1);
        }

        $primaryFields = $config['models']['fields']['primary'];

        if (array_key_exists($stripped_class, $primaryFields)) {
            return $primaryFields[$stripped_class];
        } else {
            //return the default
            return $defaultField;
        }
    }

    /**
     * Display the primary field.
     *
     * @param $item
     * @param null $config
     *
     * @return mixed
     */
    public function displayPrimaryField($item, $config = null)
    {
        $field = $this->getPrimaryField($item, $config);

        return $item->$field;
    }

    /**
     * Render fields into appropriate format for an item creation form.
     *
     * @param $fields
     *
     * @return string
     */
    public function formCreate($fields)
    {
        $output = '';

        foreach ($fields as $f) {
            $ucF = ucfirst($f);

            $input_attr = [
                'class' => 'form-control',
                'id' => 'createItem'.$f,
                'name' => $f,
            ];

            $label = $this->humanReadableField($ucF);

            $output .= '<fieldset class="form-group">';

            $output .= '<label for="'.$input_attr['id'].'">'.$label.'</label>';

            if ($this->isIdField($f)) {
                $input_attr['type'] = 'select';

                $output .= '<select ';
                foreach ($input_attr as $attr => $value) {
                    $output .= "{$attr}='{$value}'";
                }

                $relation = $this->crudApi->getRelatedModel($f);
                $output .= '>';

                $output .= $this->crudApi->getRelatedOptions($relation);

                $output .= '</select>';
            } else {
                $input_attr['type'] = 'text';

                $output .= '<input';
                foreach ($input_attr as $attr => $value) {
                    $output .= " {$attr}='{$value}'";
                }
                $output .= '>';
            }

            $output .= '</fieldset>';
        }

        return $output;
    }

    /**
     * Render fields into appropriate format for an edit form.
     *
     * @param array $fields Fields to render.
     *
     * @return string
     */
    public function formEdit($fields)
    {
        $output = '';
        foreach ($fields as $f) {
            $ucF = ucfirst($f);

            $input_attr = [
                'class' => 'form-control',
                'id' => 'editItem'.$ucF,
                'name' => $f,
            ];

            $label = $this->humanReadableField($ucF);

            $output .= '<fieldset class="form-group">';

            $output .= '<label for="'.$input_attr['id'].'">'.$label.'</label>';

            if ($this->isIdField($f)) {
                $input_attr['type'] = 'select';

                $output .= '<select ';
                foreach ($input_attr as $attr => $value) {
                    $output .= "{$attr}='{$value}'";
                }

                $relation = $this->crudApi->getRelatedModel($f);
                $output .= '>';

                $output .= $this->crudApi->getRelatedOptions($relation);
                $output .= '</select>';
            } else {
                $input_attr['type'] = 'text';

                $output .= '<input';
                foreach ($input_attr as $attr => $value) {
                    $output .= " {$attr}='{$value}'";
                }
                $output .= '>';
            }

            $output .= '</fieldset>';
        }
        return $output;
    }

    /**
     * Return fields as table headings.
     *
     * @param array $fields Fields to display.
     *
     * @return string
     */
    public function tableHeadings($fields)
    {
        $output = '';
        foreach ($fields as $f) {
            $field = $this->humanReadableField($f);
            $output .= '<th>'.$field.'</th>';
        }

        return $output;
    }

    /**
     * Output the instances fields into table content format.
     *
     * @param array $fields
     * @param $instance
     *
     * @return string
     */
    public function tableContent($fields, $instance)
    {
        $output = '';
        foreach ($fields as $f) {
            if ($this->isIdField($f)) {
                $related = $this->getRelatedField($f);
                $relation = $instance->$related;
                $field = $this->getPrimaryField($relation);
                if (strpos($field, ',')) {
                    $subfields = explode(',', $field);
                    $display = '';
                    foreach ($subfields as $sf) {
                        $display .= $relation->$sf.' ';
                    }
                } else {
                    $display = $relation->$field;
                }
                $output .= '<td>'.$display.'</td>';
            } else {
                $output .= '<td>'.$instance->$f.'</td>';
            }
        }

        return $output;
    }

    /**
     * Convert a field internal name into human readable name.
     *
     * Example:
     *  'Organisation_id' becomes 'Organisation Id'.
     *
     * @param string $field Field to convert.
     *
     * @return mixed|string
     */
    public function humanReadableField($field)
    {
        $field = str_replace('_id', ' Id', $field);
        $field = ucwords($field);
        return $field;
    }
}

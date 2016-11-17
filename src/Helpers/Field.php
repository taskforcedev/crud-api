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
     * @param            $item   Model to retrieve primary field of.
     * @param null|array $config CrudApi Configuration.
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
}

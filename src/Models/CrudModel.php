<?php

namespace Taskforcedev\CrudAPI\Models;

use Illuminate\Database\Eloquent\Model;

abstract class CrudModel extends Model
{
    /**
     * Model must provide class to validate incomming data
     * @return bool Returns if the data is valid.
     */
    abstract public function validate($data);
}

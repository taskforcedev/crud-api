<?php

namespace Taskforcedev\CrudAPI\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesCommands;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;

abstract class Controller extends BaseController
{
    use DispatchesCommands, ValidatesRequests;

    protected function determineNamespace()
    {
        $vendorFolder = __DIR__ . '../../../../../';
        $appFolder = $vendorFolder . '../app';
        $namespace_check = $appFolder . '/Http/Controllers/Controller.php';
        return file_exists($namespace_check);
    }
}

<?php
namespace Taskforcedev\CrudApi\Http\Controllers;
use Auth;
use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Taskforcedev\LaravelSupport\Http\Controllers\Controller;
use Taskforcedev\CrudApi\Helpers\CrudApi;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Console\DetectsApplicationNamespace;

/**
 * Class CrudApiController.
 */
class CrudApiController extends Controller
{
    public $models;
    public function index()
    {
        $data = $this->buildData();
        $this->loadModels();
        if (!empty($this->models)) {
            $data['models'] = $this->models;
            return view('crudapi::admin.dashboard', $data);
        }
    }
    public function loadModels()
    {
        $this->loadAppModels();
    }
    public function loadAppModels()
    {
        $appFolder = app_path();
        $namespace = $this->getAppNamespace();
        $this->getPhpFiles($appFolder, $namespace);
    }
    public function getPhpFiles($dir, $namespace)
    {
        $user = Auth::user();
        foreach (scandir($dir) as $file) {
            if ($file !== '.' && $file !== '..') {
                $info = pathinfo($file);
                if (is_array($info)) {
                    if (array_key_exists('extension', $info)) {
                        $ext = $info['extension'];
                        if (pathinfo($file)['extension'] == 'php') {
                            $model = str_replace('.php', '', $file);
                            if ($model !== 'Model') {
                                $qualifiedModel = $namespace . $model;
                                $crudApiLink = route('crudapi.admin.model', $model);
                                $status = 'Unknown';
                                if ($user->can('create', $qualifiedModel)) {
                                    $status = 'Policy: Allows';
                                } else {
                                    $status = 'Policy: Denies';
                                }
                                $this->models[] = [
                                    'namespace' => $namespace,
                                    'model' => $model,
                                    'api_url' => $crudApiLink,
                                    'status' => $status,
                                ];
                            }
                        }
                    }
                }
            }
        }
    }
}

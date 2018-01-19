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
        if (config('app.debug')) {
            $data = $this->buildData();
            $this->loadModels();
            if (!empty($this->models)) {
                $data['models'] = $this->models;
                return view('crudapi::admin.dashboard', $data);
            }
        } else {
            return redirect('/');
        }
    }
    public function loadModels()
    {
        $this->loadAppFolder();
        $this->loadModelsFolder();
    }
    public function loadAppFolder()
    {
        $appFolder = app_path();
        $namespace = $this->getAppNamespace();
        $this->getPhpFiles($appFolder, $namespace);
    }

    public function loadModelsFolder()
    {
        $folder = app_path('Models');
        if (file_exists($folder)) {
            $namespace = $this->getAppNamespace();
            $this->getPhpFiles($folder, $namespace . 'Models\\');
        }
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
                                $status = [];

                                // Check if user can perform crud actions
                                $status['create'] = $user->can('create', $qualifiedModel);
                                $status['read'] = $user->can('view', $qualifiedModel);
                                $status['update'] = $user->can('update', $qualifiedModel);
                                $status['delete'] = $user->can('delete', $qualifiedModel);

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

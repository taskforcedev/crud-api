# CrudAPI #
This project is in the early stages of development.  It is not yet recommended to use this package in a production environment.

[![Build Status](https://travis-ci.org/taskforcedev/crud-api.svg?branch=master)](https://travis-ci.org/taskforcedev/crud-api) [![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/taskforcedev/crud-api/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/taskforcedev/crud-api/?branch=master) [![Codacy Badge](https://www.codacy.com/project/badge/aff7a9540c4b4f03977393a05d23a25d)](https://www.codacy.com/public/taskforce2eu/crud-api)

The project provides an Api and Admin interface to access your models without needing to create individual controllers by hand, this requires your model to provide a 'validate' method, which should provide the necessary validation and authentication.

The store method also hashes the password if it exists in the data sent in which means it should work with the User class once validation method is implemented.

## Installation ##
To install add the package to your projects composer.json

    "require": {
        "taskforcedev/crud-api": "dev-master"
    }

Once the package has downloaded make sure composer has autoloaded.  (composer dump-autoload).  Then you can add the service provider in your laravels config/app.php.

    'providers' => [
        'Taskforcedev\CrudAPI\Providers\CrudApi',
    ]

## Configuration ##

The package assumes a namespace of App (as this is laravel's default).  If you need to change this simply publish our configuration

    php artisan vendor:publish

You will then see Copied File [/vendor/taskforcedev/crud-api/src/config/crudapi.php] To [/config/crudapi.php]

Then change the following line

    'model_ns' => 'App'

To match your namespace eg

    'model_ns' => 'Acme\\Application'

Trailing slashes will automatically be added so please leave them out.

## Usage ##
The package is built around two controllers, one for Api and one for Admin crud operations.

### Models ###
In order to use this package you will need to add a validate($data) method to your models, here is an example of the User model which comes by default with laravel with an implementation of validate.

    <?php namespace App;

    use Illuminate\Auth\Authenticatable;
    use Illuminate\Database\Eloquent\Model;
    use Illuminate\Auth\Passwords\CanResetPassword;
    use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
    use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
    
    class User extends Model implements AuthenticatableContract,     CanResetPasswordContract
    {
        use Authenticatable, CanResetPassword;
    
        protected $table = 'users';
    
        protected $fillable = ['name', 'email', 'password'];
    
        protected $hidden = ['password', 'remember_token'];
    
        protected $rules = [
            'name' => 'required',
            'password' => 'required|min:8',
            'email' => 'required|email|unique:users'
        ];
    
        public function validate($data)
        {
            /* Only validate the required fields */
            $model_data = [
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => $data['password'],
            ];
    
            $validator = \Validator::make($model_data, $this->rules);
    
            if ($validator->fails()) {
                return response($validator->messages(), 400);
            }
    
            return $validator->passes();
        }
    }



### API ###
The Api controller has access to the following routes.

    GET: /api/{Model}
    GET: /api/{Model}/{id}
    POST: /api/{Model}/{id}

### Admin ###
The admin controller has access to the following routes.

    GET: /admin/crud/{Model}
    GET: /admin/crud/{Model}/{id}
    POST: /admin/crud/{Model}

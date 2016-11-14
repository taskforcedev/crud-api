# CrudAPI #
This project is in the early stages of development.  It is not yet recommended to use this package in a production environment.

[![Build Status](https://travis-ci.org/taskforcedev/crud-api.svg?branch=master)](https://travis-ci.org/taskforcedev/crud-api) [![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/taskforcedev/crud-api/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/taskforcedev/crud-api/?branch=master) [![Codacy Badge](https://www.codacy.com/project/badge/aff7a9540c4b4f03977393a05d23a25d)](https://www.codacy.com/public/taskforce2eu/crud-api) [![Code Climate](https://codeclimate.com/github/taskforcedev/crud-api/badges/gpa.svg)](https://codeclimate.com/github/taskforcedev/crud-api)

The project provides an Api and Admin interface to access your models without needing to create individual controllers by hand.

The package will be tagged for release starting from Laravel 5.3 and uses Policies to determine model permissions.

The store method also hashes the password if it exists in the data sent in which means it should work with the User class once validation method is implemented.

## Installation ##
To install add the package to your projects composer.json

    "require": {
        "taskforcedev/crud-api": "dev-master"
    }

Once the package has downloaded make sure composer has autoloaded.  (composer dump-autoload).  Then you can add the service provider in your laravels config/app.php.

    'providers' => [
        ...
    
        Taskforcedev\CrudAPI\Providers\CrudApi::class,
    ]

## Configuration ##

The package assumes a namespace of App (as this is laravel's default).  If you need to change this simply publish our configuration

    php artisan vendor:publish

You will then see Copied File [/vendor/taskforcedev/crud-api/src/config/crudapi.php] To [/config/crudapi.php]

## Usage
The package is built around two controllers, one for Api and one for Admin CRUD operations.

### Conventions / Assumptions

- The package uses the $fillable attribute on your model in order to populate crud forms
- A field with the name password/Password will not be visibile on the crud form.
- In order for models to be validated the model must have a public property of $validation

Example

    public $validation = [
        'name' => 'required',
        'domain_id' => 'required|exists:domains,id'
    ];

### Models ###

Conve

An example model can be found [here](https://gist.github.com/taskforcedev/e2c9e3522dd030907d52).

### API ###
The Api controller has access to the following routes.

    GET:  /api/{Model}
    GET:  /api/{Model}/{id}
    POST: /api/{Model}/{id}

### Admin ###
The admin controller has access to the following routes.

    GET:  /admin/crud/{Model}
    GET:  /admin/crud/{Model}/{id}
    POST: /admin/crud/{Model}

## Technologies Used ##
 * Laravel (For testing functionality)
 * jQuery (Modal forms)
 * Bootstrap ([Yeti Theme](https://bootswatch.com/yeti/) from [Bootswatch](https://bootswatch.com/))
 * [Font Awesome](http://fortawesome.github.io/Font-Awesome/)
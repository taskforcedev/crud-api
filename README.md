# CrudAPI #
Status: This package is ready to be tested on Laravel 5.3+ we have tried to follow standard conventions where possible, feedback on edge cases would be welcome.

[![Build Status](https://travis-ci.org/taskforcedev/crud-api.svg?branch=master)](https://travis-ci.org/taskforcedev/crud-api) [![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/taskforcedev/crud-api/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/taskforcedev/crud-api/?branch=master) [![Codacy Badge](https://www.codacy.com/project/badge/aff7a9540c4b4f03977393a05d23a25d)](https://www.codacy.com/public/taskforce2eu/crud-api) [![Code Climate](https://codeclimate.com/github/taskforcedev/crud-api/badges/gpa.svg)](https://codeclimate.com/github/taskforcedev/crud-api)

This package provides administration interfaces for models out of the box, in order for this to work Laravel 5.3 conventions must be followed as per the assumptions below:

## Assumptions ##
- The package uses the $fillable attribute on your model in order to populate crud forms
- Models:
 * Models must have a public property $validation containing the array of validation rules.
- Authorization: Policies must be created to provide access to each model or extend a policy with a generic admin before filter.

User Model: This package assumes users will register on their own accord or be able to reset their own password, therefor any field called Password (or lowercase) will be hidden from the admin form for security purposes.

## Installation ##
To install add the package to your projects composer.json

    "require": {
        "taskforcedev/crud-api": "dev-master"
    }

Once the package has downloaded make sure composer has autoloaded.  (composer dump-autoload).  Then you can add the service provider in your laravels config/app.php.

    'providers' => [
        ...
        // Add the laravel support class also if not already present.
        Taskforcedev\LaravelSupport\ServiceProvider::class,

        Taskforcedev\CrudApi\ServiceProvider::class,
    ]

## Configuration ##

Overriding the configuration is not currently in use however support for other frameworks may be added in the future, incase you wish to override or add to the config use:

    php artisan vendor:publish

You will then see Copied File at /config/crudapi.php


## Technologies Used ##
 * Laravel 5.3
 * Bootstrap

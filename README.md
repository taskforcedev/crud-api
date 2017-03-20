# CrudApi #

Status: Testing Ready

We have tested the package in multiple scenarios and are comfortable using it in our own production contexts.  Please let us know however if you do encounter an issue.

[![Build Status](https://travis-ci.org/taskforcedev-testing/crudapi.svg?branch=master)](https://travis-ci.org/taskforcedev-testing/crudapi) [![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/taskforcedev/crud-api/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/taskforcedev/crud-api/?branch=master) [![Codacy Badge](https://www.codacy.com/project/badge/aff7a9540c4b4f03977393a05d23a25d)](https://www.codacy.com/public/taskforce2eu/crud-api) [![Code Climate](https://codeclimate.com/github/taskforcedev/crud-api/badges/gpa.svg)](https://codeclimate.com/github/taskforcedev/crud-api)
[![StyleCI](https://styleci.io/repos/32332348/shield?branch=master)](https://styleci.io/repos/32332348)

### Integration Tests

<table>
<tbody>
<tr><td>Laravel 5.3 / CrudAPI 1.0.x</td><td><a href="https://travis-ci.org/package-testing/laravel-53-crudapi"><img src="https://travis-ci.org/package-testing/laravel-53-crudapi.svg?branch=master" /></a></td></tr>
<tr><td>Laravel 5.4 / CrudAPI 1.1.x</td><td><a href="https://travis-ci.org/package-testing/laravel-54-crudapi"><img src="https://travis-ci.org/package-testing/laravel-54-crudapi.svg?branch=master" /></a></td></tr>
</tbody>
</table>



This package provides administration interfaces for models out of the box, in order for this to work Laravel 5.3 conventions must be followed as per the assumptions below:

## Assumptions
- The package uses the $fillable attribute on your model in order to populate crud forms
- Models:
 * Models must have a public property $validation containing the array of validation rules.
- Authorization: Policies must be created to provide access to each model or extend a policy with a generic admin before filter.

User Model: This package assumes users will register on their own accord or be able to reset their own password, therefor any field called Password (or lowercase) will be hidden from the admin forms for security purposes.

## Installation
To install add the package to your projects composer.json

Laravel 5.3

    "require": {
        "taskforcedev/crud-api": "1.0.*"
    }

Laravel 5.4

    "require": {
        "taskforcedev/crud-api": "1.1.*"
    }

Once installed add the service provider in your laravels config/app.php.

    'providers' => [
        ...
        // Add the laravel support class also if not already present.
        Taskforcedev\LaravelSupport\ServiceProvider::class,

        Taskforcedev\CrudApi\ServiceProvider::class,
    ]

If you wish to use your own layout in the admin api then follow the instructions from https://github.com/taskforcedev/laravel-support to publish the taskforce-support config and set the layout name there.

In this case a yield is required for scripts to output the javascript required by the framework as well as jquery and bootstrap being included in your application

    @yield('scripts')

## Configuration

Overriding the configuration is not currently in use however support for other frameworks may be added in the future, incase you wish to override or add to the config use:

    php artisan vendor:publish --tag="crudapi-config"

You will then see Copied File at /config/crudapi.php

## Technologies Used
 * Laravel 5.3+
 * Bootstrap

## Contributing

Please see file [CONTRIBUTING.md](https://github.com/taskforcedev/crud-api/blob/master/CONTRIBUTING.md) for information on how you can help.

## Security

If you find a security issue in this package please raise an issue with a prefix of [Security] on our [Issue Board](https://github.com/taskforcedev/crud-api/issues)

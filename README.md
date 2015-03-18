# CrudAPI #
This project is in the very early stages of development.

[![Build Status](https://travis-ci.org/taskforcedev/crud-api.svg?branch=master)](https://travis-ci.org/taskforcedev/crud-api) [![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/taskforcedev/crud-api/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/taskforcedev/crud-api/?branch=master) [![Codacy Badge](https://www.codacy.com/project/badge/aff7a9540c4b4f03977393a05d23a25d)](https://www.codacy.com/public/taskforce2eu/crud-api)

The project provides an Api and Admin interface to access your models without needing to create individual controllers by hand, this requires your model to provide a 'validate' method, which should provde the necessary validation and authentication.

The store method also hashes the password if it exists in the data sent in which means it should work with the User class once validation method is implemented.
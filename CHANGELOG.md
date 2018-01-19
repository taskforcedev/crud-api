# Change Log
All notable changes to this project will be documented in this file.
This project adheres to [Semantic Versioning](http://semver.org/).

## Unreleased
### Changed
- Add information from models folder into CrudAPI dashboard.
- Show more detailed policy data (create, read, update and delete columns).
- Only show model policy status if app debug is true.

## [v1.1.7] - 2017-09-01
### Fixed
- Fix composer.json

## [v1.1.6] - 2017-09-01
### Added
- Add Package autodiscovery for Laravel 5.5.

## [v1.1.5] - 2017-02-02
### Changed
 - Refactor previous change into reusable function and reuse in appropriate places.

## [v1.1.4] - 2017-02-02
### Changed
 - Adjust output of the table headings for _id to show in a more human readable manor.

## [v1.1.3] - 2017-02-02
### Fixed
 - Fix issue with getting related model in field helper.

## [v1.1.2] - 2017-02-02
### Fixed
 - Fix issue with form edit method in field helper.

## [v1.1.1] - 2017-01-26
### Fixed
 - Fix crud-api detection of application namespace.

## [v1.1.0] - 2017-01-26
### Changed
 - Update to use laravel 5.4 version of laravel-support package.
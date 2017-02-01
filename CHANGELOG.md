# Change Log
All notable changes to this project will be documented in this file.
This project adheres to [Semantic Versioning](http://semver.org/).

## [v1.0.5] - 2017-02-01
### Changed
 - Fix version of laravel support to 1.0.* for laravel 5.3 support.

## [v1.0.4] - 2016-12-29
### Added
 - Add alias for author_id to user model - only happens if there is no author model in the apps namespaces.

## [v1.0.3] - 2016-12-29
### Added
 - Add log::info to aid in debugging if user not logged in or if doesn't have create permission.

## [v1.0.2] - 2016-12-29
### Added
 - Add ability to configure additional namespaces to check for models.
 
### Changed
 - Move config folder from src to root.

## [v1.0.1] - 2016-11-25
### Added
 - Use laravel pluralization of words (eg Countries instead of Countrys).

## [v1.0.0] - 2016-11-21
### Added
 - First Public Release, code can be considered production ready for Bootstrap 3/4 based templates.
 - Added ability to publish configuration.
 - Added CRUD functionality (Bootstrap 3/4 Modals).
 - Added support for Bootstrap 3/4
 - Added pagination.

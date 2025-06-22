The Yii-Tracy package integrates the [Tracy debugging tool](https://tracy.nette.org/)
into [Yii3](https://www.yiiframework.com/) by providing the necessary configuration.

## Requirements
- PHP 8.1 or higher

## Installation
Install the package using [Composer](https://getcomposer.org):

Either:
```shell
composer require beastbytes/yii-tracy
```
or add the following to the `require` section of your `composer.json`
```json
"beastbytes/yii-tracy": "<version_constraint>"
```

## Configuration
Yii-Tracy is configured using Yii’s configuration. It has the following configuration parameters:
* mode (null|bool|string|array) The mode that Tracy is to operate in; Development or Production.
  * `Tracy\Debugger::Detect`: Tracy detects the mode; it sets _**development mode**_ is if it is running on _localhost_
    (i.e. IP address 127.0.0.1 or ::1) and there is no proxy, otherwise it sets _**production mode**_.
  * `Tracy\Debugger::Development`: put Tracy in _**development mode**_.
  * `Tracy\Debugger::Production`: put Tracy in _**production mode**_.
  * string: enable _**development mode**_ for the given IP address.
  * string[]: enable _**development mode**_ for IP addresses in the list.

    **NOTE** It is highly recommended to combine IP addresses with a cookie token by specifying allowed addresses as 
    `<token>@<ipAddress>`; see _token_.
* editor (string) [Tracy IDE integration](https://tracy.nette.org/en/open-files-in-ide)
* email (null|string|string[]) Email address(es) to which send error notifications
* logDirectory (string) Path alias to the log directory. Default: `'@runtime/logs'`
* logSeverity (int) Log bluescreen in production mode for this error severity.
* panels (array[]) List of panels available to Tracy and their configuration.
* showBar (bool) Whether to display debug bar in _**development mode**_.
* token (string) The secret token for enabling _**development mode**_ for IP addresses. See _mode_

## Panels
Yii Tracy defines a set of panels that can be added to the debugger bar; it is also possible to add user defined panels. 
### Auth
Provides information about the current user.
### Database
Provides information about the database connection and executed queries.
### Event
Not sure what yet
### Request
Provides information about the current request.
### Route
Provides information about the current route.
### Session
Provides information about the session.
### View
Provides information about the rendered view.

## User Defined Panel
To define a panel for Tracy create a class that extends `BeastBytes\Yii\Tracy\Panel\Panel` 
and implements `Tracy\IBarPanel`, and add its configuration to `'beastbytes/yii-tracy'['panels']`. 

See [Tracy Bar Extensions](https://tracy.nette.org/en/extensions) for more information
and examine the packages panels for example code.

## License
The BeastBytes Yii Tracy package is free software. It is released under the terms of the BSD License.
Please see [`LICENSE`](./LICENSE.md) for more information.
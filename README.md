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
#### Tab
By default the current user ID is shown. This can be changed by setting `StabValue` in the constructor (see Tab Value).
#### Panel
The panel shows:
* the current user ID
* assigned Roles (if RBAC enabled)
* granted Permissions (if RBAC enabled)
* user defined parameters (see Panel Parameters)

The information shown can be customised.
##### Customisation
###### Tab Value
By default, the current user ID is shown on the tab. This can be changed by setting `StabValue` in the constructor.

`$tabValue` is an anonymous function that takes the current identity (`IdentityInterface`) as its parameter
and returns a string.
###### Panel Parameters
Additional information about the current user can be shown on the user panel by setting `$panelparameters`
in the constructor.

`$panelParameters` is an anonymous function that takes the current identity (`IdentityInterface`) as its parameter
and returns parameters to show as `array{string: string}` 
where the key is the name of the parameter and value its value.
###### id2pk
Depending on how user IDs - Primary Keys - are stored in the database,
if using (RBAC)[https://github.com/yiisoft/rbac] it may be necessary to convert the user ID
in order to get user Roles and Permissions.
An example is when using [UUIDs](https://en.wikipedia.org/wiki/Universally_unique_identifier) as the primary key
and storing it in the database in binary format.

`id2pk` is an anonymous function that takes the string representation of the user ID as its parameter
and returns the Primary Key representation.

### Database
Provides information about the database connection and executed queries.
#### Tab
Shows the number of queries.
#### Panel
Shows the database DSN and lists the queries executed. Each query shows:
* SQL
* Query parameters
* Execution time

### Event
Not sure what yet
#### Tab
#### Panel

### Request
Provides information about the current request.
#### Tab
#### Panel

### Route
Provides information about the current route.
#### Tab
#### Panel

### Session
Provides information about the session.
#### Tab
Does not show data on the tab.
#### Panel
Session values as name=>value pairs.

### View
Provides information about the rendered view.
#### Tab
Does not show data on the tab.
#### Panel
Names of the rendered view, included partial views, and layout, and their parameters.

## User Defined Panel
### Panel Class
The Panel class must extend either `BeastBytes\Yii\Tracy\Panel\Panel` 
or a collector panel class that implements `BeastBytes\Yii\Tracy\Panel\CollectorPanelInterface`
if the panel uses a `Yiisoft\Yii\Debug\Collector\CollectorInterface`.

All panels have access to Yii's Dependency Injection container through the `$container` property.

To add the panel to Tracy, add its configuration to `'beastbytes/yii-tracy'['panels']`.

See [Tracy Bar Extensions](https://tracy.nette.org/en/extensions) for more information
and examine the package's panels for example code.

The Panel class must implement the following methods:
#### panelParameters(): array
Returns view parameters for the panel view as array<string: mixed>;

#### panelTitle(): string
Returns the panel title.

#### tabIcon(array $parameters): string
Returns the icon for the debugger tab view; it must be valid SVG.

The method takes the tab parameters as a parameter to allow the icon to reflect the state of the tab;
e.g. whether any database queries were executed.

#### tabParameters(): array
Returns view parameters for the debugger tab view as array<string: mixed>;

#### tabTitle(): string
Returns the title for the debugger tab.

### Views
The panel must implement two views, _tab_ and _panel_; they are _php_ templates.
The views need only render the tab/panel content;
Yii Tracy provides layouts for both tab and panel to decorate the content.

Rendering is done using Yii\View\View.

## License
The BeastBytes Yii Tracy package is free software. It is released under the terms of the BSD License.
Please see [`LICENSE`](./LICENSE.md) for more information.
The Yii Tracy package integrates the [Tracy debugging tool](https://tracy.nette.org/)
into [Yii3](https://www.yiiframework.com/).

## Requirements
- PHP 8.1 or higher

## Installation
Do not directly install this package.

This package is a requirement of Yii Tracy Panels; install the required Yii Tracy Panels.

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
* showBar (bool) Whether to display debug bar in _**development mode**_.
* token (string) The secret token for enabling _**development mode**_ for IP addresses. See _mode_

## Panels
The following panels are available:
* [Database](https://github.com/beastbytes/yii-tracy-panel-database) Provides information about the database connection and executed queries.
* [Request](https://github.com/beastbytes/yii-tracy-panel-request) Provides information about the current request.
* [Route](https://github.com/beastbytes/yii-tracy-panel-route) Provides information about the current route.
* [Session](https://github.com/beastbytes/yii-tracy-panel-session) Provides information about the session.
* [User](https://github.com/beastbytes/yii-tracy-panel-user) Provides information about the current user.
* [View](https://github.com/beastbytes/yii-tracy-panel-view) Provides information about the rendered view.

### User Defined Panel
#### Panel Class
The Panel class must extend either `BeastBytes\Yii\Tracy\Panel\Panel`
or one of the collector panel classes if the panel uses a `Yiisoft\Yii\Debug\Collector\CollectorInterface`.

All panels have access to Yii's Dependency Injection container through the `$container` property.

See [Tracy Bar Extensions](https://tracy.nette.org/en/extensions) for more information
and examine the package's panels for example code.

The Panel class must implement the following methods:
##### getViewPath(): string
**Visibility**: _public_

Returns the view path.

BeastBytes\Yii\Tracy\ViewTrait provides this method for panels that follow the standard file structure.

##### panelParameters(): array
**Visibility**: _protected_

Returns view parameters for the panel view as array<string: mixed>;

##### panelTitle(): string
**Visibility**: _protected_

Returns the panel title.

##### tabIcon(array $parameters): string
**Visibility**: _protected_

Returns an SVG icon for the debugger tab view.

The method takes the tab parameters as a parameter to allow the icon to reflect the state of the tab;
e.g. whether any database queries were executed.

#### tabParameters(): array
**Visibility**: _protected_

Returns view parameters for the debugger tab view as array<string: mixed>;

##### tabTitle(): string
**Visibility**: _protected_

Returns the title for the debugger tab.

#### Views
The panel must implement two views, _tab_ and _panel_; they are _php_ templates.
The views need only render the tab/panel content;
Yii Tracy provides layouts for both tab and panel to decorate the content.

Rendering is done using Yii\View\View.

## License
The BeastBytes Yii Tracy package is free software. It is released under the terms of the BSD License.
Please see [`LICENSE`](./LICENSE.md) for more information.

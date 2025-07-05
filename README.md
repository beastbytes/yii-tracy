The Yii Tracy package integrates the [Tracy debugging tool](https://tracy.nette.org/)
into [Yii3](https://www.yiiframework.com/).

## Requirements
- PHP 8.1 or higher

## Installation
Do not directly install this package.

Install the [Yii Tracy Panels](#panels) as required.

## Configuration
Yii Tracy is configured using Yii’s configuration. It has the following configuration parameters
defined in the `beastbytes/yii-tracy` section of `params-web.php`:
* editor (string) [Tracy IDE integration](https://tracy.nette.org/en/open-files-in-ide)
* email (null|string|string[]) Email address(es) to which send error notifications
* logDirectory (?string) Absolute path or path alias to the log directory. Default: `'@runtime/logs'`
* logSeverity (int) Log bluescreen in production mode for this error severity.
* mode (null|bool|string|array) The mode that Tracy is to operate in; Development or Production.
  * `Tracy\Debugger::Detect`: Tracy detects the mode; it sets _**development mode**_ is if it is running on _localhost_
    (i.e. IP address 127.0.0.1 or ::1) and there is no proxy, otherwise it sets _**production mode**_.
  * `Tracy\Debugger::Development`: put Tracy in _**development mode**_.
  * `Tracy\Debugger::Production`: put Tracy in _**production mode**_.
  * string: enable _**development mode**_ for the given IP address.
  * string[]: enable _**development mode**_ for IP addresses in the list.

    **NOTE** It is highly recommended to combine IP addresses with a cookie token by specifying allowed addresses as
    `<token>@<ipAddress>`; see _token_.
* panelConfig (array) Panel configurations indexed by panel ID. Panel packages contain default configuration.
* panels (string[]) IDs of panels to show. The panels are added to the debugger in the order listed. 
* showBar (bool) Whether to display debug bar in _**development mode**_.
* token (string) The secret token for enabling _**development mode**_ for IP addresses. See _mode_.

_**Note**_: A panel must be configured in `panelConfig` and listed in `panels` to be enabled.

Set the required configuration parameters in the application `params-web` configuration file.

## Internationalisation
Yii Tracy supports internationalisation of tabs and panels.
To ensure that this works as expected an implementation of `Yiisoft\Translator\TranslatorInteface`
must be present in application views.

## Disable Yii Debug
Yii Tracy uses components of Yii Debug; to ensure Yii Tracy operates correctly, it is necessary to disable Yii Debug.

In the application entry script, set the `configModifiers` parameter in the constructor of the application runner;
the value is:
```php
[
    RemoveFromVendor::groups([
        'yiisoft/yii-debug' => '*',
    ]),
]
```

The end of the application entry script will be something like:
```php
(new HttpApplicationRunner(
    rootPath: <root path>,
    debug: <true|false>,
    checkEvents: <true|false>,
    environment: <development|test|production>,
    configModifiers: [
        RemoveFromVendor::groups([
            'yiisoft/yii-debug' => '*',
        ]),
    ],
))->run();
```

## Panels
The following panels are available:
* [Assets](https://github.com/beastbytes/yii-tracy-panel-assets) Provides information about Asset Bundles on the page.
* [Database](https://github.com/beastbytes/yii-tracy-panel-database) Provides information about the database connection and executed queries.
* [Route](https://github.com/beastbytes/yii-tracy-panel-route) Provides information about the current route.
* [User](https://github.com/beastbytes/yii-tracy-panel-user) Provides information about the current user.
* [View](https://github.com/beastbytes/yii-tracy-panel-view) Provides information about the rendered view.

Add the required panels to the `require-dev` section of the application `composer.json`.
This package is installed as a dependency.

### Custom Panels
Custom panels can be added to Yii Tracy. The information below gives details of how to do this.
Also see [Tracy Bar Extensions](https://tracy.nette.org/en/extensions) for more information and examine the existing panels for example code.

#### Panel Class
The Panel class must extend either `BeastBytes\Yii\Tracy\Panel\Panel`
or one of the collector panel classes if the panel uses a `Yiisoft\Yii\Debug\Collector\CollectorInterface`.

All panels have access to Yii's Dependency Injection container through the `$container` property.

The Panel class must implement the following methods:
##### getViewPath(): string
**Visibility**: _public_

Returns the view path.

BeastBytes\Yii\Tracy\ViewTrait provides this method for panels that follow the standard file structure.

##### panelParameters(): array
**Visibility**: _protected_

Returns view parameters for the panel view as array<string: mixed>;

##### panelTitle(): array
**Visibility**: _protected_

Returns array{id: string, category: int} where:
* id: message id for translation
* category: message translation category

_**Tip**_ Define a public constant `MESSAGE_CATEGORY = tracy-<panel-id>`

##### tabIcon(array $parameters): string
**Visibility**: _protected_

Returns an SVG icon for the debugger tab view.

The method takes the tab parameters as an argument to allow the icon to reflect the state of the tab.

#### tabParameters(): array
**Visibility**: _protected_

Returns view parameters for the debugger tab view as array<string: mixed>;

##### tabTitle(): array
**Visibility**: _protected_

Returns array{id: string, category: int} where:
* id: message id for translation
* category: message translation category

_**Tip**_ Define a public constant `MESSAGE_CATEGORY = tracy-<panel-id>`

#### Views
The panel must implement two views, _tab_ and _panel_; they are _php_ templates.
The views need only render the tab/panel content;
Yii Tracy provides layouts for both tab and panel to decorate the content.

To correctly support internationalisation and make the panel fully contained, it is recommended to:
* Define a public constant in the Panel class that defines the message translation category
```php
public const MESSAGE_CATEGORY = 'tracy-<panel-id>';
```
where `<panel-id>` is the panel id, and the prefix `tracy-` avoids name collisions
* Place the following line at the start of the tab and panel views:
```php
$translator = $translator->withDefaultCategory(Panel::MESSAGE_CATEGORY);
```
* Use message ids of the form `<panel-id>.type.name`.
Suggested _types_ are 'heading', 'title', 'value'. `type` can be omitted for body text.

#### Configuration
Two configuration files are required:
* di-web.php - defines the message translation category
* params-web - defines the panel

and references to them in `composer.json`.

##### di-web.php
```php
use Fully\Qualified\Namespace\For\Panel;
use Yiisoft\Translator\CategorySource;
use Yiisoft\Translator\IntlMessageFormatter;
use Yiisoft\Translator\Message\Php\MessageSource;

$category = Panel::MESSAGE_CATEGORY;
$messageSource = dirname(__DIR__) . '/resources/messages';

return [
    "translation.$category" => [
        'definition' => static function() use ($category, $messageSource)  {
            return new CategorySource(
                $category,
                new MessageSource($messageSource),
                new IntlMessageFormatter(),
            );
        },
        'tags' => ['translation.categorySource'],
    ],
];
````

##### params-web.php
```php
return [
    'beastbytes/yii-tracy' => [
        'panelConfig' => [
            '<panel-id>' => [
                'class' => <FQCN>,
                // Additional panel definition
            ],
        ],
    ],
];
```

##### composer.json
Add references to `di-web.php` and `params.php` in the `extra` section of `composer.json`:
```json
  "extra": {
    // Additional 'extra' sections
    "config-plugin": {
      "di-web": "di-web.php",
      "params-web": "params-web.php"
    }
  }
```

## License
The BeastBytes Yii Tracy package is free software. It is released under the terms of the BSD License.
Please see [`LICENSE`](./LICENSE.md) for more information.

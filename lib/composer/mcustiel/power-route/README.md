PowerRoute! is a PHP routing system that can execute different sets of actions based in several components of the HTTP requests and is fully compatible with PSR-7.

The configuration is formed by three main components and defines a binary tree:
* **Input sources**: The input sources are the component that takes data from the request to be evaluated.
* **Matchers**: This component receives the value from the input source and executes a check on it.
* **Actions**: The component that is executed based in the result of the check executed by matchers.
    
In the configuration the actions can be set for the case in which the matcher returns true and for the case in which it returns true, hence building a binary tree.

The full system can be extended by adding input sources, matchers and actions. Also the names used in the configuration to identify the components can be assigned arbitrarily.

The components are grouped forming the nodes of the binary tree, each node looks as following:

```php
'expectationUrl' => [
    'condition' => [
        'one-of' => [
            [
                'input-source' => ['url' => 'path'],
                'matcher' => [ 'matches' => '/some/url/?' ],
            ],
        ],
    ],
    'actions' => [
        'if-matches' => [
            ['myCustomAction' => 'withSomeParameter'],
        ],
        'else' => [
            ['notFound' => null],
        ],
    ],
],
```

[![Build Status](https://scrutinizer-ci.com/g/mcustiel/PowerRoute/badges/build.png?b=master)](https://scrutinizer-ci.com/g/mcustiel/PowerRoute/build-status/master)
[![Code Coverage](https://scrutinizer-ci.com/g/mcustiel/PowerRoute/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/mcustiel/PowerRoute/?branch=master)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/mcustiel/PowerRoute/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/mcustiel/PowerRoute/?branch=master)
[![PPM Compatible](https://raw.githubusercontent.com/php-pm/ppm-badge/master/ppm-badge.png)](https://github.com/php-pm/php-pm)

[![SensioLabsInsight](https://insight.sensiolabs.com/projects/f28ecdd1-28d0-4385-9183-972ca55cfe93/big.png)](https://insight.sensiolabs.com/projects/f28ecdd1-28d0-4385-9183-972ca55cfe93)

## Table of contents

* [Installation](#installation)
* [How to use](#how-to-use)
    * [The configuration](#the-configuration)
    * [The code](#the-code)
* [Predefined components](#predefined-components)
    * [Input sources](#input-sources)
    * [Matchers](#matchers)
    * [Actions](#actions)
* [Extending PowerRoute!](#extending-powerroute)
    * [Creating your own actions](#creating-your-own-actions)
        * [Using PSR-7 middleware](#using-psr7-middleware)
        * [TransactionData class](#transactiondata-class)
        * [Placeholders](#placeholders)
    * [Creating your own input sources](#creating-your-own-input-sources)
    * [Creating your own matchers](#creating-your-own-matchers)

## Installation

This project is published in packagist, so you just need to add it as a dependency in your composer.json:

```javascript
    "require": {
        // ...
        "mcustiel/power-route": "*"
    }
```

## How to use

### The configuration

The configuration must be a php array. It must define two keys:
* root: The name of the root node of the graph.
* nodes: The definition of all the nodes, this is a key => value pairs array where key is the name of the node and value it's definition.

#### Example

A configuration that always redirects to google.com:

```php
[
    'root' => 'default',
    'nodes' => [
        'default' => [
            'condition' => [],
            'actions' => [
                'if-matches' => [
                    [ 'redirect' => 'http://www.google.com' ]
                ]
            ]
        ]
    ]
]
```

You can use the names you prefer for the input sources, the matchers and the actions and then map them in the factories provided by this library.

### The code

After all the configuration is correctly defined, Executor class must be used to walk the graph based in the request received.
To create an instance of Executor class, the factories for Actions, Input Sources and Matchers must be created first.
Each factory constructor expects an array of Mcustiel\Creature\CreatorInterface objects, indexed by the identificator of the class used in PowerRoute! config file. See following example:  

```php
use Mcustiel\PowerRoute\PowerRoute;

use Mcustiel\PowerRoute\Common\Factories\ActionFactory;
use Mcustiel\PowerRoute\Common\Factories\InputSourceFactory;
use Mcustiel\PowerRoute\Common\Factories\MatcherFactory;
use Mcustiel\PowerRoute\Common\Factories\ActionFactory;

Mcustiel\PowerRoute\Common\Conditions\ConditionsMatcherFactory;

use Mcustiel\PowerRoute\Matchers\NotNull;
use Mcustiel\PowerRoute\Matchers\Equals;

use Mcustiel\PowerRoute\InputSources\QueryStringParam;

use Mcustiel\PowerRoute\Actions\Redirect;

use Mcustiel\Creature\SingletonLazyCreator;

use Your\Namespace\MyMatcher;
use Your\Namespace\MyInputSource;
use Your\Namespace\MyAction;

$matcherFactory = new MatcherFactory(
    [ 
        'notNull' => new SingletonLazyCreator(NotNull::class), 
        'equals' => new SingletonLazyCreator(Equals::class),
        'someSpecialMatcher' => new SingletonLazyCreator(MyMatcher::class)
    ]
);
$inputSourceFactory = new InputSourceFactory(
    [ 
        'get' => new SingletonLazyCreator(QueryStringParam::class), 
        'someSpecialInputSource' => new SingletonLazyCreator(MyInputSource::class)
    ]
);
$actionFactory = new ActionFactory(
    [ 
        'redirect' => new SingletonLazyCreator(Redirect::class),
        'someSpecialAction' => new SingletonLazyCreator(MyAction::class) 
    ]
);

$config = $yourConfigManager->getYourPowerRouteConfig();
$router = new PowerRoute(
    $config, 
    $actionFactory, 
    ConditionsMatcherFactory($inputSourceFactory, $matcherFactory)
);
```

After you have your executor instance, just call start method with the PSR7 request and response:

```php
use Zend\Diactoros\Response;
use Zend\Diactoros\ServerRequestFactory;
use Zend\Diactoros\Response\SapiEmitter;

$request = ServerRequestFactory::fromGlobals();
$response = $router->start($request, new Response());

(new SapiEmiter())->emit($response);
```

Or, to boost it up, you can use [PHP-PM](https://github.com/php-pm):

```php
namespace Your\Namespace;

class MyApplication
{
    private $router;
    
    public function __construct()
    {
        // Set up the application
        // ...
        $this->router = new PowerRoute(
            $config, 
            $actionFactory, 
            ConditionsMatcherFactory($inputSourceFactory, $matcherFactory)
        );
    }

    public function __invoke($request, $response, $next = null)
    {
        return $this->router->start($request, $response);
    }
}
```
and run it as: 
```bash
vendor/bin/ppm start --bridge=PHPPM\\Psr7\\Psr7Bridge --bootstrap=Your\\Namespace\\MyApplication
```

## Predefined components

### Input sources

#### Cookie
Allows to match the request body.

#### Cookie
Allows to execute actions based in cookies from the http request.

##### Arguments
The name of the cookie.

#### Header
Allows to execute actions based in headers from the http request.

##### Arguments
The name of the header.

#### Method
Returns the http method used to execute request. It receives no parameters.

#### QueryStringParam
Allows to execute actions based in parameters from the request's query string.

##### Arguments
The name of the query string parameter.

#### Url
Allows to execute actions based in the url or parts of it.

##### Arguments
A string specifying the part of the url to evaluate. With the following possible values:
* **full**: Evaluates the full url.
* **host**: Evaluates the host.
* **scheme**: Evaluates the scheme.
* **authority**: Evaluates the authority part.
* **fragment**: Evaluates the fragment.
* **path**: Evaluates the path.
* **port**: Evaluates the port.
* **query**: Evaluates the query.
* **user-info**: Evaluates the user information part.

### Matchers

#### CaseInsensitiveEquals
Useful to compare two strings without taking case into account.

#### Contains
This matcher returns true if the value from the input source contains as a substring the value received as an argument.

#### Equals
Returns true if the value from the input source is equal to another value received as argument.

#### InArray
Returns true if the value from the input source is in a list of values received as argument.

#### NotEmpty
Returns true if the value from the input source is not empty.

#### NotNull
Returns true if the value from the input source is not null.

#### RegExp
Returns true if the value from the input source matches a regular expression received as argument.

### Actions

### Goto

This is a default action that is always added, it's identifier is the string 'goto'. It allow to jump the execution to another node. It's argument is the name of the node to execute.

#### DisplayFile

This action displays a file. Its path must be defined as argument.

#### NotFound

This action sets the http status code to 404 in the response.

#### Redirect

This action adds a Location header to the response and set the http status code to 302. Its redirection target must be defined as argument.

#### SaveCookie

This action sets the value of a cookie. It receives as an argument an object with all the needed data for the cookie:
* name
* value
* domain
* path
* secure

#### ServerError

Sets the response statusCode to 500. Other error statusCode can also be passed as argument. On invalid error given, sets 500.

#### SetHeader

This action sets the value of a header. As an argument receives an object with the following keys:
* name
* value

#### StatusCode

Sets the response statusCode to 200 as default. Other error statusCode can be passed as argument. On invalid error throws an exception.

## Extending PowerRoute!

### Creating your own actions

To create your own actions to be used through PowerRoute! you have to create a class implementing ActionInterface. If you want to give your action the ability to support placeholders, you you must use PlacheolderEvaluator trait.

* **ActionInterface** defines the method that should be implemented by the action.
* **PlaceholderEvaluator** defines the method getValueOrPlaceholder, that gives your action the ability to parse possible placeholders in a string.

```php
interface ActionInterface
{
    public function execute(\Mcustiel\PowerRoute\Common\TransactionData $transactionData, $argument = null);
}
```

TransactionData is an object that is passed as an argument to all actions, it is used to share the request, the response and other data that you may want to share between them.

Inside an action you should retrieve the object you want to modify from TransactionData (request or response object). Then you modify it and set the new object again in TransactionData. This must be done this way because PSR7 are immutable.

You can even init a framework inside an action.

#### Using PSR7 middleware:

PowerRoute! supports psr-7 middlewares as actions. All you need to do is to map the action name in the config to a class implementing the following method:

```php
function __invoke($request, $response, $next = null);
``` 
You can also map the action name to a callable with that signature.

PowerRoute! will call the middleware and pass the configured argument as the `$next` argument.

##### Example:

For the action config:
```php
    [ 'myMiddleware' => new OtherMiddleware() ]
```
And the factory setup:
```php
    [
        'myMiddleware' => new LazyCreator(MyMiddlewareImplementation::class)
    ]
```
PowerRoute will do something like this:
```php
    $implementation = new MyMiddleWareImplementation();
    $implementation($request, $response, new OtherMiddleware());
```

#### Examples of an action:

```php
interface ActionInterface
{
    /**
     * @param \Mcustiel\PowerRoute\Common\TransactionData $transactionData This object is modified inside the class.
     * @param mixed                                       $argument        This optional argument comes from the config of PowerRoute!
     */
    public function execute(TransactionData $transactionData, $argument = null);
}
```

```php
class Redirect implements ActionInterface
{
    use PlaceholderEvaluator;

    public function execute(TransactionData $transactionData, $argument = null)
    {
        return $transactionData->setResponse(
            $transactionData->getResponse()
            ->withHeader(
                'Location',
                $this->getValueOrPlaceholder($argument, $transactionData)
            )
            ->withStatus(302)
        );
    }
}
```

#### TransactionData class:

This class is passed as an argument to every action and defines two methods to access the current request and the corresponding response (getRequest and getResponse respectively). Also it gives you the ability to save and fetc custom variables throught **get($name)** and **set($name, $value)** methods.

#### Placeholders:

The arguments an action receives can include a placeholder to access values from the TransactionData object. The arguments have the following format:

```
{{source.name}}
``` 

Where source indicates from where to obtain the value, and name is the identifier associated with the given value.

#### Possible placeholder sources:

* **var**: allows you to access some custom value saved in the TransactionData object.
* **uri**: allows you to access data from the url used to request. If you call it without an identifier, it returns the full url. If not, it allows a serie of identifiers to retrieve parts of the request:    
  * **full**: also returns the full url.
  * **host**: returns the host part of the url.
  * **scheme**: returns the scheme part of the url.
  * **authority**: returns the authority part of the url.
  * **fragment**: return the fragment part of the url.
  * **path**: returns the path of the url used in the current request.
  * **port**: returns the port requested in the url.
  * **query**: returns the query string from the current request.
  * **user-info**: returns the user information specified in the url.
* **method**: returns the method used in the current request.
* **get**: allows you to access a parameter from the query string, it must be specified as the name part of the placeholder. 
* **header**: allows you to access a header, it must be specified as the name part of the placeholder.
* **cookie**: allows you to access a cookie, it must be specified as the name part of the placeholder.
* **post**:  allows you to access a post variable, it must be specified as the name part of the placeholder.
* **bodyParam**: allows you to access a variable from the body, it must be specified as the name part of the placeholder.

** __Note__: See PSR7 documentation for more information about previous sources.

### Creating your own input sources

The input source is the component used to access data from the request, it uses a matcher uses to validate the data and the request.

It also should extend AbstractArgumentAware to have access to the argument from the configuration and it must implement InputSourceInterface. It must return the value so PowerRoute! gives it to the matcher.

```php
interface InputSourceInterface
{
    /**
     * @param \Psr\Http\Message\ServerRequestInterface $request
     * @param mixed                                    $argument
     *
     * @return mixed
     */
    public function getValue(ServerRequestInterface $request, $argument = null);
}
```

#### Example of an InputSource:

```php
class Header implements InputSourceInterface
{
    public function getValue(ServerRequestInterface $request, $argument = null)
    {
        $header = $request->getHeaderLine($argument);
        return $header ?: null;
    }
}
```

### Creating your own matchers

The matcher is the component in charge of executing a check against the value obtained from the request by the InputSource. To create your own matcher, you must create a class that should extend AbstractArgumentAware to access the argument and must implement MatcherInterface.

```php
interface MatcherInterface
{
    /**
     * @param mixed $value
     * @param mixed $argument
     *
     * @return boolean
     */
    public function match($value, $argument = null);
}
```

#### Example of a Matcher:

```php
class Equals implements MatcherInterface
{
    public function match($value, $argument = null)
    {
        return $value == $argument;
    }
}
```

## Examples

Phiremock uses PowerRoute, you can check it's config file [here](https://github.com/mcustiel/phiremock/blob/master/src/Server/Config/router-config.php).

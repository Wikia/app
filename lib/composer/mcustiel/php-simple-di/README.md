php-simple-di
=============

What is it?
-----------

php-simple-di (Php Simple Dependency Injection) is a library that provides a minimalistic dependency container with the ability to provide singleton or prototype versions of the dependencies identifying them by a name.
php-simple-di provides a singleton class where you can register your dependencies, indentifying them by a name and then you can retrieve them. This library only creates instances on demand (it does not instanciate dependencies that are not needed for a request execution), so you only process and have in memory what you are using.

Installation
------------

### Composer:

Just add the packagist dependency:
```javascript  
{
    "require": {
        // ...
        "mcustiel/php-simple-di": ">=1.2.0"
    }
}
```

Or, if you want to use the repository, adding this to your composer.json should be enough:
```javascript  
{
    "repositories": [
        {
            "type": "vcs",
            "url": "https://github.com/mcustiel/php-simple-di"
        }
    ],
    "require": {
        // ...
        "mcustiel/php-simple-di": "dev-master"
    }
}
```

Or just download the release and include it in your path.

How to use it?
--------------

### Registering
In your bootstrap file (or some startup script) you must define all the possible dependencies that your classes might need.

```php
use Mcustiel\DependencyInjection\DependencyInjectionService;

$dependencyInjectionService = new DependencyInjectionService();
// ...
$dbConfig = loadDbConfig();
$cacheConfig = loadCacheConfig();
$dependencyInjectionService->register('dbConnection', function() use ($dbConfig) {
    return new DatabaseConnection($dbConfig);
});
$dependencyInjectionService->register('cache', function() use ($cacheConfig) {
    return new CacheManager($cacheConfig);
});
```

#### Getting dependencies 
Then you can retrieve instances by refering them through their identifier.

```php
$cacheManager = $dependencyInjectionService->get('cache');
```

### Instances
php-simple-di creates "singleton" instances by default, this means everytime you request for a dependency it will return the same instance every time. If by any chance you need to change this behavior, you can define that every time you asks php-simple-di for a dependency it will return a new instance. This behavior is changed through a boolean parameter in **register** method.

#### Singleton behavior

```php
$dependencyInjectionService->add('dbConnection', function() {
    return new DatabaseConnection($dbConfig);
});
// or also you can make it explicit:
$dependencyInjectionService->register('cache', function() {
    return new CacheManager($cacheConfig);
}, true);

$instance1 = $dependencyInjectionService->get('cache');
$instance2 = $dependencyInjectionService->get('cache');
// $instance1 and $instance2 reference the same object
```

#### Prototype behavior

```php
$dependencyInjectionService->register('dbConnection', function() {
    return new DatabaseConnection($dbConfig);
}, false);

$instance1 = $dependencyInjectionService->get('cache');
$instance2 = $dependencyInjectionService->get('cache');
// $instance1 and $instance2 reference different objects
```

Notes
-----

There's a lot of discussion around Singleton pattern, mentioning it as an antipattern because it's hard to test. Anyway, php-simple-di provides the container as a singleton class to allow just a single instance to be part of the execution. You should think in good practices and avoid using this class through singleton, but define it in your bootstrap file and pass the container instance as a parameter to your application dispatcher and always pass it as a parameter (injecting it as a dependency). Then, remember to use it properly, don't pass the container as a dependency, but use it to obtain the dependencies and pass them to your services.

```php
// Do this:
$dbConnection = $dependencyInjectionService->get('dbConnection');
$personDao = new PersonDao($dbConnection); // Pass the proper dependency
// Instead of doing this:
$personDao = new PersonDao($dependencyInjectionService); // This works but is heretic and makes a little kitten cry.
```

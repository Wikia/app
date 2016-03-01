# Dependency Injection
Wrapper for [dependency injection](https://en.wikipedia.org/wiki/Dependency_injection) in our PHP code. Currently uses [PHP-DI](http://php-di.org/) as implementation.

## Usage
The global injector can be fetched using `Wikia\DependencyInjection\Injector::getInjector()`. 

### Defining dependencies
In order to add to the injector that's available anywhere, add to the `InjectorBuilder` in `Wikia\DependencyInjection\InjectorInitializer`. Here, you can add `Wikia\DependencyInjection\Module` instances that configure the `InjectorBuilder` using `InjectorBuilder->bind`, ex:

```php
use Wikia\DependencyInjection\InjectorBuilder;

class MyModule implements Module {
  public function configure(InjectorBuilder $builder) {
    $builder
      ->bind('foo')->to(5)
      ->bind(SomeInterface::class)->toClass(SomeClassImplementsSomeInterface::class)
  }
}
```

### Testing
During tests, you can set up the global injector to return mock instances:

```php
use Wikia\DependencyInjection\Injector;
use Wikia\DependencyInjection\InjectorBuilder;

/** @var Container */
private $container;

class MyTest extends PHPUnit_Framework_TestCase {
  public function setUp() {
    $this->container =
      (new InjectorBuilder())
        ->bind(PreferenceService::class)->to(new MockPreferenceService())
        ->build();
  }
  
  public function testSomething() {
    $class = $this->container->get(SomethingThatUsesPreferences::class)
    $class->doSomething();
  }
}
```
```php
class SomethingThatUsesPreferences {
  /**
   * @Inject
   */
  public function __construct(PreferenceService $preferenceService) {
    $this->preferenceService = $preferenceService
  }
}
```

The `PreferenceService` passed to `SomethingThatUsesPreferences` will be the mock object the injector defines.

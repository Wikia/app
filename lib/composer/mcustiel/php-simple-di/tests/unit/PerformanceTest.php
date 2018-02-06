<?php
namespace Unit;

use Mcustiel\DependencyInjection\DependencyContainer;
use Fixtures\FakeDependency;
use Fixtures\RequiresAnotherDependency;
use Fixtures\AnotherDependency;
use Mcustiel\DependencyInjection\DependencyInjectionService;

class PerformanceTest extends \PHPUnit_Framework_TestCase
{
    /**
     * The unit under test.
     *
     * @var \Mcustiel\DependencyInjection\DependencyContainer
     */
    private $dependencyContainer;

    public function setUp()
    {
        $this->dependencyContainer = DependencyContainer::getInstance();
    }

    public function testInstantiationWithoutSingleton()
    {
        $this->dependencyContainer->add(
            'fakeDependencyWithouthSingleton',
            function ()
            {
                return new FakeDependency('someValue');
            },
            false
        );
        $this->dependencyContainer->add(
            'anotherDependencyWithouthSingleton',
            function ()
            {
                return new AnotherDependency('otherValue');
            },
            false
        );
        $this->dependencyContainer->add(
            'requiresDependencyInConstructorWithouthSingleton',
            function ()
            {
                $injector = new DependencyInjectionService();
                return new RequiresAnotherDependency(
                    $injector->get('fakeDependencyWithouthSingleton'),
                    $injector->get('anotherDependencyWithouthSingleton')
                );
            },
            false
        );
        foreach ([5000, 15000, 25000, 50000] as $cycles) {
            $start = microtime(true);
            for ($i = $cycles; $i > 0; $i--) {
                $this->dependencyContainer->get('requiresDependencyInConstructorWithouthSingleton');
            }
            echo "\n{$cycles} cycles executed in " . (microtime(true) - $start) . " microseconds without singleton\n";
        }
    }

    public function testInstantiationWithSingleton()
    {
        $this->dependencyContainer->add(
            'fakeDependencyWithouthSingleton',
            function ()
            {
                return new FakeDependency('someValue');
            }
        );
        $this->dependencyContainer->add(
            'anotherDependencyWithouthSingleton',
            function ()
            {
                return new AnotherDependency('otherValue');
            }
        );
        $this->dependencyContainer->add(
            'requiresDependencyInConstructorWithouthSingleton',
            function ()
            {
                $injector = new DependencyInjectionService();
                return new RequiresAnotherDependency(
                    $injector->get('fakeDependencyWithouthSingleton'),
                    $injector->get('anotherDependencyWithouthSingleton')
                );
            }
        );
        foreach ([5000, 15000, 25000, 50000] as $cycles) {
            $start = microtime(true);
            for ($i = $cycles; $i > 0; $i--) {
                $this->dependencyContainer->get('requiresDependencyInConstructorWithouthSingleton');
            }
            echo "\n{$cycles} cycles executed in " . (microtime(true) - $start) . " microseconds with singleton\n";
        }
    }
}

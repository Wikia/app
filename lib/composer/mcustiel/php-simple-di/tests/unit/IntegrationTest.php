<?php
/**
 * This file is part of php-simple-di.
 *
 * php-simple-di is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * php-simple-di is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with php-simple-di.  If not, see <http://www.gnu.org/licenses/>.
 */
namespace Unit;

use Mcustiel\DependencyInjection\DependencyContainer;
use Fixtures\FakeDependency;
use Fixtures\RequiresAnotherDependency;
use Fixtures\AnotherDependency;
use Mcustiel\DependencyInjection\DependencyInjectionService;

class IntegrationTest extends \PHPUnit_Framework_TestCase
{
    /**
     * The unit under test.
     *
     * @var \Mcustiel\DependencyInjection\DependencyContainer
     */
    private $dependencyContainer;

    public function setUp()
    {
        $this->dependencyContainer = new DependencyInjectionService();
    }

    public function testDependencyContainerWhenDependencyExists()
    {
        $this->dependencyContainer->register(
            'fakeDependency',
            function ()
            {
                return new FakeDependency('someValue');
            }
        );

        $this->assertInstanceOf('\Fixtures\FakeDependency',
            $this->dependencyContainer->get('fakeDependency'));
        $this->assertEquals('someValue', $this->dependencyContainer->get('fakeDependency')
            ->getAValue());
    }

    public function testDependencyContainerWhitValuesFromOutsideTheClosure()
    {
        $theValue = 'outsideValue';
        $this->dependencyContainer->register(
            'fakeDependency',
            function () use($theValue)
            {
                return new FakeDependency($theValue);
            }
        );

        $this->assertEquals('outsideValue', $this->dependencyContainer->get('fakeDependency')
            ->getAValue());
    }

    public function testDependencyContainerSingleton()
    {
        $this->dependencyContainer->register(
            'fakeDependency',
            function ()
            {
                return new FakeDependency('someValue');
            }
        );

        $instance1 = $this->dependencyContainer->get('fakeDependency');
        $instance2 = $this->dependencyContainer->get('fakeDependency');
        $this->assertInstanceOf('\Fixtures\FakeDependency', $instance1);
        $this->assertInstanceOf('\Fixtures\FakeDependency', $instance2);

        $this->assertSame($instance1, $instance2);
    }

    public function testDependencyContainerNoSingleton()
    {
        $this->dependencyContainer->register(
            'fakeDependency',
            function ()
            {
                return new FakeDependency('someValue');
            },
            false
        );

        $instance1 = $this->dependencyContainer->get('fakeDependency');
        $instance2 = $this->dependencyContainer->get('fakeDependency');
        $this->assertInstanceOf('\Fixtures\FakeDependency', $instance1);
        $this->assertInstanceOf('\Fixtures\FakeDependency', $instance2);

        $this->assertFalse($this->areTheSame($instance1, $instance2));
    }

    /**
     * @expectedException \Mcustiel\DependencyInjection\Exception\DependencyDoesNotExistException
     * @expectedExceptionMessage Dependency identified by 'doesNotExists' does not exist
     */
    public function testDependencyContainerWhenDependencyDoesNotExist()
    {
        $this->dependencyContainer->get('doesNotExists');
    }

    public function testInjection()
    {
        $this->dependencyContainer->register(
            'fakeDependency',
            function ()
            {
                return new FakeDependency('someValue');
            }
        );
        $this->dependencyContainer->register(
            'anotherDependency',
            function ()
            {
                return new AnotherDependency('anotherValue');
            }
        );
        $this->dependencyContainer->register(
            'requiresDependencyInConstructor',
            function ()
            {
                $injector = new DependencyInjectionService();
                return new RequiresAnotherDependency(
                    $injector->get('fakeDependency'),
                    $injector->get('anotherDependency')
                );
            }
        );
        $instance = $this->dependencyContainer->get('requiresDependencyInConstructor');
        $this->assertInstanceOf(FakeDependency::class, $instance->getFakeDependency());
    }

    private function areTheSame(&$object1, &$object2)
    {
        return $object1 === $object2;
    }
}

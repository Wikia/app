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
namespace Mcustiel\DependencyInjection;

use Mcustiel\DependencyInjection\Exception\DependencyDoesNotExistException;

/**
 * A minimalistic dependency container.
 *
 * @author mcustiel
 */
class DependencyContainer
{
    /**
     * The singleton instance of this class
     * @var DependencyContainer
     */
    private static $instance;
    /**
     * The collection of dependencies contained.
     * @var Dependency[]
     */
    private $dependencies;

    private function __construct()
    {
        $this->dependencies = [];
    }

    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * Adds an object generator and the identifier for that object, with the option
     * of make the object 'singleton' or not.
     *
     * @param string   $identifier The identifier of the dependency
     * @param callable $loader     The generator for the dependency object
     * @param string   $singleton  Whether or not to return always the same instance of the object
     */
    public function add($identifier, callable $loader, $singleton = true)
    {
        $this->dependencies[$identifier] = new Dependency($loader, $singleton);
    }

    /**
     * Gets the dependency identified by the given identifier.
     *
     * @param string $identifier The identifier of the dependency
     *
     * @return object The object identified by the given id
     * @throws DependencyDoesNotExistException If there's not dependency with the given id
     */
    public function get($identifier)
    {
        if (!isset($this->dependencies[$identifier])) {
            throw new DependencyDoesNotExistException(
                "Dependency identified by '$identifier' does not exist"
            );
        }
        return $this->dependencies[$identifier]->get();
    }
}

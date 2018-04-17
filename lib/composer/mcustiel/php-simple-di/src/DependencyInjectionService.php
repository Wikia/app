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

/**
 * This class is a Wrapper to avoid that developers have to use a Singleton class.
 *
 * @author mcustiel
*/
class DependencyInjectionService
{
    private $container;

    public function __construct()
    {
        $this->container = DependencyContainer::getInstance();
    }

    /**
     * Registers a dependency into the Dependency Injection system
     *
     * @param string   $identifier The identifier for this dependency
     * @param callable $loader     The loader function for the dependency (to be called when needed)
     * @param string   $singleton  Whether or not to return always the same instance
     */
    public function register($identifier, callable $loader, $singleton = true)
    {
        $this->container->add($identifier, $loader, $singleton);
    }

    /**
     * Returns the dependency identified by the given identifier.
     *
     * @param string $identifier The identifier for the required depedency
     *
     * @return mixed The dependency associated with the identifier
     */
    public function get($identifier)
    {
        return $this->container->get($identifier);
    }
}

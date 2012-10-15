<?php
/**
 * This file is part of phpUnderControl.
 * 
 * PHP Version 5.2.0
 *
 * Copyright (c) 2007-2010, Manuel Pichler <mapi@phpundercontrol.org>.
 * All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions
 * are met:
 *
 *   * Redistributions of source code must retain the above copyright
 *     notice, this list of conditions and the following disclaimer.
 *
 *   * Redistributions in binary form must reproduce the above copyright
 *     notice, this list of conditions and the following disclaimer in
 *     the documentation and/or other materials provided with the
 *     distribution.
 *
 *   * Neither the name of Manuel Pichler nor the names of his
 *     contributors may be used to endorse or promote products derived
 *     from this software without specific prior written permission.
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS
 * FOR A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE
 * COPYRIGHT OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT,
 * INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING,
 * BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES;
 * LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER
 * CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT
 * LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN
 * ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE
 * POSSIBILITY OF SUCH DAMAGE.
 * 
 * @category  QualityAssurance
 * @package   Console
 * @author    Manuel Pichler <mapi@phpundercontrol.org>
 * @copyright 2007-2010 Manuel Pichler. All rights reserved.
 * @license   http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @version   SVN: $Id$
 * @link      http://www.phpundercontrol.org/
 */

/**
 * Collection with all available commands and options.
 *
 * @category  QualityAssurance
 * @package   Console
 * @author    Manuel Pichler <mapi@phpundercontrol.org>
 * @copyright 2007-2010 Manuel Pichler. All rights reserved.
 * @license   http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @version   Release: 0.6.1beta1
 * @link      http://www.phpundercontrol.org/
 */
class phpucConsoleInputDefinition implements ArrayAccess, IteratorAggregate
{
    /**
     * Marks a normal command or option that shows up in the cli help.
     */
    const MODE_NORMAL = 0;
    
    /**
     * Marks a hidden command or option. This means a command is not shown in 
     * the cli help.
     */
    const MODE_HIDDEN = 1;
    
    /**
     * List of valid modes.
     *
     * @var array(string=>array)
     */
    private $definition = array(
    );
    
    /**
     * Constructs a new input definition and asks the command implementations 
     * for their input definition. 
     *
     */
    public function __construct()
    {
        $this->registerCommands();
    }
    
    /**
     * Checks if a command with the given <b>$cmd</b> identifier already exists. 
     *
     * @param string $cmd  The unique command identifier.
     * 
     * @return boolean
     */
    public function hasCommand( $cmd )
    {
        return isset( $this->definition[$cmd] );
    }
    
    /**
     * Adds a new command to the input definition.
     *
     * @param string  $cmd  The unique command identifier.
     * @param string  $help The command help text.
     * @param integer $mode The command mode, hidden or visible(normal).
     * 
     * @return void
     * throws phpucErrorException
     *        If a command for the given command idenfier already exists or an
     *        input value has an invalid format. 
     */
    public function addCommand( $cmd, $help, $mode = self::MODE_NORMAL )
    {
        if ( isset( $this->definition[$cmd] ) )
        {
            throw new phpucErrorException(
                "The command name '{$cmd}' is already in use."
            );
        }
    
        if ( !in_array( $mode, array( self::MODE_NORMAL, self::MODE_HIDDEN ) ) )
        {
            throw new phpucErrorException( 'Invalid value for mode given.' );
        }
        
        $this->definition[$cmd] = array(
            'mode'     =>  $mode,
            'help'     =>  $help,
            'args'     =>  array(),
            'options'  =>  array(),
        );
    }
    
    /**
     * Checks if an argument named <b>$arg</b> for the given command <b>$cmd</b>
     * exists.
     *
     * @param string $cmd The command identifier.
     * @param string $arg The argument identifier.
     * 
     * @return boolean
     */
    public function hasArgument( $cmd, $arg )
    {
        return isset( $this->definition[$cmd]['args'][$arg] );
    }
    
    /**
     * Adds a new command line argument for the specified <b>$cmd</b>.
     *
     * @param string  $cmd       The associated command identifier.
     * @param string  $arg       The argument identifier.
     * @param string  $help      The help text for the argument.
     * @param boolean $mandatory Marks this argument as mandatory.
     * 
     * @return void
     * @throws phpucErrorException
     *         If no command for the given identifier exists. If an argument with
     *         an equal argument identifier exists. If the mandatory parameter
     *         is not of type <b>boolean</b>.
     */
    public function addArgument( $cmd, $arg, $help, $mandatory = true )
    {
        if ( !isset( $this->definition[$cmd] ) )
        {
            throw new phpucErrorException(
                "The command '{$cmd}' for '{$arg}' doesn't exist."
            );
        }
        if ( isset( $this->definition[$cmd]['args'][$arg] ) )
        {
            throw new phpucErrorException(
                "An argument '{$arg}' for command '{$cmd}' already exists."
            );
        }
        if ( !is_bool( $mandatory ) )
        {
            throw new phpucErrorException( 
                'The mandatory parameter must be of type boolean.' 
            );
        }
        
        $this->definition[$cmd]['args'][$arg] = array(
            'help'       =>  $help,
            'mandatory'  =>  $mandatory
        );
    }
    
    /**
     * Checks if an option named <b>$opt</b> for the given command <b>$cmd</b>
     * exists.
     *
     * @param string $cmd The command identifier.
     * @param string $opt The option identifier.
     * 
     * @return boolean
     */
    public function hasOption( $cmd, $opt )
    {
        foreach ( $this->definition[$cmd]['options'] as $option )
        {
            if ( $option['short'] === $opt || $option['long'] === $opt )
            {
                return true;
            }
        }
        return false;
    }
    
    /**
     * Adds a new option to the given command <b>$cmd</b>.
     *
     * @param string $cmd 
     *        The command identifier.
     * @param string $short
     *        The short cli identifier for this option. 
     * @param string $long 
     *        The long cli identifier for this option.  
     * @param string $help
     *        The cli help text for this option.
     * @param boolean|string|array|null $arg
     *        Defines if this option has an argument and what it should be. If
     *        this parameter is of type <b>string</b> it is used as a regular
     *        expression for input validation. If this parameter is an <b>array</b>
     *        it is used as whitelist. 
     * @param string|null $default
     *        An optional default value for this option.
     * @param boolean $mandatory
     *        Marks this option as mandatory.
     * @param integer $mode 
     *        The command mode, hidden or visible(normal).
     *        
     * @return void
     * @throws phpucErrorException
     *         If no command for the given identifier exists. If an option with
     *         an equal <b>$long</b> or <b>$short</b> identifier exists. If the 
     *         mandatory parameter is not of type <b>boolean</b>. If the 
     *         <b>$mode</b> parameter has an invalid format. 
     */
    public function addOption( 
        $cmd, 
        $short, 
        $long, 
        $help,
        $arg = null, 
        $default = null, 
        $mandatory = false, 
        $mode = self::MODE_NORMAL
    ) {
        if ( !isset( $this->definition[$cmd] ) )
        {
            throw new phpucErrorException(
                "The command '{$cmd}' for option '{$long}' doesn't exist."
            );
        }
        
        if ( $this->hasOption( $cmd, $short ) )
        {
            throw new phpucErrorException(
                "An option '{$short}' already exists for command '{$cmd}'."
            );
        }
        if ( $this->hasOption( $cmd, $long ) )
        {
            throw new phpucErrorException(
                "An option '{$long}' already exists for command '{$cmd}'."
            );
        }
        
        if ( !is_bool( $mandatory ) )
        {
            throw new phpucErrorException( 
                'The mandatory parameter must be of type boolean.'
            );
        }
    
        if ( !in_array( $mode, array( self::MODE_NORMAL, self::MODE_HIDDEN ) ) )
        {
            throw new phpucErrorException( 'Invalid value for mode given.' );
        }
        
        $this->definition[$cmd]['options'][] = array(
            'short'      =>  $short,
            'long'       =>  $long,
            'arg'        =>  $arg,
            'help'       =>  $help,
            'mode'       =>  $mode,
            'default'    =>  $default,
            'mandatory'  =>  $mandatory,
        );
    }
    
    /**
     * Returns an iterator with all registered cli commands.
     *
     * @return Iterator
     */
    public function getIterator()
    {
        return new ArrayIterator( $this->definition );
    }
    
    /**
     * Array access method for isset.
     *
     * @param string $name The command name to look up.
     * 
     * @return boolean
     */
    public function offsetExists( $name )
    {
        return ( isset( $this->definition[$name] ) );
    }
    
    /**
     * Returns the command definition for the given name.
     * 
     * If no command for the given <b>$name</b> exists, this method will throw
     * an <b>OutOfRangeException</b>.
     *
     * @param string $name The name of the requested command.
     * 
     * @return array
     * @throws OutOfRangeException If the requested command doesn't exist.
     * @todo TODO: Change to a an instance of phpucConsoleCommandDefintion
     */
    public function offsetGet( $name )
    {
        if ( $this->offsetExists( $name ) )
        {
            return $this->definition[$name];
        }
        throw new OutOfRangeException( "Unknown index '{$name}'." );
    }
    
    /**
     * Adds a new command definition.
     *
     * @param string $name  The command name.
     * @param array  $value The command array.
     * 
     * @return void
     * @throws InvalidArgumentException If the $value is not an array.
     * @todo TODO: Change to a an instance of phpucConsoleCommandDefintion
     */
    public function offsetSet( $name, $value )
    {
        // Nothing todo here
    }
    
    /**
     * Does nothing here!?!?
     *
     * @param string $name The command name.
     * 
     * @return void
     */
    public function offsetUnset( $name )
    {
        // Nothing todo here
    }
    
    /**
     * Registers the available phpUnderControl commands and their options.
     *
     * @return void
     */
    protected function registerCommands()
    {
        $files = new phpucPhpFileFilterIterator(
            new DirectoryIterator( PHPUC_INSTALL_DIR . '/Commands' )
        );
        
        $commands = array();
        
        foreach ( $files as $file )
        {
            // Load reflection class
            $refClass = new ReflectionClass( $files->getClassName() );
            
            // Skip abstract classes and interfaces
            if ( $refClass->isInterface() || $refClass->isAbstract() )
            {
                continue;
            }
            
            // Check for extension interface
            if ( !$refClass->implementsInterface( 'phpucConsoleCommandI' ) )
            {
                continue;
            }
            
            $command = $refClass->newInstance();
            $command->registerCommand( $this );
            
            $commands[] = $command;
        }
        
        foreach ( $commands as $command )
        {
            foreach ( $command->createTasks() as $task )
            {
                if ( $task instanceof phpucConsoleExtensionI )
                {
                    $task->registerCommandExtension( $this, $command );
                }
            }
        }
        
        ksort( $this->definition );
    }
}

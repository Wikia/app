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
 * Input parser for cli inputs.
 * 
 * Depending on a defined set of input commands and options this class extracts
 * the required informations from the provided command line input.
 *
 * @category  QualityAssurance
 * @package   Console
 * @author    Manuel Pichler <mapi@phpundercontrol.org>
 * @copyright 2007-2010 Manuel Pichler. All rights reserved.
 * @license   http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @version   Release: 0.6.1beta1
 * @link      http://www.phpundercontrol.org/
 * 
 * @property-read phpucConsoleArgs $args The console arguments.
 */
class phpucConsoleInput
{
    /**
     * The argument array form the command line interface.
     *
     * @var array(string)
     */
    private $argv = array();
    
    /**
     * The given command.
     *
     * @var string
     */
    private $command = null;
    
    /**
     * The given command line options.
     *
     * @var array(string=>mixed)
     */
    private $options = array();
    
    /**
     * The given command line arguments.
     *
     * @var array(string=>string)
     */
    private $arguments = array();
    
    /**
     * List of valid modes.
     *
     * @var array(string=>array)
     */
    private $commands = null;
    
    /**
     * List of properties read from the command line interface.
     *
     * @var array(string=>mixed)
     */
    private $properties = array(
        'args'  =>  null,
    );
    
    /**
     * The ctor checks the current script environment.
     * 
     * @param phpucConsoleInputDefinition $definition
     *        An optional input definition instance that is used by the input
     *        parser.
     */
    public function __construct( phpucConsoleInputDefinition $definition = null )
    {
        if ( $definition === null )
        {
            $this->commands = new phpucConsoleInputDefinition();
        }
        else
        {
            $this->commands = $definition;
        }
        
        if ( isset( $GLOBALS['argv'] ) )
        {
            $this->argv = $GLOBALS['argv'];
            // Drop first arg with file name
            array_shift( $this->argv );
            
            return;
        }
        $argc_argv = strtolower( ini_get( 'register_argc_argv' ) );
        if ( $argc_argv === 'on' || $argc_argv === '1' )
        {
            throw new phpucConsoleException(
                'An unknown command line argument error occured.'
            );
        }
        else
        {
            throw new phpucConsoleException(
                'Please enable "register_argc_argv" for your php cli installation.'
            );
        }
    }
    
    /**
     * Parses the input command line options and arguments.
     *
     * @return boolean
     */
    public function parse()
    {
        if ( $this->hasHelpOption() )
        {
            $this->printHelp();
            return false;
        }
        else if ( !$this->hasCommand() && $this->hasUsageOption() )
        {
            $this->printUsage();
            return false;
        }
        else if ( !$this->hasCommand() && $this->hasVersionOption() )
        {
            $this->printVersion();
            return false;
        }
        
        // First argument must be the mode
        if ( $this->parseCommand() === false )
        {
            $this->printUsage();
            throw new phpucConsoleException(
                'You must enter a valid installation mode as first argument.'
            );
        }
        
        $this->parseOptions();
        $this->parseArguments();
        
        $this->properties['args'] = new phpucConsoleArgs(
            $this->command,
            $this->options,
            $this->arguments
        );

        return true;
    }
    
    /**
     * Magic property getter method.
     *
     * @param string $name The property name.
     * 
     * @return mixed
     * @throws OutOfRangeException If the requested property doesn't exist or
     *         is writonly.
     */
    public function __get( $name )
    {
        if ( array_key_exists( $name, $this->properties ) === true )
        {
            return $this->properties[$name];
        }
        throw new OutOfRangeException(
            sprintf( 'Unknown or writonly property $%s.', $name )
        );
    }
    
    /**
     * Checks if the help option isset in the arguments.
     *
     * @return boolean
     */
    private function hasHelpOption()
    {
        return in_array( '-h', $this->argv ) || in_array( '--help', $this->argv );
    }
    
    /**
     * Checks if the usage option isset in the arguments.
     *
     * @return boolean
     */
    private function hasUsageOption()
    {
        return in_array( '-u', $this->argv ) || in_array( '--usage', $this->argv );
    }
    
    /**
     * Checks if the version option isset in the arguments.
     *
     * @return boolean
     */
    private function hasVersionOption()
    {
        return in_array( '-v', $this->argv ) || in_array( '--version', $this->argv );
    }
    
    /**
     * Checks the the first command line parameter is a valid command identfier.
     *
     * @return boolean
     */
    private function hasCommand()
    {
        return isset( $this->commands[reset( $this->argv )] );
    }
    
    /**
     * Parses the first argument from the command line. This must be a valid 
     * installer mode.
     *
     * @return boolean
     */
    private function parseCommand()
    {
        $command = array_shift( $this->argv );
        
        if ( !isset( $this->commands[$command] ) )
        {
            return false;
        }
        $this->command = $command;
        
        return true;
    }
    
    /**
     * Parses all given command line options.
     *
     * @return void
     */
    private function parseOptions()
    {
        $opts = array();
        if ( isset( $this->commands[$this->command]['options'] ) )
        {
            $opts = $this->commands[$this->command]['options'];
        }
        
        foreach ( $opts as $opt )
        {
            $short = sprintf( '-%s', $opt['short'] );
            $long  = sprintf( '--%s', $opt['long'] );
            
            $option = null;
            if ( in_array( $short, $this->argv ) === true )
            {
                $option = $short;
            }
            else if ( in_array( $long, $this->argv ) === true )
            {
                $option = $long;
            }
            
            
            if ( $option === null )
            {
                if ( $opt['mandatory'] === false )
                {
                    continue;
                }
                else if ( !isset( $opt['default'] ) )
                {
                    throw new phpucConsoleException(
                        "The option '{$long}' is marked as mandatory and not set."
                    );                 
                }
                
                $option = '--' . $opt['long'];
                
                array_unshift( $this->argv, $opt['default'] );
                array_unshift( $this->argv, $option );
            }
            
            // Search array index for option.
            $idx = array_search( $option, $this->argv );
            
            if ( $opt['arg'] === null )
            {
                // Mark option as set
                $this->options[$opt['long']] = true;
                // Unset option in arg array
                unset( $this->argv[$idx] );
                
                continue;
            }

            // Check for a value
            ++$idx;
            if ( !isset( $this->argv[$idx] ) 
                || strpos( $this->argv[$idx], '-' ) === 0
            ) {
                throw new phpucConsoleException(
                    "The option '{$option}' requires an additional value."
                );
            }
            $value = $this->argv[$idx];
            
            // Unset option and value
            unset( $this->argv[$idx - 1], $this->argv[$idx] ); 
            
            if ( is_array( $opt['arg'] ) 
                && in_array( $value, $opt['arg'] ) === false
            ) {
                throw new phpucConsoleException(
                    sprintf(
                        'The value for option %s must match one of these values %s.',
                        $option,
                        '"' . implode( '", "', $opt['arg'] ) . '"'
                    )
                );
            }
            else if ( is_string( $opt['arg'] ) 
                && preg_match( $opt['arg'], $value ) === 0
            ) {
                throw new phpucConsoleException(
                    "The value for option '{$option}' has an invalid format."
                );
            }
            $this->options[$opt['long']] = $value;
        }
    }
    
    /**
     * Parses all command line arguments.
     *
     * @return void
     */
    private function parseArguments()
    {
        $args = $this->commands[$this->command]['args'];
        
        foreach ( $args as $name => $arg )
        {
            $value = array_shift( $this->argv );
            if ( $value === null )
            {
                if ( $arg['mandatory'] )
                {
                    throw new phpucConsoleException(
                        sprintf( 'Missing argument <%s>.', $name )
                    );
                }
                return;
            }
            $this->arguments[$name] = $value;
        }
    }
    
    /**
     * Generates the help message for the command line tool.
     *
     * @return void
     */
    private function printHelp()
    {
        // Try to find a command
        if ( $this->parseCommand() === false )
        {
            // First print general usage.
            $this->printUsage();
            
            echo PHP_EOL;

            // Print all options and arguments
            foreach ( $this->commands as $command => $config )
            {
                // Skip hidden commands
                if ( $config['mode'] === phpucConsoleInputDefinition::MODE_HIDDEN )
                {
                    continue;
                }
                
                $this->printModeHelp( $command );
            }
            
            printf(
                ' -% -2s --% -23s %s%s -% -2s --% -23s %s%s -% -2s --% -23s %s%s',
                'h',
                'help',
                'Print this help text.',
                PHP_EOL,
                'u',
                'usage',
                'Print a short usage example.',
                PHP_EOL,
                'v',
                'version',
                'Print the phpUnderControl version.',
                PHP_EOL
            );
        }
        else
        {
            $this->printModeHelp( $this->command );
        }
    }
    
    /**
     * Prints the help text for a single installer command.
     *
     * @param string $command The installer command.
     * 
     * @return void
     */
    private function printModeHelp( $command )
    {
        printf(
            'Command line options and arguments for "%s"%s',
            $command,
            PHP_EOL
        );
        
        $opts = array();
        if ( isset( $this->commands[$command]['options'] ) )
        {
            $opts = $this->commands[$command]['options'];
        }
        
        usort( $opts, array( $this, 'sortCommandOptions' ) );
        
        foreach ( $opts as $opt )
        {
            $tokens = $this->tokenizeHelp( $opt['help'] );
            
            printf(
                ' -% -2s --% -23s %s%s',
                $opt['short'],
                $opt['long'],
                array_shift( $tokens ),
                PHP_EOL
            );
            foreach ( $tokens as $token )
            {
                printf(
                    '                               %s%s', $token, PHP_EOL
                );
            }
        }
        
        $cmdArgs = $this->commands[$command]['args'];
        foreach ( $cmdArgs as $name => $arg )
        {
            $tokens = $this->tokenizeHelp( $arg['help'] );
            
            printf(
                ' % -29s %s%s',
                "<{$name}>",
                array_shift( $tokens ),
                PHP_EOL
            );
            foreach ( $tokens as $token )
            {
                printf(
                    '                                 %s%s', $token, PHP_EOL
                );
            }
        }
        echo PHP_EOL;
    }
    
    /**
     * Splits long help texts into smaller tokens of max 42 characters.
     * 
     * @param string $help The original help text.
     * 
     * @return array(string)
     */
    private function tokenizeHelp( $help )
    {
        $tokens = preg_split( '#(\r\n|\n|\r)#', wordwrap( $help, 44 ) );
        return array_map( 'trim', $tokens );
    }
    
    /**
     * Helper method that is used to sort the command options by the long 
     * option identifier.
     *
     * @param array(string=>mixed) $option1 Compare option one.
     * @param array(string=>mixed) $option2 Compare option two.
     * 
     * @return integer
     */
    private function sortCommandOptions( $option1, $option2 )
    {
        return strcasecmp( $option1['long'], $option2['long'] );
    }
    
    /**
     * Prints a general usage for the command line tool.
     *
     * @return void
     */
    private function printUsage()
    {
        $commands = '';
        foreach ( $this->commands as $command => $config )
        {
            // Skip hidden commands
            if ( $config['mode'] === phpucConsoleInputDefinition::MODE_HIDDEN )
            {
                continue;
            }
            
            $commands .= sprintf(
                '  * % -13s  %s%s',
                $command,
                $config['help'],
                PHP_EOL
            );
        }
        
        printf( 
            'Usage: phpuc.php <command> <options> <arguments>%s' .
            'For single command help type:%s' .
            '    phpuc.php <command> --help%s' . 
            'Available commands:%s%s',
            PHP_EOL,
            PHP_EOL,
            PHP_EOL,
            PHP_EOL,
            $commands
        );
    }
    
    /**
     * Prints the phpUnderControl version number.
     *
     * @return void
     */
    private function printVersion()
    {
        echo 'phpUnderControl 0.6.1beta1 by Manuel Pichler.', PHP_EOL;
    }
}

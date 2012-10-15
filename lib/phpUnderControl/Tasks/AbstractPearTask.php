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
 * @package   Tasks
 * @author    Manuel Pichler <mapi@phpundercontrol.org>
 * @copyright 2007-2010 Manuel Pichler. All rights reserved.
 * @license   http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @version   SVN: $Id$
 * @link      http://www.phpundercontrol.org/
 */

/**
 * Abstract base class for the PEAR based options.
 *
 * @category  QualityAssurance
 * @package   Tasks
 * @author    Manuel Pichler <mapi@phpundercontrol.org>
 * @copyright 2007-2010 Manuel Pichler. All rights reserved.
 * @license   http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @version   Release: 0.6.1beta1
 * @link      http://www.phpundercontrol.org/
 * 
 * @property      string $cliTool       The PEAR cli command line tool.
 * @property      string $pearBinaryDir An optional PEAR install directory.
 * @property-read string $executable    The full command file name.
 */
abstract class phpucAbstractPearTask 
       extends phpucAbstractTask 
    implements phpucConsoleExtensionI
{
    /**
     * Constructs a new pear task.
     */
    public function __construct()
    {
        parent::__construct();
        
        $this->properties['cliTool']       = null;
        $this->properties['executable']    = null;
        $this->properties['pearBinaryDir'] = null;
        
        $this->cliTool = $this->getCliToolName();
    }
    
    /**
     * Sets the parsed console arguments.
     *
     * @param phpucConsoleArgs $args The console arguments.
     * 
     * @return void
     */
    public function setConsoleArgs( phpucConsoleArgs $args )
    {
        parent::setConsoleArgs( $args );
        
        if ( $args->hasOption( 'pear-executables-dir' ) )
        {
            $this->pearBinaryDir = $args->getOption( 'pear-executables-dir' );
        }
    }
    
    /**
     * Does the primary validation that the command line tool exists. If the
     * tool exists this method passes the request to the internal template 
     * method {@link doValidate()}.
     *
     * @return void
     * 
     * @throws phpucValidateException If the validation fails.
     */
    public final function validate()
    {
        // Get possible or configured pear path
        if ( $this->pearBinaryDir === null )
        {
            $paths = explode( PATH_SEPARATOR, getenv( 'PATH' ) );
        }
        else
        {
            $paths = array( $this->pearBinaryDir );
        }
        $paths = array_unique( $paths );

        $windows = phpucFileUtil::getOS() == phpucFileUtil::OS_WINDOWS;

        foreach ( $paths as $path )
        {
            $fileName = sprintf( 
                '%s/%s%s', 
                $path, 
                $this->cliTool,
                ( $windows === true ? '.bat' : '' ) 
            );
            
            if ( file_exists( $fileName ) === false )
            {
                continue;
            }
            if ( is_executable( $fileName ) === false && $windows === false )
            {
                continue;
            }
            $this->properties['executable'] = $fileName;
            break;
        }
        
        if ( $this->executable === null )
        {
            throw new phpucValidateException(
                "Missing cli tool '{$this->cliTool}', check the PATH variable."
            );
        }
        else if ( $this->pearBinaryDir === null )
        {
            $dir = dirname( $this->executable );
            if ( strpos( getenv( 'PATH' ), $dir ) !== false )
            {
                $this->properties['executable'] = basename( $this->executable );
            }
        }
        
        $this->doValidate();
    }
    
    /**
     * Callback method that registers a command extension. 
     *
     * @param phpucConsoleInputDefinition $def 
     *        The input definition container.
     * @param phpucConsoleCommandI  $command
     *        The context cli command instance.
     * 
     * @return void
     */
    public function registerCommandExtension(
        phpucConsoleInputDefinition $def,
        phpucConsoleCommandI $command
    ) {
        if ( !$def->hasOption( $command->getCommandId(), 'pear-executables-dir' ) )
        {
            $def->addOption(
                $command->getCommandId(),
                'e',
                'pear-executables-dir',
                'The pear directory with cli scripts.',
                true
            );
        }
    }
    
    /**
     * Magic property setter method.
     *
     * @param string $name  The property name.
     * @param mixed  $value The property value.
     * 
     * @return void
     * @throws OutOfRangeException If the property doesn't exist or is readonly.
     */
    public function __set( $name, $value )
    {
        switch ( $name )
        {
            case 'cliTool':
                $this->properties[$name] = $value;
                break;
                
            case 'pearBinaryDir':
                if ( trim( $value ) === '' )
                {
                    $this->properties[$name] = null;
                }
                else
                {
                    $this->properties[$name] = preg_replace( 
                        sprintf( '#%s+$#', DIRECTORY_SEPARATOR ), '', $value
                    );
                }
                break;
                
            default:
                throw new OutOfRangeException(
                    sprintf( 'Unknown or readonly property $%s.', $name )
                );
                break;
        }
    }
    
    /**
     * Template validate method for additional checks.
     *
     * @return void
     */
    protected function doValidate()
    {
        // Nothing todo here
    }
    
    /**
     * Must return the name of the used cli tool.
     *
     * @return string
     */
    protected abstract function getCliToolName();
}

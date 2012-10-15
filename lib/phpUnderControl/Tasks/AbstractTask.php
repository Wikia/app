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
 * Abstract base implementation of a phpUnderControl task.
 *
 * @category  QualityAssurance
 * @package   Tasks
 * @author    Manuel Pichler <mapi@phpundercontrol.org>
 * @copyright 2007-2010 Manuel Pichler. All rights reserved.
 * @license   http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @version   Release: 0.6.1beta1
 * @link      http://www.phpundercontrol.org/
 * 
 * @property-read boolean $artifacts 
 *                If the value of this property is set to <b>true</b> an artifacts
 *                directory exists.
 */
abstract class phpucAbstractTask implements phpucTaskI
{
    /**
     * Virtual properties for the setting implementation.
     *
     * @var array(string=>mixed)
     */
    protected $properties = array();

    /**
     * The command line arguments.
     *
     * @var phpucConsoleArgs
     */
    protected $args = null;
    
    /**
     * Constructs a new task instance.
     */
    public function __construct()
    {

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
        $this->args = $args;
        
        if ( $args->hasArgument( 'cc-install-dir' ) )
        {
            // Check for an artifacts directory
            $this->properties['artifacts'] = ( 
                is_dir( $args->getArgument( 'cc-install-dir' ) . '/artifacts' )
            );
        }
    }

    /**
     * Validates the task constrains.
     *
     * @return void
     * @throws phpucValidateException If the validation fails.
     */
    public function validate()
    {
        // Nothing todo here
    }
    
    /**
     * Magic property isset method.
     *
     * @param string $name The property name.
     * 
     * @return boolean
     */
    public function __isset( $name )
    {
        return array_key_exists( $name, $this->properties );
    }
    
    /**
     * Magic property getter method.
     *
     * @param string $name The property name.
     * 
     * @return mixed
     * @throws OutOfRangeException If the property doesn't exist or is writonly.
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
        throw new OutOfRangeException(
            sprintf( 'Unknown or readonly property $%s.', $name )
        );
    }

    /**
     * Returns the configured project name.
     *
     * @return string
     */
    protected function getProjectName()
    {
        return $this->args->getOption( 'project-name' );
    }
    
    /**
     * Returns the root directory of the context project.
     *
     * @return string
     */
    protected function getProjectPath()
    {
        return sprintf(
            '%s/projects/%s', 
            $this->getCruiseControlDirectory(),
            $this->getProjectName()
        );
    }

    /**
     * Returns the log directory of the context project.
     *
     * @return string
     */
    protected function getProjectLogDirectory()
    {
        return sprintf(
            '%s/logs/%s',
            $this->getCruiseControlDirectory(),
            $this->getProjectName()
        );
    }

    /**
     * Returns the artifacts directory of the context project.
     *
     * @return string
     */
    protected function getProjectArtifactDirectory()
    {
        return sprintf(
            '%s/artifacts/%s',
            $this->getCruiseControlDirectory(),
            $this->getProjectName()
        );
    }

    /**
     * Returns the configuration of the current context project.
     *
     * @return phpucConfigProject
     */
    protected function getProjectConfiguration()
    {
        return $this->getCruiseControlConfiguration()->getProject(
            $this->getProjectName()
        );
    }

    /**
     * Returns the configured cruisecontrol installation directory.
     *
     * @return string
     */
    protected function getCruiseControlDirectory()
    {
        return $this->args->getArgument( 'cc-install-dir' );
    }

    /**
     * Returns a cruise control configuration file instance.
     *
     * @return phpucConfigFile
     */
    protected function getCruiseControlConfiguration()
    {
        return new phpucConfigFile(
            $this->getCruiseControlDirectory() . '/config.xml'
        );
    }
    
    /**
     * Returns the working directory where phpUnderControl runs. This method
     * was introduced for php 5.3alpha1 and some getcwd() issues.
     *
     * @return string
     */
    protected function getWorkingDirectory()
    {
        if ( ( $cwd = getcwd() ) === false )
        {
            $cwd = getenv( 'PWD' );
        }
        return $cwd;
    }
}
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
 * @author    Sebastian Marek <proofek@gmail.com>
 * @copyright 2007-2010 Manuel Pichler. All rights reserved.
 * @license   http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @version   SVN: $Id$
 * @link      http://www.phpundercontrol.org/
 */

/**
 * This class represents an ant task in a build.xml file.
 *
 * @category  QualityAssurance
 * @package   Tasks
 * @author    Sebastian Marek <proofek@gmail.com>
 * @copyright 2007-2010 Manuel Pichler. All rights reserved.
 * @license   http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @version   Release: 0.6.1beta1
 * @link      http://www.phpundercontrol.org/
 *
 * @property      string         $executable  The command line executable.
 * @property      string         $dir         Optional working directory.
 * @property      string         $argLine     Optional command line arguments.
 * @property      string         $output      Optional output file.
 * @property      string         $error       Optional error log file.
 * @property      string         $include     Include filter for fileset ant task
 * @property      boolean        $failonerror Should the target fail on an error.
 * @property      boolean        $logerror    Should the target log all errors.
 * @property-read string         $targetName  The unique identifier for this target.
 * @property-read phpucBuildFile $buildFile   The context build file object.
 */
abstract class phpucAbstractAntTask
{
    /**
     * List of {@link phpucAbstractAntTask}
     *
     * @var array(phpucAbstractAntTask)
     */
    protected $tasks = array();

    /**
     * Magic properties for the build target.
     *
     * @var array(string=>mixed)
     */
    protected $properties = array(
        'failonerror'  =>  false,
        'executable'   =>  null,
        'targetName'   =>  null,
        'buildFile'    =>  null,
        'logerror'     =>  false,
        'argLine'      =>  null,
        'output'       =>  null,
        'error'        =>  null,
        'dir'          =>  '${basedir}/source',
        'include'      =>  null,
    );

    /**
     * The constructor takes the parent build file as an argument.
     *
     * @param phpucBuildFile $buildFile  The parent build file object.
     */
    protected function __construct(phpucBuildFile $buildFile)
    {
        $this->properties['buildFile']  = $buildFile;
    }

    /**
     * Creates {@link phpucAbstractAntTask} specified by task name
     *
     * @see phpucExecAntTask
     * @see phpucApplyAntTask
     * @see phpucFilesetAntTask
     *
     * @param phpucBuildFile $buildFile Parent build file
     * @param string         $taskName  Task name
     *
     * @return phpucAbstractAntTask
     * @throws phpucTaskException
     */
    public static function create( phpucBuildFile $buildFile, $taskName )
    {
        $className = 'phpuc' . ucfirst( $taskName ) . 'AntTask';

        if ( !class_exists( $className ) ) {
            throw new phpucTaskException(
                sprintf(
                    "Cannot create '%s' ant task. Source class '%s' not available.",
                    $taskName,
                    $className
                )
            );
        }

        return new $className($buildFile);
    }

    /**
     * Magic property isset method.
     *
     * @param string $name The property name.
     *
     * @return boolean
     * @ignore
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
     * @throws OutOfRangeException If the requested property doesn't exist or
     *         is writeonly.
     * @ignore
     */
    public function __get( $name )
    {
        if ( array_key_exists( $name, $this->properties ) )
        {
            return $this->properties[$name];
        }
        throw new OutOfRangeException(
            sprintf( 'Unknown or writeonly property $%s.', $name )
        );
    }

    /**
     * Magic property setter method.
     *
     * @param string $name  The property name.
     * @param mixed  $value The property value.
     *
     * @return void
     * @throws OutOfRangeException If the requested property doesn't exist or
     *         is readonly.
     * @throws InvalidArgumentException If the given value has an unexpected
     *         format or an invalid data type.
     * @ignore
     */
    public function __set( $name, $value )
    {
        switch ( $name )
        {
            case 'executable':
            case 'argLine':
            case 'output':
            case 'error':
            case 'dir':
            case 'include':
                $this->properties[$name] = $value;
                break;

            case 'failonerror':
            case 'logerror':
                if ( !is_bool( $value ) )
                {
                    throw new InvalidArgumentException(
                        sprintf( 'The property $%s must be a boolean.', $name )
                    );
                }
                $this->properties[$name] = $value;
                break;

            default:
                throw new OutOfRangeException(
                    sprintf( 'Unknown or readonly property $%s.', $name )
                );
                break;
        }
    }

    /**
     * Builds/Rebuilds the target xml content.
     *
     * @see phpucExecAntTask
     * @see phpucApplyAntTask
     * @see phpucFilesetAntTask
     *
     * @param DOMElement $target Xml element
     *
     * @return void
     */
    abstract public function buildXml(DOMElement $target);

    /**
     * Adds a task to the task list
     *
     * @see phpucAbstractAntTask::$tasks
     *
     * @param phpucAbstractAntTask $task ant task
     *
     * @return void
     */
    public function addTask(phpucAbstractAntTask $task)
    {
        $this->tasks[] = $task;
    }

    /**
     * Creates a dom element in the context of the current build file.
     *
     * @param string $tagName Name of the element to create.
     *
     * @return DOMElement
     */
    protected function createElement( $tagName )
    {
        return $this->buildFile->createElement( $tagName );
    }
}
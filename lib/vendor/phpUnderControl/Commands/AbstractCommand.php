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
 * @package   Commands
 * @author    Manuel Pichler <mapi@phpundercontrol.org>
 * @copyright 2007-2010 Manuel Pichler. All rights reserved.
 * @license   http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @version   SVN: $Id$
 * @link      http://www.phpundercontrol.org/
 */

/**
 * Implementation mode of the example mode.
 *
 * @category  QualityAssurance
 * @package   Commands
 * @author    Manuel Pichler <mapi@phpundercontrol.org>
 * @copyright 2007-2010 Manuel Pichler. All rights reserved.
 * @license   http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @version   Release: 0.6.1beta1
 * @link      http://www.phpundercontrol.org/
 */
abstract class phpucAbstractCommand implements phpucCommandI
{
    /**
     * Factory method for the different cli modes.
     *
     * @param string $commandId The command identifier.
     *
     * @return phpucAbstractCommand
     */
    public static function createCommand( $commandId )
    {
        // Create the command identifier
        $identifier = ucwords( strtr( $commandId, '-', ' ' ) );
        $identifier = str_replace( ' ', '', $identifier );

        // Generate class name
        $className = sprintf( 'phpuc%sCommand', $identifier );

        if ( class_exists( $className, true ) === false )
        {
            throw new phpucErrorException(
                sprintf( 'Unknown command "%s" used.', $commandId )
            );
        }

        return new $className();
    }

    /**
     * The console argument object.
     *
     * @var phpucConsoleArgs
     */
    protected $args = null;

    /**
     * List of command specific tasks.
     *
     * @var array(phpucTaskI)
     */
    protected $tasks = null;

    /**
     * Constructs a new command instance.
     */
    public final function __construct()
    {
    }

    /**
     * Setter for the console arguments.
     *
     * @param phpucConsoleArgs $args The console arguments.
     *
     * @return void
     */
    public function setConsoleArgs( phpucConsoleArgs $args )
    {
        $this->args = $args;
    }

    /**
     * Validates all command tasks.
     *
     * @return void
     */
    public function validate()
    {
        foreach ( $this->createTasks() as $task )
        {
            $task->setConsoleArgs( $this->args );
            $task->validate();
        }
    }

    /**
     * Executes all command tasks.
     *
     * @return void
     */
    public function execute()
    {
        foreach ( $this->createTasks() as $task )
        {
            $task->setConsoleArgs( $this->args );
            $task->execute();
        }
    }

    /**
     * Creates a set of command specific tasks.
     *
     * @return array(phpucTaskI)
     */
    public final function createTasks()
    {
        if ( $this->tasks === null )
        {
            $this->tasks = $this->doCreateTasks();
        }
        return $this->tasks;
    }

    /**
     * Creates all command specific {@link phpucTaskI} objects.
     *
     * @return array(phpucTaskI)
     */
    protected abstract function doCreateTasks();
}
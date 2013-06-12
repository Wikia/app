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
 * Settings for the php unit tool.
 *
 * @category  QualityAssurance
 * @package   Tasks
 * @author    Manuel Pichler <mapi@phpundercontrol.org>
 * @copyright 2007-2010 Manuel Pichler. All rights reserved.
 * @license   http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @version   Release: 0.6.1beta1
 * @link      http://www.phpundercontrol.org/
 *
 * @property-read boolean $coverage  Enable coverage support?
 */
class phpucPhpUnitTask extends phpucAbstractPearTask
{
    /**
     * Constructs a new phpunit task.
     */
    public function __construct()
    {
        parent::__construct();

        $this->properties['coverage'] = true;
    }

    /**
     * Creates the coverage build directory.
     *
     * @return void
     * @throws phpucExecuteException If the execution fails.
     */
    public function execute()
    {
        $out = phpucConsoleOutput::get();
        $out->writeLine( 'Performing PHPUnit task.' );
        $out->startList();
        
        $this->createLogDirectories();
        $this->createAntTarget();
        $this->createCruiseControlPublisher();

        $out->writeLine();
    }

    /**
     * Creates the required log directories.
     *
     * @return void
     */
    protected function createLogDirectories()
    {
        phpucConsoleOutput::get()->writeListItem(
            'Creating log dir: project/{1}/build/coverage',
            $this->getProjectName()
        );
        phpucFileUtil::createDirectoryIfNotExists( 
            $this->getProjectPath() . '/build/logs'
        );

        if ( $this->coverage )
        {
            phpucConsoleOutput::get()->writeListItem(
                'Creating coverage dir: project/{1}/build/coverage',
                $this->getProjectName()
            );
            phpucFileUtil::createDirectoryIfNotExists(
                $this->getProjectPath() . '/build/coverage'
            );
        }
    }

    /**
     * Creates the required cruisecontrol publishers for phpunit.
     *
     * @return void
     */
    protected function createCruiseControlPublisher()
    {
        phpucConsoleOutput::get()->writeListItem(
            'Modifying config file: config.xml'
        );

        $config    = $this->getCruiseControlConfiguration();
        $project   = $config->getProject( $this->getProjectName() );
        $publisher = $project->createArtifactsPublisher();

        $publisher->dir          = 'projects/${project.name}/build/coverage';
        $publisher->subdirectory = 'coverage';

        if ( $this->artifacts )
        {
            $publisher->dest = 'artifacts/${project.name}';
        }
        else
        {
            $publisher->dest = 'logs/${project.name}';
        }

        $config->store();
    }

    /**
     * Creates the ant target element for phpunit.
     *
     * @return void
     */
    protected function createAntTarget()
    {
        phpucConsoleOutput::get()->writeListItem(
            'Modifying build file:  project/{1}/build.xml',
            $this->getProjectName()
        );

        $buildFile = new phpucBuildFile( $this->getProjectPath() . '/build.xml' );

        $buildTarget = $buildFile->createBuildTarget( 'phpunit' );
        $buildTarget->dependOn( 'lint' );

        $execTask = phpucAbstractAntTask::create( $buildFile, 'exec' );
        $execTask->executable  = $this->executable;
        $execTask->failonerror = true;
        $execTask->argLine     = $this->getPhpunitCliArguments();
        
        $buildTarget->addTask( $execTask );

        $buildFile->store();
    }

    /**
     * Creates the phpunit command line arguments.
     *
     * @return string
     */
    protected function getPhpunitCliArguments()
    {
        $arguments = $this->getPhpunitLogOptions();
        if ( $this->args->hasOption( 'test-case' ) )
        {
            $arguments .= ' ' . $this->args->getOption( 'test-case' );
        }
        
        $arguments .= ' ' . $this->args->getOption( 'test-dir' );
        if ( $this->args->hasOption( 'test-file' ) )
        {
            $arguments .= '/' . $this->args->getOption( 'test-file' );
        }
        
        return $arguments;
    }

    /**
     * Returns the log options for phpunit.
     *
     * @return string
     */
    protected function getPhpunitLogOptions()
    {
        $logs = ' --log-junit ${basedir}/build/logs/phpunit.xml';

        if ( $this->properties['coverage'] === true )
        {
            $logs .= ' --coverage-clover ${basedir}/build/logs/phpunit.coverage.xml';
            $logs .= ' --coverage-html ${basedir}/build/coverage';
        }
        return $logs;
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
        parent::registerCommandExtension( $def, $command );

        $def->addOption(
            $command->getCommandId(),
            'n',
            'without-phpunit',
            'Disable PHPUnit support.'
        );
        $def->addOption(
            $command->getCommandId(),
            't',
            'test-dir',
            'The test directory in the project.',
            true,
            null,
            false
        );
        $def->addOption(
            $command->getCommandId(),
            'a',
            'test-case',
            'Name of the test case class.',
            true,
            null,
            false
        );
        $def->addOption(
            $command->getCommandId(),
            'l',
            'test-file',
            'Name of the test case file.',
            true,
            null,
            false
        );
    }

    /**
     * Validates the existing PHPUnit version.
     *
     * @return void
     */
    protected function doValidate()
    {
        $binary = basename( $this->executable );

        if ( ( $execdir = dirname( $this->executable ) ) !== '.' )
        {
            chdir( $execdir );

            if ( phpucFileUtil::getOS() === phpucFileUtil::OS_UNIX )
            {
                $binary = "./{$binary}";
            }
        }

        // Check Xdebug installation
        if ( extension_loaded( 'xdebug' ) === false )
        {
            phpucConsoleOutput::get()->writeLine(
                'NOTICE: The xdebug extension is not installed. For coverage'
            );
            phpucConsoleOutput::get()->writeLine(
                'you must install xdebug with the following command:'
            );
            phpucConsoleOutput::get()->writeLine(
                '  pecl install pecl/xdebug'
            );

            $this->properties['coverage'] = false;
        }
    }

    /**
     * Must return the name of the used cli tool.
     *
     * @return string
     */
    protected function getCliToolName()
    {
        return 'phpunit';
    }
}

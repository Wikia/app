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
 * This task generates the code browser.
 *
 * @category  QualityAssurance
 * @package   Tasks
 * @author    Manuel Pichler <mapi@phpundercontrol.org>
 * @copyright 2007-2010 Manuel Pichler. All rights reserved.
 * @license   http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @version   Release: 0.6.1beta1
 * @link      http://www.phpundercontrol.org/
 */
class phpucCodeBrowserTask extends phpucAbstractPearTask implements phpucConsoleExtensionI
{
    /**
     * Performs the primary task and adds an execute publisher to the config.xml.
     *
     * @return void
     */
    public function execute()
    {
        $out = phpucConsoleOutput::get();
        $out->writeLine( 'Performing PHP_CodeBrowser task.' );

        $out->startList();
        $out->writeListItem(
            'Creating browser dir: project/{1}/build/php-code-browser',
            $this->args->getOption( 'project-name' )
        );
        $this->createCodeBrowserBuildDirectory();

        $out->writeListItem( 'Modifying config file: config.xml' );
        $this->createCodeBrowserExecutePublisher();
        $this->createCodeBrowserArtifactsPublisher();

        $out->writeLine();
    }

    /**
     * Creates the build directory for the source browser report.
     *
     * @return void
     */
    private function createCodeBrowserBuildDirectory()
    {
        if ( file_exists( $this->getCodeBrowserBuildDirectory() ) === false )
        {
            mkdir( $this->getCodeBrowserBuildDirectory(), 0755, true );
        }
    }

    /**
     * Returns the build directory used for the PHP_CodeBrowser report.
     *
     * @return string
     */
    private function getCodeBrowserBuildDirectory()
    {
        return sprintf(
            '%s/projects/%s/build/php-code-browser',
            $this->args->getArgument( 'cc-install-dir' ),
            $this->args->getOption( 'project-name' )
        );
    }

    /**
     * Creates an execute publisher for the PHP_CodeBrowser generator.
     *
     * @return void
     */
    private function createCodeBrowserExecutePublisher()
    {
        $projectConfig = $this->getCruiseControlProjectConfiguration();

        $publisher          = $projectConfig->createExecutePublisher();
        $publisher->command = sprintf(
            '%s ' .
            '--log projects/${project.name}/build/logs ' .
            '--source %s ' .
            '--output projects/${project.name}/build/php-code-browser',
            $this->getCodeBrowserExecutable(),
            $this->getProjectSourceDirectory()
        );

        $projectConfig->configFile->store();
    }

    /**
     * Creates an artifacts publisher for the generate PHP_CodeBrowser report.
     *
     * @return void
     */
    private function createCodeBrowserArtifactsPublisher()
    {
        $projectConfig = $this->getCruiseControlProjectConfiguration();

        $publisher               = $projectConfig->createArtifactsPublisher();
        $publisher->dir          = 'projects/${project.name}/build/php-code-browser';
        $publisher->subdirectory = 'php-code-browser';

        if ( $this->artifacts )
        {
            $publisher->dest = 'artifacts/${project.name}';
        }
        else
        {
            $publisher->dest = 'logs/${project.name}';
        }

        $projectConfig->configFile->store();
    }

    /**
     * Returns a configuration instance for the current project
     *
     * @return phpucConfigProject
     */
    private function getCruiseControlProjectConfiguration()
    {
        $configFile = new phpucConfigFile(
            $this->args->getArgument( 'cc-install-dir' ) . '/config.xml'
        );

        return $configFile->getProject( $this->args->getOption( 'project-name' ) );
    }

    /**
     * Returns the source code directory for the current project.
     *
     * @return string
     */
    private function getProjectSourceDirectory()
    {
        $sourceDirectory = $this->args->getOption( 'source-dir' );
        if ( realpath( $sourceDirectory ) === $sourceDirectory )
        {
            return $sourceDirectory;
        }
        return 'projects/${project.name}/source/' . $sourceDirectory;
    }

    /**
     * Returns the pathname of the PHP_CodeBrowser executable.
     *
     * @return string
     */
    private function getCodeBrowserExecutable()
    {
        return $this->executable;
    }

    /**
     * Callback method that registers a command extension.
     *
     * @param phpucConsoleInputDefinition $definition
     *        The input definition container.
     * @param phpucConsoleCommandI  $command
     *        The context cli command instance.
     *
     * @return void
     */
    public function registerCommandExtension(
        phpucConsoleInputDefinition $definition,
        phpucConsoleCommandI $command
    ) {
        parent::registerCommandExtension( $definition, $command );

        $definition->addOption(
            $command->getCommandId(),
            'b',
            'without-code-browser',
            'Disable PHP CodeBrowser support.'
        );

        if ( !$definition->hasOption( $command->getCommandId(), 'source-dir' ) )
        {
            $definition->addOption(
                $command->getCommandId(),
                's',
                'source-dir',
                'The source directory in the project.',
                true,
                'src',
                true
            );
        }
    }

    /**
     * Must return the name of the used cli tool.
     *
     * @return string
     */
    protected function getCliToolName()
    {
        return 'phpcb';
    }
}

<?php
/**
 * This file is part of phpUnderControl.
 *
 * PHP Version 5
 *
 * Copyright (c) 2007-2010, Manuel Pichler <mapi@manuel-pichler.de>.
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
 * @author    Manuel Pichler <mapi@manuel-pichler.de>
 * @copyright 2007-2010 Manuel Pichler. All rights reserved.
 * @license   http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @version   SVN: $Id$
 * @link      http://www.phpundercontrol.org/
 */

/**
 * Performs a project checkout.
 *
 * @category  QualityAssurance
 * @package   Tasks
 * @author    Manuel Pichler <mapi@manuel-pichler.de>
 * @copyright 2007-2010 Manuel Pichler. All rights reserved.
 * @license   http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @version   Release: 0.6.1beta1
 * @link      http://www.phpundercontrol.org/
 */
class phpucCheckoutTask extends phpucAbstractTask implements phpucConsoleExtensionI
{
    /**
     * Performs a project checkout against the specified repository.
     *
     * @return void
     */
    public function execute()
    {
        $out = phpucConsoleOutput::get();
        $out->writeLine( 'Performing checkout task.' );
        $out->startList();

        // Get current working dir
        $cwd = getcwd();

        $out->writeListItem( 'Checking out project.' );

        $projectPath = sprintf(
            '%s/projects/%s',
            $this->args->getArgument( 'cc-install-dir' ),
            $this->args->getOption( 'project-name' )
        );

        // Switch working dir to the CruiseControl project directory
        chdir( $projectPath );

        $checkout = phpucAbstractCheckout::createCheckout( $this->args );
        $checkout->checkout();

        chdir( $cwd );

        $out->writeListItem( 'Preparing config.xml file.' );

        $fileName = sprintf(
            '%s/config.xml',
            $this->args->getArgument( 'cc-install-dir' )
        );

        $config  = new phpucConfigFile( $fileName );
        $project = $config->getProject( $this->args->getOption( 'project-name' ) );

        $strapper                   = $project->createBootStrapper();
        $strapper->localWorkingCopy = "{$projectPath}/source";
        $strapper->strapperType     = $this->args->getOption( 'version-control' );

        $trigger                   = $project->createBuildTrigger();
        $trigger->localWorkingCopy = "{$projectPath}/source";
        $trigger->triggerType      = $this->args->getOption( 'version-control' );

        $config->store();

        $out->writeListItem( 'Preparing build.xml checkout target.' );

        $buildFile  = new phpucBuildFile( "{$projectPath}/build.xml" );
        $buildTarget = $buildFile->createBuildTarget( 'checkout' );

        $execTask = phpucAbstractAntTask::create( $buildFile, 'exec' );
        $execTask->executable = phpucFileUtil::findExecutable(
            $this->args->getOption( 'version-control' )
        );
        $execTask->argLine     = $checkout->getUpdateCommand();
        $execTask->failonerror = true;
        $buildTarget->addTask( $execTask );

        $buildFile->store();

        $out->writeLine();
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
        $def->addOption(
            $command->getCommandId(),
            'v',
            'version-control',
            'The used version control system.',
            array( 'svn', 'cvs', 'git' ),
            null,
            true
        );
        $def->addOption(
            $command->getCommandId(),
            'x',
            'version-control-url',
            'The version control system project url.',
            true,
            null,
            true
        );
        $def->addOption(
            $command->getCommandId(),
            'u',
            'username',
            'Optional username for the version control system.',
            true
        );
        $def->addOption(
            $command->getCommandId(),
            'p',
            'password',
            'Optional password for the version control system.',
            true
        );
        $def->addOption(
            $command->getCommandId(),
            'd',
            'destination',
            'This option is deprecated and will be removed in upcoming versions.',
            true,
            'source',
            true
        );
        $def->addOption(
            $command->getCommandId(),
            'm',
            'module',
            'A CVS project module.',
            true
        );
    }
}
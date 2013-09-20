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
 * @author    Sebastian Marek <proofek@gmail.com>
 * @copyright 2007-2010 Manuel Pichler. All rights reserved.
 * @license   http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @version   SVN: $Id$
 * @link      http://www.phpundercontrol.org/
 */

/**
 * Performs syntax check using php lint.
 *
 * @category  QualityAssurance
 * @package   Tasks
 * @author    Sebastian Marek <proofek@gmail.com>
 * @copyright 2007-2010 Manuel Pichler. All rights reserved.
 * @license   http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @version   Release: 0.6.1beta1
 * @link      http://www.phpundercontrol.org/
 */
class phpucLintTask extends phpucAbstractTask implements phpucConsoleExtensionI
{
    /**
     * Performs php files syntax check using php lint.
     *
     * @return void
     */
    public function execute()
    {
        $out = phpucConsoleOutput::get();
        $out->writeLine( 'Performing PHP lint task.' );
        $out->startList();

        $projectName = $this->args->getOption( 'project-name' );
        $projectPath = sprintf(
            '%s/projects/%s',
            $this->args->getArgument( 'cc-install-dir' ),
            $this->args->getOption( 'project-name' )
        );

        $out->writeListItem(
            'Modifying build file: project/{1}/build.xml', $projectName
        );

        $buildFile  = new phpucBuildFile( "{$projectPath}/build.xml" );
        $buildTarget = $buildFile->createBuildTarget( 'lint' );

        $filesetTask = phpucAbstractAntTask::create( $buildFile, 'fileset' );
        $filesetTask->include = '**/*.php';

        $applyTask = phpucAbstractAntTask::create( $buildFile, 'apply' );
        $applyTask->argLine = '-l';
        $applyTask->failonerror = true;
        $applyTask->logerror = true;
        $applyTask->addTask( $filesetTask );

        $buildTarget->addTask( $applyTask );

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
            'li',
            'without-lint',
            'Disable lint check.'
        );
    }
}
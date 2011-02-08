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
 * Settings for the php code sniffer tool.
 *
 * @category  QualityAssurance
 * @package   Tasks
 * @author    Manuel Pichler <mapi@phpundercontrol.org>
 * @copyright 2007-2010 Manuel Pichler. All rights reserved.
 * @license   http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @version   Release: 0.6.1beta1
 * @link      http://www.phpundercontrol.org/
 */
class phpucPhpCodeSnifferTask extends phpucAbstractPearTask
{
    /**
     * Minimum code sniffer version.
     */
    const CODE_SNIFFER_VERSION = '1.0.0';

    /**
     * Does nothing.
     *
     * @return void
     */
    public function execute()
    {
        $out = phpucConsoleOutput::get();
        $out->writeLine( 'Performing PHP_CodeSniffer task.' );

        $projectName = $this->args->getOption( 'project-name' );
        $projectPath = sprintf(
            '%s/projects/%s',
            $this->args->getArgument( 'cc-install-dir' ),
            $projectName
        );

        $out->startList();
        $out->writeListItem(
            'Modifying build file: project/{1}/build.xml', $projectName
        );

        // Create error log file
        $errorLog = phpucFileUtil::getSysTempDir() . '/checkstyle.error.log';

        $buildFile = new phpucBuildFile( $projectPath . '/build.xml', $projectName );

        $buildTarget = $buildFile->createBuildTarget( 'php-codesniffer' );
        $buildTarget->dependOn( 'lint' );

        $execTask = phpucAbstractAntTask::create( $buildFile, 'exec' );
        $execTask->executable = $this->executable;
        $execTask->error      = $errorLog;
        $execTask->output     = '${basedir}/build/logs/checkstyle.xml';
        $execTask->argLine    = sprintf(
            '--report=checkstyle --standard=%s %s',
            $this->args->getOption( 'coding-guideline' ),
            $this->args->getOption( 'source-dir' )
        );
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
        parent::registerCommandExtension( $def, $command );

        $def->addOption(
            $command->getCommandId(),
            'f',
            'without-code-sniffer',
            'Disable PHP CodeSniffer support.'
        );

        $def->addOption(
            $command->getCommandId(),
            'g',
            'coding-guideline',
            'The used PHP_CodeSniffer coding guideline.',
            true,
            'PEAR',
            true
        );
        if ( !$def->hasOption( $command->getCommandId(), 'source-dir' ) )
        {
            $def->addOption(
                $command->getCommandId(),
                's',
                'source-dir',
                'The source directory in the project.',
                true,
                'src',
                true
            );
        }
        if ( !$def->hasOption( $command->getCommandId(), 'ignore-dir' ) )
        {
            $def->addOption(
                $command->getCommandId(),
                'r',
                'ignore-dir',
                'List of ignorable directories, separated by comma.',
                true,
                null,
                false
            );
        }
    }

    /**
     * Validates the existing code sniffer version.
     *
     * @return void
     */
    protected function doValidate()
    {
        $cwd = $this->getWorkingDirectory();

        $binary = basename( $this->executable );

        if ( ( $execdir = dirname( $this->executable ) ) !== '.' )
        {
            chdir( $execdir );

            if ( phpucFileUtil::getOS() === phpucFileUtil::OS_UNIX )
            {
                $binary = "./{$binary}";
            }
        }

        $regexp = '/version\s+([0-9\.]+(RC[0-9])?)/';
        $retval = exec( escapeshellcmd( "{$binary} --version" ) );

        chdir( $cwd );

        if ( preg_match( $regexp, $retval, $match ) === 0 )
        {
            phpucConsoleOutput::get()->writeLine(
                'WARNING: Cannot identify PHP_CodeSniffer version.'
            );
            // Assume valid version
            $version = self::CODE_SNIFFER_VERSION;
        }
        else
        {
            $version = $match[1];
        }

        if ( version_compare( $version, self::CODE_SNIFFER_VERSION ) < 0 )
        {
            throw new phpucValidateException(
                sprintf(
                    'PHP_CodeSniffer version %s or higher required.' .
                    ' Given version is "%s".',
                    self::CODE_SNIFFER_VERSION,
                    $version
                )
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
        return 'phpcs';
    }
}

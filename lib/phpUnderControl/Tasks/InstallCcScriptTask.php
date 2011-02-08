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
 * @link      http://www.phpundercontrol.org/
 */

/**
 * This task installs linux init script to start/stop cruisecontrol service
 * in linux systems.
 *
 * @category  QualityAssurance
 * @package   Tasks
 * @author    Sebastian Marek <proofek@gmail.com>
 * @copyright 2007-2010 Manuel Pichler. All rights reserved.
 * @license   http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @version   Release: 0.6.1beta1
 * @link      http://www.phpundercontrol.org/
 */
class phpucInstallCcScriptTask extends phpucAbstractTask implements phpucConsoleExtensionI
{
    /**
     * Validates parameters.
     *
     * @return void
     * @throws phpucValidateException If the directory doesn't exist or the
     *         a project for the given name already exists.
     */
    public function validate()
    {
        $installDir = $this->args->getArgument( 'cc-install-dir' );
        $initDir    = $this->args->getArgument( 'init-dir' );

        $javaHome = $this->args->getOption( 'java-home' );
        $ccBin    = $this->args->getOption( 'cc-bin' );

        if ( !is_dir( $installDir ) || !is_file( "$installDir/$ccBin" ) )
        {
            throw new phpucValidateException(
                'Invalid cruisecontrol directory <cc-install-dir>.'
            );
        }

        if ( !is_dir( $initDir ) )
        {
            throw new phpucValidateException(
                'Invalid init scripts directory <init-dir>.'
            );
        }

        if ( !is_dir( $javaHome ) || !is_file( "$javaHome/bin/java" ) )
        {
            throw new phpucValidateException(
                'Invalid JAVA_HOME directory.'
            );
        }

        if ( is_file( "$initDir/cruisecontrol" ) )
        {
            throw new phpucValidateException(
                'Cruisecontrol init script already exists - Aborting!'
            );
        }

        if ( !is_writable( $initDir ) )
        {
            throw new phpucValidateException(
                'Cannot write into init script directory. ' .
                'Make sure the directory is writeable or ' .
                'run the script as root user.'
            );
        }
    }

    /**
     * Installs linux init script for cruisecontrol
     *
     * @return void
     */
    public function execute()
    {
        $out = phpucConsoleOutput::get();
        $out->writeLine( 'Setting up Cruisecontrol start-up script.' );

        $installDir = $this->args->getArgument( 'cc-install-dir' );
        $initDir    = $this->args->getArgument( 'init-dir' );

        $javaHome = $this->args->getOption( 'java-home' );
        $ccUser   = $this->args->getOption( 'cc-user' );
        $ccBin    = $this->args->getOption( 'cc-bin' );

        $ccScript = file_get_contents( PHPUC_DATA_DIR . '/template/cruisecontrol.sh' );
        if ( !$ccScript )
        {
            throw new phpucTaskException(
                'Cannot access Cruisecontrol init script template.'
            );
        }

        $ccScript = str_replace( '%cc-install-dir%', $installDir, $ccScript );
        $ccScript = str_replace( '%java-home%', $javaHome, $ccScript );
        $ccScript = str_replace( '%run-as-user%', $ccUser, $ccScript );
        $ccScript = str_replace( '%cc-bin%', $ccBin, $ccScript );

        $result = file_put_contents( "$initDir/cruisecontrol", $ccScript );
        if ( !$result )
        {
            throw new phpucTaskException(
                'Cruisecontrol init script could not be saved.'
            );
        }

        $out->writeLine( 'Making the script executable.' );
        chmod("$initDir/cruisecontrol", 0755);
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
            'u',
            'cc-user',
            'Username to run Cruisecontrol service.',
            true,
            'cruisecontrol',
            true
        );

        $def->addOption(
            $command->getCommandId(),
            'j',
            'java-home',
            'The full path to JAVA_HOME directory.',
            true,
            '/usr',
            true
        );

        $def->addOption(
            $command->getCommandId(),
            'b',
            'cc-bin',
            'Cruisecontrol script name.',
            true,
            'cruisecontrol.sh',
            true
        );
    }
}
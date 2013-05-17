<?php
/**
 * This file is part of phpUnderControl.
 *
 * PHP Version 5.2.0
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
 * Removes old build artifacts and logs for a specified project.
 *
 * @category  QualityAssurance
 * @package   Tasks
 * @author    Manuel Pichler <mapi@manuel-pichler.de>
 * @copyright 2007-2010 Manuel Pichler. All rights reserved.
 * @license   http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @version   Release: 0.6.1beta1
 * @link      http://www.phpundercontrol.org/
 */
class phpucProjectCleanTask extends phpucAbstractTask implements phpucConsoleExtensionI
{
    /**
     * Validates that a project <cc-install-dir>/projects/<project-name> exists.
     *
     * @return void
     * @throws phpucValidateException
     *         If the directory doesn't exist or the config.xml file does not
     *         contain a section for this project.
     */
    public function validate()
    {
        if ( is_dir( $this->getProjectPath() ) === false )
        {
            throw new phpucValidateException(
                "Missing project directory '{$this->getProjectPath()}'."
            );
        }
    }
    
    /**
     * Removes the project configuration from the CruiseControl config.xml file
     * and deletes all project contents.
     *
     * @return void
     */
    public function execute()
    {
        $timestamps = $this->collectTimestamps();

        $this->cleanLogFiles( $timestamps );
        $this->cleanArtifacts( $this->getProjectLogDirectory(), $timestamps );
        $this->cleanArtifacts( $this->getProjectArtifactDirectory(), $timestamps );
    }

    /**
     * Removes all project log files.
     *
     * @param array $timestamps List of all removable logs files.
     *
     * @return void
     */
    protected function cleanLogFiles( array $timestamps )
    {
        foreach ( array_keys( $timestamps ) as $file )
        {
            unlink( $file );
        }
    }

    /**
     * Removes all project artifact subdirectories that match one of the given
     * timestamps.
     *
     * @param string $basePath
     *        Base directory where the method starts to clean up.
     * @param array $timestamps
     *        List of all removable timestamps.
     *
     * @return void
     */
    protected function cleanArtifacts( $basePath, array $timestamps )
    {
        foreach ( $timestamps as $timestamp )
        {
            $path = "{$basePath}/{$timestamp}";
            if ( is_dir( $path ) )
            {
                phpucFileUtil::deleteDirectory( $path );
            }
        }
    }

    /**
     * Collects all timestamps for the context project.
     *
     * @return array(string=>string)
     */
    protected function collectTimestamps()
    {
        $path = $this->getProjectLogDirectory();
        if ( !is_dir( $path ) )
        {
            return array();
        }

        $timestamps = array();
        foreach ( glob( "{$path}/log*.xml" ) as $file )
        {
            $timestamps[$file] = substr( basename( $file ), 3, 14 );
        }

        return $this->reduceTimestamps( $timestamps );
    }

    /**
     * Reduces the number of timestamps in the array.
     *
     * @param array(string=>string) $timestamps All timestamps for this project.
     *
     * @return array(string=>string)
     */
    protected function reduceTimestamps( array $timestamps )
    {
        // Sort reverse, newest first
        arsort( $timestamps );

        if ( $this->args->hasOption( 'keep-days' ) === false )
        {
            $keepBuilds = (int) $this->args->getOption( 'keep-builds' );
            if ( $keepBuilds < 1 )
            {
                $keepBuilds = 20;
            }
        }
        else
        {
            $time = (int) $this->args->getOption( 'keep-days' );
            $time = mktime( 0, 0, 0 ) - ( $time * 86400 );

            $keepBuilds = count( $timestamps );
            foreach ( $timestamps as $timestamp )
            {
                if ( preg_match( '/(\d{4})(\d{2})(\d{2})/', $timestamp, $m ) === 0 )
                {
                    continue;
                }

                if ( mktime( 0, 0, 0, $m[2], $m[3], $m[1] ) < $time )
                {
                    --$keepBuilds;
                }
            }
        }

        // Return reduced array.
        return array_slice( $timestamps, $keepBuilds );
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
            'j',
            'project-name',
            'The name of the generated project.',
            true,
            null,
            true
        );
        $def->addOption(
            $command->getCommandId(),
            'k',
            'keep-builds',
            'The number of builds to keep.',
            true,
            20,
            true
        );
        $def->addOption(
            $command->getCommandId(),
            'd',
            'keep-days',
            'Removes all builds older than specified days.',
            true
        );
    }
}
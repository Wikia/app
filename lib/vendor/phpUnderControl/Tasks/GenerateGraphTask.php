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
 * Generates a set of graphs for each project build.
 *
 * @category  QualityAssurance
 * @package   Tasks
 * @author    Manuel Pichler <mapi@phpundercontrol.org>
 * @copyright 2007-2010 Manuel Pichler. All rights reserved.
 * @license   http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @version   Release: 0.6.1beta1
 * @link      http://www.phpundercontrol.org/
 */
class phpucGenerateGraphTask extends phpucAbstractTask implements phpucConsoleExtensionI
{
    /**
     * The log directory.
     *
     * @var string
     */
    protected $logDir = null;

    /**
     * The graph output directory.
     *
     * Normally this defaults to log directory but in some cases different
     * directories are used for artifacts.
     *
     * @var string
     */
    protected $outputDir = null;

    /**
     * Internal used debug property.
     *
     * If this is set to <b>true</b> all graphs are regenerate on every call.
     *
     * @var boolean
     */
    private $debug = false;

    /**
     * Validates that the project log directory exists.
     *
     * @return void
     *
     * @throws phpucValidateException If the validation fails.
     */
    public function validate()
    {
        $logdir = $this->args->getArgument( 'project-log-dir' );

        if ( trim( $this->logDir = realpath( $logdir ) ) === '' )
        {
            throw new phpucValidateException(
                "The specified log directory '{$logdir}' doesn't exist."
            );
        }

        if ( $this->args->hasArgument( 'project-output-dir' ) )
        {
            $outputDir = $this->args->getArgument( 'project-output-dir' );

            if ( trim( $this->outputDir = realpath( $outputDir ) ) === '' )
            {
                throw new phpucValidateException(
                    "The specified output directory '{$outputDir}' doesn't exist."
                );
            }
        }
        else
        {
            $this->outputDir = $this->logDir;
        }

        $this->validateMaxNumber();
    }

    /**
     * Validates the configured max number value for log entries that will
     * appear in a generated graph.
     *
     * @return void
     */
    private function validateMaxNumber()
    {
        if ( $this->getMaxNumber() < 2 )
        {
            throw new phpucValidateException(
                'The maximum number of builds shown in charts must greater one.'
            );
        }
    }

    /**
     * Returns the maximum number of log files that will show up in a generated
     * graph.
     *
     * @return integer
     */
    private function getMaxNumber()
    {
        if ( $this->args->hasOption( 'max-number' ) )
        {
            return $this->args->getOption( 'max-number' );
        }
        return PHP_INT_MAX;
    }

    /**
     * Generates a set of charts for each project build(if required).
     *
     * @return void
     */
    public function execute()
    {
        // Force update?
        $force = ( $this->debug || $this->args->hasOption( 'force-update' ) );

        $inputLoader  = new phpucInputLoader();
        $chartFactory = new phpucChartFactory( $this->getMaxNumber() );

        $logFiles = new phpucLogFileIterator( $this->logDir );

        foreach ( $logFiles as $logFile )
        {
            $xpath = new DOMXPath( $logFile );

            $outputDir = "{$this->outputDir}/{$logFile->timestamp}/graph";

            foreach ( $inputLoader as $input )
            {
                $input->processLog( $xpath );
                if ( count( array_filter( $input->data ) ) === 0 )
                {
                    continue;
                }

                if ( !is_dir( $outputDir ) )
                {
                    mkdir( $outputDir, 0755, true );
                }

                $fileName = "{$outputDir}/{$input->fileName}.svg";

                if ( !is_dir( dirname( $fileName ) ) ) {
                    mkdir( dirname( $fileName ) );
                }

                if ( !file_exists( $fileName ) || $force )
                {
                    $chart = $chartFactory->createChart( $input );
                    $chart->render(
                        $input->graphDims['width'],
                        $input->graphDims['height'],
                        $fileName
                    );
                }
            }
        }
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
            'force-update',
            'Force graphic creation and overwrite existing files.'
        );
        $def->addOption(
            $command->getCommandId(),
            'm',
            'max-number',
            'Maximum number of entries that will appear in the generated graph.',
            true
        );
    }
}

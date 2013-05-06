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
 * Merges a set of PHPUnit log files within a single log.
 *
 * @category  QualityAssurance
 * @package   Tasks
 * @author    Manuel Pichler <mapi@manuel-pichler.de>
 * @copyright 2007-2010 Manuel Pichler. All rights reserved.
 * @license   http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @version   Release: 0.6.1beta1
 * @link      http://www.phpundercontrol.org/
 */
class phpucMergePhpunitTask extends phpucAbstractTask implements phpucConsoleExtensionI
{
    /**
     * List of input log files.
     *
     * @var array(string=>string)
     */
    private $inputFiles = array();
    
    /**
     * The log output file.
     *
     * @var string
     */
    private $outputFile = null;
    
    private $validateErrors = array();

    /**
     * Validates the task constrains.
     *
     * @return void
     * @throws phpucValidateException If the validation fails.
     */
    public function validate()
    {
        $input = $this->args->getOption( 'input' );
        
        if ( is_dir( $input ) === true )
        {
            $inputFiles = glob( "{$input}/*.xml" );
        }
        else
        {
            $inputFiles = array_map( 'trim', explode( ',', $input ) );
        }

        $files = $inputFiles;
        foreach ( $files as $idx => $file )
        {
            if ( file_exists( $file ) === false )
            {
                // Reset file index
                $files[$idx] = null;
                
                // Store error message
                $this->validateErrors[] = sprintf(
                    'The specified --input "%s" doesn\'t exist.', $file
                );
            }
        }
        
        // If no input exists, throw an exception 
        if ( count( array_filter( $files ) ) === 0 )
        {
            $message = '';
            foreach ( $inputFiles as $file )
            {
                $message .= sprintf(
                    'The specified --input "%s" doesn\'t exist.', $file
                );
                throw new phpucValidateException( $message );
            }
        }
        
        if ( $this->args->hasOption( 'builds' ) === true )
        {
            $builds = $this->args->getOption( 'builds' );
            $builds = array_map( 'trim', explode( ',', $builds ) );
        }
        else if ( count( $files ) === 1 )
        {
            $builds[] = pathinfo( reset( $files ), PATHINFO_FILENAME );
        }
        else
        {
            $parts = array();
            foreach ( $files as $file )
            {
                $tokens = array();
                $token  = strtok( $file, '\/' );
                while ( $token !== false )
                {
                    $tokens[] = $token;
                    $token    = strtok( '\/' );
                }
                $parts[] = $tokens;
            }
            
            $builds = array();
            for ( $i = 1, $j = 0, $c = count( $parts ); $i < $c; ++$i, ++$j )
            {
                $builds[$j] = join( '-', array_diff( $parts[$j], $parts[$i] ) );
                $builds[$i] = join( '-', array_diff( $parts[$i], $parts[$j] ) );
            }
            $builds = array_unique( $builds );
        }
        
        if ( count( $builds ) !== count( $files ) )
        {
            $message = sprintf(
                'Number of build identifiers "%s" and files "%s" doesn\'t match.',
                count( $builds ),
                count( $files )
            );

            throw new phpucValidateException( $message );
        }
        else if ( count( $this->validateErrors ) > 0 )
        {
            foreach ( $files as $idx => $file )
            {
                if ( $file === null )
                {
                    // Remove this build and file, the file doesn't exist
                    unset( $builds[$idx], $files[$idx] );
                }
            }
        }
        
        $this->inputFiles = array_combine( $builds, $files );
        
        $output = dirname( $this->args->getOption( 'output' ) );
        if ( is_dir( $output ) === false )
        {
            if ( is_file( $output ) === true
                || mkdir( $output ) === false
                || is_dir( $output ) === false
            ) {
                throw new phpucValidateException(
                    sprintf( 'Cannot create output directory "%s".', $output )
                );
            }
        }
        $this->outputFile = $this->args->getOption( 'output' );
    }
    
    /**
     * This method executes the main merge process of this task.
     * 
     * @return void
     * @throws phpucTaskException 
     *         If the generated test suite contains an error or a failure. This
     *         error result is used to signal a failed build.
     */
    public function execute()
    {
        $inputFiles = new ArrayIterator( $this->inputFiles );
        $aggregator = new phpucPHPUnitTestLogAggregator();
        
        $aggregator->aggregate( $inputFiles );
        $aggregator->store( $this->outputFile );
        
        if ( count( $this->validateErrors ) > 0 )
        {
            throw new phpucTaskException( implode( ' ', $this->validateErrors ) );
        }
        else if ( $aggregator->hasErrors() || $aggregator->hasFailures() )
        {
            throw new phpucTaskException(
                'There are errors or failures in the generated test suite.'
            );
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
            'i',
            'input',
            'List of input log files(separated by comma) or a single log ' .
            'directory with multiple log files.',
            true,
            null,
            true
        );
        $def->addOption(
            $command->getCommandId(),
            'o',
            'output',
            'Optional file name for the generated phpunit log. The default ' .
            'file name is "phpunit.xml".',
            true,
            null,
            true
        );
        $def->addOption(
            $command->getCommandId(),
            'b',
            'builds',
            'Optional list of build identifiers(separated by comma). This ' .
            'option can be used together with a comma separated list of log ' .
            'files',
            true
        );
    }
}
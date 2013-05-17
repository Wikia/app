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
 * This task creates a simple example project for the phpUnderControl patch set.
 *
 * @category  QualityAssurance
 * @package   Tasks
 * @author    Manuel Pichler <mapi@phpundercontrol.org>
 * @copyright 2007-2010 Manuel Pichler. All rights reserved.
 * @license   http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @version   Release: 0.6.1beta1
 * @link      http://www.phpundercontrol.org/
 * 
 * @property-read boolean $metrics  Enable metrics support?
 * @property-read boolean $coverage Enable coverage support?
 */
class phpucExampleTask extends phpucAbstractTask
{
    /**
     * List of example files.
     *
     * @var array(string)
     */
    protected $fileNames = array(
        'src/Math.php',
        'tests/MathTest.php',
    );
    
    /**
     * Creates a new example project with test files.
     *
     * @return void
     * @throws phpucExecuteException If the execution fails.
     */
    public function execute()
    {
        $out = phpucConsoleOutput::get();
        $out->writeLine( 'Performing example task.' );
        
        $installDir  = $this->args->getArgument( 'cc-install-dir' );
        $projectName = $this->args->getOption( 'project-name' );
        $projectPath = sprintf( '%s/projects/%s', $installDir, $projectName );
        
        $out->startList();
        
        $out->writeListItem(
            'Creating source directory:  project/{1}/source/src', $projectName
        );
        mkdir( $projectPath . '/source/src' );
        
        $out->writeListItem(
            'Creating tests directory:   project/{1}/source/tests', $projectName
        );
        mkdir( $projectPath . '/source/tests' );
        
        $out->writeListItem(
            'Creating source class:      project/{1}/source/src/Math.php', 
            $projectName
        );
        file_put_contents(
            $projectPath . '/source/src/Math.php',
            file_get_contents( PHPUC_DATA_DIR . '/example/src/Math.php' )
        );
        
        $out->writeListItem(
            'Creating test class:        project/{1}/source/tests/MathTest.php',
            $projectName
        );
        file_put_contents(
            $projectPath . '/source/tests/MathTest.php',
            file_get_contents( PHPUC_DATA_DIR . '/example/tests/MathTest.php' )
        );
        
        $out->writeListItem( 'Modifying config file:      config.xml' );
        
        $configXml                     = new DOMDocument();
        $configXml->preserveWhiteSpace = false;
        $configXml->load( $installDir . '/config.xml' );
        
        $alwaysbuild = $configXml->createElement( 'alwaysbuild' );
        
        $xpath         = new DOMXPath( $configXml );
        $modifications = $xpath->query( 
            sprintf( 
                '/cruisecontrol/project[@name="%s"]/modificationset', $projectName
            )
        )->item( 0 );
        $modifications->appendChild( $alwaysbuild );
        
        $configXml->formatOutput = true;
        $configXml->save( $installDir . '/config.xml' );
        
        $out->writeLine();
    }
}
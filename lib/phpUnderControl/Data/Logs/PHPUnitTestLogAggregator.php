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
 * @category   QualityAssurance
 * @package    Data
 * @subpackage Logs
 * @author     Manuel Pichler <mapi@manuel-pichler.de>
 * @copyright  2007-2010 Manuel Pichler. All rights reserved.
 * @license    http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @version    SVN: $Id$
 * @link       http://www.phpundercontrol.org/
 */

/**
 * Aggregates multiple PHPUnit test log files. 
 *
 * @category   QualityAssurance
 * @package    Data
 * @subpackage Logs
 * @author     Manuel Pichler <mapi@manuel-pichler.de>
 * @copyright  2007-2010 Manuel Pichler. All rights reserved.
 * @license    http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @version    Release: 0.6.1beta1
 * @link       http://www.phpundercontrol.org/
 */
class phpucPHPUnitTestLogAggregator extends phpucAbstractLogAggregator
{
    /**
     * Identifier for the current build log file.
     *
     * @var string
     */
    protected $currentBuild = null;
    
    /**
     * Array with created test suite elements.
     *
     * @var array(string=>DOMElement)
     */
    protected $testSuites = array();
    
    /**
     * Array with created test case aggregate suite elements.
     *
     * @var array(string=>DOMElement)
     */
    protected $mergeSuites = array();
    
    /**
     * The number of detected test errors.
     *
     * @var integer
     */
    private $testErrorCount = -1;
    
    /**
     * The number of detected test failures.
     *
     * @var integer
     */
    private $testFailureCount = -1;
    
    /**
     * Aggregates the results of all log files in the given iterator.
     *
     * @param Iterator $files List of coverage log files.
     * 
     * @return void
     */
    public function aggregate( Iterator $files )
    {
        // Create a new empty log
        $this->log = $this->createLog();
        
        // List of all broken builds
        $brokenBuilds = array();
        
        foreach ( $files as $build => $file )
        {
            if ( !file_exists( $file ) )
            {
                // Store broken build identifier.
                $brokenBuilds[] = $build;
                
                continue;
            }
            
            $log = new DOMDocument( '1.0', 'UTF-8' );
            
            $log->preserveWhiteSpace = false;
            $log->formatOutput       = true;
            
            // Load log file and validate
            if ( !$log->load( $file ) || !$this->isValidTestLog( $log ) )
            {
                // Store broken build identifier.
                $brokenBuilds[] = $build;
                
                // Skip broken logs
                continue;
            }
            
            $this->currentBuild = $build;
            
            $this->traverseTestSuites( 
                $log->documentElement, 
                $this->log->documentElement
            );
        }
        
        if ( count( $brokenBuilds ) > 0 )
        {
            $this->appendBrokenBuilds( $brokenBuilds );
        }
    }
    
    /**
     * Returns <b>true</b> when the generated test suite contains test errors.
     *
     * @return boolean
     */
    public function hasErrors()
    {
        if ( $this->testErrorCount === -1 && $this->log !== null )
        {
            $xpath = new DOMXPath( $this->log );
            
            $this->testErrorCount = 0;
            foreach ( $xpath->query( '//testsuite[@errors > 0]/@errors' ) as $node )
            {
                $this->testErrorCount += (integer) $node->nodeValue;
            }
        }
        return ( $this->testErrorCount > 0 );
    }
    
    /**
     * Returns <b>true</b> when the generated test suite contains test failures.
     *
     * @return boolean
     */
    public function hasFailures()
    {
        if ( $this->testFailureCount === -1 && $this->log !== null )
        {
            $xpath = new DOMXPath( $this->log );
            
            $this->testFailureCount = 0;
            foreach ( $xpath->query( '//testsuite[@failures > 0]/@failures' ) as $node )
            {
                $this->testFailureCount += (integer) $node->nodeValue;
            }
        }
        return ( $this->testFailureCount > 0 );
    }
    
    /**
     * Traverses one level of testsuite elements and adds the required contents
     * to the given <b>$target</b> element. 
     *
     * @param DOMElement $source The input testsuite element.
     * @param DOMElement $target The output testsuite element.
     * 
     * @return void
     */
    protected function traverseTestSuites( DOMElement $source, DOMElement $target )
    {
        foreach ( $source->childNodes as $node )
        {
            if ( $node->nodeType !== XML_ELEMENT_NODE )
            {
                continue;
            }
            else if ( $node->nodeName === 'testsuite' )
            {
                $name = $node->getAttribute( 'name' );

                if ( !isset( $this->testSuites[$name] ) )
                {
                    $this->testSuites[$name] = $this->copyTestSuite( $node, $target );
                }
                else
                {
                    $this->updateTestSuite( $this->testSuites[$name], $node );
                }
                
                if ( strpos( $name, '::' ) === false )
                {
                    $this->traverseTestSuites( $node, $this->testSuites[$name] );
                }
                else
                {
                    $this->appendTestCase( $this->testSuites[$name], $node );
                }
            }
            else if ( $node->nodeName === 'testcase' )
            {
                $name = sprintf(
                    '%s::%s',
                    $node->getAttribute( 'class' ),
                    $node->getAttribute( 'name' )
                );
                
                if ( !isset( $this->mergeSuites[$name] ) )
                {
                    $this->mergeSuites[$name] = $this->createTestCase( $name, $target );
                }
                
                $this->updateTestCase( $this->mergeSuites[$name], $node );
                $this->appendTestCase( $this->mergeSuites[$name], $node );
            }
        }
    }
    
    /**
     * Copies a test suite element.
     *
     * @param DOMElement $contextSuite The context test suite to copy.
     * @param DOMElement $parentSuite  The parent test suite element.
     * 
     * @return $parentSuite
     */
    protected function copyTestSuite( DOMElement $contextSuite, DOMElement $parentSuite )
    {
        $suite = $this->log->createElement( 'testsuite' );
        foreach ( $contextSuite->attributes as $attribute )
        {
            $suite->setAttribute( $attribute->nodeName, $attribute->nodeValue );
        }
        $parentSuite->appendChild( $suite );
        
        return $suite;
    }
    
    /**
     * Updates some attributes in <b>$contextSuite</b> with the attribute values
     * in <b>$inputSuite</b>.
     *
     * @param DOMElement $contextSuite The context suite to update.
     * @param DOMElement $inputSuite   The test suite with additional values.
     * 
     * @return void
     */
    protected function updateTestSuite( DOMElement $contextSuite, DOMElement $inputSuite )
    {
        $contextSuite->setAttribute(
            'tests',
            (integer) $contextSuite->getAttribute( 'tests' ) +
            (integer) $inputSuite->getAttribute( 'tests' )
        );
        $contextSuite->setAttribute(
            'failures',
            (integer) $contextSuite->getAttribute( 'failures' ) +
            (integer) $inputSuite->getAttribute( 'failures' )
        );
        $contextSuite->setAttribute(
            'errors',
            (integer) $contextSuite->getAttribute( 'errors' ) +
            (integer) $inputSuite->getAttribute( 'errors' )
        );
        $contextSuite->setAttribute(
            'time',
            (float) $contextSuite->getAttribute( 'time' ) +
            (float) $inputSuite->getAttribute( 'time' )
        ); 
    }
    
    /**
     * Creates a new test case - test suite container.
     *
     * @param string     $name        The name of the new test case/suite.
     * @param DOMElement $parentSuite The parent test suite element.
     * 
     * @return DOMElement
     */
    protected function createTestCase( $name, DOMElement $parentSuite )
    {
        $suite = $this->log->createElement( 'testsuite' );
        $suite->setAttribute( 'name', $name );
        $suite->setAttribute( 'time', '0.0' );
        $suite->setAttribute( 'tests', '0' );
        $suite->setAttribute( 'errors', '0' );
        $suite->setAttribute( 'failures', '0' );
        
        $parentSuite->appendChild( $suite );

        return $suite;
    }
    
    /**
     * Updates a set of attributes in <b>$contextTest</b> with values of the
     * given <b>$inputTest</b>.
     *
     * @param DOMElement $contextTest The context test case/suite element.
     * @param DOMElement $inputTest   The input test case element.
     * 
     * @return void
     */
    protected function updateTestCase(DOMElement $contextTest, DOMElement $inputTest)
    {
        $contextTest->setAttribute(
            'tests', 1 + (integer) $contextTest->getAttribute( 'tests' )
        );
        $contextTest->setAttribute(
            'errors',
            (integer) $contextTest->getAttribute( 'errors' ) +
            $inputTest->getElementsByTagName( 'error' )->length
        );
        $contextTest->setAttribute(
            'failures',
            (integer) $contextTest->getAttribute( 'failures' ) +
            $inputTest->getElementsByTagName( 'failure' )->length
        );
        $contextTest->setAttribute(
            'time',
            (float) $contextTest->getAttribute( 'time' ) +
            (float) $inputTest->getAttribute( 'time' )
        );
    }
    
    /**
     * Appends the given <b>$inputTest</b> to the <b>$contextSuite</b> element.
     *
     * @param DOMElement $contextSuite The context test suite.
     * @param DOMElement $inputTest    The input test case.
     * 
     * @return void
     */
    protected function appendTestCase( DOMElement $contextSuite, DOMElement $inputTest )
    {
        $test = $this->log->importNode( $inputTest, true );
        $test->setAttribute( 'build', $this->currentBuild );
                    
        $contextSuite->appendChild( $test );
    }
    
    /**
     * Appends all broken builds to th log file.
     *
     * @param array(string) $brokenBuilds The broken link identifiers.
     * 
     * @return void
     */
    protected function appendBrokenBuilds( array $brokenBuilds )
    {
        // Create an xpath instance for the context log
        $xpath = new DOMXPath( $this->log );
        
        // First collect all test cases and append broken build test cases
        $query = sprintf( '//testcase[@build="%s"]', $this->currentBuild );
        foreach ( $xpath->query( $query ) as $node )
        {
            foreach ( $brokenBuilds as $build )
            {
                $this->createErrorTestCase( $node, $node->parentNode, $build );
                $this->increment( $node->parentNode, 1 );
            }
        }
        
        // Collect all test suites with unexecuted test cases
        $query = sprintf( '//testsuite[@build="%s"]', $this->currentBuild );
        foreach ( $xpath->query( $query ) as $node )
        {
            foreach ( $brokenBuilds as $build )
            {
                $tests = $node->getElementsByTagName( 'testcase' );
                $suite = $node->parentNode->appendChild(
                    $node->cloneNode( false )
                );
                $suite->setAttribute( 'tests', $tests->length );
                $suite->setAttribute( 'errors', $tests->length );
                $suite->setAttribute( 'failures', '0' );
                $suite->setAttribute( 'time', '0.000000' );
                $suite->setAttribute( 'build', $build );
                
                foreach ( $tests as $test )
                {
                    $this->createErrorTestCase( $test, $suite );
                }
                
                $this->increment( $node->parentNode, $tests->length );
            }
        }
    }
    
    /**
     * Creates a failed test case
     *
     * @param DOMElement $node       The context node.
     * @param DOMElement $parentNode The parent test suite.
     * @param string     $build      An optional build identifier.
     * 
     * @return void
     */
    protected function createErrorTestCase( $node, $parentNode, $build = null )
    {
        $error = $this->log->createElement( 'error' );
        $error->setAttribute( 'type', 'PHPUnit_Framework_Error' );
        $error->appendChild(
            $this->log->createCDATASection(
                sprintf( 
                    "%s(%s)\nWas never executed.\n", 
                    $node->getAttribute( 'name' ),
                    $node->getAttribute( 'class' )
                )
            )
        );
                
        $test = $node->cloneNode( false );
        $test->setAttribute( 'time', '0.000000' );
        $test->appendChild( $error );
        
        if ( $build !== null )
        {
            $test->setAttribute( 'build', $build );
        }
                
        $parentNode->appendChild( $test );
    }
    
    /**
     * Increments the error and test count up the tree
     *
     * @param DOMElement $node  The context element
     * @param integer    $count Number to increment.
     * 
     * @return void
     */
    protected function increment( $node, $count )
    {
        while ( $node->nodeName === 'testsuite' )
        {
            $node->setAttribute(
                'tests', $count + (int) $node->getAttribute( 'tests' )
            );
            $node->setAttribute(
                'errors', $count + (int) $node->getAttribute( 'errors' )
            );
            $node = $node->parentNode;
        }
    }
    
    
    /**
     * Checks that the given <b>$log</b> fills the minimum xml log requirements.
     *
     * @param DOMDocument $log The log file instance to check.
     * 
     * @return boolean
     */
    protected function isValidTestLog( DOMDocument $log )
    {
        if ( $log->documentElement === null )
        {
            return false;
        }
        return ( $log->documentElement->nodeName === 'testsuites' );
    }
    
    /**
     * Creates a new empty log instance.
     *
     * @return DOMDocument
     */
    protected function createLog()
    {
        $log               = new DOMDocument( '1.0', 'UTF-8' );
        $log->formatOutput = true;
        
        $log->appendChild( $log->createElement( 'testsuites' ) );
        
        return $log;
    }
}
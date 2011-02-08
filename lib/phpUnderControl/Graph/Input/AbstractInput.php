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
 * @category   QualityAssurance
 * @package    Graph
 * @subpackage Input
 * @author     Manuel Pichler <mapi@phpundercontrol.org>
 * @copyright  2007-2010 Manuel Pichler. All rights reserved.
 * @license    http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @version    SVN: $Id$
 * @link       http://www.phpundercontrol.org/
 */

/**
 * Abstract base class for graph input data.
 *
 * This class provides the main xpath and data extraction logic for conrete
 * implementations. This means an extending class must only define the xpath
 * rules and the required chart type.
 *
 * <code>
 * class MyChartInput extends phpucAbstractInput
 * {
 *     public function __construct()
 *     {
 *         parent::__construct(
 *             'Coding Violations',
 *             '06-coding-violations',
 *             phpucChartI::TYPE_LINE
 *         );
 *
 *         $this->addRule(
 *             new phpucInputRule(
 *                 'PHP CodeSniffer',
 *                 '/cruisecontrol/checkstyle/file/error',
 *                 self::MODE_COUNT
 *             )
 *         );
 *     }
 * }
 * </code>
 *
 * @category   QualityAssurance
 * @package    Graph
 * @subpackage Input
 * @author     Manuel Pichler <mapi@phpundercontrol.org>
 * @copyright  2007-2010 Manuel Pichler. All rights reserved.
 * @license    http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @version    Release: 0.6.1beta1
 * @link       http://www.phpundercontrol.org/
 *
 * @property-read string               $title      The human readable data title.
 * @property-read integer              $type       The output chart type.
 * @property-read array(string=>mixed) $data       The extracted log file data.
 * @property-read string               $yAxisLabel An optional label for the y-axis.
 * @property-read string               $xAxisLabel An optional label for the x-axis.
 * @property-read array(string=>int)   $graphDims  The Graph-Dimensions
 */
abstract class phpucAbstractInput implements phpucInputI
{
    /**
     * The human readable input type title.
     *
     * @var string
     */
    protected $title = null;

    /**
     * An optional label for the y-axis.
     *
     * @var string
     */
    protected $yAxisLabel = '';

    /**
     * An optional label for the x-axis.
     *
     * @var string
     */
    protected $xAxisLabel = '';

    /**
     * Dimensions of Graph to export
     *
     * @var array(string=>int)
     */
    protected $graphDims = array();

    /**
     * The output image file name.
     *
     * @var string
     */
    private $fileName = null;

    /**
     * The output chart type.
     *
     * @var integer
     */
    private $type = null;

    /**
     * The extracted log file data.
     *
     * @var array(string=>array)
     */
    private $data = array();

    /**
     * List of input rules.
     *
     * @var array(phpucInputRule)
     */
    private $rules = array();
    
    /**
     * Constructs a new input type implementation.
     *
     * @param string  $title    The human readable input type title.
     * @param string  $fileName The output image file name.
     * @param integer $type     The output chart type.
     *
     * @throws InvalidArgumentException If the given type is unknown.
     */
    public function __construct( $title, $fileName, $type )
    {
        $this->title    = $title;
        $this->fileName = $fileName;
        $this->graphDims= array('width'  => 390,
                                'height' => 250,);

        $expected = array(
            phpucChartI::TYPE_PIE,
            phpucChartI::TYPE_LINE,
            phpucChartI::TYPE_DOT,
            phpucChartI::TYPE_TIME
        );

        if ( !in_array( $type, $expected ) )
        {
            throw new InvalidArgumentException( 'Invalid input type given.' );
        }
        $this->type = $type;
    }

    /**
     * Magic property getter method.
     *
     * @param string $name The property name.
     *
     * @return mixed
     * @throws OutOfRangeException If the requested property doesn't exist or
     *         is writonly.
     * @ignore
     */
    public function __get( $name )
    {
        switch ( $name )
        {
            case 'type':
            case 'title':
            case 'rawData':
            case 'fileName':
            case 'yAxisLabel':
            case 'xAxisLabel':
            case 'graphDims':
                return $this->$name;

            case 'data':
                return $this->postProcessLog( $this->data );

            default:
                throw new OutOfRangeException(
                    sprintf( 'Unknown or writonly property $%s.', $name )
                );
                break;
        }
    }

    /**
     * Magic property setter method.
     *
     * @param string $name  The property name.
     * @param mixed  $value The property value.
     *
     * @return void
     * @throws OutOfRangeException If the requested property doesn't exist or
     *         is readonly.
     * @throws InvalidArgumentException If the given value has an unexpected
     *         format or an invalid data type.
     * @ignore
     */
    public function __set( $name, $value )
    {
        throw new OutOfRangeException(
            sprintf( 'Unknown or readonly property $%s.', $name )
        );
    }

    /**
     * Evaluates all defined xpath rules against the given DOMXPath instance.
     *
     * @param DOMXPath $xpath The context dom xpath object.
     *
     * @return void
     */
    public function processLog( DOMXPath $xpath )
    {
        foreach ( $this->rules as $rule )
        {
            $label = $rule->label;
            if ( !isset( $this->data[$label] ) )
            {
                $this->data[$label] = array();
            }

            $nodeList = $xpath->query( $rule->xpath );

            switch ( $rule->mode )
            {
                case self::MODE_COUNT:
                    $this->data[$label][] = $this->processLogCount( $nodeList );
                    break;

                case self::MODE_SUM:
                    $this->data[$label][] = $this->processLogSum( $nodeList );
                    break;

                case self::MODE_VALUE:
                    $this->data[$label][] = $this->processLogValue( $nodeList );
                    break;

                case self::MODE_LIST:
                    $this->data[$label][] = implode( 
                        ';', $this->processLogList( $nodeList ) 
                    );
                    break;
            }
        }
    }

    /**
     * Calculates the sum of all node values.
     *
     * @param DOMNodeList $nodeList Fetched node list.
     *
     * @return integer
     */
    protected function processLogSum( DOMNodeList $nodeList )
    {
        $sum = 0;
        foreach ( $nodeList as $node )
        {
            $sum += (float) $node->nodeValue;
        }
        return $sum;
    }

    /**
     * Counts all nodes in the node list
     *
     * @param DOMNodeList $nodeList Fetched node list.
     *
     * @return integer
     */
    protected function processLogCount( DOMNodeList $nodeList )
    {
        return $nodeList->length;
    }

    /**
     * Creates a concated string with all node values.
     *
     * @param DOMNodeList $nodeList Fetched node list.
     *
     * @return string
     */
    protected function processLogValue( DOMNodeList $nodeList )
    {
        $value = '';
        foreach ( $nodeList as $node )
        {
            $value .= $node->nodeValue;
        }
        return $value;
    }

    /**
     * Creates a list of metric values
     *
     * @param DOMNodeList $nodeList Fetched node list.
     *
     * @return array
     */
    protected function processLogList( DOMNodeList $nodeList )
    {
        $logList = array();
        foreach ( $nodeList as $node )
        {
            $logList[] = $node->nodeValue;
        }
        return $logList;
    }

    /**
     * Post processes the fetched data.
     *
     * Concrete implementations can overwrite this this method to post process
     * the fetched data before it is given to the graph object. This can be very
     * usefull in all cases where logs don't have the required format.
     *
     * @param array(string=>array) $logs Fetched log data.
     *
     * @return array(string=>mixed)
     */
    protected function postProcessLog( array $logs )
    {
        return $logs;
    }

    /**
     * Adds a xpath rule to this input object.
     *
     * @param phpucInputRule $rule The rule instance
     *
     * @return void
     */
    protected function addRule( phpucInputRule $rule )
    {
        $this->rules[] = $rule;
    }
}

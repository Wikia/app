<?php
/**
 * This file is part of PHP_Depend.
 *
 * PHP Version 5
 *
 * Copyright (c) 2008-2010, Manuel Pichler <mapi@pdepend.org>.
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
 * @package    PHP_Depend
 * @subpackage Metrics
 * @author     Manuel Pichler <mapi@pdepend.org>
 * @copyright  2008-2010 Manuel Pichler. All rights reserved.
 * @license    http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @version    SVN: $Id$
 * @link       http://pdepend.org/
 */

require_once 'PHP/Depend/Code/ASTVisitorI.php';
require_once 'PHP/Depend/Metrics/AbstractAnalyzer.php';
require_once 'PHP/Depend/Metrics/AnalyzerI.php';
require_once 'PHP/Depend/Metrics/FilterAwareI.php';
require_once 'PHP/Depend/Metrics/NodeAwareI.php';
require_once 'PHP/Depend/Metrics/ProjectAwareI.php';

/**
 * This class calculates the Cyclomatic Complexity Number(CCN) for the project,
 * methods and functions.
 *
 * @category   QualityAssurance
 * @package    PHP_Depend
 * @subpackage Metrics
 * @author     Manuel Pichler <mapi@pdepend.org>
 * @copyright  2008-2010 Manuel Pichler. All rights reserved.
 * @license    http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @version    Release: 0.9.19
 * @link       http://pdepend.org/
 */
class PHP_Depend_Metrics_CyclomaticComplexity_Analyzer
       extends PHP_Depend_Metrics_AbstractAnalyzer
    implements PHP_Depend_Metrics_AnalyzerI,
               PHP_Depend_Metrics_FilterAwareI,
               PHP_Depend_Metrics_NodeAwareI,
               PHP_Depend_Metrics_ProjectAwareI,
               PHP_Depend_Code_ASTVisitorI
{
    /**
     * Type of this analyzer class.
     */
    const CLAZZ = __CLASS__;

    /**
     * Metrics provided by the analyzer implementation.
     */
    const M_CYCLOMATIC_COMPLEXITY_1 = 'ccn',
          M_CYCLOMATIC_COMPLEXITY_2 = 'ccn2';

    /**
     * Hash with all calculated node metrics.
     *
     * <code>
     * array(
     *     '0375e305-885a-4e91-8b5c-e25bda005438'  =>  array(
     *         'loc'    =>  42,
     *         'ncloc'  =>  17,
     *         'cc'     =>  12
     *     ),
     *     'e60c22f0-1a63-4c40-893e-ed3b35b84d0b'  =>  array(
     *         'loc'    =>  42,
     *         'ncloc'  =>  17,
     *         'cc'     =>  12
     *     )
     * )
     * </code>
     *
     * @var array(string=>array) $_nodeMetrics
     */
    private $_nodeMetrics = null;

    /**
     * The project Cyclomatic Complexity Number.
     *
     * @var integer $_ccn
     */
    private $_ccn = 0;

    /**
     * Extended Cyclomatic Complexity Number(CCN2) for the project.
     *
     * @var integer $_ccn2
     */
    private $_ccn2 = 0;

    /**
     * Processes all {@link PHP_Depend_Code_Package} code nodes.
     *
     * @param PHP_Depend_Code_NodeIterator $packages All code packages.
     *
     * @return void
     */
    public function analyze(PHP_Depend_Code_NodeIterator $packages)
    {
        if ($this->_nodeMetrics === null) {

            $this->fireStartAnalyzer();

            // Init node metrics
            $this->_nodeMetrics = array();

            // Visit all packages
            foreach ($packages as $package) {
                $package->accept($this);
            }

            $this->fireEndAnalyzer();
        }
    }

    /**
     * Returns the cyclomatic complexity for the given <b>$node</b> instance.
     *
     * @param PHP_Depend_Code_NodeI $node The context node instance.
     *
     * @return integer
     */
    public function getCCN(PHP_Depend_Code_NodeI $node)
    {
        $metrics = $this->getNodeMetrics($node);
        if (isset($metrics[self::M_CYCLOMATIC_COMPLEXITY_1])) {
            return $metrics[self::M_CYCLOMATIC_COMPLEXITY_1];
        }
        return 0;
    }

    /**
     * Returns the extended cyclomatic complexity for the given <b>$node</b>
     * instance.
     *
     * @param PHP_Depend_Code_NodeI $node The context node instance.
     *
     * @return integer
     */
    public function getCCN2(PHP_Depend_Code_NodeI $node)
    {
        $metrics = $this->getNodeMetrics($node);
        if (isset($metrics[self::M_CYCLOMATIC_COMPLEXITY_2])) {
            return $metrics[self::M_CYCLOMATIC_COMPLEXITY_2];
        }
        return 0;
    }

    /**
     * This method will return an <b>array</b> with all generated metric values
     * for the given <b>$node</b>. If there are no metrics for the requested
     * node, this method will return an empty <b>array</b>.
     *
     * @param PHP_Depend_Code_NodeI $node The context node instance.
     *
     * @return array(string=>mixed)
     */
    public function getNodeMetrics(PHP_Depend_Code_NodeI $node)
    {
        $metrics = array();
        if (isset($this->_nodeMetrics[$node->getUUID()])) {
            $metrics = $this->_nodeMetrics[$node->getUUID()];
        }
        return $metrics;
    }

    /**
     * Provides the project summary metrics as an <b>array</b>.
     *
     * @return array(string=>mixed)
     */
    public function getProjectMetrics()
    {
        return array(
            self::M_CYCLOMATIC_COMPLEXITY_1  =>  $this->_ccn,
            self::M_CYCLOMATIC_COMPLEXITY_2  =>  $this->_ccn2
        );
    }

    /**
     * Visits a function node.
     *
     * @param PHP_Depend_Code_Function $function The current function node.
     *
     * @return void
     * @see PHP_Depend_VisitorI::visitFunction()
     */
    public function visitFunction(PHP_Depend_Code_Function $function)
    {
        $this->fireStartFunction($function);
        $this->calculateComplexity($function);
        $this->fireEndFunction($function);
    }

    /**
     * Visits a code interface object.
     *
     * @param PHP_Depend_Code_Interface $interface The context code interface.
     *
     * @return void
     * @see PHP_Depend_VisitorI::visitInterface()
     */
    public function visitInterface(PHP_Depend_Code_Interface $interface)
    {
        // Empty visit method, we don't want interface metrics
    }

    /**
     * Visits a method node.
     *
     * @param PHP_Depend_Code_Class $method The method class node.
     *
     * @return void
     * @see PHP_Depend_VisitorI::visitMethod()
     */
    public function visitMethod(PHP_Depend_Code_Method $method)
    {
        $this->fireStartMethod($method);
        $this->calculateComplexity($method);
        $this->fireEndMethod($method);
    }

    /**
     * Visits methods, functions or closures and calculated their complexity.
     *
     * @param PHP_Depend_Code_AbstractCallable $callable The visited callable.
     *
     * @return void
     * @since 0.9.8
     */
    public function calculateComplexity(PHP_Depend_Code_AbstractCallable $callable)
    {
        $data = array(
            self::M_CYCLOMATIC_COMPLEXITY_1 => 1,
            self::M_CYCLOMATIC_COMPLEXITY_2 => 1
        );
        
        foreach ($callable->getChildren() as $child) {
            $data = $child->accept($this, $data);
        }

        $this->_storeNodeComplexityAndUpdateProject($callable->getUUID(), $data);
    }

    /**
     * Stores the complexity of a node and updates the corresponding project
     * values.
     *
     * @param string                 $id         Identifier of the analyzed item.
     * @param array(string=>integer) $complexity The node complexity values.
     *
     * @return void
     * @since 0.9.8
     */
    private function _storeNodeComplexityAndUpdateProject($id, array $complexity)
    {
        $this->_nodeMetrics[$id] = $complexity;

        $this->_ccn  += $complexity[self::M_CYCLOMATIC_COMPLEXITY_1];
        $this->_ccn2 += $complexity[self::M_CYCLOMATIC_COMPLEXITY_2];
    }

    /**
     * Magic call method used to provide simplified visitor implementations.
     * With this method we can call <b>visit${NodeClassName}</b> on each node.
     *
     * @param string $method Name of the called method.
     * @param array  $args   Array with method argument.
     *
     * @return mixed
     * @since 0.9.12
     */
    public function __call($method, $args)
    {
        $value = $args[1];
        foreach ($args[0]->getChildren() as $child) {
            $value = $child->accept($this, $value);
        }
        return $value;
    }

    /**
     * Visits a boolean AND-expression.
     *
     * @param PHP_Depend_Code_ASTNodeI $node The currently visited node.
     * @param array(string=>integer)   $data The previously calculated ccn values.
     *
     * @return array(string=>integer)
     * @since 0.9.8
     */
    public function visitBooleanAndExpression($node, $data)
    {
        ++$data[self::M_CYCLOMATIC_COMPLEXITY_2];
        return $this->visit($node, $data);
    }

    /**
     * Visits a boolean OR-expression.
     *
     * @param PHP_Depend_Code_ASTNodeI $node The currently visited node.
     * @param array(string=>integer)   $data The previously calculated ccn values.
     *
     * @return array(string=>integer)
     * @since 0.9.8
     */
    public function visitBooleanOrExpression($node, $data)
    {
        ++$data[self::M_CYCLOMATIC_COMPLEXITY_2];
        return $this->visit($node, $data);
    }

    /**
     * Visits a switch label.
     *
     * @param PHP_Depend_Code_ASTNodeI $node The currently visited node.
     * @param array(string=>integer)   $data The previously calculated ccn values.
     *
     * @return array(string=>integer)
     * @since 0.9.8
     */
    public function visitSwitchLabel($node, $data)
    {
        if (!$node->isDefault()) {
            ++$data[self::M_CYCLOMATIC_COMPLEXITY_1];
            ++$data[self::M_CYCLOMATIC_COMPLEXITY_2];
        }
        return $this->visit($node, $data);
    }

    /**
     * Visits a catch statement.
     *
     * @param PHP_Depend_Code_ASTNodeI $node The currently visited node.
     * @param array(string=>integer)   $data The previously calculated ccn values.
     *
     * @return array(string=>integer)
     * @since 0.9.8
     */
    public function visitCatchStatement($node, $data)
    {
        ++$data[self::M_CYCLOMATIC_COMPLEXITY_1];
        ++$data[self::M_CYCLOMATIC_COMPLEXITY_2];

        return $this->visit($node, $data);
    }

    /**
     * Visits an elseif statement.
     *
     * @param PHP_Depend_Code_ASTNodeI $node The currently visited node.
     * @param array(string=>integer)   $data The previously calculated ccn values.
     *
     * @return array(string=>integer)
     * @since 0.9.8
     */
    public function visitElseIfStatement($node, $data)
    {
        ++$data[self::M_CYCLOMATIC_COMPLEXITY_1];
        ++$data[self::M_CYCLOMATIC_COMPLEXITY_2];

        return $this->visit($node, $data);
    }

    /**
     * Visits a for statement.
     *
     * @param PHP_Depend_Code_ASTNodeI $node The currently visited node.
     * @param array(string=>integer)   $data The previously calculated ccn values.
     *
     * @return array(string=>integer)
     * @since 0.9.8
     */
    public function visitForStatement($node, $data)
    {
        ++$data[self::M_CYCLOMATIC_COMPLEXITY_1];
        ++$data[self::M_CYCLOMATIC_COMPLEXITY_2];

        return $this->visit($node, $data);
    }

    /**
     * Visits a foreach statement.
     *
     * @param PHP_Depend_Code_ASTNodeI $node The currently visited node.
     * @param array(string=>integer)   $data The previously calculated ccn values.
     *
     * @return array(string=>integer)
     * @since 0.9.8
     */
    public function visitForeachStatement($node, $data)
    {
        ++$data[self::M_CYCLOMATIC_COMPLEXITY_1];
        ++$data[self::M_CYCLOMATIC_COMPLEXITY_2];

        return $this->visit($node, $data);
    }

    /**
     * Visits an if statement.
     *
     * @param PHP_Depend_Code_ASTNodeI $node The currently visited node.
     * @param array(string=>integer)   $data The previously calculated ccn values.
     *
     * @return array(string=>integer)
     * @since 0.9.8
     */
    public function visitIfStatement($node, $data)
    {
        ++$data[self::M_CYCLOMATIC_COMPLEXITY_1];
        ++$data[self::M_CYCLOMATIC_COMPLEXITY_2];

        return $this->visit($node, $data);
    }

    /**
     * Visits a logical AND expression.
     *
     * @param PHP_Depend_Code_ASTNodeI $node The currently visited node.
     * @param array(string=>integer)   $data The previously calculated ccn values.
     *
     * @return array(string=>integer)
     * @since 0.9.8
     */
    public function visitLogicalAndExpression($node, $data)
    {
        ++$data[self::M_CYCLOMATIC_COMPLEXITY_2];
        return $this->visit($node, $data);
    }

    /**
     * Visits a logical OR expression.
     *
     * @param PHP_Depend_Code_ASTNodeI $node The currently visited node.
     * @param array(string=>integer)   $data The previously calculated ccn values.
     *
     * @return array(string=>integer)
     * @since 0.9.8
     */
    public function visitLogicalOrExpression($node, $data)
    {
        ++$data[self::M_CYCLOMATIC_COMPLEXITY_2];
        return $this->visit($node, $data);
    }

    /**
     * Visits a ternary operator.
     *
     * @param PHP_Depend_Code_ASTNodeI $node The currently visited node.
     * @param array(string=>integer)   $data The previously calculated ccn values.
     *
     * @return array(string=>integer)
     * @since 0.9.8
     */
    public function visitConditionalExpression($node, $data)
    {
        ++$data[self::M_CYCLOMATIC_COMPLEXITY_1];
        ++$data[self::M_CYCLOMATIC_COMPLEXITY_2];

        return $this->visit($node, $data);
    }

    /**
     * Visits a while-statement.
     *
     * @param PHP_Depend_Code_ASTNodeI $node The currently visited node.
     * @param array(string=>integer)   $data The previously calculated ccn values.
     *
     * @return array(string=>integer)
     * @since 0.9.8
     */
    public function visitWhileStatement($node, $data)
    {
        ++$data[self::M_CYCLOMATIC_COMPLEXITY_1];
        ++$data[self::M_CYCLOMATIC_COMPLEXITY_2];

        return $this->visit($node, $data);
    }

    /**
     * Visits a do/while-statement.
     *
     * @param PHP_Depend_Code_ASTNodeI $node The currently visited node.
     * @param array(string=>integer)   $data The previously calculated ccn values.
     *
     * @return array(string=>integer)
     * @since 0.9.12
     */
    public function visitDoWhileStatement($node, $data)
    {
        ++$data[self::M_CYCLOMATIC_COMPLEXITY_1];
        ++$data[self::M_CYCLOMATIC_COMPLEXITY_2];

        return $this->visit($node, $data);
    }
}
<?php
/**
 * This file is part of PHP_PMD.
 *
 * PHP Version 5
 *
 * Copyright (c) 2009-2010, Manuel Pichler <mapi@phpmd.org>.
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
 * @category   PHP
 * @package    PHP_PMD
 * @subpackage Node
 * @author     Manuel Pichler <mapi@phpmd.org>
 * @copyright  2009-2010 Manuel Pichler. All rights reserved.
 * @license    http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @version    SVN: $Id$
 * @link       http://phpmd.org
 */

require_once 'PHP/PMD/Node/Annotation.php';

/**
 * Collection of code annotations.
 *
 * @category   PHP
 * @package    PHP_PMD
 * @subpackage Node
 * @author     Manuel Pichler <mapi@phpmd.org>
 * @copyright  2009-2010 Manuel Pichler. All rights reserved.
 * @license    http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @version    Release: 0.2.7
 * @link       http://phpmd.org
 */
class PHP_PMD_Node_Annotations
{
    /**
     * Detected annotations.
     *
     * @var array(PHP_PMD_Node_Annotation)
     */
    private $_annotations = array();

    /**
     * Regexp used to extract code annotations.
     *
     * @var string
     */
    private $_regexp = '(@([a-z_][a-z0-9_]+)\(([^\)]+)\))i';

    /**
     * Constructs a new collection instance.
     *
     * @param PHP_PMD_AbstractNode $node The context/parent node.
     */
    public function __construct(PHP_PMD_AbstractNode $node)
    {
        preg_match_all($this->_regexp, $node->getDocComment(), $matches);
        foreach (array_keys($matches[0]) as $i) {
            $name  = $matches[1][$i];
            $value = trim($matches[2][$i], '" ');

            $this->_annotations[] = new PHP_PMD_Node_Annotation($name, $value);
        }
    }
    
    /**
     * Checks if one of the annotations suppresses the given rule.
     *
     * @param PHP_PMD_AbstractRule $rule The rule to check.
     *
     * @return boolean
     */
    public function suppresses(PHP_PMD_AbstractRule $rule)
    {
        foreach ($this->_annotations as $annotation) {
            if ($annotation->suppresses($rule)) {
                return true;
            }
        }
        return false;
    }
}
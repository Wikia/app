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
 * @category   PHP
 * @package    PHP_Depend
 * @subpackage Code
 * @author     Manuel Pichler <mapi@pdepend.org>
 * @copyright  2008-2010 Manuel Pichler. All rights reserved.
 * @license    http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @version    SVN: $Id$
 * @link       http://www.pdepend.org/
 * @since      0.9.15
 */

require_once 'PHP/Depend/Code/ASTUnaryExpression.php';

/**
 * This class represents a cast-expression node.
 *
 * <code>
 * //     ----------
 * $foo = (int) $bar;
 * //     ----------
 *
 * //     -----------
 * $foo = (bool) $bar;
 * //     -----------
 *
 * //     ------------
 * $foo = (array) $bar;
 * //     ------------
 *
 * //     ------------
 * $foo = (unset) $bar;
 * //     ------------
 *
 * //     -------------
 * $foo = (double) $bar;
 * //     -------------
 *
 * //     -------------
 * $foo = (string) $bar;
 * //     -------------
 *
 * //     -------------
 * $foo = (object) $bar;
 * //     -------------
 * </code>
 *
 * @category   PHP
 * @package    PHP_Depend
 * @subpackage Code
 * @author     Manuel Pichler <mapi@pdepend.org>
 * @copyright  2008-2010 Manuel Pichler. All rights reserved.
 * @license    http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @version    Release: 0.9.19
 * @link       http://www.pdepend.org/
 * @since      0.9.15
 */
class PHP_Depend_Code_ASTCastExpression extends PHP_Depend_Code_ASTUnaryExpression
{
    /**
     * Type of this node class.
     */
    const CLAZZ = __CLASS__;

    /**
     * Constructs a new cast-expression node.
     *
     * @param string $image The original cast image.
     */
    public function __construct($image)
    {
        parent::__construct(preg_replace('(\s+)', '', strtolower($image)));
    }

    /**
     * Returns <b>true</b> when this node represents an array cast-expression.
     *
     * @return boolean
     */
    public function isArray()
    {
        return ($this->image === '(array)');
    }

    /**
     * Returns <b>true</b> when this node represents an object cast-expression.
     *
     * @return boolean
     */
    public function isObject()
    {
        return ($this->image === '(object)');
    }

    /**
     * Returns <b>true</b> when this node represents a boolean cast-expression.
     *
     * @return boolean
     */
    public function isBoolean()
    {
        return ($this->image === '(bool)' || $this->image === '(boolean)');
    }

    /**
     * Returns <b>true</b> when this node represents an integer cast-expression.
     *
     * @return boolean
     */
    public function isInteger()
    {
        return ($this->image === '(int)' || $this->image === '(integer)');
    }

    /**
     * Returns <b>true</b> when this node represents a float cast-expression.
     *
     * @return boolean
     */
    public function isFloat()
    {
        return ($this->image === '(real)'
            || $this->image === '(float)'
            || $this->image === '(double)'
        );
    }

    /**
     * Returns <b>true</b> when this node represents a string cast-expression.
     *
     * @return boolean
     */
    public function isString()
    {
        return (strcmp('(string)', $this->image) === 0);
    }

    /**
     * Returns <b>true</b> when this node represents an unset cast-expression.
     *
     * @return boolean
     */
    public function isUnset()
    {
        return ($this->image === '(unset)');
    }

    /**
     * Accept method of the visitor design pattern. This method will be called
     * by a visitor during tree traversal.
     *
     * @param PHP_Depend_Code_ASTVisitorI $visitor The calling visitor instance.
     * @param mixed                       $data    Optional previous calculated data.
     *
     * @return mixed
     */
    public function accept(PHP_Depend_Code_ASTVisitorI $visitor, $data = null)
    {
        return $visitor->visitCastExpression($this, $data);
    }
}
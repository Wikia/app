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
 * @since      0.9.5
 */

/**
 * This class encapsultes possible default values for function and method
 * parameters of class properties. We use a separate class because otherwise it
 * you can not differenciate between no default value and a scalar <b>null</b>.
 *
 * @category   PHP
 * @package    PHP_Depend
 * @subpackage Code
 * @author     Manuel Pichler <mapi@pdepend.org>
 * @copyright  2008-2010 Manuel Pichler. All rights reserved.
 * @license    http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @version    Release: 0.9.19
 * @link       http://www.pdepend.org/
 * @since      0.9.5
 */
class PHP_Depend_Code_Value
{
    /**
     * Boolean flag that is <b>true</b> when a PHP-value was set.
     *
     * @var boolean $_valueAvailable
     */
    private $_valueAvailable = false;

    /**
     * The parsed PHP-value,
     *
     * @var mixed $_value
     */
    private $_value = null;

    /**
     * This method will return the parsed PHP value.
     *
     * @return mixed
     */
    public function getValue()
    {
        return $this->_value;
    }

    /**
     * This method will set the parsed PHP-value. Please note that this method
     * acts as a one-way-function, only the first call with set the value all
     * following calls will be ignored.
     *
     * @param mixed $value The parsed PHP-value.
     *
     * @return void
     */
    public function setValue($value)
    {
        if ($this->_valueAvailable === false) {
            $this->_value          = $value;
            $this->_valueAvailable = true;
        }
    }

    /**
     * This method will return <b>true</b> when the PHP-value is already set.
     *
     * @return boolean
     */
    public function isValueAvailable()
    {
        return $this->_valueAvailable;
    }
}
?>

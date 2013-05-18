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
 * @subpackage Parser
 * @author     Manuel Pichler <mapi@pdepend.org>
 * @copyright  2008-2010 Manuel Pichler. All rights reserved.
 * @license    http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @version    SVN: $Id$
 * @link       http://www.pdepend.org/
 * @since      0.9.6
 */

/**
 * This class provides a scoped collection for {@PHP_Depend_Token} objects.
 *
 * @category   PHP
 * @package    PHP_Depend
 * @subpackage Parser
 * @author     Manuel Pichler <mapi@pdepend.org>
 * @copyright  2008-2010 Manuel Pichler. All rights reserved.
 * @license    http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @version    Release: 0.9.19
 * @link       http://www.pdepend.org/
 * @since      0.9.6
 */
class PHP_Depend_Parser_TokenStack
{
    /**
     * The actual token scope.
     *
     * @var array(PHP_Depend_Token) $_tokens
     */
    private $_tokens = array();

    /**
     * Stack with token scopes.
     *
     * @var array(array) $_stack
     */
    private $_stack = array();

    /**
     * The current stack offset.
     *
     * @var integer
     */
    private $_offset = 0;

    /**
     * This method will push a new token scope onto the stack,
     *
     * @return void
     */
    public function push()
    {
        $this->_stack[$this->_offset++] = $this->_tokens;
        $this->_tokens                  = array();
    }

    /**
     * This method will pop the top token scope from the stack and return an
     * array with all collected tokens. Additionally this method will add all
     * tokens of the removed scope onto the next token scope.
     *
     * @return array(PHP_Depend_Token)
     */
    public function pop()
    {
        $tokens        = $this->_tokens;
        $this->_tokens = $this->_stack[--$this->_offset];

        unset($this->_stack[$this->_offset]);

        foreach ($tokens as $token) {
            $this->_tokens[] = $token;
        }
        return $tokens;
    }

    /**
     * This method will add a new token to the currently active token scope.
     *
     * @param PHP_Depend_Token $token The token to add.
     *
     * @return PHP_Depend_Token
     */
    public function add(PHP_Depend_Token $token)
    {
        return ($this->_tokens[] = $token);
    }
}

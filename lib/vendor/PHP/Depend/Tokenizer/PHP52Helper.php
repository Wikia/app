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
 * @subpackage Tokenizer
 * @author     Manuel Pichler <mapi@pdepend.org>
 * @copyright  2008-2010 Manuel Pichler. All rights reserved.
 * @license    http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @version    SVN: $Id$
 * @link       http://www.pdepend.org/
 */

/**
 * Utility class that can be used to handle PHP's namespace separator in all
 * PHP environments lower than 5.3alpha3
 *
 * @category   PHP
 * @package    PHP_Depend
 * @subpackage Tokenizer
 * @author     Manuel Pichler <mapi@pdepend.org>
 * @copyright  2008-2010 Manuel Pichler. All rights reserved.
 * @license    http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @version    Release: 0.9.19
 * @link       http://www.pdepend.org/
 *
 * @todo Rename this class into PHP52Helper and make methods none static.
 */
final class PHP_Depend_Tokenizer_PHP52Helper
{
    /**
     * This method implements a workaround for all PHP versions lower 5.3alpha3
     * that do not handle the namespace separator char.
     *
     * @param string $source The raw source code.
     *
     * @return array The tokens.
     */
    public static function tokenize($source)
    {
        // Replace backslash with valid token
        $source = preg_replace(
            array('#\\\\([^"\'`\\\\])#i', '(<<<(\s*)(["\'])([\w\d]+)\2)'),
            array(':::\\1', '<<<\1\3'),
            $source
        );

        $tokens = self::_tokenize($source);

        $result = array();
        for ($i = 0, $c = count($tokens); $i < $c; ++$i) {
            if (is_string($tokens[$i])) {
                $result[] = str_replace(':::', '\\', $tokens[$i]);
            } else if ($tokens[$i][0] !== T_DOUBLE_COLON) {
                $tokens[$i][1] = str_replace(':::', '\\', $tokens[$i][1]);
                $result[]      = $tokens[$i];
            } else if (!isset($tokens[$i + 1]) || $tokens[$i + 1] !== ':') {
                $tokens[$i][1] = str_replace(':::', '\\', $tokens[$i][1]);
                $result[]      = $tokens[$i];
            } else {
                $result[] = '\\';
                ++$i;
            }
        }

        return $result;
    }

    /**
     * Executes the internal tokenizer function and decorates it with some
     * exception handling.
     *
     * @param string $source The raw php source code.
     *
     * @return array
     * @todo Exception should be moved into a general package.
     */
    private static function _tokenize($source)
    {
        ini_set('track_errors', 'on');
        $php_errormsg = null;

        $tokens = @token_get_all($source);

        if ($php_errormsg === null) {
            return $tokens;
        }
        throw new PHP_Depend_Parser_TokenException($php_errormsg);
    }
}

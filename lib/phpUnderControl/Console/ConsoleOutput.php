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
 * @package   Console
 * @author    Manuel Pichler <mapi@phpundercontrol.org>
 * @copyright 2007-2010 Manuel Pichler. All rights reserved.
 * @license   http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @version   SVN: $Id$
 * @link      http://www.phpundercontrol.org/
 */

/**
 * Utility class that handles the command line output.
 *
 * @category  QualityAssurance
 * @package   Console
 * @author    Manuel Pichler <mapi@phpundercontrol.org>
 * @copyright 2007-2010 Manuel Pichler. All rights reserved.
 * @license   http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @version   Release: 0.6.1beta1
 * @link      http://www.phpundercontrol.org/
 */
class phpucConsoleOutput
{
    /**
     * Holds the configured console output instance.
     *
     * @var phpucConsoleOutput
     */
    protected static $output = null;
    
    /**
     * Returns the configured console output instance or <b>null</b>
     *
     * @return phpucConsoleOutput
     */
    public static function get()
    {
        return self::$output;
    }
    
    /**
     * Sets the default console output instance.
     *
     * @param phpucConsoleOutput $output A console output implementation.
     * 
     * @return void
     */
    public static function set( phpucConsoleOutput $output )
    {
        self::$output = $output;
    }
    
    protected $index = 1;
    
    /**
     * Writes a single line and replaces all placeholders with given tokens. 
     * 
     * Beside the the <b>$line</b> parameter this method accepts a variable list
     * of scalar parameters that should replace placeholders in the <b>$line</b>
     * string. Please note that the placeholder index begins with 1 and not 0. 
     * 
     * <code>
     * $out = new phpucConsoleOutput();
     * $out->writeLine( '{1} is an instance of "{2}"', '$out', get_class( $out ) );
     * // Results in:
     * //   $out is an instance of "phpucConsoleOutput" 
     * </code>  
     *
     * @param string $text The primary output text.
     * 
     * @return void
     */
    public function writeLine( $text = '' )
    {
        $args = func_get_args();
        $this->writeLineArray( $text, $args );
    }
    
    /**
     * Writes an indexed list item and replaces all placeholders with given 
     * tokens. 
     * 
     * Beside the the <b>$line</b> parameter this method accepts a variable list
     * of scalar parameters that should replace placeholders in the <b>$line</b>
     * string. Please note that the placeholder index begins with 1 and not 0.
     * 
     * You must call {phpucConsoleOutput::startList()} method before you start
     * a new list, this resets the internal counter. 
     * 
     * <code>
     * $out = new phpucConsoleOutput();
     * $out->startList();
     * $out->writeListItem( 
     *     '{1} is an instance of "{2}"', '$out', get_class( $out )
     * );
     * $out->writeListItem( 
     *     '{1} is an instance of "{2}"', '$out', get_class( $out )
     * );
     * // Results in:
     * //   1. $out is an instance of "phpucConsoleOutput"
     * //   2. $out is an instance of "phpucConsoleOutput" 
     * </code>  
     *
     * @param string $text The primary output text.
     * 
     * @return void
     */
    public function writeListItem( $text )
    {
        $args = func_get_args();
        $this->writeLineArray(
            sprintf( '  % 2d. %s', $this->index, $text ), $args
        );
        ++$this->index;
    }

    /**
     * Resets the internal counter for listr items.
     *
     * @return void
     */
    public function startList()
    {
        $this->index = 1;
    }
    
    /**
     * This method replaces all placeholders in <b>$text</b> with values from
     * the <b>$args</b> <b>array</b> and then it outputs the generated text.
     *
     * @param string                 $text The raw output text.
     * @param array(integer=>string) $args Replace values.
     * 
     * @return void
     */
    protected function writeLineArray( $text, $args )
    {
        $text = $this->replacePlaceholders( $text, $args );
        
        echo $text, PHP_EOL;        
    }
    
    /**
     * Replaces all <b>{[0-9]+}</b> placeholders with the corresponding values
     * in the <b>$args</b> array.
     *
     * @param string                 $text   The raw output text.
     * @param array(integer=>string) $values Replace values.
     * 
     * @return string
     */
    protected function replacePlaceholders( $text, array $values )
    {
        if ( preg_match_all( '/\{(\d+)\}/', $text, $matches ) === 0 )
        {
            return $text;
        }
        
        $mapping = array_combine(
            $matches[0], array_map( 'intval', $matches[1] )
        );
        
        foreach ( $mapping as $token => $index )
        {
            if ( isset( $values[$index] ) )
            {
                $text = str_replace( $token, $values[$index], $text );
            }
        }
        
        return $text;
    }
}
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
 * @package   Util
 * @author    Manuel Pichler <mapi@phpundercontrol.org>
 * @copyright 2007-2010 Manuel Pichler. All rights reserved.
 * @license   http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @version   SVN: $Id$
 * @link      http://www.phpundercontrol.org/
 */

/**
 * Utility class for customized templates and other files.
 * 
 * Custom code locations are identified by the following tag:
 * 
 * <code>
 *   &lt;%-- phpUnderControl (0-9+) --%&gt;
 * </code>
 * 
 * And the customized code must be surrounded by the following two comments where
 * the number must match the value of the placeholder.
 * 
 * <code>
 *   &lt;%-- begin phpUnderControl 1 --%&gt;
 *     Hello World
 *   &lt;%-- end phpUnderControl 1 --%&gt;
 * </code> 
 *
 * @category  QualityAssurance
 * @package   Util
 * @author    Manuel Pichler <mapi@phpundercontrol.org>
 * @copyright 2007-2010 Manuel Pichler. All rights reserved.
 * @license   http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @version   Release: 0.6.1beta1
 * @link      http://www.phpundercontrol.org/
 */
class phpucFileCopyUtil
{
    /**
     * List of file extensions where this class should look into the contents
     * for custom tags.
     *
     * @var array(string)
     */
    protected static $extensions = array( 'jsp' );
    
    /**
     * Copies the contents from the <b>$source</b> file to the <b>$target</b> file.
     * 
     * If the extension of this file is registered as a possible customization
     * type this method will search for placeholders and for custom content in
     * the target file. When the target contains custom content, this will be
     * transfered to the new file.
     *
     * @param string $source The source file name.
     * @param string $target The target file name.
     * 
     * @return void
     */
    public function copy( $source, $target )
    {
        // First load content
        $code = file_get_contents( $source );
        
        // Extract file extension from source
        $ext = pathinfo( $source, PATHINFO_EXTENSION );
        
        // Check for prepare extension
        if ( in_array( $ext, self::$extensions, true ) )
        {
            if ( $this->hasPlaceHolders( $code ) === true )
            {
                $code = $this->prepareCode( $target, $code );
            }
        }
        
        file_put_contents( $target, $code );
    }
    
    /**
     * Tests the given code for placeholders.
     * 
     * A placeholder is defined as:
     * <code>
     *   &lt;%-- phpUnderControl (0-9+) --%&gt;
     * </code>
     *
     * @param string $code The code of a source file.
     *  
     * @return boolean
     */
    protected function hasPlaceHolders( $code )
    {
        return ( preg_match( '#<%-- phpUnderControl (\d+) --%>#', $code ) !== 0 );
    }
    
    /**
     * Extracts custom content from the <b>$target</b> file and moves it into 
     * <b>$code</b>.
     * 
     * Customized code must be surrounded by:
     * <code>
     *   &lt;%-- begin phpUnderControl 1 --%&gt;
     *     Hello World
     *   &lt;%-- end phpUnderControl 1 --%&gt;
     * </code> 
     *
     * @param string $target The target file name.
     * @param string $code   The code of a source file.
     * 
     * @return string The prepared code.
     */
    protected function prepareCode( $target, $code )
    {
        // First check, that target exists
        if ( !file_exists( $target ) )
        {
            return $code;
        }
        
        // Load target code
        $targetCode = file_get_contents( $target );
        
        // Extract custom code blocks
        $regex = '#<%-- begin phpUnderControl (\d+) --%>'
               . '.*<%-- end phpUnderControl \\1 --%>#Us';
        // Skip for not customized code
        if ( preg_match_all( $regex, $targetCode, $matches ) === 0 )
        {
            return $code;
        }
        
        $customBlocks    = $matches[0];
        $customBlockKeys = $matches[1];
        
        $search  = array();
        $replace = array();
        foreach ( $customBlockKeys as $idx => $key )
        {
            $search[]  = "<%-- phpUnderControl {$key} --%>";
            $replace[] = $customBlocks[$idx];
        }
        
        return str_replace( $search, $replace, $code );
    }
}
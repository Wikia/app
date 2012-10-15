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
 * Filter iterator that expects a {@link DirectoryIterator} as argument. 
 * 
 * This iterator accepts all php files that end with 'Input.php' and do not 
 * begin with 'Abstract'. 
 *
 * @category   QualityAssurance
 * @package    Graph
 * @subpackage Input
 * @author     Manuel Pichler <mapi@phpundercontrol.org>
 * @copyright  2007-2010 Manuel Pichler. All rights reserved.
 * @license    http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @version    Release: 0.6.1beta1
 * @link       http://www.phpundercontrol.org/
 */
class phpucInputIterator extends FilterIterator
{
    /**
     * The required file suffix.
     */
    const SUFFIX = 'Input.php';
    
    /**
     * List of available input object.
     *
     * @var array(phpucInputI)
     */
    private $inputs = null;
    
    /**
     * Returns <b>true</b> if the file name indicates a valid input file. 
     *
     * @return boolean
     */
    public function accept()
    {
        // Get current file name
        $file = basename( $this->getInnerIterator()->current() );
        
        return (
            strpos( $file, 'Abstract' ) !== 0 && 
            substr( $file, -1 * strlen( self::SUFFIX ) ) === self::SUFFIX
            
        );
    }
    
    /**
     * Returns an instance of {@link phpucInputI}.
     *
     * @return phpucInputI
     */
    public function current()
    {
        $key = $this->key();
        
        if ( !isset( $this->inputs[$key] ) )
        {
            // Build class name from file
            $class = 'phpuc' . pathinfo( parent::current(), PATHINFO_FILENAME );
            
            $this->inputs[$key] = new $class();
        }
        
        return $this->inputs[$key];
    }
}
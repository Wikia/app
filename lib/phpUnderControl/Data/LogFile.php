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
 * @package   Data
 * @author    Manuel Pichler <mapi@phpundercontrol.org>
 * @copyright 2007-2010 Manuel Pichler. All rights reserved.
 * @license   http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @version   SVN: $Id$
 * @link      http://www.phpundercontrol.org/
 */

/**
 * This model/data class reflects a single build log file.
 *
 * @category  QualityAssurance
 * @package   Data
 * @author    Manuel Pichler <mapi@phpundercontrol.org>
 * @copyright 2007-2010 Manuel Pichler. All rights reserved.
 * @license   http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @version   Release: 0.6.1beta1
 * @link      http://www.phpundercontrol.org/
 * 
 * @property-read string $timestamp The cruise control timestamp format.
 * @property-read string $fileName  The full log file filename.
 */
class phpucLogFile extends DOMDocument
{
    /**
     * Virtual properties for a single build log file.
     *
     * @var array(string=>mixed)
     */
    protected $properties = array(
        'timestamp'  =>  null,
        'fileName'   =>  null,        
    );
    
    /**
     * Constructs a new log file instance for the given file.
     *
     * @param string $fileName Path of a cc log file.
     */
    public function __construct( $fileName )
    {
        parent::__construct();
        
        $this->load( $fileName );
        
        // Extract timestamp from file name
        preg_match( '/log([0-9]+)/', basename( $fileName ), $match );
        
        $this->properties['timestamp'] = $match[1];
        $this->properties['fileName']  = $fileName;
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
        if ( array_key_exists( $name, $this->properties ) )
        {
            return $this->properties[$name];
        }
        throw new OutOfRangeException(
            sprintf( 'Unknown or writonly property $%s.', $name )
        );
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
}
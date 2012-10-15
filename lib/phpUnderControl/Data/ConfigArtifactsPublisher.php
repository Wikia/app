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
 * This class represents an artificats publisher in the config.xml file.
 *
 * @category  QualityAssurance
 * @package   Data
 * @author    Manuel Pichler <mapi@phpundercontrol.org>
 * @copyright 2007-2010 Manuel Pichler. All rights reserved.
 * @license   http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @version   Release: 0.6.1beta1
 * @link      http://www.phpundercontrol.org/
 * 
 * @property      string             $dir          A directory to publish.
 * @property      string             $file         A file to publish.
 * @property      string             $dest         The destination directory.
 * @property      string             $subdirectory A destination sub directory.
 * @property-read DOMElement         $element      The execute xml element. 
 * @property-read phpucConfigProject $project      The parent project instance.
 */
class phpucConfigArtifactsPublisher implements phpucConfigPublisherI
{
    /**
     * Magic properties for the artifact publisher tag.
     *
     * @var array(string=>mixed)
     */
    protected $properties = array(
        'element'       =>  null,
        'project'       =>  null,
        'dir'           =>  null,
        'file'          =>  null,
        'dest'          =>  null,
        'subdirectory'  =>  null,
    );
    
    /**
     * The ctor takes the parent project object as argument.
     *
     * @param phpucConfigProject $project The parent project.
     */
    public function __construct( phpucConfigProject $project )
    {
        $this->properties['project'] = $project;
        $this->properties['element'] = $project->element
            ->ownerDocument
            ->createElement(
                'artifactspublisher'
            );
                                               
        $publishers = $project->element->getElementsByTagName( 'publishers' );
        $publishers->item( 0 )->appendChild( $this->element );
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
        switch ( $name )
        {
            case 'dir':
            case 'file':
            case 'dest':
            case 'subdirectory':
                $this->properties[$name] = $value;
                break;
            
            default:
                throw new OutOfRangeException(
                    sprintf( 'Unknown or readonly property $%s.', $name )
                );
                break;
        }
    }
    
    /**
     * Builds/Rebuilds the <artifactspublisher> tag.
     *
     * @return void
     * @throws ErrorException If neither the $dir property nor the $file
     *         property was set.
     */
    public function buildXml()
    {
        if ( $this->file === null && $this->dir === null )
        {
            throw new ErrorException(
                'You must set a artificat $dir or $file. Nothing set.'
            );
        }
        else if ( $this->file === null )
        {
            $this->element->setAttribute( 'dir', $this->dir );    
        }
        else
        {
            $this->element->setAttribute( 'file', $this->file );
        }
        
        $this->element->setAttribute( 'dest', $this->dest );
        
        if ( $this->subdirectory !== null )
        {
            $this->element->setAttribute( 'subdirectory', $this->subdirectory );
        }
    }
}
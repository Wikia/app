<?php
/**
 * This file is part of phpUnderControl.
 *
 * PHP Version 5.2.0
 *
 * Copyright (c) 2007-2010, Manuel Pichler <mapi@manuel-pichler.de>.
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
 * @author    Manuel Pichler <mapi@manuel-pichler.de>
 * @copyright 2007-2010 Manuel Pichler. All rights reserved.
 * @license   http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @version   SVN: $Id$
 * @link      http://www.phpundercontrol.org/
 */

/**
 * Abstraction for the CruiseControl <(cvs|svn|git)bootstrapper> tags.
 *
 * @category  QualityAssurance
 * @package   Data
 * @author    Manuel Pichler <mapi@manuel-pichler.de>
 * @copyright 2007-2010 Manuel Pichler. All rights reserved.
 * @license   http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @version   Release: 0.6.1beta1
 * @link      http://www.phpundercontrol.org/
 *
 * @property string $localWorkingCopy
 *           Path to the local copy of the Subversion, CVS or git repository
 *           module which contains the project sources.
 * @property string $strapperType
 *           The used boot strapper type. At the moment only CVS, Subversion
 *           and git are supported types.
 * @property-read phpucConfigProject $project
 *                The parent project instance.
 */
class phpucConfigBootStrapper
{
    /**
     * Magic properties for the artifact publisher tag.
     *
     * @var array(string=>mixed)
     */
    protected $properties = array(
        'localWorkingCopy'  =>  null,
        'strapperType'      =>  null,
        'project'           =>  null,
    );

    /**
     * The ctor takes the parent project object as argument.
     *
     * @param phpucConfigProject $project The parent project.
     */
    public function __construct( phpucConfigProject $project )
    {
        $this->properties['project'] = $project;
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
            case 'localWorkingCopy':
                $this->properties[$name] = $value;
                break;

            case 'strapperType':
                if ( !in_array( $value, array( 'cvs', 'svn', 'git' ) ) )
                {
                    throw new InvalidArgumentException(
                        'Invalid value for the $strapperType property.'
                    );
                }
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
     * Generates the up
     *
     * @return void
     */
    public function buildXml()
    {
        $elemName = "{$this->strapperType}bootstrapper";

        $element = $this->project
            ->element
            ->ownerDocument
            ->createElement( $elemName );
        $element->setAttribute( 'localWorkingCopy', $this->localWorkingCopy );

        $bootstrappers = $this->project
            ->element
            ->getElementsByTagName( 'bootstrappers' );
        $bootstrappers->item( 0 )->appendChild( $element );
    }
}
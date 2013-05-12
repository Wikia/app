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
 * @package   VersionControl
 * @author    Manuel Pichler <mapi@phpundercontrol.org>
 * @copyright 2007-2010 Manuel Pichler. All rights reserved.
 * @license   http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @version   SVN: $Id$
 * @link      http://www.phpundercontrol.org/
 */

/**
 * Abstract checkout implementation.
 *
 * @category  QualityAssurance
 * @package   VersionControl
 * @author    Manuel Pichler <mapi@phpundercontrol.org>
 * @copyright 2007-2010 Manuel Pichler. All rights reserved.
 * @license   http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @version   Release: 0.6.1beta1
 * @link      http://www.phpundercontrol.org/
 *
 * @property string $url
 *           The subversion repository url.
 * @property string $username
 *           Username for the subversion repository.
 * @property string $password
 *           Password for the subversion repository.
 */
abstract class phpucAbstractCheckout implements phpucCheckoutI
{
    /**
     * Factory method that create a checkout implementation for the console
     * arguments.
     *
     * @param phpucConsoleArgs $args
     *        The given console arguments.
     *
     * @return phpucCheckoutI
     * @throws phpucErrorException
     *         If the defined version control system is not valid, but this
     *         should never happen.
     */
    public static function createCheckout( phpucConsoleArgs $args )
    {
        switch ( $args->getOption( 'version-control' ) )
        {
            case 'git':
                $checkout = new phpucGitCheckout();
                break;

            case 'svn':
                $checkout = new phpucSubversionCheckout();
                break;

            case 'cvs':
                $checkout = new phpucCvsCheckout();

                if ( $args->hasOption( 'module' ) === false )
                {
                    throw new phpucErrorException(
                        'Missing mandatory CVS option --module.'
                    );
                }
                $checkout->module = $args->getOption( 'module' );
                break;

            default:
                throw new phpucErrorException(
                    "Unknown checkout type '{$args->getOption( 'version-control' )}'"
                );
        }

        $checkout->url = $args->getOption( 'version-control-url' );

        if ( $args->hasOption( 'username' ) )
        {
            $checkout->username = $args->getOption( 'username' );
        }
        if ( $args->hasOption( 'password' ) )
        {
            $checkout->password = $args->getOption( 'password' );
        }

        return $checkout;
    }

    /**
     * Virtual properties for the setting implementation.
     *
     * @var array(string=>mixed)
     */
    protected $properties = array(
        'url'       =>  null,
        'password'  =>  null,
        'username'  =>  null,
    );

    /**
     * Magic property getter method.
     *
     * @param string $name The property name.
     *
     * @return mixed
     * @throws OutOfRangeException If the property doesn't exist or is writonly.
     */
    public function __get( $name )
    {
        if ( array_key_exists( $name, $this->properties ) === true )
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
     * @throws OutOfRangeException If the property doesn't exist or is readonly.
     */
    public function __set( $name, $value )
    {
        switch ( $name )
        {
            case 'url':
            case 'password':
            case 'username':
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
     * Implement to return version control specific update command
     *
     * @return string
     */
    abstract public function getUpdateCommand();
}

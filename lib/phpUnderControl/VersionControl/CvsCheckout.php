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
 * @package   VersionControl
 * @author    Manuel Pichler <mapi@manuel-pichler.de>
 * @copyright 2007-2010 Manuel Pichler. All rights reserved.
 * @license   http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @version   SVN: $Id$
 * @link      http://www.phpundercontrol.org/
 */

/**
 * CVS checkout implementation. 
 *
 * @category  QualityAssurance
 * @package   VersionControl
 * @author    Manuel Pichler <mapi@manuel-pichler.de>
 * @copyright 2007-2010 Manuel Pichler. All rights reserved.
 * @license   http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @version   Release: 0.6.1beta1
 * @link      http://www.phpundercontrol.org/
 * 
 * @property string $module
 *           The cvs project module.
 */
class phpucCvsCheckout extends phpucAbstractCheckout
{
    /**
     * The temporary cvs password file.
     *
     * @var string
     */
    protected $passFile = null;
    
    /**
     * Constructs a new cvs checkout.
     */
    public function __construct()
    {
        $this->properties['module'] = null;
        
        $this->passFile = tempnam( phpucFileUtil::getSysTempDir(), 'cvs' );
    }
    
    /**
     * Removes the temporary cvs password file.
     *
     */
    public function __destruct()
    {
        @unlink( $this->passFile );
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
            case 'module':
                $this->properties[$name] = $value;
                break;
                
            default:
                parent::__set( $name, $value );
                break;                
        }
    }
    
    /**
     * Performs a subversion checkout.
     *
     * @return void
     * @throws phpucErrorException
     *         If the cvs login or the checkout fails.
     */
    public function checkout()
    {
        $url = ":pserver:{$this->username}:";
        if ( $this->password !== null )
        {
            $url .= $this->password;
        }
        $url .= "@{$this->url}";
        
        $cvs = "cvs -d {$url}";

        $this->runShellCommand( "{$cvs} login" );
        $this->runShellCommand( "{$cvs} co -d source {$this->module}" );
    }
    
    /**
     * Runs the given command and checks the response for errors.
     *
     * @param string $cmd The cvs cli command string
     * 
     * @return void
     * @throws phpucErrorException
     *         If the cvs login or the checkout fails.
     */
    protected function runShellCommand( $cmd )
    {
        $env  = array( 'CVS_PASSFILE'  =>  $this->passFile );
        $spec = array(
            0  =>  array("pipe", "r"),  // stdin 
            1  =>  array("pipe", "w"),  // stdout
            2  =>  array("pipe", "w")   // stderr
        );
        
        $proc = proc_open( escapeshellcmd( $cmd ), $spec, $pipes, null, $env );
        if ( is_resource( $proc ) === false )
        {
            throw new phpucErrorException( "Cannot execute command '{$cmd}'." );
        }
        
        // Read stdout
        $stdout = '';
        while ( !feof( $pipes[1] ) )
        {
            $stdout .= fgets( $pipes[1], 128 );
        }
        fclose( $pipes[1] );

        // Read stderr
        $stderr = '';
        while ( !feof( $pipes[2] ) )
        {
            $stderr .= fgets( $pipes[2], 128 );
        }
        fclose( $pipes[2] );
            
        proc_close( $proc );
        
        // For any reason cvs writes to stderr during the checkout?
        if ( $stdout === '' && $stderr !== '' )
        {
            throw new phpucErrorException( $stderr );
        }
    }

    /**
     * CVS uses update command to update existing repository from a server
     * 
     * @return string
     */
    public function getUpdateCommand()
    {
        return "up";
    }
}
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
 * File system utility class.
 *
 * @category  QualityAssurance
 * @package   Util
 * @author    Manuel Pichler <mapi@phpundercontrol.org>
 * @copyright 2007-2010 Manuel Pichler. All rights reserved.
 * @license   http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @version   Release: 0.4.0
 * @link      http://www.phpundercontrol.org/
 */
final class phpucFileUtil
{
    /**
     * Indicates any windows operations system.
     */
    const OS_WINDOWS = 0;
    
    /**
     * Indicates any unix based operation system.
     */
    const OS_UNIX = 1;
    
    /**
     * List of valid operation systems.
     *
     * @var array(integer)
     */
    private static $validOS = array( self::OS_UNIX, self::OS_WINDOWS );
    
    /**
     * List of known windows executable extensions.
     *
     * @var array(string)
     */
    private static $windowsExts = array( 'exe', 'cmd', 'bat' );
    
    /**
     * List of environment paths.
     *
     * @var array(string)
     */
    private static $paths = null;
    
    /**
     * The used operation system.
     * 
     * This property was primary introduced for class testing. 
     *
     * @var integer
     */
    private static $os = null;
    
    /**
     * Returns the current operation system. If no operation system is configured
     * this method uses the PHP constant <b>PHP_OS</b> for detection.
     *
     * @return integer
     */
    public static function getOS()
    {
        if ( self::$os === null )
        {
            if ( stristr( PHP_OS, 'win' ) && !stristr( PHP_OS, 'darwin' ) )
            {
                self::$os = self::OS_WINDOWS;
            }
            else
            {
                self::$os = self::OS_UNIX;
            }
        }
        return self::$os;
    }
    
    /**
     * Sets the current operation system.  The method only exist's for testing.
     *
     * @param integer $os The current system os.
     * 
     * @return void
     * @throws InvalidArgumentException If the given $os property is not a valid
     *         operation system, known by this class.
     */
    public static function setOS( $os = null )
    {
        if ( $os !== null && in_array( $os, self::$validOS, true ) === false )
        {
            throw new InvalidArgumentException(
                sprintf( 'Invalid operation system type %d.', $os )
            );
        }
        self::$os = $os;
    }
    
    /**
     * Returns an <b>array</b> with all configured system paths. If the class 
     * internal property isn't set, this method uses the environment variable 
     * 'PATH' and the PHP constant <b>PATH_SEPARATOR</b> is used.
     *
     * @return array(string)
     */
    public static function getPaths()
    {
        if ( self::$paths === null )
        {
            self::$paths = array_unique(
                explode( PATH_SEPARATOR, getenv( 'PATH' ) )
            );
        }
        return self::$paths;
    }
    
    /**
     * Allows to set some custom paths. This method is only need intended for
     * testing.
     *
     * @param array $paths List of environment paths.
     * 
     * @return void
     */
    public static function setPaths( array $paths = null )
    {
        self::$paths = $paths;
    }
    
    /**
     * Tries to find the full path for the given <b>$executable</b>. 
     * 
     * <b>$executable</b> should contain the unix file name with out any
     * file extension because for windows it tries to append some default
     * extensions.  
     *
     * @param string $executable The pure executable name without an extension.
     * 
     * @return string The executable path.
     * @throws phpucErrorException If the given executable doesn't exist in any
     *         of the configured paths.
     */
    public static function findExecutable( $executable )
    {
        $path = null;
        if ( self::getOS() === self::OS_UNIX )
        {
            $path = self::findUnixExecutable( $executable );
        }
        else
        {
            $path = self::findWindowsExecutable( $executable );
        }
        return $path;
    }
    
    /**
     * Returns the system temp directory.
     *
     * @return string
     */
    public static function getSysTempDir()
    {
        if ( function_exists( 'sys_get_temp_dir' ) )
        {
            return sys_get_temp_dir();
        }
        else if ( $tmp = getenv( 'TMP' ) )
        {
            return $tmp;
        }
        else if ( $tmp = getenv( 'TEMP' ) )
        {
            return $tmp;
        }
        else if ( $tmp = getenv( 'TMPDIR' ) )
        {
            return $tmp;
        }
        else if ( file_exists( '/tmp' ) )
        {
            return '/tmp';
        }
        throw new ErrorException( 'Cannot get system temp directory.' );
    }

    /**
     * Creates a new directory if it doesn't already exist.
     *
     * @param string $path The directory to create.
     *
     * @return void
     */
    public static function createDirectoryIfNotExists( $path )
    {
        if ( file_exists( $path ) === false )
        {
            mkdir( $path, 0775, true );
        }
    }
    
    /**
     * Removes the given directory recursive.
     *
     * @param string $path The directory to delete.
     * 
     * @return void
     */
    public static function deleteDirectory( $path )
    {
        self::deleteDirectoryRecursive( new RecursiveDirectoryIterator( $path ) );
        
        rmdir( $path );
    }
    
    /**
     * Removes the given directory recursive.
     *
     * @param DirectoryIterator $it The context directory iterator.
     * 
     * @return void
     */
    private static function deleteDirectoryRecursive( DirectoryIterator $it )
    {
        foreach ( $it as $file )
        {
            if ( $it->isDot() )
            {
                continue;
            }
            else if ( $it->isDir() )
            {
                self::deleteDirectoryRecursive( $it->getChildren() );

                rmdir( $it->getPathname() );
            }
            else
            {
                unlink( $it->getPathname() );
            }
        }
    }
    
    /**
     * Tries to find the given executable on an unix system.
     *
     * @param string $executable The pure executable name without an extension.
     * 
     * @return string The executable path.
     * @throws phpucErrorException If the given executable doesn't exist in any
     *         of the configured paths.
     */
    private static function findUnixExecutable( $executable )
    {
        foreach ( self::getPaths() as $path )
        {
            $fullPath = "{$path}/{$executable}";
            
            if ( file_exists( $fullPath ) && is_executable( $fullPath ) )
            {
                return $executable;
            }
        }
        throw new phpucErrorException(
            sprintf(
                'Cannot find the executable "%s" in your environment', $executable
            )
        );
    }
    
    /**
     * Tries to find the given executable on a windows system. This means it 
     * appends all known executable file extensions to the given name and this 
     * method skips the "is_executable" check.
     *
     * @param string $executable The pure executable name without an extension.
     * 
     * @return string The executable path.
     * @throws phpucErrorException If the given executable doesn't exist in any
     *         of the configured paths.
     */
    private static function findWindowsExecutable( $executable )
    {
        foreach ( self::getPaths() as $path )
        {
            foreach ( self::$windowsExts as $ext )
            {
                $fullPath = $path . DIRECTORY_SEPARATOR . "{$executable}.{$ext}";

                if ( file_exists( $fullPath ) )
                {
                    return $fullPath;
                }
            }
        }
        throw new phpucErrorException(
            sprintf(
                'Cannot find the executable "%s" in your environment', $executable
            )
        );
    }
}

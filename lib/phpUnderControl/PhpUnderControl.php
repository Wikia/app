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
 * @package   PhpUnderControl
 * @author    Manuel Pichler <mapi@phpundercontrol.org>
 * @copyright 2007-2010 Manuel Pichler. All rights reserved.
 * @license   http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @version   SVN: $Id$
 * @link      http://www.phpundercontrol.org/
 */

if ( defined( 'PHPUC_INSTALL_DIR' ) === false )
{
    if ( strpos( '/usr/share/php', '@php_dir' ) === false )
    {
        define( 'PHPUC_INSTALL_DIR', '/usr/share/php/phpUnderControl' );
        define( 'PHPUC_DATA_DIR', '/usr/share/php/data/phpUnderControl/data' );
        define( 'PHPUC_BIN_DIR', '/usr/bin' );
        define( 'PHPUC_EZC_BASE', '/usr/share/php/ezc/Base/base.php' );
    }
    else
    {
        define( 'PHPUC_INSTALL_DIR', dirname( __FILE__ ) );
        define( 'PHPUC_DATA_DIR', realpath( PHPUC_INSTALL_DIR . '/../data' ) );
        define( 'PHPUC_BIN_DIR', PHPUC_INSTALL_DIR . '/../bin' );
        define( 'PHPUC_EZC_BASE', PHPUC_INSTALL_DIR . '/../lib/ezc/Base/src/base.php' );
    }
}

require_once PHPUC_INSTALL_DIR . '/Util/Autoloader.php';

/**
 * Main installer class.
 *
 * @category  QualityAssurance
 * @package   PhpUnderControl
 * @author    Manuel Pichler <mapi@phpundercontrol.org>
 * @copyright 2007-2010 Manuel Pichler. All rights reserved.
 * @license   http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @version   Release: 0.6.1beta1
 * @link      http://www.phpundercontrol.org/
 */
class phpucPhpUnderControl
{
    /**
     * Main method for phpUnderControl
     *
     * @return void
     */
    public static function main()
    {
        $autoloader = new phpucAutoloader();
        
        spl_autoload_register( array( $autoloader, 'autoload' ) );
        
        if ( file_exists( PHPUC_EZC_BASE ) )
        {
            include_once PHPUC_EZC_BASE;

            spl_autoload_register( array( 'ezcBase', 'autoload' ) );
        }
        
        $phpUnderControl = new phpucPhpUnderControl();
        $phpUnderControl->run();
    }
    
    /**
     * The used console input object.
     *
     * @var phpucConsoleInput
     */
    private $input = null;
    
    /**
     * List with all tasks.
     *
     * @var array(phpucTaskI)
     */
    private $tasks = array();
    
    /**
     * The ctor creates the required console arg instance.
     */
    public function __construct()
    {
        $this->input = new phpucConsoleInput();
    }
    
    /**
     * Performs a single cli request.
     *
     * @return void
     */
    public function run()
    {
        try
        {
            if ( $this->input->parse() )
            {
                phpucConsoleOutput::set( new phpucConsoleOutput() );
                
                $command = phpucAbstractCommand::createCommand( 
                    $this->input->args->command
                );
                $command->setConsoleArgs( $this->input->args );
        
                $command->validate();
                $command->execute();
            }
            exit( 0 );
        }
        catch ( phpucConsoleException $e )
        {
            echo $e->getMessage(), PHP_EOL;
            exit( 1 );
        }
        catch ( phpucExecuteException $e )
        {
            echo $e->getMessage(), PHP_EOL;
            exit( 2 );
        }
        catch ( phpucValidateException $e )
        {
            echo $e->getMessage(), PHP_EOL;
            exit( 3 );
        }
        catch ( phpucRuntimeException $e )
        {
            echo $e->getMessage(), PHP_EOL;
            exit( 5 );
        }
        catch ( Exception $e )
        {
            echo $e->getMessage(), PHP_EOL;
            exit( 4 );
        }
    }
}
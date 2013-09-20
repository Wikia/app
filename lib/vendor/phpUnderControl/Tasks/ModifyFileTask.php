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
 * @package   Tasks
 * @author    Manuel Pichler <mapi@phpundercontrol.org>
 * @copyright 2007-2010 Manuel Pichler. All rights reserved.
 * @license   http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @version   SVN: $Id$
 * @link      http://www.phpundercontrol.org/
 */

/**
 * Modifies a defined set of files.
 *
 * @category  QualityAssurance
 * @package   Tasks
 * @author    Manuel Pichler <mapi@phpundercontrol.org>
 * @copyright 2007-2010 Manuel Pichler. All rights reserved.
 * @license   http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @version   Release: 0.6.1beta1
 * @link      http://www.phpundercontrol.org/
 */
class phpucModifyFileTask extends phpucAbstractTask
{
    /**
     * List of files to modify.
     *
     * @var array(string)
     */
    protected $files = array();
    
    /**
     * Sets a list of create files.
     *
     * @param array $files List of files.
     * 
     * @return void
     */
    public function setFiles( array $files )
    {
        $this->files = $files;
    }
    
    /**
     * Checks that the <b>webapps/cruisecontrol</b> folder exists.
     *
     * @return void
     * @throws phpucValidateException If the validation fails.
     */
    public function validate()
    {
        $installDir = $this->args->getArgument( 'cc-install-dir' );
        
        foreach ( $this->files as $file )
        {
            if ( !file_exists( $installDir . $file ) )
            {
                throw new phpucValidateException(
                    sprintf( 'Missing required CruiseControl file "%s".', $file )
                );
            }
        }
    }
    
    /**
     * Overrides all files from <b>$files</b> in the cc webapps folder.
     *
     * @return void
     * @throws phpucExecuteException If the execution fails.
     */
    public function execute()
    {
        $out = phpucConsoleOutput::get();
        $out->writeLine( 'Performing modify file task.' );
        
        $installDir = $this->args->getArgument( 'cc-install-dir' );
        
        $out->startList();
        
        foreach ( $this->files as $file )
        {
            $filepath = $installDir . $file;
            
            if ( file_exists( "{$filepath}.orig" ) === false )
            {
                $out->writeListItem( 'Creating backup "{1}".', $file );
                
                copy( $filepath, "{$filepath}.orig" );
            }
            
            $out->writeListItem( 'Modifying file "{1}"', $file );
            
            $fileUtil = new phpucFileCopyUtil();
            $fileUtil->copy( PHPUC_DATA_DIR . '/' . $file, $filepath );
        }
        
        $out->writeLine();
    }
}
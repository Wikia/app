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
 * @package   Tasks
 * @author    Manuel Pichler <mapi@manuel-pichler.de>
 * @copyright 2007-2010 Manuel Pichler. All rights reserved.
 * @license   http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @version   SVN: $Id$
 * @link      http://www.phpundercontrol.org/
 */

/**
 * Deletes the project configuration and all project contents.
 *
 * @category  QualityAssurance
 * @package   Tasks
 * @author    Manuel Pichler <mapi@manuel-pichler.de>
 * @copyright 2007-2010 Manuel Pichler. All rights reserved.
 * @license   http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @version   Release: 0.6.1beta1
 * @link      http://www.phpundercontrol.org/
 */
class phpucProjectDeleteTask extends phpucAbstractTask
{
    /**
     * Validates that a project <cc-install-dir>/projects/<project-name> exists.
     * 
     * @return void
     * @throws phpucValidateException 
     *         If the directory doesn't exist or the config.xml file does not
     *         contain a section for this project.
     */
    public function validate()
    {
        $installDir  = $this->args->getArgument( 'cc-install-dir' );
        $projectName = $this->args->getOption( 'project-name' );
        $projectPath = "{$installDir}/projects/{$projectName}";
        
        if ( !is_dir( $projectPath ) )
        {
            throw new phpucValidateException(
                "Missing project directory '{$projectPath}'."
            );
        }
        
        $configFile = "{$installDir}/config.xml";
        if ( !file_exists( $configFile ) )
        {
            throw new phpucValidateException(
                "Missing CruiseControl configuration '{$configFile}'."
            );
        }
        
        $dom = new DOMDocument();
        $dom->load( $configFile );
        
        $xpath = new DOMXPath( $dom );
        $nodes = $xpath->query( "/cruisecontrol/project[@name='{$projectName}']" );
        
        if ( $nodes->length === 0 )
        {
            throw new phpucValidateException(
                "Missing a project configuration for '{$projectName}'."
            );
        }
    }
    
    /**
     * Removes the project configuration from the CruiseControl config.xml file
     * and deletes all project contents.
     *
     * @return void
     */
    public function execute()
    {
        $installDir  = $this->args->getArgument( 'cc-install-dir' );
        $projectName = $this->args->getOption( 'project-name' );
        
        $this->deleteProjectConfig( $installDir, $projectName );
        $this->deleteProjectStatusFile( $installDir, $projectName );
        $this->deleteProjectArtifacts( $installDir, $projectName );
        $this->deleteProjectLogs( $installDir, $projectName );
        $this->deleteProjectDirectory( $installDir, $projectName );
    }
    
    /**
     * Removes the project configuration from the config.xml file.
     *
     * @param string $installDir
     *        The CruiseControl installation directory.
     * @param string $projectName
     *        The project name.
     * 
     * @return void
     */
    protected function deleteProjectConfig( $installDir, $projectName )
    {
        $config = new phpucConfigFile( "{$installDir}/config.xml" );
        $config->getProject( $projectName )->delete();
        $config->store();
    }
    
    /**
     * Removes the serialized project file within the CruiseControl directory.
     *
     * @param string $installDir
     *        The CruiseControl installation directory.
     * @param string $projectName
     *        The project name.
     * 
     * @return void
     */
    protected function deleteProjectStatusFile( $installDir, $projectName )
    {
        $file = "{$installDir}/{$projectName}.ser";
        if ( file_exists( $file ) )
        {
            unlink( $file );
        }
    }
    
    /**
     * Deletes the artifacts directory for the context project.
     *
     * @param string $installDir
     *        The CruiseControl installation directory.
     * @param string $projectName
     *        The project name.
     * 
     * @return void
     */
    protected function deleteProjectArtifacts( $installDir, $projectName )
    {
        $artifacts = "{$installDir}/artifacts/{$projectName}";
        if ( is_dir( $artifacts ) )
        {
            phpucFileUtil::deleteDirectory( $artifacts );
        }
    }
    
    /**
     * Deletes the logs directory for the context project.
     *
     * @param string $installDir
     *        The CruiseControl installation directory.
     * @param string $projectName
     *        The project name.
     * 
     * @return void
     */
    protected function deleteProjectLogs( $installDir, $projectName )
    {
        $artifacts = "{$installDir}/logs/{$projectName}";
        if ( is_dir( $artifacts ) )
        {
            phpucFileUtil::deleteDirectory( $artifacts );
        }
    }
    
    /**
     * Deletes the project directory for the context project.
     *
     * @param string $installDir
     *        The CruiseControl installation directory.
     * @param string $projectName
     *        The project name.
     * 
     * @return void
     */
    protected function deleteProjectDirectory( $installDir, $projectName )
    {
        $artifacts = "{$installDir}/projects/{$projectName}";
        if ( is_dir( $artifacts ) )
        {
            phpucFileUtil::deleteDirectory( $artifacts );
        }
    }
}
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
 * This task creates the base directory structure for a new project.
 *
 * @category  QualityAssurance
 * @package   Tasks
 * @author    Manuel Pichler <mapi@phpundercontrol.org>
 * @copyright 2007-2010 Manuel Pichler. All rights reserved.
 * @license   http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @version   Release: 0.6.1beta1
 * @link      http://www.phpundercontrol.org/
 */
class phpucProjectTask extends phpucAbstractTask implements phpucConsoleExtensionI
{
    /**
     * Validates that the required <cc-install-dir>/projects directory exists.
     * 
     * @return void
     * @throws phpucValidateException If the directory doesn't exist or the 
     *         a project for the given name already exists.
     */
    public function validate()
    {
        $installDir  = $this->args->getArgument( 'cc-install-dir' );
        $projectName = $this->args->getOption( 'project-name' );
        
        if ( !is_dir( $installDir . '/projects' ) )
        {
            throw new phpucValidateException(
                'Missing projects directory <cc-install-dir>/projects.'
            );
        }
        if ( is_dir( $installDir . '/projects/' . $projectName ) )
        {
            throw new phpucValidateException( 'Project directory already exists.' );
        }
        
        if ( $this->args->hasOption( 'ant-script', 'project' ) )
        {
            if ( !( $path = realpath( $this->args->getOption( 'ant-script' ) ) ) )
            {
                throw new phpucValidateException('Not a valid ant-script location.');
            }
        }
    }
    
    /**
     * Adds a new project to CruiseControl.
     * 
     * This method creates the base directory structure for a CruiseControl
     * project and adds this project to the CruiseControl config.xml file.
     *
     * @return void
     */
    public function execute()
    {
        $out = phpucConsoleOutput::get();
        $out->writeLine( 'Performing project task.' );
        
        $installDir  = $this->args->getArgument( 'cc-install-dir' );
        $projectName = $this->args->getOption( 'project-name' );
        $projectPath = sprintf( '%s/projects/%s', $installDir, $projectName );
        
        $out->startList();
        
        $out->writeListItem(
            'Creating project directory: projects/{1}', $projectName
        );
        mkdir( $projectPath );
        
        $out->writeListItem(
            'Creating source directory:  projects/{1}/source', $projectName
        );
        mkdir( $projectPath . '/source' );
        
        $out->writeListItem(
            'Creating build directory:   projects/{1}/build', $projectName
        );
        mkdir( $projectPath . '/build' );
        
        $out->writeListItem(
            'Creating log directory:     projects/{1}/build/logs', $projectName
        );
        mkdir( $projectPath . '/build/logs' );
        
        $out->writeListItem(
            'Creating build file:        projects/{1}/build.xml', $projectName
        );
        $buildFile = new phpucBuildFile( $projectPath . '/build.xml', $projectName );
        $buildFile->store();
        
        $out->writeListItem( 'Creating backup of file:    config.xml.orig' );
        @unlink( $installDir . '/config.xml.orig' );
        copy( $installDir . '/config.xml', $installDir . '/config.xml.orig' );
        
        $out->writeListItem( 'Searching ant directory' );
        if ( !( $anthome = $this->getAntHome( $installDir ) ) )
        {
            throw new phpucExecuteException( 'ERROR: Cannot locate ant directory.' );
        }
        
        $out->writeListItem( 'Modifying project file:     config.xml' );
        
        $config  = new phpucConfigFile( $installDir . '/config.xml' );
        $project = $config->createProject( $projectName );
        
        $project->interval = $this->args->getOption( 'schedule-interval' );
        $project->anthome  = $anthome;

        if ( $this->args->hasOption( 'ant-script' ) )
        {
            $project->antscript = $this->args->getOption( 'ant-script' );
        }
        
        $config->store();
                
        $out->writeLine();
    }
    
    /**
     * Tries to find the ant home directory.
     *
     * @param string $installDir The CruiseControl installation directory.
     *
     * @return string
     */
    public function getAntHome( $installDir )
    {
        if ( count( $ant = glob( sprintf( '%s/apache-ant*', $installDir ) ) ) === 0 )
        {
            if ( file_exists( $installDir . '/bin/ant' ) )
            {
                return $installDir;
            }
            
            $os = phpucFileUtil::getOS();
            if ( $os !== phpucFileUtil::OS_WINDOWS )
            {
                $ant = shell_exec( 'which ant' );
            }
            if ( strstr( trim( $ant ), 'bin/ant' ) )
            {                
                return substr( $ant, 0, ( strlen( $ant ) - 7 ) );
            }
            
            return false;
        } else {
            return array_pop( $ant );
        }        
    }
    
    /**
     * Callback method that registers a command extension. 
     *
     * @param phpucConsoleInputDefinition $def 
     *        The input definition container.
     * @param phpucConsoleCommandI  $command
     *        The context cli command instance.
     * 
     * @return void
     */
    public function registerCommandExtension(
        phpucConsoleInputDefinition $def,
        phpucConsoleCommandI $command
    ) {
        
         $def->addOption(
            $command->getCommandId(),
            'A',
            'ant-script',
            'The full path to a custom ant launcher script.',
            true
        );
        
        $def->addOption(
            $command->getCommandId(),
            'j',
            'project-name',
            'The name of the generated project.',
            true,
            'php-under-control',
            true
        );
        
        $def->addOption(
            $command->getCommandId(),
            'i',
            'schedule-interval',
            'Schedule interval.',
            true,
            300,
            true
        );
    }
}

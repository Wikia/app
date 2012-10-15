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
 * This class represents the CruiseControl configuration file.
 *
 * @category  QualityAssurance
 * @package   Data
 * @author    Manuel Pichler <mapi@phpundercontrol.org>
 * @copyright 2007-2010 Manuel Pichler. All rights reserved.
 * @license   http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @version   Release: 0.6.1beta1
 * @link      http://www.phpundercontrol.org/
 */
class phpucConfigFile extends DOMDocument
{
    /**
     * The config.xml file name.
     *
     * @var string
     */
    protected $fileName = '';
    
    /**
     * List of projects from the configuration file.
     *
     * @var array(string=>phpucConfigProject)
     */
    protected $projects = array();
    
    /**
     * The ctor takes the configuration file name as argument.
     *
     * @param string $fileName The config file name.
     * 
     * @throws phpucErrorException If the given config file doesn't exist.
     */
    public function __construct( $fileName )
    {
        parent::__construct( '1.0', 'UTF-8' );
        
        // First check for valid file name
        if ( !file_exists( $fileName ) )
        {
            throw new phpucErrorException(
                sprintf( 'Cannot find CruiseControl config file "%s".', $fileName )
            );
        }
        
        $this->fileName           = $fileName;
        $this->formatOutput       = true;
        $this->preserveWhiteSpace = false;
        
        $this->load( $fileName );
    }
    
    /**
     * Creates a new project for the given name.
     *
     * @param string $projectName The name for the new project.
     * 
     * @return phpucConfigProject
     * @throws ErrorException If the configuration contains more than one project
     *         with the same name. But this should never happen.
     */
    public function createProject( $projectName )
    {
        $project = new phpucConfigProject( $this, $projectName );
        
        $this->projects[$projectName] = $project;
        
        return $project;
    }
    
    /**
     * Returns an existing project from the config file.
     *
     * @param string $projectName The name for the new project.
     * 
     * @return phpucConfigProject
     * @throws phpucErrorException If no project for the given name exists.
     */
    public function getProject( $projectName )
    {
        if ( !isset($this->projects[$projectName]) )
        {
            $project = new phpucConfigProject( $this, $projectName );
            
            if ( $project->isNew() )
            {
                throw new phpucErrorException( 
                    "Cannot find a project names '{$projectName}'." 
                );
            }
            
            $this->projects[$projectName] = $project;
        }        
        return $this->projects[$projectName];
    }
    
    /**
     * Writes all changes to the config.xml file.
     *
     * @return void
     * @throws ErrorException If a sub action fails.
     */
    public function store()
    {
        foreach ( $this->projects as $project )
        {
            $project->buildXml();
        }
        $this->save( $this->fileName );
    }
}
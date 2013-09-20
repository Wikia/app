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
 * This class represents a single project in the CruiseControl config.xml file.
 *
 * @category  QualityAssurance
 * @package   Data
 * @author    Manuel Pichler <mapi@phpundercontrol.org>
 * @copyright 2007-2010 Manuel Pichler. All rights reserved.
 * @license   http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @version   Release: 0.6.1beta1
 * @link      http://www.phpundercontrol.org/
 *
 * @property      integer         $interval    The schedule interval.
 * @property      string          $anthome     The ant build tool location.
 * @property      string          $antscript   The custom ant launcher script.
 * @property-read phpucConfigFile $configFile  The parent config file object.
 * @property-read string          $projectName The project name,
 * @property-read DOMElement      $element     The <project> xml element.
 */
class phpucConfigProject
{
    /**
     * Marks a clean project instance.
     */
    const STATE_CLEAN = 1;

    /**
     * Marks a dirty or new project instance.
     */
    const STATE_DIRTY = 2;

    /**
     * Marks a deleted project instance.
     */
    const STATE_DELETED = 3;

    /**
     * Magic properties for the project tag.
     *
     * @var array(string=>mixed)
     * @ignore
     */
    protected $properties = array(
        'element'      =>  null,
        'anthome'      =>  null,
        'antscript'    =>  null,
        'interval'     =>  null,
        'configFile'   =>  null,
        'projectName'  =>  null,
    );

    /**
     * List of all registered artificat publishers.
     *
     * @var array(phpucConfigArtifactsPublisher)
     */
    protected $publishers = array();

    /**
     * List of all registered boot strappers.
     *
     * @var array(phpucConfigBootStrapper)
     */
    protected $bootStrappers = array();

    /**
     * List of all registered build triggers.
     *
     * @var array(phpucConfigBuildTrigger)
     */
    protected $buildTriggers = array();

    /**
     * Denotes the actual state of this project object.
     *
     * @var integer
     */
    protected $state = self::STATE_CLEAN;

    /**
     * The <schedule> element from the project configuration.
     *
     * @var DOMElement
     */
    private $scheduleElement = null;

    /**
     * The build tool element from the project configuration.
     *
     * @var DOMElement
     */
    private $toolElement = null;

    /**
     * The ctor takes the parent config file and the project name as arguments.
     *
     * @param phpucConfigFile $configFile  The parent config file.
     * @param string          $projectName The project name.
     */
    public function __construct( phpucConfigFile $configFile, $projectName )
    {
        $this->properties['configFile']  = $configFile;
        $this->properties['projectName'] = $projectName;

        $this->loadProject();
        $this->init();
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
            case 'anthome':
                $this->properties[$name] = $value;
                break;

            case 'antscript':
                $this->properties[$name] = $value;
                break;

            case 'interval':
                if ( !is_numeric( $value ) || $value < 0 )
                {
                    throw new InvalidArgumentException(
                        sprintf( 'Property $%s must be a positive integer.', $name )
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

        $this->state = self::STATE_DIRTY;
    }

    /**
     * Returns true if the current project is new and not loaded from the
     * configuration file.
     *
     * @return boolean
     */
    public function isNew()
    {
        return ( $this->state === self::STATE_DIRTY );
    }

    /**
     * Creates a new artifact publisher for this project.
     *
     * @return phpucConfigArtifactsPublisher
     */
    public function createArtifactsPublisher()
    {
        $this->state = self::STATE_DIRTY;

        $publisher = new phpucConfigArtifactsPublisher( $this );

        $this->publishers[] = $publisher;

        return $publisher;
    }

    /**
     * Creates a new execute publisher for this project.
     *
     * @return phpucConfigExecutePublisher
     */
    public function createExecutePublisher()
    {
        $this->state = self::STATE_DIRTY;

        $execute = new phpucConfigExecutePublisher( $this );

        $this->publishers[] = $execute;

        return $execute;
    }

    /**
     * Creates a new boot strapper for this project.
     *
     * @return phpucConfigBootStrapper
     */
    public function createBootStrapper()
    {
        $this->state = self::STATE_DIRTY;

        $bootStrapper = new phpucConfigBootStrapper( $this );

        $this->bootStrappers[] = $bootStrapper;

        return $bootStrapper;
    }

    /**
     * Creates a new build trigger for this project.
     *
     * @return phpucConfigBuildTrigger
     */
    public function createBuildTrigger()
    {
        $buildTrigger = new phpucConfigBuildTrigger( $this );

        $this->buildTriggers[] = $buildTrigger;

        return $buildTrigger;
    }

    /**
     * Removes the project section for this project from the configuration file.
     *
     * @return void
     */
    public function delete()
    {
        $this->state = self::STATE_DELETED;

        $this->element->parentNode->removeChild( $this->element );
    }

    /**
     * Builds/Rebuilds the project xml document.
     *
     * @return void
     * @throws ErrorException If one of the artifact publisher fail.
     */
    public function buildXml()
    {
        // Skip if this project is not dirty
        if ( $this->state !== self::STATE_DIRTY )
        {
            return;
        }

        $this->scheduleElement->setAttribute( 'interval', $this->interval );

        if ( !( $this->anthome == null ) )
        {
            $this->toolElement->setAttribute( 'anthome', $this->anthome );
        }

        if (! ( $this->antscript === null ) )
        {
            $this->toolElement->removeAttribute( 'anthome' );
            $this->toolElement->setAttribute( 'antscript', $this->antscript );
        }
        elseif ( !strstr( dirname( $this->configFile->documentURI ), $this->anthome ) )
        {
            $schedules = $this->element->getElementsByTagName( 'schedule' );
            $tools     = $schedules->item( 0 )->getElementsByTagName( 'ant' );

            $i = $tools->length - 1;
            while ( $i > -1 )
            {
                $antTool = $tools->item( $i );
                $this->replaceAntTool( $antTool );
                $i--;
            }
        }

        foreach ( $this->publishers as $publisher )
        {
            $publisher->buildXml();
        }
        foreach ( $this->bootStrappers as $bootStrapper )
        {
            $bootStrapper->buildXml();
        }
        foreach ( $this->buildTriggers as $buildTrigger )
        {
            $buildTrigger->buildXml();
        }

        $this->state = self::STATE_CLEAN;
    }

    /**
     * If an external ant is to be used, CC will not pass class and env
     * variables so we should use an exec task so that the logger is setup
     * correctly. This method replaces the periodic internal ant worker with an
     * exec task that starts an external ant worker
     *
     * @param DOMElement $antTool
     * @return void
     */
    protected function replaceAntTool( DOMElement $antTool )
    {
        $execTool = $this->configFile->createElement( 'exec' );

        $workingDir = dirname( $this->configFile->documentURI );
        $execTool->setAttribute(
            'workingdir', dirname( $this->configFile->documentURI )
        );

        $execTool->setAttribute( 'command', '/usr/bin/ant' );

        $argStr = "-logger org.apache.tools.ant.XmlLogger " .
                  "-logfile {$workingDir}/log.xml " .
                  '-buildfile projects/${project.name}/build.xml';
        $execTool->setAttribute( 'args', $argStr );

        $antTool->parentNode->replaceChild( $execTool, $antTool );
    }

    /**
     * Tries to load an existing project configuration. If no project for the
     * name exists a new project will be created.
     *
     * @return void
     * @throws phpucErrorException If the configuration contains more than one
     *         project with the same name. But this should never happen.
     */
    private function loadProject()
    {
        $xpath  = new DOMXPath( $this->configFile );
        $result = $xpath->query(
            "/cruisecontrol/project[@name='{$this->projectName}']"
        );

        if ( $result->length === 0 )
        {
            $this->newProjectFromTemplate();
        }
        else if ( $result->length > 1 )
        {
            throw new phpucErrorException(
                "There is more than one project named '{$this->projectName}'."
            );
        }
        else
        {
            $this->properties['element'] = $result->item( 0 );
        }
    }

    /**
     * Creates a new project fragment from a pre defined template.
     *
     * @return void
     */
    private function newProjectFromTemplate()
    {
        $project = new DOMDocument();
        $project->load( PHPUC_DATA_DIR . '/template/project.xml' );

        $element = $this->configFile->importNode( $project->documentElement, true );
        $element->setAttribute( 'name', $this->projectName );
        $this->configFile->documentElement->appendChild( $element );

        $this->properties['element'] = $element;

        $this->state = self::STATE_DIRTY;
    }

    /**
     * Loads some project xml elements into object properties and initializes
     * some values from the project configuration.
     *
     * @return void
     */
    private function init()
    {
        // Load the schedule element
        $schedules = $this->element->getElementsByTagName( 'schedule' );

        $this->scheduleElement = $schedules->item( 0 );
        $interval = $this->scheduleElement->getAttribute( 'interval' );
        $this->properties['interval'] = $interval;

        $tools = $schedules->item( 0 )->getElementsByTagName( 'ant' );

        if ( $tools->length > 0 )
        {
            $this->toolElement = $tools->item( 0 );

            $anthome    = trim( $this->toolElement->getAttribute( 'anthome' ) );
            $antscript  = trim( $this->toolElement->getAttribute( 'antscript' ) );
            if ( $anthome !== '' )
            {
                $this->properties['anthome'] = $anthome;
            }
            if ( $antscript !== '' )
            {
                $this->properties['antscript'] = $antscript;
            }
        }
    }
}
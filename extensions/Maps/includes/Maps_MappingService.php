<?php

/**
 * Base class for mapping services. Deriving classes hold mapping service specific
 * information and functionality, which can be used by any mapping feature.
 *
 * @since 0.6.3
 *
 * @file Maps_MappingService.php
 * @ingroup Maps
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
abstract class MapsMappingService implements iMappingService {

	/**
	 * The internal name of the service.
	 *
	 * @since 0.6.3
	 *
	 * @var string
	 */
	protected $serviceName;

	/**
	 * A list of aliases for the internal name.
	 *
	 * @since 0.6.3
	 *
	 * @var array
	 */
	protected $aliases;

	/**
	 * A list of features that support the service, used for validation and defaulting.
	 *
	 * @since 0.6.3
	 *
	 * @var array
	 */
	protected $features;

	/**
	 * A list of names of resource modules to add.
	 *
	 * @since 0.7.3
	 *
	 * @var array
	 */
	protected $resourceModules = array();

	/**
	 * A list of dependencies (header items) that have been added.
	 *
	 * @since 0.6.3
	 *
	 * @var array
	 */
	private $addedDependencies = array();

	/**
	 * A list of dependencies (header items) that need to be added.
	 *
	 * @since 0.6.3
	 *
	 * @var array
	 */
	private $dependencies = array();

	/**
	 * Constructor. Creates a new instance of MapsMappingService.
	 *
	 * @since 0.6.3
	 *
	 * @param string $serviceName
	 * @param array $aliases
	 */
	public function __construct( $serviceName, array $aliases = array() ) {
		$this->serviceName = $serviceName;
		$this->aliases = $aliases;
	}

	/**
	 * @see iMappingService::addParameterInfo
	 *
	 * @since 0.7
	 *
	 * @param $parameterInfo array of IParam
	 */
	public function addParameterInfo( array &$parameterInfo ) {
	}

	/**
	 * @see iMappingService::addFeature
	 *
	 * @since 0.6.3
	 */
	public function addFeature( $featureName, $handlingClass ) {
		$this->features[$featureName] = $handlingClass;
	}

	/**
	 * @see iMappingService::addDependencies
	 *
	 * @since 0.6.3
	 */
	public final function addDependencies( &$parserOrOut ) {
		$dependencies = $this->getDependencyHtml();

		// Only add a head item when there are dependencies.
		if ( $parserOrOut instanceof Parser ) {
			if ( $dependencies ) {
				$parserOrOut->getOutput()->addHeadItem( $dependencies );
			}

			$parserOrOut->getOutput()->addModules( $this->getResourceModules() );
		}
		elseif ( $parserOrOut instanceof OutputPage ) {
			if ( $dependencies ) {
				$parserOrOut->addHeadItem( md5( $dependencies ), $dependencies );
			}

			$parserOrOut->addModules( $this->getResourceModules() );
		}
	}
	
	/**
	 * Returns a list of all config variables that should be passed to the JS.
	 * 
	 * @since 1.0.1
	 * 
	 * @return array
	 */
	public function getConfigVariables() {
		return array();
	}

	/**
	 * @see iMappingService::getDependencyHtml
	 *
	 * @since 0.6.3
	 */
	public final function getDependencyHtml() {
		$allDependencies = array_merge( $this->getDependencies(), $this->dependencies );
		$dependencies = array();

		// Only add dependnecies that have not yet been added.
		foreach ( $allDependencies as $dependency ) {
			if ( !in_array( $dependency, $this->addedDependencies ) ) {
				$dependencies[] = $dependency;
				$this->addedDependencies[] = $dependency;
			}
		}

		// If there are dependencies, put them all together in a string, otherwise return false.
		return count( $dependencies ) > 0 ? implode( '', $dependencies ) : false;
	}

	/**
	 * Returns a list of html fragments, such as script includes, the current service depends on.
	 *
	 * @since 0.6.3
	 *
	 * @return array
	 */
	protected function getDependencies() {
		return array();
	}

	/**
	 * @see iMappingService::getName
	 *
	 * @since 0.6.3
	 */
	public function getName() {
		return $this->serviceName;
	}

	/**
	 * @see iMappingService::getFeature
	 *
	 * @since 0.6.3
	 */
	public function getFeature( $featureName ) {
		return array_key_exists( $featureName, $this->features ) ? $this->features[$featureName] : false;
	}

	/**
	 * @see iMappingService::getFeatureInstance
	 *
	 * @since 0.6.6
	 */
	public function getFeatureInstance( $featureName ) {
		$className = $this->getFeature( $featureName );

		if ( $className === false || !class_exists( $className ) ) {
			throw new MWException( 'Could not create a mapping feature class instance' );
		}

		return new $className( $this );
	}

	/**
	 * @see iMappingService::getAliases
	 *
	 * @since 0.6.3
	 */
	public function getAliases() {
		return $this->aliases;
	}

	/**
	 * @see iMappingService::hasAlias
	 *
	 * @since 0.6.3
	 */
	public function hasAlias( $alias ) {
		return in_array( $alias, $this->aliases );
	}

	/**
	 * Returns the resource modules that need to be loaded to use this mapping service.
	 *
	 * @since 0.7.3
	 *
	 * @return array of string
	 */
	public function getResourceModules() {
		return $this->resourceModules;
	}

	/**
	 * Add one or more names of resource modules that should be loaded.
	 *
	 * @since 0.7.3
	 *
	 * @param mixed $modules Array of string or string
	 */
	public function addResourceModules( $modules ) {
		$this->resourceModules = array_merge( $this->resourceModules, (array)$modules );
	}

	/**
	 * @see iMappingService::addDependency
	 *
	 * @since 0.6.3
	 */
	public final function addDependency( $dependencyHtml ) {
		$this->dependencies[] = $dependencyHtml;
	}

	/**
	 * @see iMappingService::getEarthZoom
	 *
	 * @since 1.0
	 */
	public function getEarthZoom() {
		return 1;
	}

}
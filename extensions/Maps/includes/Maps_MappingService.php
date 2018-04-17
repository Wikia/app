<?php

/**
 * Base class for mapping services. Deriving classes hold mapping service specific
 * information and functionality, which can be used by any mapping feature.
 *
 * @since 0.6.3
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
abstract class MapsMappingService {

	/**
	 * The internal name of the service.
	 *
	 * @var string
	 */
	protected $serviceName;

	/**
	 * A list of aliases for the internal name.
	 *
	 * @var array
	 */
	protected $aliases;

	/**
	 * A list of features that support the service, used for validation and defaulting.
	 *
	 * @var array
	 */
	protected $features;

	/**
	 * A list of names of resource modules to add.
	 *
	 * @var array
	 */
	protected $resourceModules = [];

	/**
	 * A list of dependencies (header items) that have been added.
	 *
	 * @var array
	 */
	private $addedDependencies = [];

	/**
	 * A list of dependencies (header items) that need to be added.
	 *
	 * @var array
	 */
	private $dependencies = [];

	/**
	 * @param string $serviceName
	 * @param array $aliases
	 */
	public function __construct( $serviceName, array $aliases = [] ) {
		$this->serviceName = $serviceName;
		$this->aliases = $aliases;
	}

	/**
	 * @since 0.7
	 *
	 * @param $parameterInfo array of IParam
	 */
	public function addParameterInfo( array &$parameterInfo ) {
	}

	/**
	 * @since 0.6.3
	 */
	public function addFeature( $featureName, $handlingClass ) {
		$this->features[$featureName] = $handlingClass;
	}

	/**
	 * @since 5.2.0
	 * @param ParserOutput $parserOutput
	 */
	public final function addDependencies( ParserOutput $parserOutput ) {
		$dependencies = $this->getDependencyHtml();

		// Only add a head item when there are dependencies.
		if ( $dependencies ) {
			$parserOutput->addHeadItem( $dependencies );
		}

		$parserOutput->addModules( $this->getResourceModules() );
	}

	/**
	 * @since 0.6.3
	 */
	public final function getDependencyHtml() {
		$allDependencies = array_merge( $this->getDependencies(), $this->dependencies );
		$dependencies = [];

		// Only add dependencies that have not yet been added.
		foreach ( $allDependencies as $dependency ) {
			if ( !in_array( $dependency, $this->addedDependencies ) ) {
				$dependencies[] = $dependency;
				$this->addedDependencies[] = $dependency;
			}
		}

		// If there are dependencies, put them all together in a string, otherwise return false.
		return $dependencies !== [] ? implode( '', $dependencies ) : false;
	}

	/**
	 * Returns a list of html fragments, such as script includes, the current service depends on.
	 *
	 * @since 0.6.3
	 *
	 * @return array
	 */
	protected function getDependencies() {
		return [];
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
	 * Returns a list of all config variables that should be passed to the JS.
	 *
	 * @since 1.0.1
	 *
	 * @return array
	 */
	public function getConfigVariables() {
		return [];
	}

	/**
	 * @since 0.6.3
	 */
	public function getName() {
		return $this->serviceName;
	}

	/**
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
	 * @since 0.6.3
	 */
	public function getFeature( $featureName ) {
		return array_key_exists( $featureName, $this->features ) ? $this->features[$featureName] : false;
	}

	/**
	 * @since 0.6.3
	 */
	public function getAliases() {
		return $this->aliases;
	}

	/**
	 * @since 0.6.3
	 */
	public function hasAlias( $alias ) {
		return in_array( $alias, $this->aliases );
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
	 * @param array $dependencies
	 */
	public function addHtmlDependencies( array $dependencies ) {
		foreach ( $dependencies as $dependency ) {
			$this->addHtmlDependency( $dependency );
		}
	}

	/**
	 * @since 0.6.3
	 *
	 * @param $dependencyHtml
	 */
	public final function addHtmlDependency( $dependencyHtml ) {
		$this->dependencies[] = $dependencyHtml;
	}

	/**
	 * @since 1.0
	 */
	public function getEarthZoom() {
		return 1;
	}

	public abstract function getMapId( $increment = true );

}

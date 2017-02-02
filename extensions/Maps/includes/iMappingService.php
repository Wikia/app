<?php

/**
 * Interface that should be implemented by all mapping feature classes.
 * 
 * @since 0.6.3
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
interface iMappingService {
	
	/**
	 * Returns the internal name of the service.
	 * 
	 * @since 0.6.5
	 * 
	 * @return string
	 */	
	public function getName();
	
	/**
	 * Adds the dependencies to the parser output as head items.
	 * 
	 * @since 0.6.3
	 * 
	 * @param mixed $parserOrOut
	 */
	public function addDependencies( &$parserOrOut );
	
	/**
	 * Adds service-specific parameter definitions to the provided parameter list.
	 * 
	 * @since 0.7
	 *
	 * @param array $parameterInfo
	 *
	 * @return array
	 */
	public function addParameterInfo( array &$parameterInfo );
	
	/**
	 * Adds a feature to this service. This is to indicate this service has support for this feature.
	 * 
	 * @since 0.6.5
	 * 
	 * @param string $featureName
	 * @param string $handlingClass
	 */	
	public function addFeature( $featureName, $handlingClass );
	
	/**
	 * Returns the name of the class that handles the provided feature in this service, or false if there is none.
	 * 
	 * @since 0.6.5
	 * 
	 * @param string $featureName.
	 * 
	 * @return mixed String or false
	 */	
	public function getFeature( $featureName );
	
	/**
	 * Returns an instance of the class handling the provided feature with this service, or false if there is none.
	 * 
	 * @since 0.6.6
	 * 
	 * @param string $featureName.
	 * 
	 * @return object or false
	 */	
	public function getFeatureInstance( $featureName );	
	
	/**
	 * Returns a list of aliases.
	 * 
	 * @since 0.6.5
	 * 
	 * @return array
	 */	
	public function getAliases();
	
	/**
	 * Returns if the service has a certain alias or not.
	 * 
	 * @since 0.6.5
	 * 
	 * @param string $alias
	 * 
	 * @return boolean
	 */	
	public function hasAlias( $alias );
	
	/**
	 * Returns the default zoomlevel for the mapping service.
	 * 
	 * @since 0.6.5
	 * 
	 * @return integer
	 */
	public function getDefaultZoom();
	
	/**
	 * Returns the zoomlevel that shows the whole earth for the mapping service.
	 * 
	 * @since 1.0
	 * 
	 * @return integer
	 */
	public function getEarthZoom();
	
	/**
	 * Returns a string that can be used as an unique ID for the map html element.
	 * Increments the number by default, providing false for $increment will get
	 * you the same ID as on the last request.
	 * 
	 * @since 0.6.5
	 * 
	 * @param boolean $increment
	 * 
	 * @return string
	 */
	public function getMapId( $increment = true );

}
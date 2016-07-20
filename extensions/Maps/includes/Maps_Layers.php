<?php

/**
 * Static class for layer functionality.
 *
 * @since 0.7.2
 * 
 * @file Maps_Layers.php
 * @ingroup Maps
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class MapsLayers {
	
	/**
	 * List that maps layer types (keys) to their classes (values).
	 * 
	 * @since 0.7.2
	 * 
	 * @var array of string
	 */
	protected static $classes = array();
	
	/**
	 * List that maps layer types (keys) to the services that they support (values).
	 * 
	 * @since 0.7.2
	 * 
	 * @var array of array of string
	 */	
	protected static $services = array();
	
	/**
	 * Returns a new instance of a layer class for the provided layer type.
	 * 
	 * @since 0.7.2
	 * 
	 * @param string $type
	 * @param array $properties
	 * 
	 * @return MapsLayer
	 */
	public static function getLayer( $type, array $properties ) {
		self::initializeLayers();
		
		if ( self::hasLayer( $type ) ) {
			$className = self::$classes[$type];
			return new $className( $properties );
		}
		else {
			throw new exception( "There is no layer class for layer of type $type." );
		}
	}
	
	/**
	 * Returns the available layer types, optionally filtered by them requiring the
	 * support of the $service parameter.
	 * 
	 * @since 0.7.2
	 * 
	 * @param string $service
	 * 
	 * @return array
	 */
	public static function getAvailableLayers( $service = null ) {
		self::initializeLayers();
		
		if ( is_null( $service ) ) {
			return array_keys( self::$classes );
		}
		else {
			$layers = array();
			
			foreach ( self::$services as $layerType => $supportedServices ) {
				if ( in_array( $service, $supportedServices ) ) {
					$layers[] = $layerType;
				}
			}
			
			return $layers;
		}
	}
	
	/**
	 * Returns the mapping services supported by the provided layer type.
	 * 
	 * @since 0.7.2
	 * 
	 * @param string $type
	 * 
	 * @return array
	 */
	public static function getServicesForType( $type ) {
		return array_key_exists( $type, self::$services ) ? self::$services[$type] : array();
	}

	/**
	 * Returns if there is a layer class for the provided layer type.
	 * 
	 * @since 0.7.2
	 * 
	 * @param string $type
	 * @param string $service
	 * 
	 * @return boolean
	 */	
	public static function hasLayer( $type, $service = null ) {
		self::initializeLayers();

		if ( array_key_exists( $type, self::$classes ) && array_key_exists( $type, self::$services ) ) {
			return is_null( $service ) || in_array( $service, self::$services[$type] );
		}
		else {
			return false;
		}
	}
	
	/**
	 * Register a layer.
	 * 
	 * @param string $type
	 * @param string $layerClass
	 * @param $serviceIdentifier
	 * 
	 * @since 0.7.2
	 */
	public static function registerLayer( $type, $layerClass, $serviceIdentifier ) {
		self::$classes[$type] = $layerClass;
		self::$services[$type][] = $serviceIdentifier;
	}
	
	/**
	 * Initializes the layers functionality by registering the layer types
	 * by firing the  hook.
	 * 
	 * @since 0.7.2
	 */
	protected static function initializeLayers() {
		wfRunHooks( 'MappingLayersInitialization' );
	}
	
}
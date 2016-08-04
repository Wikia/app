<?php

/**
 * Static class which keeps track of basic layer template definitions, abstract layers that
 * serve as template of a specific layer type to allow defining layers of that type with their
 * custom properties.
 *
 * @since 3.0 (previously as MapsLayers since 0.7.2)
 *
 * @file Maps_LayerTypes.php
 * @ingroup Maps
 *
 * @author Jeroen De Dauw
 * @author Daniel Werner
 */
class MapsLayerTypes {

	/**
	 * List of maps layer types (keys) to their classes (values).
	 *
	 * @since 3.0 (available in MapsLayers class in 0.7.2 to 3.0)
	 *
	 * @var array of string
	 */
	protected static $classes = array();

	/**
	 * List of maps layer types (keys) to the services that they support (values).
	 *
	 * @since 3.0 (available in MapsLayers class in 0.7.2 to 3.0)
	 *
	 * @var array of array of string
	 */
	protected static $services = array();

	/**
	 * Returns the type of a layer instance. This is necessary since we do the registering
	 * in the MapsLayer classes thru a static function which can't be defined as abstract in
	 * the base class.
	 *
	 * @since 3.0
	 *
	 * @param MapsLayer $layer Layer to get the associated, registered type of.
	 *
	 * @return string
	 */
	public static function getTypeOfLayer( MapsLayer $layer ) {
		return array_search( get_class( $layer ), self::$classes );
	}

	/**
	 * Returns the available layer types, optionally filtered by them requiring the
	 * support of a specific service.
	 *
	 * @since 3.0 (previously 'getAvailableLayers' since 0.7.2)
	 *
	 * @param string $service
	 *
	 * @return array
	 */
	public static function getAvailableTypes( $service = null ) {
		self::initializeTypes();

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
	 * @since 3.0 (available in MapsLayers class in 0.7.2 to 3.0)
	 *
	 * @param string $type
	 *
	 * @return array
	 */
	public static function getServicesForType( $type ) {
		return array_key_exists( $type, self::$services ) ? self::$services[$type] : array();
	}

	/**
	 * Returns whether the layer type exists (that's the case if the type is associated
	 * with a layer class).
	 *
	 * @since 3.0 (previously 'hasLayer' since 0.7.2)
	 *
	 * @param string $type
	 * @param string $service
	 *
	 * @return boolean
	 */
	public static function hasType( $type, $service = null ) {
		self::initializeTypes();

		if ( array_key_exists( $type, self::$classes ) && array_key_exists( $type, self::$services ) ) {
			return is_null( $service ) || in_array( $service, self::$services[$type] );
		}
		else {
			return false;
		}
	}

	/**
	 * Returns the class of a layer template class or null if the type doesn't exist.
	 *
	 * @since 3.0
	 *
	 * @param string $type
	 *
	 * @return string|null
	 */
	public static function getTypesClass( $type ) {
		if( ! self::hasType( $type ) )
			return null;

		return self::$classes[ $type ];
	}

	/**
	 * Register a layer type by associating a specific class with it.
	 *
	 * @param string $type
	 * @param string $layerClass
	 * @param string[]|string $serviceIdentifier
	 *
	 * @since 3.0
	 */
	public static function registerLayerType( $type, $layerClass, $serviceIdentifier ) {
		self::$classes[$type] = $layerClass;
		if( is_array( $serviceIdentifier ) ) {
			self::$services[$type] = $serviceIdentifier;
		} else {
			self::$services[$type] = array( $serviceIdentifier );
		}
	}

	/**
	 * Initializes the layers functionality by registering the layer types
	 * by firing the hook.
	 *
	 * @since 3.0
	 */
	protected static function initializeTypes() {
		// only initialize once!
		if( empty( self::$classes ) ) {
			Hooks::run( 'MappingLayersInitialization' );
		}
	}
}

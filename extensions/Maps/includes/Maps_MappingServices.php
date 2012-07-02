<?php

/**
 * Class for interaction with MappingService objects.
 * 
 * @since 0.6.6
 * 
 * @file Maps_MappingServices.php
 * @ingroup Maps
 * 
 * @author Jeroen De Dauw
 */
final class MapsMappingServices {
	
	/**
	 * Accociative array containing service identifiers as keys and the names
	 * of service classes as values.
	 * 
	 * @since 0.6.6
	 * 
	 * @var array of string
	 */
	protected static $registeredServices = array();
	
	/**
	 * Accociative with service identifiers as keys containing instances of
	 * the mapping service classes. 
	 * 
	 * Note: This list only contains the instances, so is not to be used for
	 * looping over all available services, as not all of them are guaranteed 
	 * to have an instance already, use $registeredServices for this purpouse.
	 * 
	 * @since 0.6.6
	 * 
	 * @var array of iMappingService
	 */
	protected static $services = array();
	
	/**
	 * Registeres a service class linked to an identifier. 
	 * Also allows automatic registration of a list of features for this service.
	 * 
	 * @since 0.6.6
	 * 
	 * @param $serviceIdentifier String: internal service identifier
	 * @param $serviceClassName String
	 * @param $features Array
	 */
	public static function registerService( $serviceIdentifier, $serviceClassName, array $features = array() ) {
		self::$registeredServices[$serviceIdentifier] = $serviceClassName;
		
		foreach( $features as $featureName => $featureClassName ) {
			self::registerServiceFeature( $serviceIdentifier, $featureName, $featureClassName );
		}
	}
	
	/**
	 * Registeres a feature for a service object.
	 * Registers a warning when the service is not registered, but does not give an error.
	 * 
	 * @since 0.6.6
	 * 
	 * @param $serviceIdentifier String: internal service identifier
	 * @param $featureName String
	 * @param $featureClassName String
	 */
	public static function registerServiceFeature( $serviceIdentifier, $featureName, $featureClassName ) {
		if ( array_key_exists( $serviceIdentifier, self::$registeredServices ) ) {
			$service = self::getServiceInstance( $serviceIdentifier );
			$service->addFeature( $featureName, $featureClassName );			
		}
		else {
			// If the feature is not registered, register a warning. This is not an error though!
			wfWarn( "Tried to register feature '$featureName' with class '$featureClassName' to non-registered service '$serviceIdentifier'." );
		}
	}
	
	/**
	 * Returns the instance of a service class. This method takes
	 * care of creating the instance if this is not done yet.
	 * 
	 * @since 0.6.6
	 * 
	 * @param $serviceIdentifier String: internal service identifier
	 * 
	 * @return iMappingService
	 */
	public static function getServiceInstance( $serviceIdentifier ) {
		if ( !array_key_exists( $serviceIdentifier, self::$services ) ) {
			if ( array_key_exists( $serviceIdentifier, self::$registeredServices ) ) {
				$service = new self::$registeredServices[$serviceIdentifier]( $serviceIdentifier );
				
				if ( $service instanceof iMappingService ) {
					self::$services[$serviceIdentifier] = $service;
				}
				else {
					throw new Exception( 'The service object linked to service identifier ' . $serviceIdentifier . ' does not implement iMappingService.' );
				}
			}
			else {
				throw new Exception( 'There is no service object linked to service identifier ' . $serviceIdentifier . '.' );
			}
		}

		return self::$services[$serviceIdentifier];
	}
	
	/**
	 * Retuns an instance of a MapsMappingService. The service name is validated
	 * and aliases are resolved and a check is made if the feature is supported.
	 * If the feature is not supported, or the service does not exist, defaulting
	 * will be used.
	 * 
	 * @since 0.6.6
	 * 
	 * @param $service String: service name or alias, does not need to be secure
	 * @param $feature String
	 * 
	 * @return iMappingService
	 */
	public static function getValidServiceInstance( $service, $feature ) {
		return self::getServiceInstance( self::getValidServiceName( $service, $feature ) );
	}
	
	/**
	 * Returns a valid service. When an invalid service is provided, the default one will be returned.
	 * Aliases are also changed into the main service names @see MapsMappingServices::getMainServiceName.
	 *
	 * @since 0.6.6
	 *
	 * @param $service String: service name or alias, does not need to be secure
	 * @param $feature String
	 *
	 * @return string
	 */
	public static function getValidServiceName( $service, $feature ) {
		global $egMapsDefaultService, $egMapsDefaultServices;

		// Get rid of any aliases.
		// Also rely on this to instantiate all registered services.
		$service = self::getMainServiceName( $service );
		
		// Check if there is a mathing instance.
		$shouldChange = !array_key_exists( $service, self::$services );
		
		// If it should not be changed, ensure the service supports this feature.
		if ( !$shouldChange ) {
			$shouldChange = self::getServiceInstance( $service )->getFeature( $feature ) === false;
		}

		// Change the service to the most specific default value available.
		// Note: the default services should support their corresponding features.
		// If they don't, a fatal error will occur later on.
		if ( $shouldChange ) {
			if ( array_key_exists( $feature, $egMapsDefaultServices ) ) {
				$service = $egMapsDefaultServices[$feature];
			}
			else {
				$service = $egMapsDefaultService;
			}
		}

		return $service;
	}

	/**
	 * Returns an array with the identifiers for all registered services.
	 * 
	 * @since 0.6.6
	 * 
	 * @return array
	 */
	public static function getServiceIdentifiers() {
		return array_keys( self::$registeredServices );
	}
	
	/**
	 * Checks if the service name is an alias for an actual service,
	 * and changes it into the main service name if this is the case.
	 *
	 * @since 0.6.6
	 *
	 * @param $serviceName String: service name or alias, does not need to be secure
	 * 
	 * @return string
	 */
	protected static function getMainServiceName( $serviceName ) {
		if ( !array_key_exists( $serviceName, self::$services ) ) {
			foreach ( self::getServiceIdentifiers() as $serviceIdentifier ) {
				$service = self::getServiceInstance( $serviceIdentifier );

				if ( $service->hasAlias( $serviceName ) ) {
					 $serviceName = $service->getName();
					 break;
				}
			}
		}
		
		return $serviceName;
	}
	
	/**
	 * Returns an array containing all the possible values for the service parameter, including aliases.
	 *
	 * @since 0.6.6
	 *
	 * @return array of string
	 */
	public static function getAllServiceValues() {
		global $egMapsAvailableServices;

		$allServiceValues = array();

		foreach ( $egMapsAvailableServices as $availableService ) {
			$allServiceValues[] = $availableService;
			$allServiceValues = array_merge( $allServiceValues, self::getServiceInstance( $availableService )->getAliases() );
		}

		return $allServiceValues;
	}
	
	/**
	 * Returns an array with an instance of a MappingService object for every available mapping service.
	 * 
	 * @since 0.7.3
	 * 
	 * @return array of MappingService
	 */
	public static function getAllObjects() {
		$objects = array();
		
		foreach ( self::$registeredServices as $service => $class ) {
			$objects[] = self::getServiceInstance( $service );
		}
		
		return $objects;
	} 
	
}

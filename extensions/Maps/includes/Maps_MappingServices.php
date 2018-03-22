<?php

/**
 * Class for interaction with MappingService objects.
 *
 * @since 0.6.6
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
final class MapsMappingServices {

	/**
	 * Associative array containing service identifiers as keys and the names
	 * of service classes as values.
	 *
	 * @var string[]
	 */
	private static $registeredServices = [];

	/**
	 * Associative with service identifiers as keys containing instances of
	 * the mapping service classes.
	 *
	 * Note: This list only contains the instances, so is not to be used for
	 * looping over all available services, as not all of them are guaranteed
	 * to have an instance already, use $registeredServices for this purpose.
	 *
	 * @var MapsMappingService[]
	 */
	private static $services = [];

	/**
	 * Registers a service class linked to an identifier.
	 * Also allows automatic registration of a list of features for this service.
	 */
	public static function registerService( string $serviceIdentifier, string $serviceClassName, array $features = [] ) {
		self::$registeredServices[$serviceIdentifier] = $serviceClassName;

		foreach ( $features as $featureName => $featureClassName ) {
			self::registerServiceFeature( $serviceIdentifier, $featureName, $featureClassName );
		}
	}

	/**
	 * Registeres a feature for a service object.
	 * Registers a warning when the service is not registered, but does not give an error.
	 */
	public static function registerServiceFeature( string $serviceIdentifier, string $featureName, string $featureClassName ) {
		if ( array_key_exists( $serviceIdentifier, self::$registeredServices ) ) {
			$service = self::getServiceInstance( $serviceIdentifier );
			$service->addFeature( $featureName, $featureClassName );
		} else {
			// If the feature is not registered, register a warning. This is not an error though!
			wfWarn(
				"Tried to register feature '$featureName' with class '$featureClassName' to non-registered service '$serviceIdentifier'."
			);
		}
	}

	/**
	 * Returns the instance of a service class. This method takes
	 * care of creating the instance if this is not done yet.
	 *
	 * @throws MWException
	 */
	public static function getServiceInstance( string $serviceIdentifier ): MapsMappingService {
		if ( !array_key_exists( $serviceIdentifier, self::$services ) ) {
			if ( array_key_exists( $serviceIdentifier, self::$registeredServices ) ) {
				$service = new self::$registeredServices[$serviceIdentifier]( $serviceIdentifier );

				if ( $service instanceof MapsMappingService ) {
					self::$services[$serviceIdentifier] = $service;
				} else {
					throw new MWException(
						'The service object linked to service identifier ' . $serviceIdentifier . ' does not implement iMappingService.'
					);
				}
			} else {
				throw new MWException(
					'There is no service object linked to service identifier ' . $serviceIdentifier . '.'
				);
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
	 * @return MapsMappingService
	 */
	public static function getValidServiceInstance( string $service, string $feature ): MapsMappingService {
		return self::getServiceInstance( self::getValidServiceName( $service, $feature ) );
	}

	/**
	 * Returns a valid service. When an invalid service is provided, the default one will be returned.
	 * Aliases are also changed into the main service names @see MapsMappingServices::getMainServiceName.
	 *
	 * @param $service String: service name or alias, does not need to be secure
	 * @param $feature String
	 *
	 * @return string
	 */
	public static function getValidServiceName( string $service, string $feature ): string {
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
			} else {
				$service = $egMapsDefaultService;
			}
		}

		return $service;
	}

	/**
	 * Checks if the service name is an alias for an actual service,
	 * and changes it into the main service name if this is the case.
	 *
	 * @param $serviceName String: service name or alias, does not need to be secure
	 *
	 * @return string
	 */
	private static function getMainServiceName( string $serviceName ): string {
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
	 * Returns an array with the identifiers for all registered services.
	 */
	public static function getServiceIdentifiers(): array {
		return array_keys( self::$registeredServices );
	}

	/**
	 * Returns an array containing all the possible values for the service parameter, including aliases.
	 *
	 * @return string[]
	 */
	public static function getAllServiceValues(): array {
		global $egMapsAvailableServices;

		$allServiceValues = [];

		foreach ( $egMapsAvailableServices as $availableService ) {
			$allServiceValues[] = $availableService;
			$allServiceValues = array_merge(
				$allServiceValues,
				self::getServiceInstance( $availableService )->getAliases()
			);
		}

		return $allServiceValues;
	}

	/**
	 * Returns an array with an instance of a MappingService object for every available mapping service.
	 *
	 * @return MapsMappingService[]
	 */
	public static function getAllObjects(): array {
		$objects = [];

		foreach ( self::$registeredServices as $service => $class ) {
			$objects[] = self::getServiceInstance( $service );
		}

		return $objects;
	}

}

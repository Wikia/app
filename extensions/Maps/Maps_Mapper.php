<?php

/** 
 * A class that holds static helper functions for common functionality that is not map-spesific.
 *
 * @file Maps_Mapper.php
 * @ingroup Maps
 *
 * @author Jeroen De Dauw
 */

if( !defined( 'MEDIAWIKI' ) ) {
	die( 'Not an entry point.' );
}

final class MapsMapper {
	
	/**
	 * Array holding the parameters that are not spesific to a mapping service, 
	 * their aliases, criteria and default value.
	 *
	 * @var array
	 */
	private static $mainParams;

	public static function initializeMainParams() {
		global $egMapsSizeRestrictions, $egMapsMapWidth, $egMapsMapHeight;

		self::$mainParams = array
			(
			'zoom' => array(
				'type' => 'integer',
				'criteria' => array(
					'not_empty' => array()
					)				
				),
			'width' => array(
				'type' => 'integer',
				'criteria' => array(
					'not_empty' => array(),
					'in_range' => $egMapsSizeRestrictions['width']
					),
				'default' => $egMapsMapWidth		
				),
			'height' => array(
				'type' => 'integer',
				'criteria' => array(
					'not_empty' => array(),
					'in_range' => $egMapsSizeRestrictions['height']
					),
				'default' => $egMapsMapHeight
				),
			);
	}

	/**
	 * Returns the main parameters array.
	 * 
	 * @return array
	 */
	public static function getMainParams() {
		return self::$mainParams;
	}	
	
	/**
	 * Returns a valid service. When an invalid service is provided, the default one will be returned.
	 * Aliases are also chancged into the main service names @see MapsMapper::getMainServiceName().
	 *
	 * @param string $service
	 * @param string $feature
	 * @param string $subfeature
	 * 
	 * @return string
	 */
	public static function getValidService($service, $feature, $subfeature = '') {
		global $egMapsAvailableServices, $egMapsDefaultService, $egMapsDefaultServices, $egMapsServices;

		// Get rid of any aliases.
		$service = self::getMainServiceName($service);
		
		// If the service is not loaded into maps, it should be changed.
		$shouldChange = ! array_key_exists($service, $egMapsServices);

		// If it should not be changed, ensure the service supports this feature, and when present, sub feature.
		// TODO: recursive checking for sub features would definitly be cooler.
		if (! $shouldChange) {
			if (array_key_exists($feature, $egMapsServices[$service])) {
				if (array_key_exists('class', $egMapsServices[$service][$feature])) {
					// If the class key is set, the feature does not have sub features, so the service supports the feature.
					$shouldChange = false;
				}
				else
				{
					// The feature has sub features, so check if the current service has support for it.
					$shouldChange = !array_key_exists($subfeature, $egMapsServices[$service][$feature]);
				}
			}
			else {
				// The service does not support this feature.
				$shouldChange = true;
			}
		}

		// Change the service to the most specific default value available.
		// Note: the default services should support their corresponding features.
		// If they don't, a fatal error will occur later on.
		if ($shouldChange) {
			if (array_key_exists($feature, $egMapsDefaultServices)) {
				if (is_array($egMapsDefaultServices[$feature])) {
					if (array_key_exists($subfeature, $egMapsDefaultServices[$feature])) {
						$service = $egMapsDefaultServices[$feature][$subfeature];
					}
					else {
						$service = $egMapsDefaultService;
					}
				}
				else {
					$service = $egMapsDefaultServices[$feature];
				}
			}
			else {
				$service = $egMapsDefaultService;
			}
		}
		
		return $service;
	}
	
	/**
	 * Checks if the service name is an alias for an actual service,
	 * and changes it into the main service name if this is the case.
	 *
	 * @param string $service
	 * @return string
	 */
	private static function getMainServiceName($service) {
		global $egMapsServices;
		
		if (! array_key_exists($service, $egMapsServices)) {
			foreach ($egMapsServices as $serviceName => $serviceInfo) {
				if (in_array($service, $serviceInfo['aliases'])) {
					 $service = $serviceName;
					 break;
				}
			}
		}
		
		return $service;
	}	
}

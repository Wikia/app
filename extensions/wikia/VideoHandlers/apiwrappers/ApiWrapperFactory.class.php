<?php

class ApiWrapperFactory {
	protected $videoId;
	protected $classname;
	
	protected static $instance = null;
		
	public static function getInstance() {
		if (self::$instance == null) {
			self::$instance = new ApiWrapperFactory();
		}
		
		return self::$instance;
	}
	
	/**
	 * Get provider name from id
	 * @param int $id
	 * @return mixed provider name or null
	 */
	public function getProviderNameFromId($id) {
		$providerMap = F::app()->wg->videoMigrationProviderMap;
		if (!empty($providerMap[$id])) {
			return strtolower($providerMap[$id]);
		}
		
		return null;
	}
	
	public function getApiWrapper($url) {
		$map = F::app()->wg->videoMigrationProviderMap;
		$url = trim($url);
		$fixed_url = strtolower( $url );
		$test = strpos( $fixed_url, "http://" );
		if( !false === $test ) {
			return false;
		}
		
		$fixed_url = str_replace( "http://", "", $fixed_url );
		$fixed_parts = explode( "/", $fixed_url );
		$hostname = $fixed_parts[0];

		foreach( $map as $id => $name ) {
			$class_name = $name . 'ApiWrapper';
			if ( $class_name::isMatchingHostname( $hostname ) ) {
				return $class_name::newFromUrl( $url );
			}
		}
		
		return null;
	}
	
}
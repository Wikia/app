<?php

class ApiWrapperFactory {
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
		global $wgVideoMigrationProviderMap;
		$url = trim($url);
		$fixed_url = strtoupper( $url );
		$test = strpos( $fixed_url, "HTTP://" );
		if( !false === $test ) {
			return null;
		}
		
		$fixed_url = str_replace( "HTTP://", "", $fixed_url );
		$fixed_parts = explode( "/", $fixed_url );
		$hostname = $fixed_parts[0];

		foreach( $wgVideoMigrationProviderMap as $id => $name ) {
			$class_name = $name . 'ApiWrapper';
			if ( $class_name::hostnameFromProvider( $hostname ) ) {
				return $class_name::newFromUrl( $url );
			}
		}

		// Screenplay is not supported by this method
		
		// Realgravity is not supported by this method
		
		//@todo Wikia premium video
		
		//@todo local video		
		
		
		return null;
	}
	

	/**
	 *
	 * @param string $url
	 * @return boolean true if parsed successfully
	 */

	// TODO: This needs ApiWrapper
	private function parseGamevideosUrl($url) {
		$parsed = explode( "/", $url );
		if( is_array( $parsed ) ) {
			//@todo create GamevideosApiWrapper
			/*$this->classname = 'GamevideosApiWrapper'; */

			//$this->videoId = array_pop( $parsed );
			return true;
		}

		return false;
	}


}
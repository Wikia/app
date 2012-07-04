<?php

class ApiWrapperFactory {
	protected $videoId;
	protected $classname;
	
	protected static $instance = null;
		
	public static function getInstance() {

		wfProfileIn( __METHOD__ );

		if (self::$instance == null) {
			self::$instance = new ApiWrapperFactory();
		}

		wfProfileOut( __METHOD__ );

		return self::$instance;
	}
	
	/**
	 * Get provider name from id
	 * @param int $id
	 * @return mixed provider name or null
	 */
	public function getProviderNameFromId($id) {

		wfProfileIn( __METHOD__ );

		$providerMap = F::app()->wg->videoMigrationProviderMap;
		if (!empty($providerMap[$id])) {

			wfProfileOut( __METHOD__ );
			return strtolower($providerMap[$id]);
		}

		wfProfileOut( __METHOD__ );
		return null;
	}
	
	public function getApiWrapper( $url ) {
        wfProfileIn( __METHOD__ );

        if ( empty( F::app()->wg->allowNonPremiumVideos ) ) {
            wfProfileOut( __METHOD__ );
            return null;
        }

		$map = F::app()->wg->videoMigrationProviderMap;
		$url = trim($url);
		$fixed_url = strtolower( $url );
		$test = strpos( $fixed_url, "http://" );
		if( !false === $test ) {
			wfProfileOut( __METHOD__ );
			return false;
		}
		
		$fixed_url = str_replace( "http://", "", $fixed_url );
		$fixed_parts = explode( "/", $fixed_url );
		$hostname = $fixed_parts[0];

		foreach( $map as $id => $name ) {
			$class_name = $name . 'ApiWrapper';
			if ( $class_name::isMatchingHostname( $hostname ) ) {
				wfProfileOut( __METHOD__ );
				return $class_name::newFromUrl( $url );
			}
		}
		wfProfileOut( __METHOD__ );
		return null;
	}
	
}
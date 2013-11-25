<?php

class ApiWrapperFactory {
	protected $videoId;
	protected $classname;

	protected static $instance = null;

	/**
	 * @static
	 * @return ApiWrapperFactory
	 */
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

	/**
	 * @param $url
	 * @return bool|null|ApiWrapper
	 * @throws WikiaException
	 */
	public function getApiWrapper( $url ) {
		wfProfileIn( __METHOD__ );

		if ( empty( F::app()->wg->allowNonPremiumVideos ) ) {
			wfProfileOut( __METHOD__ );
			// throw new WikiaException(wfMessage("videohandler-non-premium")->parse()); //TODO: re-instate html links once VETUpgrade branch is merged into trunk (Liz)
			throw new WikiaException(wfMessage("videohandler-non-premium-with-links")->parse());
		}

		$url = trim($url);
		$parsed = parse_url( strtolower( $url ) );

		if ( ( FALSE === $parsed ) || ( empty( $parsed['scheme'] ) ) || ( !in_array( $parsed['scheme'], array( 'http', 'https' ) ) ) ) {
			wfProfileOut( __METHOD__ );
			return false;
		}

		$map = F::app()->wg->videoMigrationProviderMap;
		foreach( $map as $name ) {
			$class_name = $name . 'ApiWrapper';
			if ( $class_name::isMatchingHostname(  $parsed['host'] ) ) {
				wfProfileOut( __METHOD__ );
				return $class_name::newFromUrl( $url );
			}
		}
		wfProfileOut( __METHOD__ );
		return null;
	}
}

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
	 * @param $url
	 * @return bool|null|ApiWrapper
	 * @throws WikiaException
	 */
	public function getApiWrapper( $url ) {
		global $wgVideoApiWrappers;
		wfProfileIn( __METHOD__ );

		$url = trim( $url );
		$parsed = parse_url( strtolower( $url ) );

		if ( ( FALSE === $parsed ) || ( empty( $parsed['scheme'] ) ) || ( !in_array( $parsed['scheme'], array( 'http', 'https' ) ) ) ) {
			wfProfileOut( __METHOD__ );
			return false;
		}

		foreach( $wgVideoApiWrappers as $apiWrapper ) {
			/* @var $apiWrapper ApiWrapper */
			if ( $apiWrapper::isMatchingHostname( $parsed['host'] ) ) {
				wfProfileOut( __METHOD__ );
				return $apiWrapper::newFromUrl( $url );
			}
		}
		wfProfileOut( __METHOD__ );
		return null;
	}
}

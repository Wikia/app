<?php

/**
 * Class FeedIngesterFactory
 */
class FeedIngesterFactory {

	// Constants for referring to short provider names
	const PROVIDER_SCREENPLAY = 'screenplay';
	const PROVIDER_IGN = 'ign';
	const PROVIDER_OOYALA = 'ooyala';
	const PROVIDER_CRUNCHYROLL = 'crunchyroll';

	// Providers from which we ingest daily video data
	protected static $ACTIVE_PROVIDERS = [
		self::PROVIDER_IGN,
		self::PROVIDER_OOYALA,
		self::PROVIDER_SCREENPLAY,
		self::PROVIDER_CRUNCHYROLL,
	];

	/**
	 * Make constructor private to avoid direct instantiation of this class.
	 */
	private function __construct() {}

	// These providers are not ingested daily, but can be ingested from if specifically named
	protected static $INACTIVE_PROVIDERS = [];

	/**
	 * Return a list of all the providers we actively ingest from
	 * @return array
	 */
	public static function getActiveProviders() {
		return self::$ACTIVE_PROVIDERS;
	}

	/**
	 * Return a list of all the providers that are legal to ingest from but from whom
	 * we do not ingest automatically.
	 * @return array
	 */
	public static function getInactiveProviders() {
		return self::$INACTIVE_PROVIDERS;
	}

	/**
	 * Return a list of all available providers
	 * @return array
	 */
	public static function getAllProviders() {
		return array_merge( self::$ACTIVE_PROVIDERS, self::$INACTIVE_PROVIDERS );
	}


	/**
	 * Given a string representing a VideoFeedIngester class and an array of parameters
	 * to pass to that class during it's construction, return an instance of that class
	 * or throw an exception.
	 * @param string $provider
	 * @param array $params
	 * @return VideoFeedIngester
	 * @throws Exception
	 */
	public static function getIngester( $provider, array $params = [] ) {
		$ingester = ucfirst( $provider ) . 'FeedIngester';
		if ( class_exists( $ingester ) ) {
			return new $ingester( $params );
		}
		throw new Exception("Invalid provider name: $ingester");
	}
}

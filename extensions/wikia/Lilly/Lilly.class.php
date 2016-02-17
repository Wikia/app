<?php

/**
 * Class Lilly
 *
 * This is the interface for lilly HTTP service
 */
class Lilly {
	const API_V2_QUEUE = '/v2/queue';
	const API_V2_CLUSTER = '/v2/cluster';
	const HTTP_TIMEOUT = 1; // 1 second timeout for lilly requests
	const CACHE_PERIOD = 432000; // 5 days
	const CACHE_VERSION = 1;

	const ACCEPTED_DOMAINS = [
		'starwars.wikia.com',
		'bg.starwars.wikia.com',
		'cs.starwars.wikia.com',
		'da.starwars.wikia.com',
		'de.starwars.wikia.com',
		'el.starwars.wikia.com',
		'es.starwars.wikia.com',
		'fr.starwars.wikia.com',
		'hr.starwars.wikia.com',
		'hu.starwars.wikia.com',
		'it.starwars.wikia.com',
		'ja.starwars.wikia.com',
		// alias for hu.starwars.wikia.com:
		'kaminopedia.wikia.com',
		'ko.starwars.wikia.com',
		'la.starwars.wikia.com',
		'nl.starwars.wikia.com',
		'no.starwars.wikia.com',
		'pl.starwars.wikia.com',
		'pt.starwars.wikia.com',
		'ro.starwars.wikia.com',
		'ru.starwars.wikia.com',
		'sl.starwars.wikia.com',
		'sr.starwars.wikia.com',
		'sv.starwars.wikia.com',
		'tr.starwars.wikia.com',
		'zh.starwars.wikia.com',
		// alias for zh.starwars.wikia.com:
		'zh-hk.starwars.wikia.com',
	];

	private function getMemcacheKey( $url ) {
		// Lilly and MediaWiki URL-encode different set of characters (for instance MediaWiki
		// don't encode '(' and lilly does). That why we're decoding the URL before using it
		// as a memcache key. URLs can be long, thus hashing.
		return wfSharedMemcKey( __CLASS__, self::CACHE_VERSION, sha1( rawurldecode( $url ) ) );
	}

	private function isSupportedUrl( $url ) {
		if ( filter_var( $url, FILTER_VALIDATE_URL ) === false ) {
			return false;
		}

		$scheme = parse_url( $url, PHP_URL_SCHEME );
		$host = parse_url( $url, PHP_URL_HOST );

		return $scheme === 'http' && in_array( $host, self::ACCEPTED_DOMAINS );
	}

	public function getCluster( $url ) {
		global $wgLillyServiceUrl, $wgMemc, $wgWikiaDatacenter;

		// No calls from Reston
		if ( $wgWikiaDatacenter === WIKIA_DC_RES ) {
			return [];
		}

		if ( !$this->isSupportedUrl( $url ) ) {
			return [];
		}

		$memcKey = $this->getMemcacheKey( $url );
		$cachedValue = $wgMemc->get( $memcKey );

		if ( $cachedValue !== false ) {
			return $cachedValue;
		}

		$query = http_build_query( [ 'url' => $url ] );
		$lillyUrl = $wgLillyServiceUrl . self::API_V2_CLUSTER . '?' . $query;

		$response = Http::get( $lillyUrl, self::HTTP_TIMEOUT, [ 'noProxy' => true ] );
		$linkMap = json_decode( $response, true /*assoc*/ );

		if ( !is_array( $linkMap ) || count( $linkMap ) === 0 ) {
			$wgMemc->set( $memcKey, [], self::CACHE_PERIOD );
			return [];
		}

		// Cache the cluster for all URLs in the cluster
		foreach ( $linkMap as $lang => $url ) {
			$wgMemc->set( $this->getMemcacheKey( $url ), $linkMap, self::CACHE_PERIOD );
		}

		return $linkMap;
	}
}

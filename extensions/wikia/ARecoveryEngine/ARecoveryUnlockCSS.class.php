<?php
class ARecoveryUnlockCSS {
	const CSS_FILE_PATH = 'extensions/wikia/ARecoveryEngine/css/recoveryUnlock.scss';
	const API_URL = 'http://cs-api.sp-prod.net/';
	const API_ENDPOINT = 'sp_create_csurl';
	const CACHE_TTL = 3600 * 10; //10h
	const TIMEOUT = 10;
	const WIKIA_PROXY_ENDPOINT = '/__bre';

	public static function getUnlockCSSUrl() {
		global $wgServer, $wgSourcePointAccountId;
		$wikiaCssUrl = self::getWikiaUnlockCSSUrl();
		$memcKey = sha1( $wikiaCssUrl );
		$memCache = F::app()->wg->Memc;

		if ( ARecoveryModule::isLockEnabled() ) {
			$jsonData = [
				"account_id" => $wgSourcePointAccountId,
				"is_pub_resource" => false,
				"pub_base" => $wgServer . self::WIKIA_PROXY_ENDPOINT,
				"resource" => $wikiaCssUrl
			];

			$cachedCriptedUrl = $memCache->get( $memcKey );
			if ( $cachedCriptedUrl ) {
				return $cachedCriptedUrl;
			} else {
				try {
					$spQuery = self::postJson(self::API_URL . self::API_ENDPOINT, $jsonData);
				} catch ( Exception $e ) {
					self::logFetchingCryptedCSSFailure( $jsonData );
					return $wikiaCssUrl;
				}

				if ( $spQuery['code'] == 200 && self::verifyContent( $spQuery['response'] ) ) {
					$memCache->set( $memcKey, $spQuery['response'], self::CACHE_TTL) ;
					return $spQuery['response'];
				} else {
					self::logFetchingCryptedCSSFailure( $jsonData );
				}
			}
		}
		return $wikiaCssUrl;
	}

	private static function logFetchingCryptedCSSFailure( $jsonData ) {
		\Wikia\Logger\WikiaLogger::instance()
			->warning( 'Failed to fetch crypted CSS',
				['url' => self::API_URL . self::API_ENDPOINT,
					'data' => $jsonData]
			);
	}

	private static function verifyContent( $url ) {
		$options = [
			'returnInstance' => true,
			'timeout' => self::TIMEOUT,
			'noProxy' => true
		];

		try {
			$response = \Http::get( $url, self::TIMEOUT, $options );
		} catch ( Exception $e ) {
			return false;
		}

		if ( strpos( $response->getContent(), '#WikiaArticle' ) !== false ) {
			return true;
		}
		return false;
	}

	private static function getWikiaUnlockCSSUrl() {
		$am = AssetsManager::getInstance();
		$files = [ self::CSS_FILE_PATH ];
		$cssLink = $am->getSassesUrl( $files );
		return $cssLink;
	}

	private static function postJson( $url, $jsonString ) {
		if ( is_array( $jsonString ) ) {
			$jsonString = json_encode( $jsonString );
		}
		$options = [
			'postData' => $jsonString,
			'headers' => [
				'Content-Type' => 'application/json',
				'Content-Length ' => strlen( $jsonString )
			],
			'returnInstance' => true,
			'timeout' => self::TIMEOUT,
			'noProxy' => true
		];

		$response = \Http::post( $url, $options ); /* @var CurlHttpRequest $response */
		return [ 'response' => $response->getContent(), 'code' => $response->getStatus() ];
	}

}

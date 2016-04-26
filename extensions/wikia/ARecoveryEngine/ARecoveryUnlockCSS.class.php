<?php
class ARecoveryUnlockCSS {
	const CSS_FILE_PATH = 'extensions/wikia/ARecoveryEngine/css/recoveryUnlock.scss';
	const API_URL = 'http://cs-api.sp-prod.net/';
	const API_ENDPOINT = 'sp_create_csurl';
	const CACHE_TTL = 3600 * 10; //10h
	const TIMEOUT = 10;

	private $outputPage = null;

	public function __construct(OutputPage $outputPage) {
		$this->outputPage = $outputPage;
	}

	public function getUnlockCSSUrl() {
		global $wgServer, $wgSourcePointAccountId, $wgEnableUsingSourcePointProxyForCSS;
		$wikiaCssUrl = $this->getWikiaUnlockCSSUrl();
		$memcKey = $wikiaCssUrl;
		$memCache = F::app()->wg->Memc;

		if ( $wgEnableUsingSourcePointProxyForCSS ) {
			$jsonData = [
				"account_id" => $wgSourcePointAccountId,
				"is_pub_resource" => false,
				"pub_base" => $wgServer."/__are",
				"resource" => $wikiaCssUrl
			];

			$cachedCriptedUrl = $memCache->get( $memcKey );
			if ( $cachedCriptedUrl ) {
				return $cachedCriptedUrl;
			} else {
				$spQuery = self::postJson(self::API_URL . self::API_ENDPOINT, $jsonData);
				if ( $spQuery['code'] == 200 && $this->verifyContent( $spQuery['response'] ) ) {
					$memCache->set( $memcKey, $spQuery['response'], self::CACHE_TTL) ;
					return $spQuery['response'];
				} else {
					\Wikia\Logger\WikiaLogger::instance()
						->warning( 'Failed to fetch crypted CSS',
							['url' => self::API_URL . self::API_ENDPOINT,
							 'data' => $jsonData]
						);
				}
			}
		}
		return $wikiaCssUrl;
	}

	private function verifyContent($url) {
		$options = [
			'returnInstance' => true,
			'timeout' => self::TIMEOUT,
			'noProxy' => true
		];
		$response = \Http::get($url, self::TIMEOUT, $options);
		if (strpos($response->getContent(), '#WikiaArticle') !== false) {
			return true;
		}
		return false;
	}

	private function getWikiaUnlockCSSUrl() {
		$am = AssetsManager::getInstance();
		$files = [self::CSS_FILE_PATH];
		$cssLink = $am->getSassesUrl($files);
		return $cssLink;
	}

	private function postJson( $url, $jsonString ) {
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
		return array( 'response' => $response->getContent(), 'code' => $response->getStatus() );
	}

}

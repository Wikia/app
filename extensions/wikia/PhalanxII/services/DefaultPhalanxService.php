<?php

use Wikia\Service\Gateway\UrlProvider;

/**
 * Default {@see PhalanxService} implementation that issues HTTP request to external Phalanx service
 * and immediately throws exception if the request fails.
 */
class DefaultPhalanxService implements PhalanxService {
	const REGEX_VALID_RESPONSE = 'ok';

	/** @var UrlProvider $urlProvider */
	private $urlProvider;

	public function __construct( UrlProvider $urlProvider ) {
		$this->urlProvider = $urlProvider;
	}

	/**
	 * @param PhalanxMatchParams $phalanxMatchParams
	 * @return PhalanxBlockInfo[]
	 * @throws PhalanxServiceException
	 */
	public function doMatch( PhalanxMatchParams $phalanxMatchParams ): array {
		$response = $this->doRequest( 'match', $phalanxMatchParams->buildQueryParams() );

		if ( $response === false ) {
			throw new PhalanxServiceException();
		}

		$jsonResponse = json_decode( $response, true );
		$phalanxBlocks = [];

		foreach ( $jsonResponse as $blockInfo ) {
			$phalanxBlocks[] = PhalanxBlockInfo::newFromJsonObject( $blockInfo );
		}

		return $phalanxBlocks;
	}

	/**
	 * @param string $regex
	 * @return bool
	 * @throws PhalanxServiceException
	 * @throws RegexValidationException
	 */
	public function doRegexValidation( string $regex ): bool {
		$response = $this->doRequest( 'validate', http_build_query( [ 'regex' => $regex ] ) );

		if ( $response === false ) {
			throw new PhalanxServiceException();
		}

		if ( $response !== static::REGEX_VALID_RESPONSE ) {
			throw new RegexValidationException( $response );
		}

		return true;
	}

	private function doRequest( string $action, string $queryParams ) {
		global $wgPhalanxServiceOptions;

		$url = $this->getServiceUrl( $action );
		$options = $wgPhalanxServiceOptions;

		$options['postData'] = $queryParams;

		return Http::post( $url, $options );
	}

	private function getServiceUrl( string $action ) {
		global $wgPhalanxServiceUrl;

		if ( !empty( $wgPhalanxServiceUrl ) ) {
			return "http://$wgPhalanxServiceUrl/$action";
		}

		return "http://{$this->urlProvider->getUrl( 'phalanx' )}/$action";
	}
}

<?php

/**
 * Default {@see PhalanxService} implementation that issues HTTP request to external Phalanx service
 * and immediately throws exception if the request fails.
 */
class DefaultPhalanxService implements PhalanxService {
	const REGEX_VALID_RESPONSE = 'ok';

	/** @var PhalanxHttpClient $phalanxHttpClient */
	private $phalanxHttpClient;

	public function __construct( PhalanxHttpClient $phalanxHttpClient ) {
		$this->phalanxHttpClient = $phalanxHttpClient;
	}

	/**
	 * @param PhalanxMatchParams $phalanxMatchParams
	 * @return PhalanxBlockInfo[]
	 * @throws PhalanxServiceException
	 */
	public function doMatch( PhalanxMatchParams $phalanxMatchParams ): array {
		$response = $this->phalanxHttpClient->matchRequest( $phalanxMatchParams );

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
		$response = $this->phalanxHttpClient->regexValidationRequest( $regex );

		if ( $response === false ) {
			throw new PhalanxServiceException();
		}

		if ( $response !== static::REGEX_VALID_RESPONSE ) {
			throw new RegexValidationException( $response );
		}

		return true;
	}
}

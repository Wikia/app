<?php

/**
 * A "desperate" {@see PhalanxMatchService} implementation that will retry requests N times
 * if they fail before giving up.
 */
class DesperatePhalanxService implements PhalanxService {
	const RETRY_COUNT = 3;
	const DELAY_BETWEEN_RETRIES = 20000;

	/** @var PhalanxService $phalanxService */
	private $phalanxService;

	public function __construct( PhalanxService $phalanxService ) {
		$this->phalanxService = $phalanxService;
	}

	/**
	 * @param PhalanxMatchParams $phalanxMatchParams
	 * @return PhalanxBlockInfo[]
	 * @throws PhalanxServiceException
	 */
	public function doMatch( PhalanxMatchParams $phalanxMatchParams ): array {
		return $this->doMatchWithRetries( $phalanxMatchParams );
	}

	private function doMatchWithRetries( PhalanxMatchParams $phalanxMatchParams, int $retryCount = 1 ): array {
		try {
			return $this->phalanxService->doMatch( $phalanxMatchParams );
		} catch ( PhalanxServiceException $phalanxServiceException ) {
			if ( ++$retryCount > static::RETRY_COUNT ) {
				throw $phalanxServiceException;
			}

			usleep( static::DELAY_BETWEEN_RETRIES );
			return $this->doMatchWithRetries( $phalanxMatchParams, $retryCount );
		}
	}

	/**
	 * @param string $regex
	 * @return bool
	 * @throws PhalanxServiceException
	 * @throws RegexValidationException
	 */
	public function doRegexValidation( string $regex ): bool {
		return $this->doRegexValidationWithRetries( $regex );
	}

	private function doRegexValidationWithRetries( string $regex, int $retryCount = 1 ): bool {
		try {
			return $this->phalanxService->doRegexValidation( $regex );
		} catch ( PhalanxServiceException $phalanxServiceException ) {
			if ( ++$retryCount > static::RETRY_COUNT ) {
				throw $phalanxServiceException;
			}

			usleep( static::DELAY_BETWEEN_RETRIES );
			return $this->doRegexValidationWithRetries( $regex, $retryCount );
		}
	}
}

<?php

interface PhalanxService {
	/**
	 * @param PhalanxMatchParams $phalanxMatchParams
	 * @return PhalanxBlockInfo[]
	 * @throws PhalanxServiceException
	 */
	public function doMatch( PhalanxMatchParams $phalanxMatchParams ): array;

	/**
	 * @param string $regex
	 * @return bool
	 * @throws PhalanxServiceException
	 * @throws RegexValidationException
	 */
	public function doRegexValidation( string $regex ): bool;
}

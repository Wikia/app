<?php
namespace Wikia\PortableInfobox\Helpers;

class InfoboxParamsValidator {
	private $supportedParams = [
		'theme',
		'theme-source',
		'layout'
	];

	/**
	 * validates infobox tags attribute names
	 * @param array $params
	 * @throws InvalidInfoboxParamsException
	 * @todo: consider using hashmap instead of array ones validator grows
	 * @returns boolean
	 */
	public function validateParams( $params ) {
		foreach ( array_keys( $params ) as $param ) {
			if ( !in_array( $param, $this->supportedParams ) ) {
				throw new InvalidInfoboxParamsException( $param );
			}
		}

		return true;
	}
}

class InvalidInfoboxParamsException extends \Exception {
}

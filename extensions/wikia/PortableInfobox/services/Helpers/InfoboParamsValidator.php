<?php
namespace Wikia\PortableInfobox\Helpers;

class InfoboParamsValidator {
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
	 */
	public function validateParams( $params ) {
		foreach ( array_keys( $params ) as $param ) {
			if ( !in_array( $param, $this->$supportedParams ) ) {
				throw new InvalidInfoboxParamsException( $param );
			}
		}
	}
}

class InvalidInfoboxParamsException extends \Exception {
}

<?php
namespace Wikia\PortableInfobox\Helpers;

class InfoboxParamsValidator {
	private $supportedParams = [
		'accent-color-default',
		'accent-color-source',
		'accent-color-text-default',
		'accent-color-text-source',
		'layout',
		'theme',
		'theme-source',
	];

	private $supportedLayouts = [
		'default',
		'stacked'
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

	/**
	 * validates if argument is valid color value. Currently only hex values are supported
	 * @param $color
	 * @return bool
	 * @throws InvalidColorValueException
	 */
	public function validateColorValue( $color ) {
		return !empty( preg_match('/^(#[a-f0-9]{3}([a-f0-9]{3})?)$/i', $color) );
	}

	/**
	 * checks if given layout name is supported
	 * @param $layoutName
	 * @return bool
	 */
	public function validateLayout( $layoutName ) {
		return $layoutName && in_array( $layoutName, $this->supportedLayouts );
	}
}

class InvalidInfoboxParamsException extends \Exception {
}

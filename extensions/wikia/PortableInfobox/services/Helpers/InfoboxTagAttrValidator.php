<?php
namespace Wikia\PortableInfobox\Helpers;

class InfoboxTagAttrValidator {
	private $supportedAttributes = [
		'theme',
		'theme-source',
		'layout'
	];

	/**
	 * validates infobox tags attribute names
	 * @param array $attributes
	 * @throws InvalidInfoboxAttributeException
	 */
	public function validateAttributes( $attributes ) {
		foreach ( array_keys( $attributes ) as $attr ) {
			if ( !in_array( $attr, $this->supportedAttributes ) ) {
				throw new InvalidInfoboxAttributeException( $attr );
			}
		}
	}
}

class InvalidInfoboxAttributeException extends \Exception {
}

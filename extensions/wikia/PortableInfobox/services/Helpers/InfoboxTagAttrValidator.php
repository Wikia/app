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
	 * @throws notValidInfoboxAttributesErrorException
	 */
	public function validateAttributes( $attributes ) {
		foreach ( array_keys( $attributes ) as $attr ) {
			if ( !in_array( $attr, $this->supportedAttributes ) ) {
				throw new notValidInfoboxAttributesErrorException( $attr );
			}
		}
	}
}

class notValidInfoboxAttributesErrorException extends \Exception {
}

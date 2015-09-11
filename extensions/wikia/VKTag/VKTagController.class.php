<?php

class VKTagController extends WikiaParserTagController {

	const PARSER_TAG_NAME = 'vk';

	const TAG_ALLOWED_PARAMS = [
		'group-id',
		'width',
		'height',
		'mode',
		'wide',
		'color1',
		'color2',
		'color3',
	];

	static public function onParserFirstCallInit( Parser $parser ) {
		$parser->setHook( self::PARSER_TAG_NAME, [ new static(), 'parseTag' ] );
		return true;
	}

	/**
	 * Parses the vk tag. Checks to ensure the required attributes are there.
	 * Then constructs the HTML after seeing which attributes are in use.
	 */
	public function parseTag( $input, array $args, Parser $parser, PPFrame $frame ) {
		if ( empty( $args['group-id'] ) ) {
			return '<strong class="error">' . wfMessage( 'vktag-group-id' )->parse() . '</strong>';
		}

		$attributes = $this->prepareAttributes( $args, self::TAG_ALLOWED_PARAMS );
		$attributes['data-wikia-widget'] = 'vk';

		// VK needs element id to be passed to the API, so let's give it one
		$attributes['id'] = 'vk-wrapper-' . wfRandomString( 6 );

		$html = Html::element( 'div', $attributes );

		if ( !( new WikiaIFrameTagBuilderHelper() )->isMobileSkin() ) {
			// Wrapper used for easily selecting the widget in Selenium tests
			$html = Html::rawElement( 'span', [ 'class' => 'widget-vk' ], $html );

			$parser->getOutput()->addModules( 'ext.wikia.VKTag' );
		}

		return $html;
	}

	/**
	 * Validates, prefixes and sanitizes the provided attributes.
	 *
	 * @param array $attributes - attributes to validate
	 * @param array $permittedAttributes - names of permitted parameters
	 *
	 * @return array
	 */
	private function prepareAttributes( array $attributes, array $permittedAttributes ) {
		$validatedAttributes = [ ];

		foreach ( $attributes as $attributeName => $attributeValue ) {
			if ( in_array( $attributeName, $permittedAttributes ) ) {
				$validatedAttributes['data-' . $attributeName] = $attributeValue;
			}
		}

		return $validatedAttributes;
	}

	protected function buildParamValidator( $paramName ) {
		return true;
	}
}

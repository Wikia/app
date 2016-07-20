<?php

class TwitterTagController extends WikiaController {

	const PARSER_TAG_NAME = 'twitter';
	const TWITTER_NAME = 'Twitter';
	const TWITTER_BASE_URL = 'https://twitter.com/';
	const TWITTER_USER_TIMELINE = '/^https:\/\/twitter.com\/[a-z0-9_]*$/i';

	const REGEX_DIGITS = '/^[0-9]*$/';
	const REGEX_HEX_COLOR = '/#[0-9a-f]{3}(?:[0-9a-f]{3})?$/i';
	const REGEX_TWITTER_SCREEN_NAME = '/^[a-z0-9_]{1,15}$/i';

	const TAG_PERMITTED_ATTRIBUTES = [
		// Required Parameter
		'widget-id' => self::REGEX_DIGITS,
		// Regular Parameters
		'chrome' => '/^((noheader|nofooter|noborders|noscrollbar|transparent) ?){0,5}$/i',
		'tweet-limit' => self::REGEX_DIGITS,
		'aria-polite' => '/^(off|polite|assertive)$/i',
		'related' => '/.*/',
		'lang' => '/^[a-z\-]{2,5}$/i',
		'theme' => '/^(light|dark)$/i',
		'link-color' => self::REGEX_HEX_COLOR,
		'border-color' => self::REGEX_HEX_COLOR,
		'width' => self::REGEX_DIGITS,
		'height' => self::REGEX_DIGITS,
		'show-replies' => '/^(true|false)$/i',
		// Parameters below if used properly, may overwrite the timeline type to:
		// User Timeline
		'screen-name' => self::REGEX_TWITTER_SCREEN_NAME,
		'user-id' => self::REGEX_DIGITS,
		// List Timeline
		'list-owner-screen-name' => self::REGEX_TWITTER_SCREEN_NAME,
		'list-owner-screen-id' => self::REGEX_DIGITS,
		'list-slug' => '/^[^0-9]+.{0,24}$/',
		'list-id' => self::REGEX_DIGITS,
		// Collection Timeline
		'custom-timeline-id' => self::REGEX_DIGITS,
		// At the moment of writing this code there's also aviable Search Timeline and (undocumented)
		// Favourites Timeline, but there's no (documented) parameter to force any of them.
	];

	static public function onParserFirstCallInit( Parser $parser ) {
		$parser->setHook( self::PARSER_TAG_NAME, [ new static(), 'parseTag' ] );
		return true;
	}

	/**
	 * Parses the twitter tag. Checks to ensure the required attributes are there.
	 * Then constructs the HTML after seeing which attributes are in use.
	 *
	 * @return string
	 */
	public function parseTag( $input, array $args, Parser $parser, PPFrame $frame ) {
		if ( !empty( $args[ 'href' ] ) && preg_match( self::TWITTER_USER_TIMELINE, $args[ 'href' ] ) ) {
			$href = $args[ 'href' ];
		} else {
			// if no href to user timeline check for id
			if ( empty( $args[ 'widget-id' ] ) ) {
				return '<strong class="error">' . wfMessage( 'twitter-tag-widget-id' )->parse() . '</strong>';
			}
			$href = self::TWITTER_BASE_URL;
		}

		$attributes = $this->prepareAttributes( $args, self::TAG_PERMITTED_ATTRIBUTES );
		$attributes[ 'href' ] = $href;
		// data-wikia-widget attribute is searched for by Mercury
		$attributes[ 'data-wikia-widget' ] = self::PARSER_TAG_NAME;

		if ( ( new WikiaIFrameTagBuilderHelper() )->isMobileSkin() ) {
			$html = Html::element( 'a', $attributes, self::TWITTER_NAME );
		} else {
			// Twitter script is searching for twitter-timeline class
			$attributes[ 'class' ] = 'twitter-timeline';
			$html = Html::element( 'a', $attributes, self::TWITTER_NAME );
			// Wrapper used for easily selecting the widget in Selenium tests
			$html = Html::rawElement( 'span', [ 'class' => 'widget-twitter' ], $html );

			$parser->getOutput()->addModules( 'ext.TwitterTag' );
		}

		return $html;
	}

	/**
	 * Validates, prefixes and sanitizes the provided attributes.
	 *
	 * @param array $attributes - attributes to validate
	 * @param array $permittedAttributes - key-value pairs of permitted parameters and regexes which these parameters'
	 *     values have to match.
	 *
	 * @return array
	 */
	private function prepareAttributes( array $attributes, array $permittedAttributes ) {
		$validatedAttributes = [ ];

		foreach ( $attributes as $attributeName => $attributeValue ) {
			if ( array_key_exists( $attributeName, $permittedAttributes ) &&
				 preg_match( $permittedAttributes[ $attributeName ], $attributeValue )
			) {
				$validatedAttributes[ 'data-' . $attributeName ] = $attributeValue;
			}
		}

		return $validatedAttributes;
	}

	protected function buildParamValidator( $paramName ) {
		return true;
	}
}

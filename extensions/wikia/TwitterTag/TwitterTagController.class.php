<?php

class TwitterTagController extends WikiaParserTagController {

	const PARSER_TAG_NAME = 'twitter';
	const TWITTER_BASE_URL = 'https://twitter.com/';

	/**
	 * Registers the <twitter> tag with the parser and sets its callback.
	 *
	 * @param Parser $parser
	 *
	 * @return bool - hooks aways have to return true
	 */
	static public function onParserFirstCallInit( Parser $parser ) {
		$parser->setHook( self::PARSER_TAG_NAME, [ new static(), 'parseTag' ] );

		return true;
	}

	/**
	 * Parses the twitter tag. Checks to ensure the required attributes are there.
	 * Then constructs the HTML after seeing which attributes are in use.
	 *
	 * @param string $input - not used
	 * @param array $args - attributes to the tag in an assoc array
	 * @param Parser $parser - not used
	 * @param PPFrame $frame - not used
	 *
	 * @return string $html - HTML output for the twitter tag
	 */
	public function parseTag( $input, array $args, Parser $parser, PPFrame $frame ) {
		if ( empty( $args['widget-id'] ) ) {
			return '<strong class="error">' . wfMessage( 'twittertag-widget-id' )->parse() . '</strong>';
		}

		$isMobileSkin = $this->isMobileSkin();

		$regexAny = '/.*/';
		$regexDigits = '/^[0-9]*$/';
		$regexHexColor = '/^#[0-9a-f]{3,6}$/i';
		$regexTwitterScreenName = '/^[a-z0-9_]{1,15}$/i';

		$permittedAttributes = [
			// Required Parameter
			'widget-id' => $regexDigits,
			// Regular Parameters
			'chrome' => '/^((noheader|nofooter|noborders|noscrollbar|transparent) ?){0,5}$/i',
			'tweet-limit' => $regexDigits,
			'aria-polite' => '/^(off|polite|assertive)$/i',
			'related' => $regexAny,
			'lang' => '/^[a-z\-]{2,5}$/i',
			'theme' => '/^(light|dark)$/i',
			'link-color' => $regexHexColor,
			'border-color' => $regexHexColor,
			'width' => $regexDigits,
			'height' => $regexDigits,
			'show-replies' => '/^(true|false)$/i',
			// Parameters below if used properly, may overwrite the timeline type to:
			// User Timeline
			'screen-name' => $regexTwitterScreenName,
			'user-id' => $regexDigits,
			// List Timeline
			'list-owner-screen-name' => $regexTwitterScreenName,
			'list-owner-screen-id' => $regexDigits,
			'list-slug' => '/^[^0-9]+.{0,24}$/',
			'list-id' => $regexDigits,
			// Collection Timeline
			'custom-timeline-id' => $regexDigits,
			// At the moment of writing this code there's also aviable Search Timeline and (undocumented)
			// Favourites Timeline, but there's no (documented) parameter to force any of them.

			// Non-Twitter Parameters - for manual control over the <a> tag - mostly useful for noscript browsers.
			'href' => '/^' . preg_quote( self::TWITTER_BASE_URL, '/' ) . '/i',
			'label' => $regexAny,
		];

		$nonPrefixedAttributesNames = [ 'href', 'label' ];

		$attributes = $this->prepareAttributes( $args, $permittedAttributes, $nonPrefixedAttributesNames );

		if ( $isMobileSkin ) {
			$attributes['data-wikia-widget'] = 'twitter';
		} else {
			$attributes['class'] = 'twitter-timeline';
		}

		$html = $this->renderLink( $attributes );

		if ( !$isMobileSkin ) {
			// Wrapper used for easily selecting the widget in Selenium tests
			$html = Html::rawElement( 'span', [ 'class' => 'widget-twitter' ], $html );
			$html .= $this->getInitializationScript();
		}

		return $html;
	}

	private function isMobileSkin() {
		return $this->app->checkSkin( [ 'wikiamobile', 'mercury' ] );
	}

	/**
	 * Validates, prefixes and sanitizes the provided attributes.
	 *
	 * @param array $attributes - attributes to validate
	 * @param array $permittedAttributes - key-value pairs of permitted parameters and regexes which these parameters'
	 *     values have to match.
	 * @param array $nonPrefixedAttributesNames - attributes which shouldn't get the 'data-' prefix
	 *
	 * @return array
	 */
	private function prepareAttributes( $attributes, $permittedAttributes, $nonPrefixedAttributesNames ) {
		$validatedAttributes = [ ];

		foreach ( $attributes as $attributeName => $attributeValue ) {
			if ( array_key_exists( $attributeName, $permittedAttributes ) &&
				preg_match( $permittedAttributes[$attributeName], $attributeValue )
			) {
				$prefix = in_array( $attributeName, $nonPrefixedAttributesNames ) ? '' : 'data-';
				$validatedAttributes[$prefix . $attributeName] = strip_tags( $attributeValue );
			}
		}

		return $validatedAttributes;
	}

	/**
	 * Sets the href param for <a> and its contents based on the arrtibutes if possible.
	 *
	 * @param array $attributes
	 *
	 * @return string - rendered HTML markup
	 */
	private function renderLink( $attributes ) {
		if ( !empty( $attributes['href'] ) && !empty( $attributes['label'] ) ) {
			$linkPathname = urlencode( substr( $attributes['href'], strlen( self::TWITTER_BASE_URL ) ) );
			$linkLabel = $attributes['label'];
		}
		elseif ( !empty( $attributes['data-screen-name'] ) ) {
			$linkPathname = urlencode( $attributes['data-screen-name'] );
			$linkLabel = wfMessage( 'twittertag-screen-name-label' )
				->params( $attributes['data-screen-name'] )
				->plain();
		}
		elseif ( !empty( $attributes['data-user-id'] ) ) {
			$linkPathname = 'intent/user?user_id='
				. urlencode( $attributes['data-user-id'] );
			$linkLabel = wfMessage( 'twittertag-user-id-label' )
				->params( $attributes['data-user-id'] )
				->plain();
		}
		elseif ( !empty( $attributes['data-list-owner-screen-name'] ) && !empty( $attributes['data-list-slug'] ) ) {
			$linkPathname = urlencode( $attributes['data-list-owner-screen-name'] )
				. '/lists/'
				. urlencode( $attributes['data-list-slug'] );
			$linkLabel = wfMessage( 'twittertag-list-label' )
				->params( $attributes['data-list-owner-screen-name'], $attributes['data-list-slug'] )
				->plain();
		}
		else {
			$linkPathname = '';
			$linkLabel = 'Twitter';
		}

		$attributes['href'] = self::TWITTER_BASE_URL . $linkPathname;
		unset( $attributes['label'] );

		return Html::element( 'a', $attributes, $linkLabel );
	}

	/**
	 * Returns a script tag which gets full Twitter script. That second script swaps <a> Twitter tags into widgets.
	 *
	 * @return string
	 */
	private function getInitializationScript() {
		return '<script>' . file_get_contents( __DIR__ . '/scripts/twitter.min.js' ) . '</script>';
	}

	protected function buildParamValidator( $paramName ) {
		return true;
	}
}

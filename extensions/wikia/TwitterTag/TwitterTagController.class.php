<?php

class TwitterTagController extends WikiaParserTagController {

	const PARSER_TAG_NAME = 'twitter';
	const TWITTER_NAME = 'Twitter';
	const TWITTER_BASE_URL = 'https://twitter.com/';

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

	public function getTagName() {
		return self::PARSER_TAG_NAME;
	}

	protected function getAttributesAllowed() {
		return array_keys( self::TAG_PERMITTED_ATTRIBUTES );
	}

	protected function getErrorOutput( $errorMessages ) {
		return $this->sendRequest(
			'TwitterTagController',
			'twitterTagError',
			[ 'errorMessages' => $errorMessages ]
		);
	}

	protected function getSuccessOutput( $args ) {
		$attributes = $this->buildTagAttributes( self::TAG_PERMITTED_ATTRIBUTES, $args, 'data' );
		$attributes['href'] = self::TWITTER_BASE_URL;

		// data-wikia-widget attribute is searched for by Mercury
		$attributes['data-wikia-widget'] = self::PARSER_TAG_NAME;

		if ( $this->isMobileSkin() ) {
			$html = Html::element( 'a', $attributes, self::TWITTER_NAME );
		} else {
			// Twitter script is searching for twitter-timeline class
			$attributes['class'] = 'twitter-timeline';
			$html = Html::element( 'a', $attributes, self::TWITTER_NAME  );
			// Wrapper used for easily selecting the widget in Selenium tests
			$html = Html::rawElement( 'span', [ 'class' => 'widget-twitter' ], $html );
		}

		return $html;
	}

	protected function registerResourceLoaderModules( Parser $parser ) {
		if ( !$this->isMobileSkin() ) {
			$parser->getOutput()->addModules( 'ext.TwitterTag' );
		}
	}

	protected function buildParamValidator( $paramName ) {
		$validator = new WikiaValidatorAlwaysTrue();
		$attributesRegexPatterns = self::TAG_PERMITTED_ATTRIBUTES;

		switch ( $paramName ) {
			case 'widget-id':
				$validator = new WikiaValidatorRegex([
					'required' => true,
					'pattern' => $attributesRegexPatterns['widget-id']
				], [
					'empty' => 'twitter-tag-empty-widget-id',
					'wrong' => 'twitter-tag-invalid-widget-id'
				]);
				break;
		}

		return $validator;
	}

	public function twitterTagError() {
		$this->setVal(
			'errorMessages',
			$this->getVal( 'errorMessages', wfMessage( 'twitter-tag-error-unknown' )->plain() )
		);

		$this->response->setTemplateEngine( WikiaResponse::TEMPLATE_ENGINE_MUSTACHE );
	}
}

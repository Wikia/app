<?php
/**
 * Class FacebookClientXFBML
 *
 * This class allows FBML (Facebook Markup Language, an extension to HTML) to
 * be incorporated into the wiki through XFBML.
 *
 * Adapted from the FBConnect MediaWiki extension.
 * @author Garrett Bruin, Sean Colombo, Liz Lee, Garth Webb
 *
 */
class FacebookClientXFBML {

	public static $supportedTags = [
		'fb:facepile',
		'fb:follow',
		'fb:like-box',
		'fb:like',
		'fb:recommendations',
		'fb:share-button'
	];

	/**
	 * Register parser hooks for all supported Facebook XFBML tags
	 *
	 * @param Parser $parser
	 *
	 * @throws MWException
	 */
	public static function registerHooks( Parser $parser ) {
		foreach ( self::$supportedTags as $tag ) {
			$parser->setHook( $tag, function ( $text, $args, $parser ) use ($tag) {
				return FacebookClientXFBML::parserHook( $tag, $text, $args, $parser );
			});
		}
	}

	/**
	 * This function is the callback that the ParserFirstCallInit hook assigns
	 * to the parser whenever a supported FBML tag is encountered (like <fb:like-box>).
	 * Function createParserHook($tag) creates an anonymous (lambda-style)
	 * function that simply redirects to parserHook(), filling in the missing
	 * $tag argument with the $tag provided to createParserHook.
	 */
	public static function parserHook( $tag, $text, $args, Parser $parser ) {
		if ( $tag == 'fb:like-box' && isset( $args['profileid'] ) ) {
			$args['profile_id'] = $args['profileid'];
			unset( $args['profileid'] );
		}

		// add custom attribute to look for in DOM. We use this to determine
		// if the Facebook SDK should be loaded.
		$args['data-type'] = 'xfbml-tag';

		// Allow other tags by default
		$attrs = self::implodeAttrs( $args );

		return "<{$tag}{$attrs}>" . $parser->recursiveTagParse( $text ) . "</$tag>";
	}

	/**
	 * Helper function to create name-value pairs from the list of attributes passed to the
	 * parser hook.
	 */
	private static function implodeAttrs( $args ) {
		$attrs = '';
		// The default action is to strip all event handlers and allow the tag
		foreach ( $args as $name => $value ) {
			// Disable all event handlers (e.g. onClick, onLogin)
			if ( substr( $name, 0, 2 ) == "on" ) {
				continue;
			}

			// Otherwise, pass the attribute through htmlspecialchars unmodified
			$attrs .= " $name=\"" . htmlspecialchars( $value ) . '"';
		}
		return $attrs;
	}
}
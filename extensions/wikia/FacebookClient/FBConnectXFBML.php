<?php
/*
 * Not a valid entry point, skip unless MEDIAWIKI is defined.
 */
if ( !defined( 'MEDIAWIKI' ) ) {
	die( 'This file is a MediaWiki extension, it is not a valid entry point' );
}


/**
 * Class FBConnectXFBML
 *
 * This class allows FBML (Facebook Markup Language, an extension to HTML) to
 * be incorporated into the wiki through XFBML.
 *
 * Adapted from the FBConnect MediaWiki extention.
 * @author Garrett Bruin, Sean Colombo, Liz Lee
 *
 */
class FBConnectXFBML {
	/**
	 * This function is the callback that the ParserFirstCallInit hook assigns
	 * to the parser whenever a supported FBML tag is encountered (like <fb:like-box>).
	 * Function createParserHook($tag) creates an anonymous (lambda-style)
	 * function that simply redirects to parserHook(), filling in the missing
	 * $tag argument with the $tag provided to createParserHook.
	 */
	static function parserHook($text, $args, $parser, $tag = '' ) {
		if( $tag == 'fb:like-box' && isset($args['profileid'] ) ){
			$args['profile_id'] = $args['profileid'];
			unset( $args['profileid'] );
		}

		// Allow other tags by default
		$attrs = self::implodeAttrs( $args );

		// load Facebook's JS API on demand (BugId:68983)
		if ($parser instanceof Parser) {
			/* @var $parser Parser */
			$parser->getOutput()->addModules('ext.wikia.FacebookClient.FBXML');
		}

		/* @var $parser DummyParser */
		return "<{$tag}{$attrs}>" . $parser->recursiveTagParse( $text ) . "</$tag>";
	}

	/**
	 * Helper function to create name-value pairs from the list of attributes passed to the
	 * parser hook.
	 */
	private static function implodeAttrs( $args ) {
		$attrs = "";
		// The default action is to strip all event handlers and allow the tag
		foreach( $args as $name => $value ) {
			// Disable all event handlers (e.g. onClick, onligin)
			if ( substr( $name, 0, 2 ) == "on" )
				continue;
			// Otherwise, pass the attribute through htmlspecialchars unmodified
			$attrs .= " $name=\"" . htmlspecialchars( $value ) . '"';
		}
		return $attrs;
	}

	/**
	 * Helper function for parserHook. Originally, all tags were directed to
	 * that function, but I had no way of knowing which tag provoked the function.
	 */
	static function createParserHook($tag) {
		$args = '$text,$args,$parser';
		$code = 'return FBConnectXFBML::parserHook($text,$args,$parser,\''.$tag.'\');';
		return create_function($args, $code);
	}

	/**
	 * Returns true if XFBML is enabled (i.e. $fbUseMarkup is not false).
	 * Defaults to true if $fbUseMarkup is not set.
	 */
	static function isEnabled() {
		global $fbUseMarkup;
		return !isset($fbUseMarkup) || $fbUseMarkup;
	}

	/**
	 * Returns the XFBML tags that Wikia supports
	 */
	static function availableTags() {
		if (!self::isEnabled()) {
			// If XFBML isn't enabled, then don't report any tags
			return array( );
		}

		$tags = ['fb:recommendations', 'fb:like-box'];

		// Reject discarded tags (that return an empty string) from Special:Version
		$tempParser = new DummyParser();
		foreach( $tags as $i => $tag ) {
			if ( self::parserHook('', [], $tempParser, $tag) == '' ) {
				unset( $tags[$i] );
			}
		}
		return $tags;
	}
}

/**
 * Class DummyParser
 *
 * Allows FBConnectXML::availableTags() to pre-sanatize the list of tags reported to
 * MediaWiki, excluding any tags that result in the tag being replaced by an empty
 * string.
 */
class DummyParser {
	// We don't pass any text in our testing, so this must return an empty string
	function recursiveTagParse() { return ''; }
}

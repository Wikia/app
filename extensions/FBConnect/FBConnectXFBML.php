<?php
/*
 * Copyright © 2008-2010 Garrett Brown <http://www.mediawiki.org/wiki/User:Gbruin>
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License along
 * with this program. If not, see <http://www.gnu.org/licenses/>.
 */


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
 * See: <http://wiki.developers.facebook.com/index.php/XFBML>
 */
class FBConnectXFBML {
	/**
	 * This function is the callback that the ParserFirstCallInit hook assigns
	 * to the parser whenever a FBML tag is encountered (like <fb:name>).
	 * Function createParserHook($tag) creates an anonymous (lambda-style)
	 * function that simply redirects to parserHook(), filling in the missing
	 * $tag argument with the $tag provided to createParserHook.
	 */
	static function parserHook($text, $args, &$parser, $tag = '' ) {
		global $fbAllowFacebookImages;
		switch ($tag) {
			case '':
				break; // Error: We shouldn't be here!
			
			// To implement a custom XFBML tag handler, simply case it here like so
			#case 'fb:login-button':
			case 'fb:login-button-perms':
			case 'fb:prompt-permission':
				// Disable these tags by returning an empty string
				break;
			case 'fb:serverfbml':
				// TODO: Is this safe? Does it respect $fbAllowFacebookImages?
				$attrs = self::implodeAttrs( $args );
				return "<fb:serverfbml{$attrs}>$text</fb:serverfbml>";
			case 'fb:profile-pic':
			case 'fb:photo':
			case 'fb:video':
				if (!$fbAllowFacebookImages) {
					break;
				}
				// Careful - no "break;" if $fbAllowFacebookImages is true
			default:
				// Allow other tags by default
				$attrs = self::implodeAttrs( $args );
				return "<{$tag}{$attrs}>" . $parser->recursiveTagParse( $text ) . "</$tag>";
		}
		// Strip the tag entirely
		return '';
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
		$args = '$text,$args,&$parser';
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
	 * Returns the availabe XFBML tags. For now, this is just an array copied from
	 * <http://wiki.developers.facebook.com/index.php/XFBML> and the second-to-last line in
	 * <http://static.ak.fbcdn.net/rsrc.php/zAE5U/lpkg/2netpns0/en_US/141/136684/js/connect.js.pkg.php>.
	 * Eventually, this method can be replaced with one that gathers these tags
	 * from the internet (e.g. by downloading an xml or js file) in real time.
	 * 
	 * This is necessary because the Facebook Platform is so new, and major updates
	 * are being pushed out every week. With such turmoil regarding the available tags
	 * and the features they offer, our list of tags should not be hardcoded into this file.
	 * 
	 * But for now... HELP! Where does Firefox pull in the XFBML tags in from??
	 * 
	 * After switching to the new JavaScript SDK, these will be the only tags
	 * implemented for a while: <http://github.com/facebook/connect-js/xfbml>.
	 *
	 * Newer documentation: http://developers.facebook.com/docs/reference/fbml/
	 */
	static function availableTags() {
		if (!self::isEnabled()) {
			// If XFBML isn't enabled, then don't report any tags
			return array( );
		}
		
		// XFBML tags in the beta version of the Facebook Connect JavaScript SDK
		// <http://wiki.github.com/facebook/connect-js/xfbml/5>
		$tags = array('fb:comments',
		              'fb:login-button',
		              'fb:bookmark',
		              'fb:recommendations',
		              'fb:activity-border-color',
		              'fb:add-profile-tab',
		              'fb:login-button-with-faces',
		              'fb:share-button',
		              'fb:fan',
		              'fb:activity',
		              'fb:live-stream',
		              'fb:profile-pic',
		              'fb:serverfbml',
		              'fb:login-button-perms',
		              'fb:like',
		              'fb:like-box',
		              'fb:name',
		              /*
		               * From the Facebook Developer's Wiki under the old JS library.
		               * Currently, these must be rendered in a <fb:serverFbml> tag.
		               * <http://wiki.developers.facebook.com/index.php/XFBML>
		               */
		              #'fb:connect-form',
		              #'fb:container',
		              #'fb:eventlink',
		              #'fb:grouplink',
		              #'fb:photo',
		              #'fb:prompt-permission',
		              #'fb:pronoun',
		              #'fb:unconnected-friends-count',
		              #'fb:user-status'
		              /*
		               * In 2008 I found these in the deprecated Facebook Connect
		               * JavaScript library, connect.js.pkg.php, though no documentation
		               * was available for them on the Facebook dev wiki. Will they be
		               * implemented in the new JS SDK?
		               */
		              #'fb:add-section-button',
		              #'fb:share-button',
		              #'fb:userlink',
		              #'fb:video',
		);
		
		// Reject discarded tags (that return an empty string) from Special:Version
		$tempParser = new DummyParser();
		foreach( $tags as $i => $tag ) {
			if ( self::parserHook('', array(), $tempParser, $tag) == '' ) {
				unset( $tags[$i] );
			}
		}
		// Allow other functions to modify the available XFBML tags
		wfRunHooks( 'XFBMLAvailableTags', array( &$tags ));
		return $tags;
	}
}


/**
 * Class DummyParser
 * 
 * Allows FBConnectXML::availableTags() to pre-sanatize the list of tags reported to
 * MediaWiki, excluding any tags that result in the tag being replaced by an empty
 * string. Sorry for the confusing summary here, its really late. =)
 */
class DummyParser {
	// We don't pass any text in our testing, so this must return an empty string
	function recursiveTagParse() { return ''; }
}

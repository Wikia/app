<?php
/**
 * ShoutBox - Adds a parser function for embedding your own shoutbox.
 *
 * @file
 * @ingroup Extensions
 * @author Jim R. Wilson
 * @author Jack Phoenix <jack@countervandalism.net>
 * @version 0.2.1
 * @copyright Copyright © 2007 Jim R. Wilson
 * @copyright Copyright © 2010-2011 Jack Phoenix
 * @license The MIT License - http://www.opensource.org/licenses/mit-license.php
 * -----------------------------------------------------------------------
 * Description:
 *	 This is a MediaWiki extension which adds a parser function for embedding
 *	 your own shoutbox into a page.
 * Requirements:
 *	 MediaWiki 1.16+
 * Installation:
 *	 1. Drop the files in $IP/extensions/ShoutBox
 *		 Note: $IP is your MediaWiki install dir.
 *	 2. Enable the extension by adding this line to your LocalSettings.php:
 *		 require_once( $IP . '/extensions/ShoutBox/ShoutBox.php' );
 * Version Notes:
 *	 version 0.1:
 *		 Initial release.
 * -----------------------------------------------------------------------
 * Copyright © 2007 Jim R. Wilson
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights to
 * use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of
 * the Software, and to permit persons to whom the Software is furnished to do
 * so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,
 * EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES
 * OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND
 * NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT
 * HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY,
 * WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING
 * FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR
 * OTHER DEALINGS IN THE SOFTWARE.
 * -----------------------------------------------------------------------
 */

# Confirm MW environment
if( !defined( 'MEDIAWIKI' ) ) {
	die( "This is an extension to the MediaWiki package and cannot be run standalone." );
}

# Credits
$wgExtensionCredits['parserhook'][] = array(
        'path' =>  __FILE__,
	'name' => 'ShoutBox',
	'version' => '0.3.0',
	'author' => array( 'Jim R. Wilson', 'Jack Phoenix' ),
	'url' => 'https://www.mediawiki.org/wiki/Extension:ShoutBox',
	'descriptionmsg' => 'shoutbox-desc',
);

// Configuration settings
$wgShoutBoxMinWidth = 100;

$wgShoutBoxMaxWidth = 600;

$wgShoutBoxMinHeight = 100;

$wgShoutBoxMaxHeight = 1024;

$wgShoutBoxDefaultId = false;

$wgShoutBoxCSS = false;

// Internationalization file
$dir = dirname( __FILE__ ) . '/';
$wgExtensionMessagesFiles['ShoutBox'] = $dir . 'ShoutBox.i18n.php';
$wgExtensionMessagesFiles['ShoutBoxMagic'] = $dir . 'ShoutBox.i18n.magic.php';

// Hooked functions
$wgHooks['ParserFirstCallInit'][] = 'ShoutBox::setup';
$wgHooks['ParserBeforeTidy'][] = 'ShoutBox::placeholderCorrections';

// @todo FIXME: Move classes out of the init file.

/**
 * Wrapper class for encapsulating ShoutBox related parser methods
 */
class ShoutBox {
	/**
	 * Sets up parser functions.
	 *
	 * @param $parser Object: instance of running Parser.
	 * @return Boolean: true
	 */
	public static function setup( &$parser ) {
		# Setup parser hook
		$parser->setFunctionHook( 'shoutbox', array( 'ShoutBox', 'parserFunction' ) );
		return true;
	}

	/**
	 * Embeds ShoutBox
	 *
	 * @param $parser Object: Instance of running Parser.
	 * @param $id Integer: Identifier of the ShoutBox (optional - if global default is available)
	 * @param $width Integer: Width of box (optional)
	 * @param $height Integer: Height of box (optional)
	 * @return String: encoded representation of input params (to be processed later)
	 */
	public static function parserFunction( $parser, $id = null, $width = null, $height = null ) {
		$params = array(
			'id' => trim( $id ),
			'width' => ( $width === null ? null : trim( $width ) ),
			'height' => ( $height === null ? null : trim( $height ) )
		);
		return '<pre>@SBCONTENT@' . base64_encode( serialize( $params ) ) . '@SBCONTENT@</pre>';
	}

	/**
	 * Performs placeholder corrections to bypass MW parser function output
	 * restraints.
	 *
	 * @param $parser Object: Instance of running Parser.
	 * @param $text String: Text of nearly fully rendered wikitext.
	 * @return Boolean: always true
	 */
	public static function placeholderCorrections( $parser, $text ) {
		$text = preg_replace_callback(
			'|<pre>@SBCONTENT@([0-9a-zA-Z\\+\\/]+=*)@SBCONTENT@</pre>|',
			array( 'ShoutBox', 'processShoutBoxParams' ),
			$text
		);
		return true;
	}

	/**
	 * Performs placeholder corrections to bypass MW parser function output
	 * restraints.
	 *
	 * @param $matches Array: An array of matches to the placeholder regular expression.
	 * @return String: embedded shoutbox if params are sane|error message
	 */
	public static function processShoutBoxParams( $matches ) {
		global $wgShoutBoxMinWidth, $wgShoutBoxMaxWidth;
		global $wgShoutBoxMinHeight, $wgShoutBoxMaxHeight;
		global $wgShoutBoxDefaultId, $wgShoutBoxCSS;

		$params = @unserialize( @base64_decode( $matches[1] ) );
		if( !$params ) {
			return '<div class="errorbox">' .
				wfMsg( 'shoutbox-unparsable-param-string', @htmlspecialchars( $matches[1] ) ) .
			'</div>';
		}

		$id = $params['id'];
		if( $id === null ) {
			$id = $wgShoutBoxDefaultId;
		}

		if( $id == null || !is_numeric( $id ) ) {
			return '<div class="errorbox">' .
				wfMsg( 'shoutbox-bad-id', @htmlspecialchars( $id ) ) .
			'</div>';
		}

		# Build URL and output embedded iframe
		$width = 150;
		$height = 300;

		# Retrieve and check width
		if( $params['width'] !== null ) {
			if (
				!is_numeric( $params['width'] ) ||
				$params['width'] < $wgShoutBoxMinWidth ||
				$params['width'] > $wgShoutBoxMaxWidth
			) {
				return '<div class="errorbox">' .
					wfMsg( 'shoutbox-illegal-width', @htmlspecialchars( $params['width'] ) ) .
				'</div>';
			}
			$width = $params['width'];
		}

		# Retrieve and check height
		if( $params['height'] !== null ) {
			if (
				!is_numeric( $params['height'] ) ||
				$params['height'] < $wgShoutBoxMinWidth ||
				$params['height'] > $wgShoutBoxMaxWidth
			)
			{
				return '<div class="errorbox">' .
					wfMsg( 'shoutbox-illegal-height', @htmlspecialchars( $params['height'] ) ) .
				'</div>';
			}
			$height = $params['height'];
		}

		if( $wgShoutBoxCSS ) {
			$url = wfMsgForContent( 'shoutbox-url-with-css', $id, urlencode( $wgShoutBoxCSS ) );
		} else {
			$url = wfMsgForContent( 'shoutbox-url', $id );
		}

		return '<iframe src="' . $url . '" width="' . $width . '" height="' .
			$height . '" frameborder="0" allowTransparency="true"></iframe>';
	}

}
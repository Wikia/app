<?php
/**
 * CSS extension - A parser-function for adding CSS to articles via file,
 * article or inline rules.
 *
 * See http://www.mediawiki.org/wiki/Extension:CSS for installation and usage
 * details.
 *
 * @file
 * @ingroup Extensions
 * @version 2.0
 * @author Aran Dunkley [http://www.organicdesign.co.nz/nad User:Nad]
 * @author Rusty Burchfield
 * @copyright © 2007-2010 Aran Dunkley
 * @copyright © 2011 Rusty Burchfield
 * @licence GNU General Public Licence 2.0 or later
 */

if ( !defined( 'MEDIAWIKI' ) ) {
	die( 'Not an entry point.' );
}

define( 'CSS_VERSION', '3.1, 2012-01-15' );

$wgCSSPath = false;
$wgCSSIdentifier = 'css-extension';

$wgHooks['ParserFirstCallInit'][] = 'wfCSSParserFirstCallInit';
$wgHooks['RawPageViewBeforeOutput'][] = 'wfCSSRawPageViewBeforeOutput';

$wgExtensionCredits['parserhook'][] = array(
	'path'           => __FILE__,
	'name'           => 'CSS',
	'author'         => array ( 'Aran Dunkley', 'Rusty Burchfield' ),
	'descriptionmsg' => 'css-desc',
	'url'            => 'https://www.mediawiki.org/wiki/Extension:CSS',
	'version'        => CSS_VERSION,
);

$wgExtensionMessagesFiles['CSS'] = dirname( __FILE__ ) . '/' . 'CSS.i18n.php';
$wgExtensionMessagesFiles['CSSMagic'] = dirname( __FILE__ ) . '/' . 'CSS.i18n.magic.php';

$wgResourceModules['ext.CSS'] = array(
	'scripts' => 'verifyCSSLoad.js',
	'localBasePath' => dirname( __FILE__ ),
	'remoteExtPath' => 'CSS',
);

function wfCSSRender( &$parser, $css ) {
	global $wgCSSPath, $wgStylePath, $wgCSSIdentifier;

	$css = trim( $css );
	$title = Title::newFromText( $css );
	$rawProtection = "$wgCSSIdentifier=1";
	$headItem = '<!-- Begin Extension:CSS -->';

	if ( is_object( $title ) && $title->exists() ) {
		# Article actually in the db
		$params = "action=raw&ctype=text/css&$rawProtection";
		$url = $title->getLocalURL( $params );
		$headItem .= HTML::linkedStyle( $url );
	} elseif ( $css[0] == '/' ) {
		# Regular file
		$base = $wgCSSPath === false ? $wgStylePath : $wgCSSPath;
		$url = wfAppendQuery( $base . $css, $rawProtection );

		# Verify the expanded URL is still using the base URL
		if ( strpos( wfExpandUrl( $url ), wfExpandUrl( $base ) ) === 0 ) {
			$headItem .= HTML::linkedStyle( $url );
		} else {
			$headItem .= '<!-- Invalid/malicious path  -->';
		}
	} else {
		# Inline CSS; use data URI to prevent injection.  JavaScript
		# will use a canary to verify load and will safely convert to
		# style tag if load fails.

		# Generate random CSS color that isn't black or white.
		$color = dechex( mt_rand( 1, hexdec( 'fffffe' ) ) );
		$color = str_pad( $color, 6, '0', STR_PAD_LEFT );

		# Prepend canary CSS to sanitized user CSS
		$canaryId = "$wgCSSIdentifier-canary-$color";
		$canaryCSS = "#$canaryId{background:#$color !important}";
		$css = $canaryCSS . Sanitizer::checkCss( $css );

		# Encode data URI and append link tag
		$dataPrefix = 'data:text/css;charset=UTF-8;base64,';
		$url = $dataPrefix . base64_encode( $css );
		$headItem .= HTML::linkedStyle( $url );

		# Calculate URI prefix to match link tag
		$hrefPrefix = $dataPrefix . base64_encode( '#' . $canaryId );
		$hrefPrefix = substr( $url, 0, strlen( $hrefPrefix ) );

		# Add JS to verify the link tag loaded and fallback if needed
		$parser->getOutput()->addModules( 'ext.CSS' );
		$headItem .= HTML::inlineScript( <<<INLINESCRIPT
jQuery( function( $ ) {
	$( 'link[href^="$hrefPrefix"]' )
		.cssExtensionDataURIFallback( '$canaryId', '$color' );
} );
INLINESCRIPT
		);
	}

	$headItem .= '<!-- End Extension:CSS -->';
	$parser->getOutput()->addHeadItem( $headItem );
	return '';
}

function wfCSSParserFirstCallInit( $parser ) {
	$parser->setFunctionHook( 'css', 'wfCSSRender' );
	return true;
}

function wfCSSRawPageViewBeforeOutput( &$rawPage, &$text ) {
	global $wgCSSIdentifier;

	if ( $rawPage->getRequest()->getBool( $wgCSSIdentifier ) ) {
		$text = Sanitizer::checkCss( $text );
	}
	return true;
}

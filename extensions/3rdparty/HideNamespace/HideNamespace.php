<?php

/**
 * Extension HideNamespace - Hides namespace in the header and title when a page is in specified namespace
 * or when the {{#hidens:}} parser function is called.
 *
 * @package MediaWiki
 * @subpackage Extensions
 * @author Matěj Grabovský, mgrabovsky@yahoo.com
 * @copyright © 2009 Matěj Grabovský
 * @licence GNU General Public Licence 2.0 or later
 */

if( !defined('MEDIAWIKI') ) {
	echo( "This file is an extension to the MediaWiki software and cannot be used standalone.\n" );
	die();
}

$wgExtensionMessagesFiles['HideNamespace'] = dirname(__FILE__) . '/HideNamespace.i18n.php';
$wgExtensionMessagesFiles['HideNamespaceMagic'] = dirname(__FILE__) . '/HideNamespace.i18n.magic.php';

$wgExtensionFunctions[] = 'wfHideNamespaceSetup';
$wgExtensionCredits['other'][] = array(
	'path'           => __FILE__,
	'name'           => "HideNamespace",
	'description'    => "Hides namespace in the header and title when a page is in specified namespace or when the <tt><nowiki>{{#hidens:}}</nowiki></tt> parser function is called.",
	'descriptionmsg' => "hidens-desc",
	'version'        => "1.1",
	'author'         => "Mat&#283;j Grabovsk&#253;",
	'url'            => "http://www.mediawiki.org/wiki/Extension:HideNamespace",
);

function wfHideNamespaceSetup() {
	global $wgParser, $wgHooks;

	$extHidensObj = new ExtensionHideNamespace;

	// Register hooks
	$wgHooks['ArticleViewHeader'][]    = array( $extHidensObj, 'onArticleViewHeader' );
	$wgHooks['OutputPageBeforeHTML'][] = array( $extHidensObj, 'onOutputPageBeforeHTML' );

	// If we support ParserFirstCallInit, hook our function to register PF hooks with it
	if( defined('MW_SUPPORTS_PARSERFIRSTCALLINIT') ) {
		$wgHooks['ParserFirstCallInit'][] = array( $extHidensObj, 'RegisterParser' );

	// Else manualy unstub Parser and call our function
	} else {
		if( class_exists( 'StubObject' ) && !StubObject::isRealObject( $wgParser ) ) {
			$wgParser->_unstub();
		}
		$extHidensObj->RegisterParser( $wgParser );
	}
}

/**
 * I've chosen to make it to a class, beacuse it looked horrible with globals.
 */
class ExtensionHideNamespace {
	private static $ns, $nsLoc;
	private static $hideInCurrent = true;

	/**
	 * Register our parser functions.
	 */
	function RegisterParser( &$parser ) {
		$parser->setFunctionHook( 'hidens', array( $this, 'HidensPf' ) );
		$parser->setFunctionHook( 'unhidens', array( $this, 'UnhidensPf' ) );

		return true;
	}

	/**
	 * Callback for our parser function {{#hidens:}}.
	 * Force to hide the namespace.
	 */
	function HidensPf( &$parser ) {
		self::$hideInCurrent = true;

		return '';
	}

	/**
	 * Callback for our parser function {{#unhidens:}}.
	 * Force to *not* hide the namespace.
	 */
	function UnhidensPf( &$parser ) {
		self::$hideInCurrent = false;

		return '';
	}

	/**
	 * Callback for the ArticleViewHeader hook.
	 * Saves namespace identifier and localized namespace name to the $ns and $nsLoc variables.
	 */
	function onArticleViewHeader( $article, $outputDone, $pcache ) {
		self::$ns = $article->mTitle->mNamespace;

		if( self::$ns == NS_MAIN ) {
			self::$nsLoc = "";
		} else {
			self::$nsLoc = substr( $article->mTitle->getPrefixedText(), 0, strpos($article->mTitle->getPrefixedText(),':') );
		}

		return true;
	}

	/**
	 * Callback for the OutputPageBeforeHTML hook.
	 * "Hides" the namespace in the header and in title.
	 */
	function onOutputPageBeforeHTML( &$out, $text ) {
		global $wgHideNsNamespaces;

		// Hide the namespace if:
		// * The page's namespace is contained in the $wgHideNsNamespaces array
		//  or
		// * The {{#hidens:}} function was called
		// BUT *not* when the {{#unhidens:}} function was called
		//
		// (Let's assume the user calls either hidens or unhidens, not both at the same time,
		// otherwise the latest called would be decisive, of course.)
		$inGlob     = isset($wgHideNsNamespaces) && in_array(self::$ns,$wgHideNsNamespaces);
		$hideInCur  = self::$hideInCurrent;

		if( self::$ns !== NS_MAIN && ( ($inGlob && $hideInCur) || (!$inGlob && $hideInCur) ) )
		{
			$out->mPagetitle = substr( $out->mPagetitle, strlen(self::$nsLoc)+1 );
			$out->mHTMLtitle = str_replace( self::$nsLoc.':'.$out->getPageTitle(), $out->mPagetitle, $out->mHTMLtitle );
		}

		return true;
	}
}

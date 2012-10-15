<?php

/**
 * Extension HideNamespace
 * Allows hiding namespace in the page title.
 *
 * @file
 * @ingroup Extensions
 * @author Matěj Grabovský (mgrabovsky.github.com)
 * @license GNU General Public Licence 2.0 or later
 */

if( !defined( 'MEDIAWIKI' ) ) {
	echo 'This file is an extension to the MediaWiki software and ',
		'cannot be used standalone.', PHP_EOL;
	die();
}

$dir = dirname( __FILE__ ) . DIRECTORY_SEPARATOR;
$wgExtensionMessagesFiles['HideNamespace'] = $dir . 'HideNamespace.i18n.php';
$wgExtensionMessagesFiles['HideNamespaceMagic'] = $dir . 'HideNamespace.i18n.magic.php';

$wgExtensionCredits['other'][] = array(
	'path'           => __FILE__,
	'name'           => 'HideNamespace',
	'descriptionmsg' => 'hidens-desc',
	'version'        => '1.4.3',
	'author'         => 'Matěj Grabovský',
	'url'            => 'https://www.mediawiki.org/wiki/Extension:HideNamespace',
);

$wgHidensNamespaces = array();

$wgHooks['ParserFirstCallInit'][] = 'ExtensionHideNamespace::registerParser';
$wgHooks['ArticleViewHeader'][] = 'ExtensionHideNamespace::onArticleViewHeader';
$wgHooks['BeforePageDisplay'][] = 'ExtensionHideNamespace::onBeforePageDisplay';

class ExtensionHideNamespace {
	private static $namespaceText;
	private static $hide = null;

	/**
	 * Register the parser functions
	 */
	public static function registerParser( $parser ) {
		$parser->setFunctionHook( 'hidens', array( __CLASS__, 'hideNs' ) );
		$parser->setFunctionHook( 'showns', array( __CLASS__, 'showNs' ) );

		return true;
	}

	/**
	 * Callback for our parser function {{#hidens:}}
	 */
	public static function hideNs() {
		self::$hide = true;

		return null;
	}

	/**
	 * Callback for our parser function {{#showns:}}
	 */
	public static function showNs() {
		self::$hide = false;

		return null;
	}

	/**
	 * Callback for the ArticleViewHeader hook.
	 *
	 * Retrieves the namespace and localized namespace text and decides whether the
	 * namespace should be hidden
	 */
	public static function onArticleViewHeader( $article ) {
		global $wgHidensNamespaces, $wgContLang;

		$namespace = $article->getTitle()->getNamespace();
		self::$namespaceText = $wgContLang->getNsText( $namespace );

		if( $namespace == NS_MAIN ) {
			self::$hide = false;
		} else {
			/**
			* Hide namespace if either
			* -  it was forced by user (with {{#hidens:}}) or
			* -  the current namespace is in $wgHidensNamespaces AND
			*      {{#showns:}} wasn't called
			*/
			$visibilityForced = !is_null( self::$hide );
			$hideByUser = $visibilityForced && self::$hide;
			$hideBySetting = in_array( $namespace, $wgHidensNamespaces );

			self::$hide = $hideByUser || ( $hideBySetting && self::$hide !== false );
		}

		return true;
	}

	/**
	 * Callback for the BeforePageDisplay hook
	 *
	 * Removes the namespace from article header and page title
	 */
	public static function onBeforePageDisplay( $out ) {
		if( self::$hide ) {
			$out->setPageTitle( mb_substr( $out->getPageTitle(),
				mb_strlen( self::$namespaceText ) + 1 ) );
		}

		return true;
	}
}


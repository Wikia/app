<?php

/**
 * Extension HasCategory - Ehances parser with ability to find out whether a page is contained
 * within a category with the {{#ifhascat:}} parser function.
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

$wgExtensionMessagesFiles['HasCategory'] = dirname(__FILE__) . '/HasCategory.i18n.php';
$wgExtensionMessagesFiles['HasCategoryMagic'] = dirname(__FILE__) . '/HasCategory.i18n.magic.php';

$wgExtensionFunctions[] = 'wfHasCategorySetup';
$wgExtensionCredits['parserhook'][] = array(
	'path'           => __FILE__,
	'name'           => "HasCategory",
	'description'    => "Ehances parser with ability to find out whether a page is contained within a category with the <tt><nowiki>{{#ifhascat:}}</nowiki></tt> parser function.",
	'descriptionmsg' => "hascategory-desc",
	'version'        => "0.10",
	'author'         => "Mat&#283;j Grabovsk&#253;",
	'url'            => "http://www.mediawiki.org/wiki/Extension:HasCategory",
);

function wfHasCategorySetup() {
	global $wgParser, $wgHooks;

	$extHasCatObj = new ExtensionHasCategory;

	// Register hooks
	$wgHooks['LanguageGetMagic'][] = array( $extHasCatObj, 'onLanguageGetMagic' );

	// If we support ParserFirstCallInit, hook our function to register PF hook with it
	if( defined('MW_SUPPORTS_PARSERFIRSTCALLINIT') ) {
		$wgHooks['ParserFirstCallInit'][] = array( $extHasCatObj, 'RegisterParser' );

	// Else manualy unstub Parser and call our function
	} else {
		if( class_exists( 'StubObject' ) && !StubObject::isRealObject( $wgParser ) ) {
			$wgParser->_unstub();
		}
		$extHasCatObj->RegisterParser( $wgParser );
	}
}

class ExtensionHasCategory {

	/**
	 * Register our parser function.
	 *
	 * @param Parser $parser
	 */
	function RegisterParser( &$parser ) {
		if ( defined( get_class( $parser ) . '::SFH_OBJECT_ARGS' ) ) {
			// These functions accept DOM-style arguments
			$parser->setFunctionHook( 'ifhascat', array( &$this, 'IfhascatPfObj' ), SFH_OBJECT_ARGS );
		} else {
			$parser->setFunctionHook( 'ifhascat', array( &$this, 'IfhascatPf' ) );
		}

		return true;
	}

	/**
	 * Just "redirect" to $this->IfhascatPf().
	 *
	 * @param Parser $parser
	 * @param PPFrame $frame
	 */
	function IfhascatPfObj( &$parser, $frame, $args ) {
		$page     = isset($args[0]) ? trim($frame->expand($args[0])) : '';
		$category = isset($args[1]) ? trim($frame->expand($args[1])) : '';
		$then     = isset($args[2]) ? trim($frame->expand($args[2])) : '1';
		$else     = isset($args[3]) ? trim($frame->expand($args[3])) : '0';

		return $this->IfhascatPf(
			$parser,
			$page,     // if *page*
			$category, // in *category*
			$then,     // *then*
			$else );   // *else*
	}

	/**
	 * Callback to our function {{#ifhascat:}}.
	 * Here we find out whether the page is really contained in the category.
	 * If yes return $then (default: 1) else return $else (default: 0).
	 */
	function IfhascatPf( &$parser, $page = '', $category = '', $then = '1', $else = '0' ) {
		// Connect to the database
		$dbr = wfGetDB( DB_SLAVE );

		// Make title object of our page
		$title    = Title::newFromText( $page );
		// If the page doesn't exist (or an error occur) return $else (0 by default)
		if( !$title )	return $else;

		// Replace spaces with '_' in the category name
		$catname  = str_replace( ' ', '_', $category );

		// Does the requested page have the specified category?
		if( $dbr->selectField(
			'categorylinks',
			'cl_from',
			array(
				'cl_from' => $title->getArticleID(),
				'cl_to' => $catname ) ) )
		{
			// Then return $then
			return $then;
		} else {
			// Else return $else
			return $else;
		}
	}
}

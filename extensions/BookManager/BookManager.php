<?php
/**
 * This extension defines navigation in subpages.
 *
 * Defines the following functions:
 * - PREVPAGENAME		(get prev page)
 * - PREVPAGENAMEE		(get prev page encode)
 * - NEXTPAGENAME		(get next page)
 * - NEXTPAGENAMEE		(get next page encode)
 * - ROOTPAGENAME		(get root page)
 * - ROOTPAGENAMEE		(get root page encode)
 * - CHAPTERNAME		(get chapter)
 * - CHAPTERNAMEE		(get chapter encode)
 * - RANDOMCHAPTER		(get random page)
 * - RANDOMCHAPTERE		(get random page encode)
 * @addtogroup Extensions
 * @author Raylton P. Sousa
 * @author Helder.wiki
 * @copyright Copyright © 2011 Raylton P. Sousa <raylton.sousa@gmail.com>
 * @copyright Copyright © 2011 Helder.wiki
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 3.0 or later
*/

if ( !defined( 'MEDIAWIKI' ) ) {
	die( 'This file is a MediaWiki extension, it is not a valid entry point' );
}
$wgBookSidebarSection = true;
$wgBookManagerNamespaces = array( NS_MAIN );
$wgBookManagerVariables = true ;
$wgBookManagerNavBar = true;
$wgCategorizeSubPages = true;
$wgCategorizeRootPages = true;
/* Copyied from extensions/Collection/Collection.php */
/** Namespace for "community books" */
$wgBookManagerPrefixNamespace = NS_PROJECT;

$dir = dirname( __FILE__ );
$wgParserTestFiles[] = $dir . "/BookManagerParserTests.txt";
$wgAutoloadClasses['BookManagerCore'] = $dir . '/BookManager.body.php';
$wgAutoloadClasses['BookManagerNavBar'] = $dir . '/BookManager.body.php';
$wgAutoloadClasses['PrintVersion'] = $dir . '/BookManager.body.php';
$wgSpecialPages['PrintVersion'] = 'PrintVersion';
$wgSpecialPageGroups['PrintVersion'] = 'other';

$wgExtensionMessagesFiles['BookManager'] = $dir . '/language/BookManager.i18n.php';
$wgExtensionMessagesFiles['BookManagerMagic'] = $dir . '/language/BookManager.i18n.magic.php';
$wgExtensionMessagesFiles['BookManagerAlias'] = $dir . '/language/BookManager.alias.php';



/**** extension basics ****/
$wgExtensionCredits['parserhook'][] = array(
	'path'		=> __FILE__,
	'name'		=> 'BookManager',
	'version'	=>  BookManagerCore::VERSION,
	'author'	=>  array( 'Raylton P. Sousa', 'Helder.wiki' ),
	'url'		=> 'http://www.mediawiki.org/wiki/Extension:BookManager',
	'descriptionmsg' => 'bookmanager-desc'
);
/* Add CSS and JS */
$wgResourceModules['ext.BookManager'] = array(
	'scripts'	=> array( 'jquery.hotkeys.js', 'bookmanager.js' ),
	'styles'	=> 'bookmanager.css',
	'messages'	=> array( 'BookManager', 'BookManager-top', 'BookManager-bottom' ),
	'dependencies'	=> array( 'jquery', 'mediawiki.util' ),
	'localBasePath'	=> $dir . '/client',
	'remoteExtPath'	=> 'BookManager/client'
);

/**** Register magic words ****/
if ( $wgBookManagerVariables ) {
$wgAutoloadClasses['BookManagerVariables'] = $dir . '/BookManager.body.php';

$wgHooks['ParserFirstCallInit'][] = 'BookManagerVariables::register';

$wgHooks['MagicWordwgVariableIDs'][] = 'BookManagerVariables::DeclareVarIds';

$wgHooks['ParserGetVariableValueSwitch'][] = 'BookManagerVariables::AssignAValue';
}
/**** Navbar ****/

$wgHooks['BeforePageDisplay'][] = 'BookManagerNavBar::addNavBar';
/****  Toolbox Section ***/
// $wgHooks['SkinTemplateToolboxEnd'][] = 'BookManagerNavBar::bookToolboxSection';
$wgHooks['BaseTemplateToolbox'][] = 'BookManagerNavBar::bookToolboxSection';
/*** Cat ***/
$wgHooks['ParserAfterTidy'][] = 'BookManagerNavBar::CatByPrefix';


<?php

/**
 * Setup and Hooks for the CategoryTree extension, an AJAX based gadget
 * to display the category structure of a wiki
 *
 * @addtogroup Extensions
 * @author Daniel Kinzler, brightbyte.de
 * @copyright © 2006-2008 Daniel Kinzler and others
 * @license GNU General Public Licence 2.0 or later
 */

if( !defined( 'MEDIAWIKI' ) ) {
	echo( "This file is an extension to the MediaWiki software and cannot be used standalone.\n" );
	die( 1 );
}

/**
* Constants for use with the mode,
* defining what should be shown in the tree
*/
define('CT_MODE_CATEGORIES', 0);
define('CT_MODE_PAGES', 10);
define('CT_MODE_ALL', 20);
define('CT_MODE_PARENTS', 100);

/**
* Constants for use with the hideprefix option,
* defining when the namespace prefix should be hidden
*/
define('CT_HIDEPREFIX_NEVER', 0);
define('CT_HIDEPREFIX_ALWAYS', 10);
define('CT_HIDEPREFIX_CATEGORIES', 20);
define('CT_HIDEPREFIX_AUTO', 30);

/**
 * Options:
 *
 * $wgCategoryTreeMaxChildren - maximum number of children shown in a tree node. Default is 200
 * $wgCategoryTreeAllowTag - enable <categorytree> tag. Default is true.
 * $wgCategoryTreeDynamicTag - loads the first level of the tree in a <categorytag> dynamically.
 *                             This way, the cache does not need to be disabled. Default is false.
 * $wgCategoryTreeDisableCache - disabled the parser cache for pages with a <categorytree> tag. Default is true.
 * $wgCategoryTreeUseCache - enable HTTP cache for anon users. Default is false.
 * $wgCategoryTreeMaxDepth - maximum value for depth argument; An array that maps mode values to
 *                           the maximum depth acceptable for the depth option.
 *                           Per default, the "categories" mode has a max depth of 2,
 *                           all other modes have a max depth of 1.
 * $wgCategoryTreeDefaultOptions - default options for the <categorytree> tag.
 * $wgCategoryTreeCategoryPageOptions - options to apply on category pages.
 * $wgCategoryTreeSpecialPageOptions - options to apply on Special:CategoryTree.
 */

if (empty($wgCategoryTreeMaxChildren)) $wgCategoryTreeMaxChildren = 200;
$wgCategoryTreeAllowTag = true;
$wgCategoryTreeDisableCache = true;
$wgCategoryTreeDynamicTag = false;
$wgCategoryTreeHTTPCache = false;
#$wgCategoryTreeUnifiedView = true;
$wgCategoryTreeMaxDepth = array(CT_MODE_PAGES => 1, CT_MODE_ALL => 1, CT_MODE_CATEGORIES => 2);

# Set $wgCategoryTreeForceHeaders to true to force the JS and CSS headers for CategoryTree to be included on every page. 
# May be usefull for using CategoryTree from within system messages, in the sidebar, or a custom skin.
$wgCategoryTreeForceHeaders = false; 
$wgCategoryTreeSidebarRoot = NULL;
$wgCategoryTreeHijackPageCategories = false; # EXPERIMENTAL! NOT YET FOR PRODUCTION USE! Main problem is general HTML/CSS layout cruftiness.

$wgCategoryTreeExtPath = $wgExtensionsPath . '/CategoryTree'; # Wikia change - RT #11231
$wgCategoryTreeVersion = '5';  #NOTE: bump this when you change the CSS or JS files!
$wgCategoryTreeUseCategoryTable = version_compare( $wgVersion, "1.13", '>=' );

$wgCategoryTreeOmitNamespace = CT_HIDEPREFIX_CATEGORIES;
$wgCategoryTreeDefaultMode = CT_MODE_CATEGORIES;
$wgCategoryTreeDefaultOptions = array(); #Default values for most options. ADD NEW OPTIONS HERE!
$wgCategoryTreeDefaultOptions['mode'] = NULL; # will be set to $wgCategoryTreeDefaultMode in efCategoryTree(); compatibility quirk
$wgCategoryTreeDefaultOptions['hideprefix'] = NULL; # will be set to $wgCategoryTreeDefaultMode in efCategoryTree(); compatibility quirk
$wgCategoryTreeDefaultOptions['showcount'] = false;
$wgCategoryTreeDefaultOptions['namespaces'] = false; # false means "no filter"

$wgCategoryTreeCategoryPageMode = CT_MODE_CATEGORIES;
$wgCategoryTreeCategoryPageOptions = array(); #Options to be used for category pages
$wgCategoryTreeCategoryPageOptions['mode'] = NULL; # will be set to $wgCategoryTreeDefaultMode in efCategoryTree(); compatibility quirk
$wgCategoryTreeCategoryPageOptions['showcount'] = true;

$wgCategoryTreeSpecialPageOptions = array(); #Options to be used for Special:CategoryTree
$wgCategoryTreeSpecialPageOptions['showcount'] = true;

$wgCategoryTreeSidebarOptions = array(); #Options to be used in the sidebar (for use with $wgCategoryTreeSidebarRoot)
$wgCategoryTreeSidebarOptions['mode'] = CT_MODE_CATEGORIES;
$wgCategoryTreeSidebarOptions['hideprefix'] = CT_HIDEPREFIX_CATEGORIES;
$wgCategoryTreeSidebarOptions['showcount'] = false;
$wgCategoryTreeSidebarOptions['hideroot'] = true;
$wgCategoryTreeSidebarOptions['namespaces'] = false; 
$wgCategoryTreeSidebarOptions['depth'] = 1;

$wgCategoryTreePageCategoryOptions = array(); #Options to be used in the sidebar (for use with $wgCategoryTreePageCategories)
$wgCategoryTreePageCategoryOptions['mode'] = CT_MODE_PARENTS;
$wgCategoryTreePageCategoryOptions['hideprefix'] = CT_HIDEPREFIX_CATEGORIES;
$wgCategoryTreePageCategoryOptions['showcount'] = false;
$wgCategoryTreePageCategoryOptions['hideroot'] = false;
$wgCategoryTreePageCategoryOptions['namespaces'] = false;
$wgCategoryTreePageCategoryOptions['depth'] = 0;
#$wgCategoryTreePageCategoryOptions['class'] = 'CategoryTreeInlineNode';

$wgExtensionAliasesFiles['CategoryTree'] = dirname(__FILE__) . '/CategoryTreePage.i18n.alias.php';

/**
 * Register extension setup hook and credits
 */
$wgExtensionFunctions[] = 'efCategoryTree';
$wgExtensionCredits['specialpage'][] = array(
	'name' => 'CategoryTree',
	'svn-date' => '$LastChangedDate: 2009-03-09 12:54:39 +0100 (pon, 09 mar 2009) $',
	'svn-revision' => '$LastChangedRevision: 48218 $',
	'author' => 'Daniel Kinzler',
	'url' => 'http://www.mediawiki.org/wiki/Extension:CategoryTree',
	'description' => 'Dynamically navigate the category structure',
	'descriptionmsg' => 'categorytree-desc',
);
$wgExtensionCredits['parserhook'][] = array(
	'name' => 'CategoryTree',
	'svn-date' => '$LastChangedDate: 2009-03-09 12:54:39 +0100 (pon, 09 mar 2009) $',
	'svn-revision' => '$LastChangedRevision: 48218 $',
	'author' => 'Daniel Kinzler',
	'url' => 'http://www.mediawiki.org/wiki/Extension:CategoryTree',
	'description' => 'Dynamically navigate the category structure',
	'descriptionmsg' => 'categorytree-desc',
);

/**
 * Register the special page
 */
$dir = dirname(__FILE__) . '/';
$wgExtensionMessagesFiles['CategoryTree'] = $dir . 'CategoryTree.i18n.php';
$wgAutoloadClasses['CategoryTreePage'] = $dir . 'CategoryTreePage.php';
$wgAutoloadClasses['CategoryTree'] = $dir . 'CategoryTreeFunctions.php';
$wgAutoloadClasses['CategoryTreeCategoryPage'] = $dir . 'CategoryPageSubclass.php';
$wgSpecialPages['CategoryTree'] = 'CategoryTreePage';
$wgSpecialPageGroups['CategoryTree'] = 'pages';
#$wgHooks['SkinTemplateTabs'][] = 'efCategoryTreeInstallTabs';
$wgHooks['ArticleFromTitle'][] = 'efCategoryTreeArticleFromTitle';
$wgHooks['LanguageGetMagic'][] = 'efCategoryTreeGetMagic';

/**
 * register Ajax function
 */
$wgAjaxExportList[] = 'efCategoryTreeAjaxWrapper';

/**
 * Hook it up
 */
function efCategoryTree() {
	global $wgUseAjax, $wgHooks, $wgOut;
	global $wgCategoryTreeDefaultOptions, $wgCategoryTreeDefaultMode, $wgCategoryTreeOmitNamespace;
	global $wgCategoryTreeCategoryPageOptions, $wgCategoryTreeCategoryPageMode;
	global $wgCategoryTreeSidebarRoot, $wgCategoryTreeForceHeaders, $wgCategoryTreeHijackPageCategories;

	# Abort if AJAX is not enabled
	if ( !$wgUseAjax ) {
		wfDebug( 'efCategoryTree: $wgUseAjax is not enabled, aborting extension setup.' );
		return;
	}

	if ( $wgCategoryTreeSidebarRoot ) {
		$wgCategoryTreeForceHeaders = true; # needed on every page anyway
		$wgHooks['SkinTemplateOutputPageBeforeExec'][] = 'efCategoryTreeSkinTemplateOutputPageBeforeExec';
	}

	if ( $wgCategoryTreeHijackPageCategories ) {
		$wgCategoryTreeForceHeaders = true; # needed on almost every page anyway
		$wgHooks['OutputPageMakeCategoryLinks'][] = 'efCategoryTreeOutputPageMakeCategoryLinks';
		$wgHooks['SkinJoinCategoryLinks'][] = 'efCategoryTreeSkinJoinCategoryLinks';
	}

	if ( defined( 'MW_SUPPORTS_PARSERFIRSTCALLINIT' ) ) {
		$wgHooks['ParserFirstCallInit'][] = 'efCategoryTreeSetHooks';
	} else {
		efCategoryTreeSetHooks();
	}

	if ( !isset( $wgCategoryTreeDefaultOptions['mode'] ) || is_null( $wgCategoryTreeDefaultOptions['mode'] ) ) {
		$wgCategoryTreeDefaultOptions['mode'] = $wgCategoryTreeDefaultMode;
	}

	if ( !isset( $wgCategoryTreeDefaultOptions['hideprefix'] ) || is_null( $wgCategoryTreeDefaultOptions['hideprefix'] ) ) {
		$wgCategoryTreeDefaultOptions['hideprefix'] = $wgCategoryTreeOmitNamespace;
	}

	if ( !isset( $wgCategoryTreeCategoryPageOptions['mode'] ) || is_null( $wgCategoryTreeCategoryPageOptions['mode'] ) ) {
		$wgCategoryTreeCategoryPageOptions['mode'] = $wgCategoryTreeCategoryPageMode;
	}

	if ( $wgCategoryTreeForceHeaders ) {
		CategoryTree::setHeaders( $wgOut );
	}
	else {
		$wgHooks['OutputPageParserOutput'][] = 'efCategoryTreeParserOutput';
	}
}

function efCategoryTreeSetHooks() {
	global $wgParser, $wgCategoryTreeAllowTag;
	if ( $wgCategoryTreeAllowTag ) {
		$wgParser->setHook( 'categorytree' , 'efCategoryTreeParserHook' );
		$wgParser->setFunctionHook( 'categorytree' , 'efCategoryTreeParserFunction' );
	}
	return true;
}

/**
* Hook magic word
*/
function efCategoryTreeGetMagic( &$magicWords, $langCode ) {
	global $wgUseAjax, $wgCategoryTreeAllowTag;

	if ( $wgUseAjax && $wgCategoryTreeAllowTag ) {
		//XXX: should we allow a local alias?
		$magicWords['categorytree'] = array( 0, 'categorytree' );
	}

	return true;
}

/**
 * Entry point for Ajax, registered in $wgAjaxExportList.
 * The $enc parameter determins how the $options is decoded into a PHP array.
 * If $enc is not given, '' is asumed, which simulates the old call interface,
 * namely, only providing the mode name or number.
 * This loads CategoryTreeFunctions.php and calls CategoryTree::ajax()
 */
function efCategoryTreeAjaxWrapper( $category, $options, $enc = '' ) {
	global $wgCategoryTreeHTTPCache, $wgSquidMaxage, $wgUseSquid;

	if ( is_string( $options ) ) {
		$options = CategoryTree::decodeOptions( $options, $enc );
	}

	$depth = isset( $options['depth'] ) ? (int)$options['depth'] : 1;

	$ct = new CategoryTree( $options, true );
	$depth = efCategoryTreeCapDepth( $ct->getOption('mode'), $depth );
	$response = $ct->ajax( $category, $depth );

	if ( $wgCategoryTreeHTTPCache && $wgSquidMaxage && $wgUseSquid ) {
		$response->setCacheDuration( $wgSquidMaxage );
		$response->setVary( 'Accept-Encoding, Cookie' ); #cache for anons only
		#TODO: purge the squid cache when a category page is invalidated
	}

	return $response;
}

/**
 * Internal function to cap depth
 */

function efCategoryTreeCapDepth( $mode, $depth ) {
	global $wgCategoryTreeMaxDepth;

	if (is_numeric($depth))
		$depth = intval($depth);
	else return 1;

	if (is_array($wgCategoryTreeMaxDepth)) {
		$max = isset($wgCategoryTreeMaxDepth[$mode]) ? $wgCategoryTreeMaxDepth[$mode] : 1;
	} elseif (is_numeric($wgCategoryTreeMaxDepth)) {
		$max = $wgCategoryTreeMaxDepth;
	} else {
		wfDebug( 'efCategoryTreeCapDepth: $wgCategoryTreeMaxDepth is invalid.' );
		$max = 1;
	}

	return min($depth, $max);
}

/**
 * Entry point for the {{#categorytree}} tag parser function.
 * This is a wrapper around efCategoryTreeParserHook
 */
function efCategoryTreeParserFunction( &$parser ) {
	$params = func_get_args();
	array_shift( $params ); //first is &$parser, strip it

	//first user-supplied parameter must be category name
	if ( !$params ) return ''; //no category specified, return nothing
	$cat = array_shift( $params );

	//build associative arguments from flat parameter list
	$argv = array();
	foreach ( $params as $p ) {
		if ( preg_match('/^\s*(\S.*?)\s*=\s*(.*?)\s*$/', $p, $m) ) {
			$k = $m[1];
			$v = preg_replace('/^"\s*(.*?)\s*"$/', '$1', $m[2]); //strip any quotes enclusing the value
		}
		else {
			$k = trim($p);
			$v = true;
		}

		$argv[$k] = $v;
	}

	//now handle just like a <categorytree> tag
	$html = efCategoryTreeParserHook( $cat, $argv, $parser );
	return array( $html, 'noparse' => true, 'isHTML' => true );
}

/**
 * Hook implementation for injecting a category tree into the sidebar.
 * Registered automatically if $wgCategoryTreeSidebarRoot is set to a category name.
 */
function efCategoryTreeSkinTemplateOutputPageBeforeExec( &$skin, &$tpl ) {
	global $wgCategoryTreeSidebarRoot, $wgCategoryTreeSidebarOptions;
	
	$html = efCategoryTreeParserHook( $wgCategoryTreeSidebarRoot, $wgCategoryTreeSidebarOptions );
	if ( $html ) $tpl->data['sidebar']['categorytree-portlet'] = $html; //requires MW 1.13, r36917

	return true;
}


/**
 * Entry point for the <categorytree> tag parser hook.
 * This loads CategoryTreeFunctions.php and calls CategoryTree::getTag()
 */
function efCategoryTreeParserHook( $cat, $argv, $parser = NULL, $allowMissing = false ) {
	global $wgOut;

	if ( $parser ) {
		$parser->mOutput->mCategoryTreeTag = true; # flag for use by efCategoryTreeParserOutput
	}
	else {
		CategoryTree::setHeaders( $wgOut );
	}

	$ct = new CategoryTree( $argv );

	$attr = Sanitizer::validateTagAttributes( $argv, 'div' );

	$hideroot = isset( $argv[ 'hideroot' ] ) ? CategoryTree::decodeBoolean( $argv[ 'hideroot' ] ) : null;
	$onlyroot = isset( $argv[ 'onlyroot' ] ) ? CategoryTree::decodeBoolean( $argv[ 'onlyroot' ] ) : null;
	$depthArg = isset( $argv[ 'depth' ] ) ? (int)$argv[ 'depth' ] : null;

	$depth = efCategoryTreeCapDepth( $ct->getOption( 'mode' ), $depthArg );
	if ( $onlyroot ) $depth = 0;

	return $ct->getTag( $parser, $cat, $hideroot, $attr, $depth, $allowMissing );
}

/**
* Hook callback that injects messages and things into the <head> tag
* Does nothing if $parserOutput->mCategoryTreeTag is not set
*/
function efCategoryTreeParserOutput( &$outputPage, $parserOutput )  {
	if ( !empty( $parserOutput->mCategoryTreeTag ) ) {
		CategoryTree::setHeaders( $outputPage );
	}
	return true;
}

/**
 * ArticleFromTitle hook, override category page handling
 */
function efCategoryTreeArticleFromTitle( &$title, &$article ) {
	if ( $title->getNamespace() == NS_CATEGORY ) {
		$article = new CategoryTreeCategoryPage( $title );
	}
	return true;
}

/**
 * OutputPageMakeCategoryLinks hook, override category links
 */
function efCategoryTreeOutputPageMakeCategoryLinks( &$out, &$categories, &$links ) {
	global $wgContLang, $wgCategoryTreePageCategoryOptions;

	$ct = new CategoryTree( $wgCategoryTreePageCategoryOptions );

	foreach ( $categories as $category => $type ) {
		$links[$type][] = efCategoryTreeParserHook( $category, $wgCategoryTreePageCategoryOptions, NULL, true );
	}

	return false;
}


function efCategoryTreeSkinJoinCategoryLinks( &$skin, &$links, &$result ) {
	$embed = '<div class="CategoryTreePretendInlineMSIE CategoryTreeCategoryBarItem">';
	$pop = '</div>';
	$sep = ' ';

#	$result = '<div class="CategoryTreeCatBarWrapper" style="border:1px solid blue">' . $embed . implode ( "{$pop} {$sep} {$embed}" , $links ) . $pop . '</div>';
	$result = $embed . implode ( "{$pop} {$sep} {$embed}" , $links ) . $pop;

	return false;
}

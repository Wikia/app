<?php
/**
 * Setup and Hooks for the CategoryTree extension, an AJAX based gadget
 * to display the category structure of a wiki
 *
 * @file
 * @ingroup Extensions
 * @author Daniel Kinzler, brightbyte.de
 * @copyright © 2006-2008 Daniel Kinzler and others
 * @license GNU General Public Licence 2.0 or later
 */

if ( !defined( 'MEDIAWIKI' ) ) {
	echo( "This file is an extension to the MediaWiki software and cannot be used standalone.\n" );
	die( 1 );
}

/**
* Constants for use with the mode,
* defining what should be shown in the tree
*/
define( 'CT_MODE_CATEGORIES', 0 );
define( 'CT_MODE_PAGES', 10 );
define( 'CT_MODE_ALL', 20 );
define( 'CT_MODE_PARENTS', 100 );

/**
* Constants for use with the hideprefix option,
* defining when the namespace prefix should be hidden
*/
define( 'CT_HIDEPREFIX_NEVER', 0 );
define( 'CT_HIDEPREFIX_ALWAYS', 10 );
define( 'CT_HIDEPREFIX_CATEGORIES', 20 );
define( 'CT_HIDEPREFIX_AUTO', 30 );

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

$wgCategoryTreeMaxChildren = 200;
$wgCategoryTreeAllowTag = true;
$wgCategoryTreeDisableCache = true;
$wgCategoryTreeDynamicTag = false;
$wgCategoryTreeHTTPCache = false;
# $wgCategoryTreeUnifiedView = true;
$wgCategoryTreeMaxDepth = array( CT_MODE_PAGES => 1, CT_MODE_ALL => 1, CT_MODE_CATEGORIES => 2 );

# Set $wgCategoryTreeForceHeaders to true to force the JS and CSS headers for CategoryTree to be included on every page.
# May be usefull for using CategoryTree from within system messages, in the sidebar, or a custom skin.
$wgCategoryTreeForceHeaders = false;
$wgCategoryTreeSidebarRoot = null;
$wgCategoryTreeHijackPageCategories = false; # EXPERIMENTAL! NOT YET FOR PRODUCTION USE! Main problem is general HTML/CSS layout cruftiness.
$wgCategoryTreeUseCategoryTable = true;

$wgCategoryTreeOmitNamespace = CT_HIDEPREFIX_CATEGORIES;
$wgCategoryTreeDefaultMode = CT_MODE_CATEGORIES;
$wgCategoryTreeDefaultOptions = array(); # Default values for most options. ADD NEW OPTIONS HERE!
$wgCategoryTreeDefaultOptions['mode'] = null; # will be set to $wgCategoryTreeDefaultMode in efCategoryTree(); compatibility quirk
$wgCategoryTreeDefaultOptions['hideprefix'] = null; # will be set to $wgCategoryTreeDefaultMode in efCategoryTree(); compatibility quirk
$wgCategoryTreeDefaultOptions['showcount'] = false;
$wgCategoryTreeDefaultOptions['namespaces'] = false; # false means "no filter"

$wgCategoryTreeCategoryPageMode = CT_MODE_CATEGORIES;
$wgCategoryTreeCategoryPageOptions = array(); # Options to be used for category pages
$wgCategoryTreeCategoryPageOptions['mode'] = NULL; # will be set to $wgCategoryTreeDefaultMode in efCategoryTree(); compatibility quirk
$wgCategoryTreeCategoryPageOptions['showcount'] = true;

$wgCategoryTreeSpecialPageOptions = array(); # Options to be used for Special:CategoryTree
$wgCategoryTreeSpecialPageOptions['showcount'] = true;

$wgCategoryTreeSidebarOptions = array(); # Options to be used in the sidebar (for use with $wgCategoryTreeSidebarRoot)
$wgCategoryTreeSidebarOptions['mode'] = CT_MODE_CATEGORIES;
$wgCategoryTreeSidebarOptions['hideprefix'] = CT_HIDEPREFIX_CATEGORIES;
$wgCategoryTreeSidebarOptions['showcount'] = false;
$wgCategoryTreeSidebarOptions['hideroot'] = true;
$wgCategoryTreeSidebarOptions['namespaces'] = false;
$wgCategoryTreeSidebarOptions['depth'] = 1;

$wgCategoryTreePageCategoryOptions = array(); # Options to be used in the sidebar (for use with $wgCategoryTreePageCategories)
$wgCategoryTreePageCategoryOptions['mode'] = CT_MODE_PARENTS;
$wgCategoryTreePageCategoryOptions['hideprefix'] = CT_HIDEPREFIX_CATEGORIES;
$wgCategoryTreePageCategoryOptions['showcount'] = false;
$wgCategoryTreePageCategoryOptions['hideroot'] = false;
$wgCategoryTreePageCategoryOptions['namespaces'] = false;
$wgCategoryTreePageCategoryOptions['depth'] = 0;
# $wgCategoryTreePageCategoryOptions['class'] = 'CategoryTreeInlineNode';

$wgExtensionMessagesFiles['CategoryTreeAlias'] = dirname( __FILE__ ) . '/CategoryTree.alias.php';

/**
 * Register extension setup hook and credits
 */
$wgExtensionFunctions[] = 'efCategoryTree';
$wgExtensionCredits['specialpage'][] = $wgExtensionCredits['parserhook'][] = array(
	'path' => __FILE__,
	'name' => 'CategoryTree',
	'author' => 'Daniel Kinzler',
	'url' => 'https://www.mediawiki.org/wiki/Extension:CategoryTree',
	'descriptionmsg' => 'categorytree-desc',
);

/**
 * Register the special page
 */
$dir = dirname( __FILE__ ) . '/';

if ( $wgUseAjax && $wgCategoryTreeAllowTag ) {
	$wgExtensionMessagesFiles['CategoryTreeMagic'] = $dir . 'CategoryTree.i18n.magic.php';
}

$wgExtensionMessagesFiles['CategoryTree'] = $dir . 'CategoryTree.i18n.php';
$wgAutoloadClasses['CategoryTreePage'] = $dir . 'CategoryTreePage.php';
$wgAutoloadClasses['CategoryTree'] = $dir . 'CategoryTreeFunctions.php';
$wgAutoloadClasses['CategoryTreeCategoryPage'] = $dir . 'CategoryPageSubclass.php';
$wgSpecialPages['CategoryTree'] = 'CategoryTreePage';
$wgSpecialPageGroups['CategoryTree'] = 'pages';
# $wgHooks['SkinTemplateTabs'][] = 'efCategoryTreeInstallTabs';
$wgHooks['ArticleFromTitle'][] = 'efCategoryTreeArticleFromTitle';

/**
 * register Ajax function
 */
$wgAjaxExportList[] = 'efCategoryTreeAjaxWrapper';

/**
 * Register ResourceLoader modules
 */
$commonModuleInfo = array(
	'localBasePath' => dirname( __FILE__ ) . '/modules',
	'remoteExtPath' => 'CategoryTree/modules',
);

$wgResourceModules['ext.categoryTree'] = array(
	'scripts' => 'ext.categoryTree.js',
	'messages' => array(
		'categorytree-collapse',
		'categorytree-expand',
		'categorytree-collapse-bullet',
		'categorytree-expand-bullet',
		'categorytree-load',
		'categorytree-loading',
		'categorytree-nothing-found',
		'categorytree-no-subcategories',
		'categorytree-no-parent-categories',
		'categorytree-no-pages',
		'categorytree-error',
		'categorytree-retry',
	),
) + $commonModuleInfo;

$wgResourceModules['ext.categoryTree.css'] = array(
	'styles' => 'ext.categoryTree.css',
) + $commonModuleInfo;

/**
 * Hook it up
 */
function efCategoryTree() {
	global $wgUseAjax, $wgHooks, $wgOut, $wgRequest;
	global $wgCategoryTreeDefaultOptions, $wgCategoryTreeDefaultMode, $wgCategoryTreeOmitNamespace;
	global $wgCategoryTreeCategoryPageOptions, $wgCategoryTreeCategoryPageMode, $wgCategoryTreeAllowTag;
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

	if ( $wgCategoryTreeAllowTag ) {
		$wgHooks['ParserFirstCallInit'][] = 'efCategoryTreeSetHooks';
	}

	if ( !isset( $wgCategoryTreeDefaultOptions['mode'] ) || is_null( $wgCategoryTreeDefaultOptions['mode'] ) ) {
		$wgCategoryTreeDefaultOptions['mode'] = $wgCategoryTreeDefaultMode;
	}

	if ( !isset( $wgCategoryTreeDefaultOptions['hideprefix'] ) || is_null( $wgCategoryTreeDefaultOptions['hideprefix'] ) ) {
		$wgCategoryTreeDefaultOptions['hideprefix'] = $wgCategoryTreeOmitNamespace;
	}

	if ( !isset( $wgCategoryTreeCategoryPageOptions['mode'] ) || is_null( $wgCategoryTreeCategoryPageOptions['mode'] ) ) {	
		$wgCategoryTreeCategoryPageOptions['mode'] = ( $mode = $wgRequest->getVal( 'mode' ) ) ? CategoryTree::decodeMode( $mode ) : $wgCategoryTreeCategoryPageMode;
	}

	if ( $wgCategoryTreeForceHeaders ) {
		CategoryTree::setHeaders( $wgOut );
	} else {
		$wgHooks['OutputPageParserOutput'][] = 'efCategoryTreeParserOutput';
	}

	$wgHooks['MakeGlobalVariablesScript'][] = 'efCategoryTreeGetConfigVars';
}

/**
 * @param $parser Parser
 * @return bool
 */
function efCategoryTreeSetHooks( $parser ) {
	$parser->setHook( 'categorytree' , 'efCategoryTreeParserHook' );
	$parser->setFunctionHook( 'categorytree' , 'efCategoryTreeParserFunction' );
	return true;
}

/**
 * Entry point for Ajax, registered in $wgAjaxExportList.
 * The $enc parameter determins how the $options is decoded into a PHP array.
 * If $enc is not given, '' is asumed, which simulates the old call interface,
 * namely, only providing the mode name or number.
 * This loads CategoryTreeFunctions.php and calls CategoryTree::ajax()
 * @param $category
 * @param $options array
 * @param $enc string
 * @return AjaxResponse|bool
 */
function efCategoryTreeAjaxWrapper( $category, $options = array(), $enc = '' ) {
	global $wgCategoryTreeHTTPCache, $wgSquidMaxage, $wgUseSquid;

	if ( is_string( $options ) ) {
		$options = CategoryTree::decodeOptions( $options, $enc );
	}

	$depth = isset( $options['depth'] ) ? (int)$options['depth'] : 1;

	$ct = new CategoryTree( $options, true );
	$depth = efCategoryTreeCapDepth( $ct->getOption( 'mode' ), $depth );
	$response = $ct->ajax( $category, $depth );

	if ( $wgCategoryTreeHTTPCache && $wgSquidMaxage && $wgUseSquid ) {
		$response->setCacheDuration( $wgSquidMaxage );
		$response->setVary( 'Accept-Encoding, Cookie' ); # cache for anons only
		# TODO: purge the squid cache when a category page is invalidated
	}

	return $response;
}

/**
 * Internal function to cap depth
 * @param $mode
 * @param $depth
 * @return int|mixed
 */
function efCategoryTreeCapDepth( $mode, $depth ) {
	global $wgCategoryTreeMaxDepth;

	if ( is_numeric( $depth ) ) {
		$depth = intval( $depth );
	} else {
		return 1;
	}

	if ( is_array( $wgCategoryTreeMaxDepth ) ) {
		$max = isset( $wgCategoryTreeMaxDepth[$mode] ) ? $wgCategoryTreeMaxDepth[$mode] : 1;
	} elseif ( is_numeric( $wgCategoryTreeMaxDepth ) ) {
		$max = $wgCategoryTreeMaxDepth;
	} else {
		wfDebug( 'efCategoryTreeCapDepth: $wgCategoryTreeMaxDepth is invalid.' );
		$max = 1;
	}

	return min( $depth, $max );
}

/**
 * Entry point for the {{#categorytree}} tag parser function.
 * This is a wrapper around efCategoryTreeParserHook
 * @param $parser Parser
 * @return array|string
 */
function efCategoryTreeParserFunction( $parser ) {
	$params = func_get_args();
	array_shift( $params ); // first is $parser, strip it

	// first user-supplied parameter must be category name
	if ( !$params ) {
		return ''; // no category specified, return nothing
	}
	$cat = array_shift( $params );

	// build associative arguments from flat parameter list
	$argv = array();
	foreach ( $params as $p ) {
		if ( preg_match( '/^\s*(\S.*?)\s*=\s*(.*?)\s*$/', $p, $m ) ) {
			$k = $m[1];
			$v = preg_replace( '/^"\s*(.*?)\s*"$/', '$1', $m[2] ); // strip any quotes enclusing the value
		} else {
			$k = trim( $p );
			$v = true;
		}

		$argv[$k] = $v;
	}

	// now handle just like a <categorytree> tag
	$html = efCategoryTreeParserHook( $cat, $argv, $parser );
	return array( $html, 'noparse' => true, 'isHTML' => true );
}

/**
 * Hook implementation for injecting a category tree into the sidebar.
 * Registered automatically if $wgCategoryTreeSidebarRoot is set to a category name.
 * @param $skin
 * @param $tpl SkinTemplate
 * @return bool
 */
function efCategoryTreeSkinTemplateOutputPageBeforeExec( $skin, $tpl ) {
	global $wgCategoryTreeSidebarRoot, $wgCategoryTreeSidebarOptions;

	$html = efCategoryTreeParserHook( $wgCategoryTreeSidebarRoot, $wgCategoryTreeSidebarOptions );
	if ( $html ) {
		$tpl->data['sidebar']['categorytree-portlet'] = $html;
	}

	return true;
}

/**
 * Entry point for the <categorytree> tag parser hook.
 * This loads CategoryTreeFunctions.php and calls CategoryTree::getTag()
 * @param $cat
 * @param $argv
 * @param $parser Parser
 * @param $allowMissing bool
 * @return bool|string
 */
function efCategoryTreeParserHook( $cat, $argv, $parser = null, $allowMissing = false ) {
	global $wgOut;

	if ( $parser ) {
		$parser->mOutput->mCategoryTreeTag = true; # flag for use by efCategoryTreeParserOutput
	} else {
		CategoryTree::setHeaders( $wgOut );
	}

	$ct = new CategoryTree( $argv );

	$attr = Sanitizer::validateTagAttributes( $argv, 'div' );

	$hideroot = isset( $argv[ 'hideroot' ] ) ? CategoryTree::decodeBoolean( $argv[ 'hideroot' ] ) : null;
	$onlyroot = isset( $argv[ 'onlyroot' ] ) ? CategoryTree::decodeBoolean( $argv[ 'onlyroot' ] ) : null;
	$depthArg = isset( $argv[ 'depth' ] ) ? (int)$argv[ 'depth' ] : null;

	$depth = efCategoryTreeCapDepth( $ct->getOption( 'mode' ), $depthArg );
	if ( $onlyroot ) {
		$depth = 0;
	}

	return $ct->getTag( $parser, $cat, $hideroot, $attr, $depth, $allowMissing );
}

/**
 * Hook callback that injects messages and things into the <head> tag
 * Does nothing if $parserOutput->mCategoryTreeTag is not set
 * @param $outputPage OutputPage
 * @param $parserOutput ParserOutput
 * @return bool
 */
function efCategoryTreeParserOutput( $outputPage, $parserOutput )  {
	if ( !empty( $parserOutput->mCategoryTreeTag ) ) {
		CategoryTree::setHeaders( $outputPage );
	}
	return true;
}

/**
 * ArticleFromTitle hook, override category page handling
 *
 * @param $title Title
 * @param $article Article
 * @return bool
 */
function efCategoryTreeArticleFromTitle( $title, &$article ) {
	if ( $title->getNamespace() == NS_CATEGORY ) {
		$article = new CategoryTreeCategoryPage( $title );
	}
	return true;
}

/**
 * OutputPageMakeCategoryLinks hook, override category links
 * @param $out
 * @param $categories
 * @param $links
 * @return bool
 */
function efCategoryTreeOutputPageMakeCategoryLinks( $out, &$categories, &$links ) {
	global $wgCategoryTreePageCategoryOptions;

	foreach ( $categories as $category => $type ) {
		$links[$type][] = efCategoryTreeParserHook( $category, $wgCategoryTreePageCategoryOptions, null, true );
	}

	return false;
}

/**
 * @param $skin
 * @param $links
 * @param $result
 * @return bool
 */
function efCategoryTreeSkinJoinCategoryLinks( $skin, &$links, &$result ) {
	$embed = '<div class="CategoryTreeCategoryBarItem">';
	$pop = '</div>';
	$sep = ' ';

	$result = $embed . implode ( "{$pop} {$sep} {$embed}" , $links ) . $pop;

	return false;
}

/**
 * @param $vars
 * @return bool
 */
function efCategoryTreeGetConfigVars( &$vars ) {
	global $wgCategoryTreeCategoryPageOptions;

	// Look this is pretty bad but Category tree is just whacky, it needs to be rewritten
	$ct = new CategoryTree( $wgCategoryTreeCategoryPageOptions );
	$vars['wgCategoryTreePageCategoryOptions'] = $ct->getOptionsAsJsStructure();
	return true;
}

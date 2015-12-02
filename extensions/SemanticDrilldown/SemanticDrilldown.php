<?php
/**
 * Semantic Drilldown extension
 *
 * Defines a drill-down interface for data stored with the Semantic MediaWiki
 * extension, via the page Special:BrowseData.
 *
 * @file
 * @defgroup SD Semantic Drilldown
 * @ingroup SD
 * @author Yaron Koren
 */

if ( !defined( 'MEDIAWIKI' ) ) die();

define( 'SD_VERSION', '2.0.1' );

$wgExtensionCredits[defined( 'SEMANTIC_EXTENSION_TYPE' ) ? 'semantic' : 'specialpage'][] = array(
	'path'        => __FILE__,
	'name'        => 'Semantic Drilldown',
	'version'     => SD_VERSION,
	'author'      => array( 'Yaron Koren', '...' ),
	'url'         => 'https://www.mediawiki.org/wiki/Extension:Semantic_Drilldown',
	'descriptionmsg'  => 'semanticdrilldown-desc',
);

// Constants for special properties - these are all deprecated
// as of version 2.0.
define( 'SD_SP_HAS_FILTER', 1 );
define( 'SD_SP_COVERS_PROPERTY', 2 );
//define( 'SD_SP_HAS_VALUE', 3 );
define( 'SD_SP_GETS_VALUES_FROM_CATEGORY', 4 );
//define( 'SD_SP_USES_TIME_PERIOD', 5 );
define( 'SD_SP_REQUIRES_FILTER', 6 );
define( 'SD_SP_HAS_LABEL', 7 );
define( 'SD_SP_HAS_DRILLDOWN_TITLE', 8 );
//define( 'SD_SP_HAS_INPUT_TYPE', 9 );
define( 'SD_SP_HAS_DISPLAY_PARAMETERS', 10 );

$sdgIP = dirname( __FILE__ );

require_once( $sdgIP . '/languages/SD_Language.php' );

$wgMessagesDirs['SemanticDrilldown'] = __DIR__ . '/i18n';
$wgExtensionMessagesFiles['SemanticDrilldown'] = $sdgIP . '/languages/SD_Messages.php';
$wgExtensionMessagesFiles['SemanticDrilldownAlias'] = $sdgIP . '/languages/SD_Aliases.php';
$wgExtensionMessagesFiles['SemanticDrilldownMagic'] = $sdgIP . '/languages/SemanticDrilldown.i18n.magic.php';

// register all special pages and other classes
$wgSpecialPages['BrowseData'] = 'SDBrowseData';
$wgAutoloadClasses['SDBrowseData'] = $sdgIP . '/specials/SD_BrowseData.php';
$wgSpecialPageGroups['BrowseData'] = 'sd_group';

$wgAutoloadClasses['SDUtils'] = $sdgIP . '/includes/SD_Utils.php';
$wgAutoloadClasses['SDFilter'] = $sdgIP . '/includes/SD_Filter.php';
$wgAutoloadClasses['SDFilterValue'] = $sdgIP . '/includes/SD_FilterValue.php';
$wgAutoloadClasses['SDAppliedFilter'] = $sdgIP . '/includes/SD_AppliedFilter.php';
$wgAutoloadClasses['SDPageSchemas'] = $sdgIP . '/includes/SD_PageSchemas.php';
$wgAutoloadClasses['SDParserFunctions'] = $sdgIP . '/includes/SD_ParserFunctions.php';

$wgHooks['smwInitProperties'][] = 'sdfInitProperties';
$wgHooks['AdminLinks'][] = 'SDUtils::addToAdminLinks';
$wgHooks['MagicWordwgVariableIDs'][] = 'SDUtils::addMagicWordVariableIDs';
$wgHooks['MakeGlobalVariablesScript'][] = 'SDUtils::setGlobalJSVariables';
$wgHooks['ParserBeforeTidy'][] = 'SDUtils::handleShowAndHide';
$wgHooks['PageSchemasRegisterHandlers'][] = 'SDPageSchemas::registerClass';
$wgHooks['ParserFirstCallInit'][] = 'SDParserFunctions::registerFunctions';

$wgPageProps['hidefromdrilldown'] = 'Whether or not the page is set as HIDEFROMDRILLDOWN';
$wgPageProps['showindrilldown'] = 'Whether or not the page is set as SHOWINDRILLDOWN';

# ##
# This is the path to your installation of Semantic Drilldown as
# seen from the web. Change it if required ($wgScriptPath is the
# path to the base directory of your wiki). No final slash.
# # TODO: fix hardcoded path
$sdgScriptPath = $wgScriptPath . '/extensions/SemanticDrilldown';
# #

# ##
# If you already have custom namespaces on your site, insert
# $sdgNamespaceIndex = ???;
# into your LocalSettings.php *before* including this file.
# The number ??? must be the smallest even namespace number
# that is not in use yet. However, it should not be smaller
# than 170.
# #
if ( !isset( $sdgNamespaceIndex ) ) {
	sdfInitNamespaces( 170 );
} else {
	sdfInitNamespaces();
}

# ##
# # Variables for display
# ##
// Set to true to have Special:BrowseData show only categories that have
// __SHOWINDRILLDOWN__ set.
$sdgHideCategoriesByDefault = false;
$sdgNumResultsPerPage = 250;
// set these to a positive value to trigger the "tag cloud" display
$sdgFiltersSmallestFontSize = - 1;
$sdgFiltersLargestFontSize = - 1;
// print categories list as tabs
$sdgShowCategoriesAsTabs = false;
// other display settings
$sdgMinValuesForComboBox = 40;
$sdgNumRangesForNumberFilters = 6;


/**********************************************/
/***** Global functions                   *****/
/**********************************************/

/**
 * Init the additional namespaces used by Semantic Drilldown.
 */
function sdfInitNamespaces() {
	global $sdgNamespaceIndex, $wgExtraNamespaces, $wgNamespaceAliases, $wgNamespacesWithSubpages, $smwgNamespacesWithSemanticLinks;
	global $wgLanguageCode, $sdgContLang;

	if ( !isset( $sdgNamespaceIndex ) ) {
		$sdgNamespaceIndex = 170;
	}

	define( 'SD_NS_FILTER', $sdgNamespaceIndex );
	define( 'SD_NS_FILTER_TALK', $sdgNamespaceIndex + 1 );

	sdfInitContentLanguage( $wgLanguageCode );

	// Register namespace identifiers
	$wgExtraNamespaces = $wgExtraNamespaces + $sdgContLang->getNamespaces();
	$wgNamespaceAliases = $wgNamespaceAliases + $sdgContLang->getNamespaceAliases();

	// Support subpages only for talk pages by default
	$wgNamespacesWithSubpages = $wgNamespacesWithSubpages + array(
		SD_NS_FILTER_TALK => true
	);

	// Enable semantic links on filter pages
	$smwgNamespacesWithSemanticLinks = $smwgNamespacesWithSemanticLinks + array(
		SD_NS_FILTER => true,
		SD_NS_FILTER_TALK => false
	);
}

/**********************************************/
/***** language settings                  *****/
/**********************************************/

/**
 * Initialize a global language object for content language. This
 * must happen early on, even before user language is known, to
 * determine labels for additional namespaces. In contrast, messages
 * can be initialized much later when they are actually needed.
 */
function sdfInitContentLanguage( $langcode ) {
	global $sdgIP, $sdgContLang;

	if ( !empty( $sdgContLang ) ) { return; }

	$sdContLangClass = 'SD_Language' . str_replace( '-', '_', ucfirst( $langcode ) );

	if ( file_exists( $sdgIP . '/languages/' . $sdContLangClass . '.php' ) ) {
		include_once( $sdgIP . '/languages/' . $sdContLangClass . '.php' );
	}

	// fallback if language not supported
	if ( !class_exists( $sdContLangClass ) ) {
		include_once( $sdgIP . '/languages/SD_LanguageEn.php' );
		$sdContLangClass = 'SD_LanguageEn';
	}

	$sdgContLang = new $sdContLangClass();
}

/**
 * Initialize the global language object for user language. This
 * must happen after the content language was initialized, since
 * this language is used as a fallback.
 */
function sdfInitUserLanguage( $langcode ) {
	global $sdgIP, $sdgLang;

	if ( !empty( $sdgLang ) ) { return; }

	$sdLangClass = 'SD_Language' . str_replace( '-', '_', ucfirst( $langcode ) );
	if ( file_exists( $sdgIP . '/languages/' . $sdLangClass . '.php' ) ) {
		include_once( $sdgIP . '/languages/' . $sdLangClass . '.php' );
	}

	// fallback if language not supported
	if ( !class_exists( $sdLangClass ) ) {
		include_once( $sdgIP . '/languages/SD_LanguageEn.php' );
		$sdLangClass = 'SD_LanguageEn';
	}

	$sdgLang = new $sdLangClass();
}

function sdfInitProperties() {
	global $sdgContLang, $wgLanguageCode;
	$sd_property_vals = array(
		SD_SP_HAS_FILTER => array( '_SD_F', '_wpg' ),
		SD_SP_COVERS_PROPERTY => array( '_SD_CP', '_wpp' ),
		//SD_SP_HAS_VALUE => array( '_SD_V', '_str' ),
		SD_SP_GETS_VALUES_FROM_CATEGORY => array( '_SD_VC', '_wpc' ),
		//SD_SP_USES_TIME_PERIOD => array( '_SD_TP', '_str' ),
		//SD_SP_HAS_INPUT_TYPE => array( '_SD_IT', '_str' ),
		SD_SP_REQUIRES_FILTER => array( '_SD_RF', '_wpg' ),
		SD_SP_HAS_LABEL => array( '_SD_L', '_str' ),
		SD_SP_HAS_DRILLDOWN_TITLE => array( '_SD_DT', '_str' ),
		SD_SP_HAS_DISPLAY_PARAMETERS => array( '_SD_DP', '_str' ),
	);
	// register main property labels
	$sd_prop_labels = $sdgContLang->getPropertyLabels();
	foreach ( $sd_prop_labels as $prop_id => $prop_alias ) {
		$prop_vals = $sd_property_vals[$prop_id];
		if ( class_exists( 'SMWDIProperty' ) ) {
			SMWDIProperty::registerProperty( $prop_vals[0], $prop_vals[1], $prop_alias, true );
		} else {
			SMWPropertyValue::registerProperty( $prop_vals[0], $prop_vals[1], $prop_alias, true );
		}
	}
	// if it's not English, add the English-language aliases as well
	if ( $wgLanguageCode != 'en' ) {
		$sd_prop_aliases = $sdgContLang->getPropertyAliases();
		foreach ( $sd_prop_aliases as $prop_alias => $prop_id ) {
			$prop_vals = $sd_property_vals[$prop_id];
			if ( class_exists( 'SMWDIProperty' ) ) {
				SMWDIProperty::registerPropertyAlias( $prop_vals[0], $prop_alias );
			} else {
				SMWPropertyValue::registerPropertyAlias( $prop_vals[0], $prop_alias );
			}
		}
	}
	return true;
}

$sdgResourceTemplate = array(
	'localBasePath' => $sdgIP,
	'remoteExtPath' => 'SemanticDrilldown'
);

$wgResourceModules += array(
	'ext.semanticdrilldown.main' => $sdgResourceTemplate + array(
		'styles' => array(
			'skins/SD_main.css',
			'skins/SD_jquery_ui_overrides.css',
		),
		'scripts' => array(
			'libs/SemanticDrilldown.js',
		),
		'dependencies' => array(
			'jquery.ui.autocomplete',
			'jquery.ui.button',
		),
		'position' => 'top',
	),
	'ext.semanticdrilldown.info' => $sdgResourceTemplate + array(
		'styles' => array(
			'skins/SD_info.css',
		),
	),
);


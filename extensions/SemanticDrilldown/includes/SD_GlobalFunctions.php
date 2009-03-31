<?php
/**
 * Global functions and constants for Semantic Drilldown.
 *
 * @author Yaron Koren
 */

if (!defined('MEDIAWIKI')) die();

define('SD_VERSION','0.5.3');

// constants for special properties
define('SD_SP_HAS_FILTER', 1);
define('SD_SP_COVERS_PROPERTY', 2);
define('SD_SP_HAS_VALUE', 3);
define('SD_SP_GETS_VALUES_FROM_CATEGORY', 4);
define('SD_SP_USES_TIME_PERIOD', 5);
define('SD_SP_REQUIRES_FILTER', 6);
define('SD_SP_HAS_LABEL', 7);
define('SD_SP_HAS_DRILLDOWN_TITLE', 8);
define('SD_SP_HAS_INPUT_TYPE', 9);

$wgExtensionCredits['specialpage'][]= array(
	'name'	=> 'Semantic Drilldown',
	'version'     => SD_VERSION,
	'author'      => 'Yaron Koren',
	'url'         => 'http://www.mediawiki.org/wiki/Extension:Semantic_Drilldown',
	'description' =>  'A drilldown interface for navigating through semantic data',
	'descriptionmsg'  => 'semanticdrilldown-desc',
);

require_once($sdgIP . '/languages/SD_Language.php');

$wgExtensionMessagesFiles['SemanticDrilldown'] = $sdgIP . '/languages/SD_Messages.php';
$wgExtensionAliasesFiles['SemanticDrilldown'] = $sdgIP . '/languages/SD_Aliases.php';

$wgHooks['smwInitProperties'][] = 'sdfInitProperties';

// register all special pages and other classes
$wgSpecialPages['Filters'] = 'SDFilters';
$wgSpecialPageGroups['Filters'] = 'users';
$wgAutoloadClasses['SDFilters'] = $sdgIP . '/specials/SD_Filters.php';
$wgSpecialPageGroups['Filters'] = 'sd_group';
$wgSpecialPages['CreateFilter'] = 'SDCreateFilter';
$wgSpecialPageGroups['CreateFilter'] = 'users';
$wgAutoloadClasses['SDCreateFilter'] = $sdgIP . '/specials/SD_CreateFilter.php';
$wgSpecialPageGroups['CreateFilter'] = 'sd_group';
$wgSpecialPages['BrowseData'] = 'SDBrowseData';
$wgSpecialPageGroups['BrowseData'] = 'users';
$wgAutoloadClasses['SDBrowseData'] = $sdgIP . '/specials/SD_BrowseData.php';
$wgSpecialPageGroups['BrowseData'] = 'sd_group';

$wgAutoloadClasses['SDUtils'] = $sdgIP . '/includes/SD_Utils.inc';
$wgAutoloadClasses['SDFilter'] = $sdgIP . '/includes/SD_Filter.php';
$wgAutoloadClasses['SDFilterValue'] = $sdgIP . '/includes/SD_FilterValue.php';
$wgAutoloadClasses['SDAppliedFilter'] = $sdgIP . '/includes/SD_AppliedFilter.php';

/**********************************************/
/***** namespace settings                 *****/
/**********************************************/

/**
 * Init the additional namespaces used by Semantic Drilldown.
 */
function sdfInitNamespaces() {
	global $sdgNamespaceIndex, $wgExtraNamespaces, $wgNamespaceAliases, $wgNamespacesWithSubpages, $smwgNamespacesWithSemanticLinks;
	global $wgLanguageCode, $sdgContLang;

	if (!isset($sdgNamespaceIndex)) {
		$sdgNamespaceIndex = 170;
	}

	define('SD_NS_FILTER',       $sdgNamespaceIndex);
	define('SD_NS_FILTER_TALK',  $sdgNamespaceIndex+1);

	sdfInitContentLanguage($wgLanguageCode);

	// Register namespace identifiers
	if (!is_array($wgExtraNamespaces)) { $wgExtraNamespaces=array(); }
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
 * Initialise a global language object for content language. This
 * must happen early on, even before user language is known, to
 * determine labels for additional namespaces. In contrast, messages
 * can be initialised much later when they are actually needed.
 */
function sdfInitContentLanguage($langcode) {
	global $sdgIP, $sdgContLang;

	if (!empty($sdgContLang)) { return; }

	$sdContLangClass = 'SD_Language' . str_replace( '-', '_', ucfirst( $langcode ) );

	if (file_exists($sdgIP . '/languages/'. $sdContLangClass . '.php')) {
		include_once( $sdgIP . '/languages/'. $sdContLangClass . '.php' );
	}

	// fallback if language not supported
	if ( !class_exists($sdContLangClass)) {
		include_once($sdgIP . '/languages/SD_LanguageEn.php');
		$sdContLangClass = 'SD_LanguageEn';
	}

	$sdgContLang = new $sdContLangClass();
}

/**
 * Initialise the global language object for user language. This
 * must happen after the content language was initialised, since
 * this language is used as a fallback.
 */
function sdfInitUserLanguage($langcode) {
	global $sdgIP, $sdgLang;

	if (!empty($sdgLang)) { return; }

	$sdLangClass = 'SD_Language' . str_replace( '-', '_', ucfirst( $langcode ) );
	if (file_exists($sdgIP . '/languages/'. $sdLangClass . '.php')) {
		include_once( $sdgIP . '/languages/'. $sdLangClass . '.php' );
	}

	// fallback if language not supported
	if ( !class_exists($sdLangClass)) {
		global $sdgContLang;
		$sdgLang = $sdgContLang;
	} else {
		$sdgLang = new $sdLangClass();
	}
}

/**
 * Setting of message cache for versions of MediaWiki that do not support
 * wgExtensionMessagesFiles - based on ceContributionScores() in
 * ContributionScores extension
 */
function sdfLoadMessagesManually() {
	global $sdgIP, $wgMessageCache;

	# add messages
	require($sdgIP . '/languages/SD_Messages.php');
	foreach($messages as $key => $value) {
		$wgMessageCache->addMessages($messages[$key], $key);
	}
}

function sdfInitProperties() {
	global $sdgContLang;
	$sd_props = $sdgContLang->getPropertyLabels();
	SMWPropertyValue::registerProperty('_SD_F', '_wpg', $sd_props[SD_SP_HAS_FILTER], true);
	SMWPropertyValue::registerProperty('_SD_CP', '_wpp', $sd_props[SD_SP_COVERS_PROPERTY], true);
	SMWPropertyValue::registerProperty('_SD_V', '_str', $sd_props[SD_SP_HAS_VALUE], true);
	SMWPropertyValue::registerProperty('_SD_VC', '_wpc', $sd_props[SD_SP_GETS_VALUES_FROM_CATEGORY], true);
	SMWPropertyValue::registerProperty('_SD_TP', '_str', $sd_props[SD_SP_USES_TIME_PERIOD], true);
	SMWPropertyValue::registerProperty('_SD_IT', '_str', $sd_props[SD_SP_HAS_INPUT_TYPE], true);
	SMWPropertyValue::registerProperty('_SD_RF', '_wpg', $sd_props[SD_SP_REQUIRES_FILTER], true);
	SMWPropertyValue::registerProperty('_SD_L', '_str', $sd_props[SD_SP_HAS_LABEL], true);
	SMWPropertyValue::registerProperty('_SD_DT', '_str', $sd_props[SD_SP_HAS_DRILLDOWN_TITLE], true);

        return true;
}

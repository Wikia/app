<?php
/**
 * Global functions and constants for Semantic Drilldown.
 *
 * @author Yaron Koren
 */

if (!defined('MEDIAWIKI')) die();

define('SD_VERSION','0.7');

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
define('SD_SP_HAS_DISPLAY_PARAMETERS', 10);

$wgExtensionCredits['specialpage'][]= array(
	'path'        => __FILE__,
	'name'        => 'Semantic Drilldown',
	'version'     => SD_VERSION,
	'author'      => array('Yaron Koren', 'David Loomer'),
	'url'         => 'http://www.mediawiki.org/wiki/Extension:Semantic_Drilldown',
	'description' =>  'A drilldown interface for navigating through semantic data',
	'descriptionmsg'  => 'semanticdrilldown-desc',
);

require_once($sdgIP . '/languages/SD_Language.php');

$wgExtensionMessagesFiles['SemanticDrilldown'] = $sdgIP . '/languages/SD_Messages.php';
$wgExtensionAliasesFiles['SemanticDrilldown'] = $sdgIP . '/languages/SD_Aliases.php';

// register all special pages and other classes
$wgSpecialPages['Filters'] = 'SDFilters';
$wgAutoloadClasses['SDFilters'] = $sdgIP . '/specials/SD_Filters.php';
$wgSpecialPageGroups['Filters'] = 'sd_group';
$wgSpecialPages['CreateFilter'] = 'SDCreateFilter';
$wgAutoloadClasses['SDCreateFilter'] = $sdgIP . '/specials/SD_CreateFilter.php';
$wgSpecialPageGroups['CreateFilter'] = 'sd_group';
$wgSpecialPages['BrowseData'] = 'SDBrowseData';
$wgAutoloadClasses['SDBrowseData'] = $sdgIP . '/specials/SD_BrowseData.php';
$wgSpecialPageGroups['BrowseData'] = 'sd_group';

$wgAutoloadClasses['SDUtils'] = $sdgIP . '/includes/SD_Utils.inc';
$wgAutoloadClasses['SDFilter'] = $sdgIP . '/includes/SD_Filter.php';
$wgAutoloadClasses['SDFilterValue'] = $sdgIP . '/includes/SD_FilterValue.php';
$wgAutoloadClasses['SDAppliedFilter'] = $sdgIP . '/includes/SD_AppliedFilter.php';

$wgHooks['smwInitProperties'][] = 'sdfInitProperties';
$wgHooks['AdminLinks'][] = 'sdfAddToAdminLinks';
$wgHooks['MagicWordwgVariableIDs'][] = 'SDUtils::addMagicWordVariableIDs';
$wgHooks['LanguageGetMagic'][] = 'SDUtils::addMagicWordLanguage';
$wgHooks['ParserBeforeTidy'][] = 'SDUtils::handleShowAndHide';

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
                include_once( $sdgIP . '/languages/SD_LanguageEn.php' );
                $sdLangClass = 'SD_LanguageEn';
        }

	$sdgLang = new $sdLangClass();
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
	global $sdgContLang, $wgLanguageCode;
	$sd_property_vals = array(
		SD_SP_HAS_FILTER => array('_SD_F', '_wpg'),
		SD_SP_COVERS_PROPERTY => array('_SD_CP', '_wpp'),
		SD_SP_HAS_VALUE => array('_SD_V', '_str'),
		SD_SP_GETS_VALUES_FROM_CATEGORY => array('_SD_VC', '_wpc'),
		SD_SP_USES_TIME_PERIOD => array('_SD_TP', '_str'),
		SD_SP_HAS_INPUT_TYPE => array('_SD_IT', '_str'),
		SD_SP_REQUIRES_FILTER => array('_SD_RF', '_wpg'),
		SD_SP_HAS_LABEL => array('_SD_L', '_str'),
		SD_SP_HAS_DRILLDOWN_TITLE => array('_SD_DT', '_str'),
		SD_SP_HAS_DISPLAY_PARAMETERS => array('_SD_DP', '_str'),
	);
	// register main property labels
	$sd_prop_labels = $sdgContLang->getPropertyLabels();
	foreach ($sd_prop_labels as $prop_id => $prop_alias) {
		$prop_vals = $sd_property_vals[$prop_id];
		SMWPropertyValue::registerProperty($prop_vals[0], $prop_vals[1], $prop_alias, true);
	}
	// if it's not English, add the English-language aliases as well
	if ($wgLanguageCode != 'en') {
		$sd_prop_aliases = $sdgContLang->getPropertyAliases();
		foreach ($sd_prop_aliases as $prop_alias => $prop_id) {
			$prop_vals = $sd_property_vals[$prop_id];
			SMWPropertyValue::registerPropertyAlias($prop_vals[0], $prop_alias);
		}
	}
        return true;
}

function sdfAddToAdminLinks(&$admin_links_tree) {
        $browse_search_section = $admin_links_tree->getSection(wfMsg('adminlinks_browsesearch'));
        $sd_row = new ALRow('sd');
        $sd_row->addItem(ALItem::newFromSpecialPage('BrowseData'));
        $sd_row->addItem(ALItem::newFromSpecialPage('Filters'));
        $sd_row->addItem(ALItem::newFromSpecialPage('CreateFilter'));
        $sd_name = wfMsg('specialpages-group-sd_group');
        $sd_docu_label = wfMsg('adminlinks_documentation', $sd_name);
        $sd_row->addItem(AlItem::newFromExternalLink("http://www.mediawiki.org/wiki/Extension:Semantic_Drilldown", $sd_docu_label));

        $browse_search_section->addRow($sd_row);

        return true;
}

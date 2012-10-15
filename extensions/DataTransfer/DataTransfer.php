<?php
/**
 * Global functions and constants for the Data Transfer extension.
 *
 * @author Yaron Koren
 */

if ( !defined( 'MEDIAWIKI' ) ) die();

define( 'DATA_TRANSFER_VERSION', '0.3.9' );

// constants for special properties
define( 'DT_SP_HAS_XML_GROUPING', 1 );
define( 'DT_SP_IS_EXCLUDED_FROM_XML', 2 );

$wgExtensionCredits['specialpage'][] = array(
	'path'           => __FILE__,
	'name'           => 'Data Transfer',
	'version'        => DATA_TRANSFER_VERSION,
	'author'         => 'Yaron Koren',
	'url'            => 'https://www.mediawiki.org/wiki/Extension:Data_Transfer',
	'descriptionmsg' => 'datatransfer-desc',
);

###
# This is the path to your installation of Semantic Forms as
# seen on your local filesystem. Used against some PHP file path
# issues.
##
$dtgIP = dirname( __FILE__ );
##

// register all special pages and other classes
$wgAutoloadClasses['DTUtils'] = $dtgIP . '/includes/DT_Utils.php';
$wgSpecialPages['ViewXML'] = 'DTViewXML';
$wgAutoloadClasses['DTViewXML'] = $dtgIP . '/specials/DT_ViewXML.php';
$wgSpecialPages['ImportXML'] = 'DTImportXML';
$wgAutoloadClasses['DTImportXML'] = $dtgIP . '/specials/DT_ImportXML.php';
$wgSpecialPages['ImportCSV'] = 'DTImportCSV';
$wgAutoloadClasses['DTImportCSV'] = $dtgIP . '/specials/DT_ImportCSV.php';
$wgJobClasses['dtImport'] = 'DTImportJob';
$wgAutoloadClasses['DTImportJob'] = $dtgIP . '/includes/DT_ImportJob.php';
$wgAutoloadClasses['DTXMLParser'] = $dtgIP . '/includes/DT_XMLParser.php';
$wgHooks['AdminLinks'][] = 'dtfAddToAdminLinks';
$wgHooks['smwInitProperties'][] = 'dtfInitProperties';

###
# This is the path to your installation of the Data Transfer extension as
# seen from the web. Change it if required ($wgScriptPath is the
# path to the base directory of your wiki). No final slash.
##
$dtgScriptPath = $wgScriptPath . '/extensions/DataTransfer';
##

###
# Permission to import files
###
$wgGroupPermissions['sysop']['datatransferimport'] = true;
$wgAvailableRights[] = 'datatransferimport';

// initialize content language
require_once($dtgIP . '/languages/DT_Language.php');
global $wgLanguageCode;
dtfInitContentLanguage($wgLanguageCode);

$wgExtensionMessagesFiles['DataTransfer'] = $dtgIP . '/languages/DT_Messages.php';
$wgExtensionMessagesFiles['DataTransferAlias'] = $dtgIP . '/languages/DT_Aliases.php';

/**********************************************/
/***** language settings                  *****/
/**********************************************/

/**
 * Initialise a global language object for content language. This
 * must happen early on, even before user language is known, to
 * determine labels for additional namespaces. In contrast, messages
 * can be initialised much later when they are actually needed.
 */
function dtfInitContentLanguage( $langcode ) {
	global $dtgIP, $dtgContLang;

	if ( !empty( $dtgContLang ) ) { return; }

	$dtContLangClass = 'DT_Language' . str_replace( '-', '_', ucfirst( $langcode ) );

	if ( file_exists( $dtgIP . '/languages/' . $dtContLangClass . '.php' ) ) {
		include_once( $dtgIP . '/languages/' . $dtContLangClass . '.php' );
	}

	// fallback if language not supported
	if ( !class_exists( $dtContLangClass ) ) {
		include_once( $dtgIP . '/languages/DT_LanguageEn.php' );
		$dtContLangClass = 'DT_LanguageEn';
	}

	$dtgContLang = new $dtContLangClass();
}

/**
 * Initialise the global language object for user language. This
 * must happen after the content language was initialised, since
 * this language is used as a fallback.
 */
function dtfInitUserLanguage( $langcode ) {
	global $dtgIP, $dtgLang;

	if ( !empty( $dtgLang ) ) { return; }

	$dtLangClass = 'DT_Language' . str_replace( '-', '_', ucfirst( $langcode ) );

	if ( file_exists( $dtgIP . '/languages/' . $dtLangClass . '.php' ) ) {
		include_once( $dtgIP . '/languages/' . $dtLangClass . '.php' );
	}

	// fallback if language not supported
	if ( !class_exists( $dtLangClass ) ) {
		global $dtgContLang;
		$dtgLang = $dtgContLang;
	} else {
		$dtgLang = new $dtLangClass();
	}
}

/**********************************************/
/***** other global helpers               *****/
/**********************************************/

function dtfInitProperties() {
	global $dtgContLang;
	$dt_props = $dtgContLang->getPropertyLabels();
	SMWPropertyValue::registerProperty( '_DT_XG', '_str', $dt_props[DT_SP_HAS_XML_GROUPING], true );
	// TODO - this should set a "backup" English value as well,
	// so that the phrase "Has XML grouping" works in all languages
	return true;
}

/**
 * Add links to the 'AdminLinks' special page, defined by the Admin Links
 * extension
 */
function dtfAddToAdminLinks( $admin_links_tree ) {
	$import_export_section = $admin_links_tree->getSection( wfMsg( 'adminlinks_importexport' ) );
	$main_row = $import_export_section->getRow( 'main' );
	$main_row->addItem( ALItem::newFromSpecialPage( 'ViewXML' ) );
	$main_row->addItem( ALItem::newFromSpecialPage( 'ImportXML' ) );
	$main_row->addItem( ALItem::newFromSpecialPage( 'ImportCSV' ) );
	return true;
}

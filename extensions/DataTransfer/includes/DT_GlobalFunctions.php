<?php
/**
 * Global functions and constants for the Data Transfer extension.
 *
 * @author Yaron Koren
 */

if (!defined('MEDIAWIKI')) die();

define('DT_VERSION','0.1.8');

// constants for special properties
define('DT_SP_HAS_XML_GROUPING', 1);
define('DT_SP_IS_EXCLUDED_FROM_XML', 2);

$wgExtensionCredits['specialpage'][]= array(
	'name'           => 'Data Transfer',
	'version'        => DT_VERSION,
	'author'         => 'Yaron Koren',
	'url'            => 'http://www.mediawiki.org/wiki/Extension:Data_Transfer',
	'description'    => 'Exports wiki pages as XML, using template calls as the data structure',
	'descriptionmsg' => 'dt-desc',
);

$dtgIP = $IP . '/extensions/DataTransfer';

// register all special pages and other classes
$wgSpecialPages['ViewXML'] = 'DTViewXML';
$wgAutoloadClasses['DTViewXML'] = $dtgIP . '/specials/DT_ViewXML.php';

require_once($dtgIP . '/languages/DT_Language.php');
$wgExtensionMessagesFiles['DataTransfer'] = $dtgIP . '/languages/DT_Messages.php';

/**********************************************/
/***** language settings                  *****/
/**********************************************/

/**
 * Initialise a global language object for content language. This
 * must happen early on, even before user language is known, to
 * determine labels for additional namespaces. In contrast, messages
 * can be initialised much later when they are actually needed.
 */
function dtfInitContentLanguage($langcode) {
	global $dtgIP, $dtgContLang;

	if (!empty($dtgContLang)) { return; }

	$dtContLangClass = 'DT_Language' . str_replace( '-', '_', ucfirst( $langcode ) );

	if (file_exists($dtgIP . '/languages/'. $dtContLangClass . '.php')) {
		include_once( $dtgIP . '/languages/'. $dtContLangClass . '.php' );
	}

	// fallback if language not supported
	if ( !class_exists($dtContLangClass)) {
		include_once($dtgIP . '/languages/DT_LanguageEn.php');
		$dtContLangClass = 'DT_LanguageEn';
	}

	$dtgContLang = new $dtContLangClass();
}

/**
 * Initialise the global language object for user language. This
 * must happen after the content language was initialised, since
 * this language is used as a fallback.
 */
function dtfInitUserLanguage($langcode) {
	global $dtgIP, $dtgLang;

	if (!empty($dtgLang)) { return; }

	$dtLangClass = 'DT_Language' . str_replace( '-', '_', ucfirst( $langcode ) );

	if (file_exists($dtgIP . '/languages/'. $dtLangClass . '.php')) {
		include_once( $dtgIP . '/languages/'. $dtLangClass . '.php' );
	}

	// fallback if language not supported
	if ( !class_exists($dtLangClass)) {
		global $dtgContLang;
		$dtgLang = $dtgContLang;
	} else {
		$dtgLang = new $dtLangClass();
	}
}

/**********************************************/
/***** other global helpers               *****/
/**********************************************/

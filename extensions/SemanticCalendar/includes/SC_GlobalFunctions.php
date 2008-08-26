<?php
/**
 * Global functions and constants for Semantic Calendar
 *
 * @author Yaron Koren
 */

if (!defined('MEDIAWIKI')) die();

define('SC_VERSION','0.2.7');

$wgExtensionCredits['parserhook'][]= array(
	'name'        => 'Semantic Calendar',
	'version'     => SC_VERSION,
	'author'      => 'Yaron Koren',
	'url'         => 'http://www.mediawiki.org/wiki/Extension:Semantic_Calendar',
	'description' =>  'A calendar that displays semantic date information',
);

$wgExtensionFunctions[] = 'scgParserFunctions';
$wgHooks['LanguageGetMagic'][] = 'scgLanguageGetMagic';

require_once($scgIP . '/includes/SC_ParserFunctions.php');
require_once($scgIP . '/includes/SC_HistoricalDate.php');
require_once($scgIP . '/languages/SC_Language.php');

$wgExtensionMessagesFiles['SemanticCalendar'] = $scgIP . '/languages/SC_Messages.php';

/**********************************************/
/***** namespace settings                 *****/
/**********************************************/

/**********************************************/
/***** language settings                  *****/
/**********************************************/

/**
 * Initialise a global language object for content language. This
 * must happen early on, even before user language is known, to
 * determine labels for additional namespaces. In contrast, messages
 * can be initialised much later when they are actually needed.
 */
function scfInitContentLanguage($langcode) {
	global $scgIP, $scgContLang;

	if (!empty($scgContLang)) { return; }

	$scContLangClass = 'SC_Language' . str_replace( '-', '_', ucfirst( $langcode ) );

	if (file_exists($scgIP . '/languages/'. $scContLangClass . '.php')) {
		include_once( $scgIP . '/languages/'. $scContLangClass . '.php' );
	}

	// fallback if language not supported
	if ( !class_exists($scContLangClass)) {
		include_once($scgIP . '/languages/SC_LanguageEn.php');
		$scContLangClass = 'SC_LanguageEn';
	}

	$scgContLang = new $scContLangClass();
}

/**
 * Initialize the global language object for user language. This
 * must happen after the content language was initialised, since
 * this language is used as a fallback.
 */
function scfInitUserLanguage($langcode) {
	global $scgIP, $scgLang;

	if (!empty($scgLang)) { return; }

	$scLangClass = 'SC_Language' . str_replace( '-', '_', ucfirst( $langcode ) );
	if (file_exists($scgIP . '/languages/'. $scLangClass . '.php')) {
		include_once( $scgIP . '/languages/'. $scLangClass . '.php' );
	}

	// fallback if language not supported
	if ( !class_exists($scLangClass)) {
		global $scgContLang;
		$scgLang = $scgContLang;
	} else {
		$scgLang = new $scLangClass();
	}
}

/**********************************************/
/***** other global helpers               *****/
/**********************************************/

function scfGetEvents($date_property, $filter_query) {
	global $smwgIP;
	include_once($smwgIP . "/includes/SMW_QueryProcessor.php");
	$events = array();
	// some changes were made to querying in SMW 1.2
	$smw_version = SMW_VERSION;
	if (version_compare(SMW_VERSION, '1.2', '>=' ) ||
		substr($smw_version, 0, 3) == '1.2') { // temporary hack
		$query_string = "[[$date_property::+]]$filter_query";
	} else {
		$query_string = "[[$date_property::*]][[$date_property::+]]$filter_query";
	}
	// set a limit sufficiently close to infinity
	$params = array('limit' => 100000);
	$inline = false;
	$format = 'auto';
	$printlabel = "";
	$printouts = array();
	if (version_compare(SMW_VERSION, '1.2', '>=' ) ||
		substr($smw_version, 0, 3) == '1.2') { // temporary hack
		$printouts[] = new SMWPrintRequest(SMWPrintRequest::PRINT_PROP, $printlabel, Title::newFromText($date_property, SMW_NS_PROPERTY));
	} else {
		$printouts[] = new SMWPrintRequest(SMW_PRINT_THIS, $printlabel);
	}
	$query  = SMWQueryProcessor::createQuery($query_string, $params, $inline, $format, $printouts);
	$results = smwfGetStore()->getQueryResult($query);
	while ($row = $results->getNext()) {
		$event_names = $row[0];
		$event_dates = $row[1];
		$event_title = $event_names->getNextObject()->getTitle();
		while ($event_date = $event_dates->getNextObject()) {
			$actual_date = date("Y-m-d", $event_date->getNumericValue());
			$events[] = array($event_title, $actual_date);
		}
	}
	return $events;
}

<?php
/**
 * LinkSuggest
 *
 * This extension provides the users with article title suggestions as he types
 * a link in wikitext.
 *
 * @file
 * @ingroup Extensions
 * @author Inez Korczyński <inez@wikia-inc.com>
 * @author Bartek Łapiński <bartek@wikia-inc.com>
 * @author Lucas Garczewski (TOR) <tor@wikia-inc.com>
 * @author Sean Colombo <sean@wikia.com>
 * @author Maciej Brencz <macbre@wikia-inc.com>
 * @author Robert Elwell <robert@wikia-inc.com>
 * @copyright Copyright (c) 2008-2012, Wikia Inc.
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

if(!defined('MEDIAWIKI')) {
	die(1);
}

$wgExtensionCredits['other'][] = array(
    'name' => 'LinkSuggest',
    'author' => 'Inez Korczyński, Bartek Łapiński, Ciencia al Poder, Lucas Garczewski, Sean Colombo, Maciej Brencz, Robert Elwell',
    'version' => '1.53',
);

$wgLinkSuggestLimit = 6;

$wgExtensionMessagesFiles['LinkSuggest'] = dirname(__FILE__).'/'.'LinkSuggest.i18n.php';
F::build('JSMessages')->registerPackage('LinkSuggest', array('tog-*'));

$wgHooks['GetPreferences'][] = 'wfLinkSuggestGetPreferences' ;
function wfLinkSuggestGetPreferences($user, &$preferences) {
	$preferences['disablelinksuggest'] = array(
		'type' => 'toggle',
		'section' => 'editing/editing-experience',
		'label-message' => 'tog-disablelinksuggest',
	);
	return true;
}

$wgHooks['EditForm::MultiEdit:Form'][] = 'AddLinkSuggest';
function AddLinkSuggest($a, $b, $c, $d) {
	global $wgOut, $wgExtensionsPath, $wgUser, $wgHooks;
	wfProfileIn(__METHOD__);

	if($wgUser->getOption('disablelinksuggest') != true) {
		$js = "{$wgExtensionsPath}/wikia/LinkSuggest/LinkSuggest.js";

		// load YUI for Oasis - TODO: Refactor LinkSuggest.js to not use YUI.  Look in /trunk/skins/oasis/js/Search.js for an example of using LinkSuggest with jQuery.
		if ( F::app()->checkSkin( 'oasis' ) ) {
			$wgOut->addHTML('<script type="text/javascript">$(function() {$.loadYUI(function() {$.getScript('.Xml::encodeJsVar($js).')})})</script>');
		}
		else {
			$wgOut->addScript('<script type="text/javascript" src="'.$js.'"></script>');
		}

		// add global JS variables only when LinkSuggest is really loaded (BugId:20958)
		$wgHooks['MakeGlobalVariablesScript'][] = 'wfLinkSuggestSetupVars';
	}

	wfProfileOut(__METHOD__);
	return true;
}

function wfLinkSuggestSetupVars( Array &$vars ) {
	global $wgContLang;
	$vars['ls_template_ns'] = $wgContLang->getFormattedNsText( NS_TEMPLATE );
	$vars['ls_file_ns'] = $wgContLang->getFormattedNsText( NS_FILE );
	return true;
}

$wgAjaxExportList[] = 'getLinkSuggest';
$wgAjaxExportList[] = 'getLinkSuggestImage';

function getLinkSuggestImage() {
	global $wgRequest;
	wfProfileIn(__METHOD__);

	$imageName = $wgRequest->getText('imageName');

	$out = 'N/A';
	try {
		$img = wfFindFile($imageName);
		if($img) {
			$out = $img->createThumb(180);
		}
	} catch (Exception $e) {
		$out = 'N/A';
	}

	$ar = new AjaxResponse($out);
	$ar->setCacheDuration(60 * 60);

	wfProfileOut(__METHOD__);
	return $ar;
}

function linkSuggestAjaxResponse($out) {
	global $wgRequest;
	if ($wgRequest->getText('format') == 'json') {
		$ar = new AjaxResponse($out);
		$ar->setCacheDuration(60 * 60); // cache results for one hour
		$ar->setContentType('application/json; charset=utf-8');
   	}
	else {
		$ar = new AjaxResponse($out);
		$ar->setCacheDuration(60 * 60);
		$ar->setContentType('text/plain; charset=utf-8');
	}

	return $ar;

}


function getLinkSuggest() {
	global $wgRequest, $wgContLang, $wgCityId, $wgExternalDatawareDB, $wgContentNamespaces, $wgMemc, $wgLinkSuggestLimit;
	wfProfileIn(__METHOD__);

	$isMobile = F::app()->checkSkin( 'wikiamobile' );
	// trim passed query and replace spaces by underscores
	// - this is how MediaWiki store article titles in database
	$query = urldecode( trim( $wgRequest->getText('query') ) );
	$query = str_replace(' ', '_', $query);

	if ( $isMobile ) {
		$key = wfMemcKey( __METHOD__, md5( $query.'_'.$wgRequest->getText('format') ), 'WikiaMobile' );
	} else {
		$key = wfMemcKey( __METHOD__, md5( $query.'_'.$wgRequest->getText('format') ) );
	}
	
	if (strlen($query) < 3 ) {
		// enforce minimum character limit on server side
		$out = $wgRequest->getText('format') == 'json'
			 ? json_encode(array('suggestions'=>array(),'redirects'=>array()))
			 : '';
	} else if ($cached = $wgMemc->get($key)) {
		$out = $cached;
	}

	if (isset($out)) {
		return linkSuggestAjaxResponse($out);
	}

	// Allow the calling-code to specify a namespace to search in (which at the moment, could be overridden by having prefixed text in the input field).
	// NOTE: This extension does parse titles to try to find things in other namespaces, but that actually doesn't work in practice because jQuery
	// Autocomplete will stop making requests after it finds 0 results.  So if you start to type "Category" and there is no page beginning
	// with "Cate", it will not even make the call to LinkSuggest.
	$namespace = $wgRequest->getVal('ns');

	// explode passed query by ':' to get namespace and article title
	$queryParts = explode(':', $query, 2);

	if(count($queryParts) == 2) {
		$query = $queryParts[1];

		$namespaceName = $queryParts[0];

		// try to get the index by canonical name first
		$namespace = MWNamespace::getCanonicalIndex(strtolower($namespaceName));
		if ( $namespace == null ) {
			// if we failed, try looking through localized namespace names
			$namespace = array_search(ucfirst($namespaceName), $wgContLang->getNamespaces());
			if (empty($namespace)) {
				// getting here means our "namespace" is not real and can only be part of the title
				$query = $namespaceName . ':' . $query;
			}
		}

		if ($namespace !== null && $query === '') {
			$out = $wgRequest->getText('format') == 'json'
				 ? json_encode(array('suggestions'=>array(),'redirects'=>array()))
				 : '';

			return linkSuggestAjaxResponse($out);
		}

	}

	// which namespaces to search in?
	if (empty($namespace)) {
		// search only within content namespaces (BugId:4625) - default behaviour
		$namespaces = $wgContentNamespaces;
	}
	else {
		// search only within a given namespace
		$namespaces = array($namespace);
	}

	$query = addslashes($query);

	$db = wfGetDB(DB_SLAVE, 'search');

	$redirects = array();
	$results = array();
	$exactMatchRow = null;

	$queryLower = strtolower($query);

	$res = $db->select(
		array( 'querycache', 'page' ),
		array( 'page_namespace', 'page_title', 'page_is_redirect' ),
		array(
			'qc_title = page_title',
			'qc_namespace = page_namespace',
			'page_is_redirect = 0',
			'qc_type' => 'Mostlinked',
			"(qc_title LIKE '{$query}%' or LOWER(qc_title) LIKE '{$queryLower}%')",
			'qc_namespace' => $namespaces
		),
		__METHOD__,
		array( 'ORDER BY' => 'qc_value DESC', 'LIMIT' => $wgLinkSuggestLimit )
	);

	linkSuggestFormatResults($db, $res, $query, $redirects, $results, $exactMatchRow);

	if (count($namespaces) > 0) {
		$commaJoinedNamespaces = count($namespaces) > 1 ?  array_shift($namespaces) . ', ' . implode(', ', $namespaces) : $namespaces[0];
	}

	$pageNamespaceClause = isset($commaJoinedNamespaces) ?  'page_namespace IN (' . $commaJoinedNamespaces . ') AND ' : '';
	if( count($results) < $wgLinkSuggestLimit ) {
		$orderBy = '';
		/* just don't add the sort option on lyrics wiki */
		if ( $wgCityId != 43339 ) {
			$orderBy = 'order by page_len desc'; 			
		}

		$sql = "SELECT page_len, page_id, page_title, rd_title, page_namespace, page_is_redirect

				FROM page IGNORE INDEX (`name_title`)

				LEFT JOIN redirect ON page_is_redirect = 1 AND page_id = rd_from

				WHERE {$pageNamespaceClause} (page_title LIKE '{$query}%' or LOWER(page_title) LIKE '{$queryLower}%')

				{$orderBy}

				LIMIT ".($wgLinkSuggestLimit * 3);
				
		$res = $db->query($sql);

		linkSuggestFormatResults($db, $res, $query, $redirects, $results, $exactMatchRow);
	}

	if ($exactMatchRow !== null) {

		$row = $exactMatchRow;

		$titleFormatted = wfLinkSuggestFormatTitle($row->page_namespace, $row->page_title);

		if ($row->page_is_redirect == 0) {

			// remove any instances of original array's value
			$resultsFlipped = array_flip($results);
			unset($resultsFlipped[$titleFormatted]);
			$results = array_flip($resultsFlipped);

			array_unshift($results, $titleFormatted);

			$flippedRedirs = array_flip($redirects);
			if (isset($flippedRedirs[$titleFormatted])) {
				unset($redirects[$flippedRedirs[$titleFormatted]]);
			}

		} else {

			$redirTitleFormatted = wfLinkSuggestFormatTitle($row->page_namespace, $row->rd_title);

			// remove any instances of original array's value
			$resultsFlipped = array_flip($results);
			unset($resultsFlipped[$redirTitleFormatted]);
			$results = array_flip($resultsFlipped);

			array_unshift($results, $redirTitleFormatted);
			$redirects[$redirTitleFormatted] = $titleFormatted;
		}
	}

	$db->freeResult( $res );

	// bugid 29988: include special pages
	// (registered in SpecialPage::$mList, not in the DB like a normal page)
	if (($namespaces == array('-1')) && (strlen($query) > 0)) {
		$specialPagesByAlpha = SpecialPageFactory::getList();
		ksort($specialPagesByAlpha, SORT_STRING);
		array_walk( $specialPagesByAlpha,
					function($val,$key) use (&$results, $query) {
						if (strtolower(substr($key, 0, strlen($query))) === strtolower($query)) {
							$results[] = wfLinkSuggestFormatTitle('-1', $key);
						}
					}
				  );
	}


	$format = $wgRequest->getText('format');

	if ($format == 'json') {
		$result_values = array_values($results);

		if ( $isMobile ) {
			$out = json_encode( array( array_splice( $result_values, 0, 10), array_splice($redirects, -1, 1) ) );
		} else {
			$out = json_encode(array('query' => $wgRequest->getText('query'), 'suggestions' => $result_values, 'redirects' => $redirects));
		}


	// legacy: LinkSuggest.js uses this
	} else {
		// Overwrite canonical title with redirect title
		for($i = 0; $i < count($results); $i++) {
			if (isset($redirects[$results[$i]])) {
				$results[$i] = $redirects[$results[$i]];
			}
		}

		$out = implode("\n", $results);
	}

	// 15 minutes times four (one hour, but easier to slice and dice)
	$wgMemc->set($key, $out, 4 * 900);

	wfProfileOut(__METHOD__);
	return linkSuggestAjaxResponse($out);
}

function linkSuggestFormatResults($db, $res, $query, &$redirects, &$results, &$exactMatchRow) {
	global $wgLinkSuggestLimit;	
	while(($row = $db->fetchObject($res)) && count($results) < $wgLinkSuggestLimit ) {

		if (strtolower($row->page_title) == $query) {
			$exactMatchRow = $row;
			continue;
		}

		$titleFormatted = wfLinkSuggestFormatTitle($row->page_namespace, $row->page_title);

		if ($row->page_is_redirect == 0) {

			if (!in_array($titleFormatted, $results)) {
				$results[] = $titleFormatted;
			}

			$flippedRedirs = array_flip($redirects);
			if (isset($flippedRedirs[$titleFormatted])) {
				unset($redirects[$flippedRedirs[$titleFormatted]]);
			}

		} else {

			$redirTitleFormatted = wfLinkSuggestFormatTitle($row->page_namespace, $row->rd_title);

			if (!in_array($redirTitleFormatted, $results)) {

				$results[] = $redirTitleFormatted;
				$redirects[$redirTitleFormatted] = $titleFormatted;

			}

		}

	}
}

/**
 * Returns formatted title based on given namespace and title
 *
 * @param $namespace integer page namespace ID
 * @param $title string page title
 * @return string formatted title (prefixed with localised namespace)
 */
function wfLinkSuggestFormatTitle($namespace, $title) {
	global $wgContLang;

	if ($namespace != NS_MAIN) {
		$title = $wgContLang->getNsText($namespace) . ':' . $title;
	}

	return str_replace('_', ' ', $title);
}

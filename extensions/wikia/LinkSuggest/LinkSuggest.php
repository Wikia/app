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
 * @copyright Copyright © 2008-2009, Wikia Inc.
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

if(!defined('MEDIAWIKI')) {
	die(1);
}

$wgExtensionCredits['other'][] = array(
    'name' => 'LinkSuggest',
    'author' => 'Inez Korczyński, Bartek Łapiński, Ciencia al Poder',
    'version' => '1.52',
);

$wgExtensionMessagesFiles['LinkSuggest'] = dirname(__FILE__).'/'.'LinkSuggest.i18n.php';

$wgHooks['UserToggles'][] = 'wfLinkSuggestToggle' ;
$wgHooks['getEditingPreferencesTab'][] = 'wfLinkSuggestToggle' ;
$wgHooks['MakeGlobalVariablesScript'][] = 'wfLinkSuggestSetupVars';


function wfLinkSuggestSetupVars( $vars ) {
	global $wgContLang;
	$vars['ls_template_ns'] = $wgContLang->getFormattedNsText( NS_TEMPLATE );
	$vars['ls_file_ns'] = $wgContLang->getFormattedNsText( NS_FILE );
	return true;
}

function wfLinkSuggestToggle($toggles, $default_array = false) {
	wfLoadExtensionMessages('LinkSuggest');
	if(is_array($default_array)) {
		$default_array[] = 'disablelinksuggest';
	} else {
		$toggles[] = 'disablelinksuggest';
	}
	return true;
}

$wgHooks['EditForm::MultiEdit:Form'][] = 'AddLinkSuggest';
function AddLinkSuggest($a, $b, $c, $d) {
	global $wgOut, $wgExtensionsPath, $wgStyleVersion, $wgUser;
	if($wgUser->getOption('disablelinksuggest') != true) {
		$wgOut->addHTML('<div id="LS_imagePreview" style="visibility: hidden; position: absolute; z-index: 1001; width: 180px;" class="yui-ac-content"></div>');
		$wgOut->addHTML('<div id="wpTextbox1_container" class="link-suggest-container"></div>');
		$wgOut->addScript('<script type="text/javascript" src="'.$wgExtensionsPath.'/wikia/LinkSuggest/LinkSuggest.js?'.$wgStyleVersion.'"></script>');
	}
	return true;
}

global $wgAjaxExportList;
$wgAjaxExportList[] = 'getLinkSuggest';
$wgAjaxExportList[] = 'getLinkSuggestImage';

function getLinkSuggestImage() {
	global $wgRequest;
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
	return $ar;
}

function getLinkSuggest() {
	global $wgRequest, $wgContLang, $wgCityId, $wgExternalDatawareDB;

	// trim passed query and replace spaces by underscores
	// - this is how MediaWiki store article titles in database
	$query = urldecode( trim( $wgRequest->getText('query') ) );
	$query = str_replace(' ', '_', $query);

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
	}

	$results = array();

	if (empty($namespace))
		// default namespace to search in
		$namespace = NS_MAIN;

	// get localized namespace name
	$namespaceName = $wgContLang->getNsText($namespace);
	// and prepare it for later use...
	$namespacePrefix = (!empty($namespaceName)) ? $namespaceName . ':' : '';

	$query = addslashes(mb_strtolower($query));
	$db = wfGetDB(DB_SLAVE, 'search' );

	$res = $db->select(
		array( "querycache" ),
		array( "qc_title" ),
		array(
			" qc_type = 'Mostlinked' ",
			" LOWER(qc_title) LIKE LOWER('{$query}%') ",
			" qc_namespace = {$namespace} "
		),
		__METHOD__,
		array("ORDER BY" => "qc_value DESC", "LIMIT" => 10)
	);
	while($row = $db->fetchObject($res)) {
		$results[] = str_replace('_', ' ', $namespacePrefix . $row->qc_title);
	}
	$db->freeResult( $res );

	$dbs = wfGetDB( DB_SLAVE, array(), $wgExternalDatawareDB );
	$res = $dbs->select(
		array( "pages" ),
		array( "page_title" ),
		array(
			" page_wikia_id " => $wgCityId,
			" page_title_lower LIKE '{$query}%' ",
			" page_namespace = {$namespace} ",
			" page_status = 0 "
		),
		__METHOD__,
		array(
			"ORDER BY" => "page_title_lower ASC",
			"LIMIT" => (15 - count($results))
		)
	);
	while($row = $dbs->fetchObject($res)) {
		$results[] = str_replace('_', ' ', $namespacePrefix . $row->page_title);
	}
	$dbs->freeResult( $res );

	$results = array_unique($results);

	if($wgRequest->getText('format') == 'json') {
		$out = Wikia::json_encode(array('query' => $wgRequest->getText('query'), 'suggestions' => array_values($results)));
	} else {
		$out = implode("\n", $results);
	}

	$ar = new AjaxResponse($out);
	$ar->setCacheDuration(60 * 60); // cache results for one hour

	return $ar;
}

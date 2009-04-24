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
    'version' => '1.51',
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
		$wgOut->addHTML('<div id="wpTextbox1_container" class="yui-ac-container"></div>');
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

	$img = wfFindFile($imageName);

	if($img) {
		$out = $img->createThumb(180);
	}

	if(trim($out) == '') {
		$out = 'N/A';
	}

	$ar = new AjaxResponse($out);
	$ar->setCacheDuration(60 * 60);
	return $ar;
}

function getLinkSuggest() {
	global $wgRequest, $wgContLang;

	// trim passed query and replace spaces by underscores
	// - this is how MediaWiki store article titles in database
	$query = str_replace(' ', '_', trim($wgRequest->getText('query')));

	// explode passed query by ':' to get namespace and article title
	$queryParts = explode(':', $query, 2);

	if(count($queryParts) == 2) {
		$query = $queryParts[1];

		$namespaceName = $queryParts[0];

		// try to get the index by canonical name first
		$namespace = Namespace::getCanonicalIndex(strtolower($namespaceName));
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

	$query = addslashes(strtolower($query));
	$db =& wfGetDB(DB_SLAVE, 'search');

	$sql = "SELECT qc_title FROM querycache WHERE qc_type = 'Mostlinked' AND LOWER(qc_title) LIKE '{$query}%' AND qc_namespace = {$namespace} ORDER BY qc_value DESC LIMIT 10;";
	$res = $db->query($sql);
	while($row = $db->fetchObject($res)) {
		$results[] = str_replace('_', ' ', $namespacePrefix . $row->qc_title);
	}

	$sql = "SELECT page_title FROM page WHERE lower(page_title) LIKE '{$query}%' AND page_is_redirect=0 AND page_namespace = {$namespace} ORDER BY page_title ASC LIMIT ".(15 - count($results));
	$res = $db->query($sql);
	while($row = $db->fetchObject($res)) {
		$results[] = str_replace('_', ' ', $namespacePrefix . $row->page_title);
	}

	$results = array_unique($results);

	$ar = new AjaxResponse(implode("\n", $results));
	$ar->setCacheDuration(60 * 60); // cache results for one hour

	return $ar;
}

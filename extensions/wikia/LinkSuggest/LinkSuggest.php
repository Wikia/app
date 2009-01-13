<?php
/*
 * LinkSuggest
 * @author Inez Korczyński
 */
if(!defined('MEDIAWIKI')) {
	die(1);
}

$wgExtensionCredits['other'][] = array(
    'name' => 'LinkSuggest',
    'author' => 'Inez Korczyński',
);

$wgExtensionMessagesFiles['LinkSuggest'] = dirname(__FILE__).'/'.'LinkSuggest.i18n.php';

$wgHooks['UserToggles'][] = 'wfLinkSuggestToggle' ;
$wgHooks['getEditingPreferencesTab'][] = 'wfLinkSuggestToggle' ;

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
		$wgOut->addHTML('<div id="wpTextbox1_container" class="yui-ac-container"></div>');
		$wgOut->addScript('<script type="text/javascript" src="'.$wgExtensionsPath.'/wikia/LinkSuggest/LinkSuggest.js?'.$wgStyleVersion.'"></script>');
	}
	return true;
}

global $wgAjaxExportList;
$wgAjaxExportList[] = 'getLinkSuggest';

function getLinkSuggest() {
	global $wgRequest, $wgContLang;

	// default namespace to search in
	$namespace = NS_MAIN;

	// trim passed query and replace spaces by underscores
	// - this is how MediaWiki store article titles in database
	$query = str_replace(' ', '_', trim($wgRequest->getText('query')));

	// explode passed query by ':' to get namespace and article title
	$queryParts = explode(':', $query, 2);

	if(count($queryParts) == 2) {
		$query = $queryParts[1];

		$namespaceName = $queryParts[0];
		$namespace = Namespace::getCanonicalIndex(strtolower($namespaceName));
		$namespaceName = $wgContLang->getNsText($namespace);
	}

	$results = array();

	if(!empty($namespace) || $namespace === 0) {
		$query = addslashes(strtolower($query));
		$db =& wfGetDB(DB_SLAVE, 'search');

		$sql = "SELECT qc_title FROM querycache WHERE qc_type = 'Mostlinked' AND LOWER(qc_title) LIKE '{$query}%' AND qc_namespace = {$namespace} ORDER BY qc_value DESC LIMIT 10;";
		$res = $db->query($sql);
		while($row = $db->fetchObject($res)) {
			$results[] = str_replace('_', ' ', (!empty($namespaceName) ? $namespaceName . ':' : '') . $row->qc_title);
		}

		$sql = "SELECT page_title FROM page WHERE lower(page_title) LIKE '{$query}%' AND page_is_redirect=0 AND page_namespace = {$namespace} ORDER BY page_title ASC LIMIT ".(15 - count($results));
		$res = $db->query($sql);
		while($row = $db->fetchObject($res)) {
			$results[] = str_replace('_', ' ', (!empty($namespaceName) ? $namespaceName . ':' : '') . $row->page_title);
		}

		$results = array_unique($results);
	}

	$ar = new AjaxResponse(implode("\n", $results));
	$ar->setCacheDuration(60 * 60); // cache results for one hour

	return $ar;
}

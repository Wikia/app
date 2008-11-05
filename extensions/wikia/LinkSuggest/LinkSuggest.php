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

	$namespace = 0;

	$query = str_replace(' ', '_', trim($wgRequest->getText('query')));

	$queryA = split(':', $query);

	if(count($queryA) > 1) {
		$namespaceName = $queryA[0];
		$query = $queryA[1];
	}

	if(isset($namespaceName)) {
		$namespace = Namespace::getCanonicalIndex(strtolower($namespaceName));
		$namespaceName = $wgContLang->getNsText($namespace);
	}

	if(!empty($namespace) || $namespace === 0) {
		$query = addslashes(strtolower($query));
		$results = array();
		$pageIds = array();

		$db =& wfGetDB(DB_SLAVE, 'search');

		$sql = "SELECT /* LinkSuggest query 1 */ DISTINCT page_id, page_title, page_namespace FROM page, querycache WHERE qc_type = 'Mostlinked' AND page_title = qc_title AND page_namespace = qc_namespace AND LOWER(qc_title) LIKE '{$query}%' AND qc_namespace = {$namespace} ORDER BY qc_value DESC LIMIT 10";
		wfDebugLog( 'linksuggest', "Database: {$db->getDBName()}" );
		wfDebugLog( 'linksuggest', "Query1: {$sql}"  );
		$res = $db->query($sql);
		while($row = $db->fetchObject($res)) {
			$pageIds[] = $row->page_id;
			$results[] = array(
				'title_org' => str_replace('_', ' ', (!empty($namespaceName)) ? $namespaceName . ':' . $row->page_title : $row->page_title),
				'title' => (!empty($namespaceName) ? $namespaceName . ':' : '') . str_replace('_', ' ', $row->page_title)
			);
		}

		if(count($results) < 10) {
			$statement = (count($pageIds) > 0) ? ' AND page_id not IN('.implode(',', $pageIds).') ' : '';
			$sql = "SELECT /* LinkSuggest query 2 */ page_id, page_title, page_namespace FROM `page` WHERE lower(page_title) LIKE '{$query}%' AND page_is_redirect=0 AND page_namespace = {$namespace} {$statement} ORDER BY page_title ASC LIMIT ".(10 - count($results));
			wfDebugLog( 'linksuggest', "Query2: {$sql}"  );
			$res = $db->query($sql);
			while($row = $db->fetchObject($res)) {
				$pageIds[] = $row->page_id;
				$results[] = array(
					'title_org' => str_replace('_', ' ', (!empty($namespaceName)) ? $namespaceName . ':' . $row->page_title : $row->page_title),
					'title' => (!empty($namespaceName) ? $namespaceName . ':' : '') . str_replace('_', ' ', $row->page_title)
				);
			}
		}

		if(count($results) < 10) {
			$statement = (count($pageIds) > 0) ? ' AND page_id not IN('.implode(',', $pageIds).') ' : '';
			$sql = "SELECT /* LinkSuggest query 3 */ page_id, page_title, page_namespace FROM page, searchindex WHERE page_id = si_page AND page_namespace = {$namespace} AND page_is_redirect=0 AND match(si_title) against ('".str_replace('_', ' ', $query)."*') {$statement} LIMIT ".(10 - count($results));
			wfDebugLog( 'linksuggest', "Query3: {$sql}"  );
			$res = $db->query($sql);
			while($row = $db->fetchObject($res)) {
				$pageIds[] = $row->page_id;
				$results[] = array(
					'title_org' => str_replace('_', ' ', (!empty($namespaceName)) ? $namespaceName . ':' . $row->page_title : $row->page_title),
					'title' => (!empty($namespaceName) ? $namespaceName . ':' : '') . str_replace('_', ' ', $row->page_title)
				);
			}
		}
	} else {
		$results = array();
	}

	$ar = new AjaxResponse(Wikia::json_encode(array('results' => $results)));
	$ar->setCacheDuration(60 * 20);

	return $ar;
}

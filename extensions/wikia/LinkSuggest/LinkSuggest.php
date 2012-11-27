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
if( !defined( 'MEDIAWIKI' ) ) {
	die( 'This is not a valid entry point to MediaWiki.' );
}

$wgExtensionCredits['other'][] = array(
	'path' => __FILE__,
	'name' => 'LinkSuggest',
	'version' => '2.0',
	'author' => array(
		'Inez Korczyński', 'Bartek Łapiński', 'Łukasz Garczewski', 'Maciej Brencz',
		'Jesús Martínez Novo', 'Jack Phoenix', 'Sean Colombo', 'Robert Elwell',
	),
	'descriptionmsg' => 'linksuggest-desc',
);

// ResourceLoader support (MW 1.17+)
$wgResourceModules['ext.wikia.LinkSuggest'] = array(
	'scripts' => 'js/jquery.wikia.linksuggest.js',
	'dependencies' => array( 'jquery.ui.autocomplete' ),
	'localBasePath' => __DIR__,
	'remoteExtPath' => 'wikia/LinkSuggest'
);

// config
$wgLinkSuggestLimit = 6;

// classes
$wgAutoloadClasses['LinkSuggest'] = __DIR__ . '/LinkSuggest.class.php';
$wgAutoloadClasses['LinkSuggestHooks'] = __DIR__ . '/LinkSuggestHooks.class.php';

// i18n
$wgExtensionMessagesFiles['LinkSuggest'] = __DIR__ . '/LinkSuggest.i18n.php';

// hooks
$wgHooks['GetPreferences'][] = 'LinkSuggestHooks::onGetPreferences' ;
$wgHooks['EditForm::MultiEdit:Form'][] = 'LinkSuggestHooks::onEditFormMultiEditForm';

// AJAX interface
$wgAjaxExportList[] = 'getLinkSuggest';
$wgAjaxExportList[] = 'getLinkSuggestImage';

function getLinkSuggest() {
	global $wgRequest;
	wfProfileIn(__METHOD__);

	$out = LinkSuggest::getLinkSuggest($wgRequest);

	$ar = new AjaxResponse($out);
	$ar->setCacheDuration(60 * 60);

	if ($wgRequest->getText('format') == 'json') {
		$ar->setContentType('application/json; charset=utf-8');
	}
	else {
		$ar->setContentType('text/plain; charset=utf-8');
	}

	wfProfileOut(__METHOD__);
	return $ar;
}

function getLinkSuggestImage() {
	global $wgRequest;
	wfProfileIn(__METHOD__);

	$res = LinkSuggest::getLinkSuggestImage($wgRequest->getText('imageName'));

	$isMobile = F::app()->checkSkin( 'wikiamobile' );
	// trim passed query and replace spaces by underscores
	// - this is how MediaWiki store article titles in database
	$query = urldecode( trim( $wgRequest->getText('query') ) );
	$query = str_replace(' ', '_', $query);

	if ( $isMobile ) {
		$key = wfMemcKey( __METHOD__, md5( $query.'_'.$wgRequest->getText('format').$wgRequest->getText('nospecial', '') ), 'WikiaMobile' );
	} else {
		$key = wfMemcKey( __METHOD__, md5( $query.'_'.$wgRequest->getText('format').$wgRequest->getText('nospecial', '') ) );
	}
	
	if (strlen($query) < 3) {
		// enforce minimum character limit on server side
		$out = $wgRequest->getText('format') == 'json'
			 ? json_encode(array('suggestions'=>array(),'redirects'=>array()))
			 : '';
	} else if (false && $cached = $wgMemc->get($key)) {
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
	
	//limit the result only to this namespace
	$namespaceFilter = $wgRequest->getVal('nsfilter');
	
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
	
	if(strlen($namespaceFilter) > 0) {
		$namespaces = array($namespaceFilter);
	}
	
	if (!empty($namespace) && $namespace != $namespaceFilter) {
		$out = $wgRequest->getText('format') == 'json'
			 ? json_encode(array('suggestions'=>array(),'redirects'=>array()))
			 : '';

		return linkSuggestAjaxResponse($out);
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

	$ar = new AjaxResponse($res);
	$ar->setCacheDuration(60 * 60);
	$ar->setContentType('text/plain; charset=utf-8');

	wfProfileOut(__METHOD__);
	return $ar;
}

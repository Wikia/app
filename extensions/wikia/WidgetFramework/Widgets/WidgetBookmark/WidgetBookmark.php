<?php
/**
 * @author Maciej Brencz
 * */
if(!defined('MEDIAWIKI')) {
	die(1);
}

global $wgWidgets;
$wgWidgets['WidgetBookmark'] = array(
	'callback' => 'WidgetBookmark',
	'title' => 'widget-title-bookmark',
	'desc' => 'widget-desc-bookmark',
	'params' => array(),
	'closeable' => true,
	'editable' => false,
	'listable' => true
);

function WidgetBookmark($id) {

	global $wgRequest, $wgCityId;

	wfProfileIn(__METHOD__);

	$pages = false;

	$id = intval(substr($id, 7));

	// handle AJAX request
	if ( $wgRequest->getVal('rs') == 'WidgetFrameworkAjax' ) {

		$pageId = $wgRequest->getVal('pid');
		$cmd =  $wgRequest->getVal('cmd');

		if ( !empty($pageId) ) {
			switch ($cmd) {
				case 'add':
					$pages = WidgetBookmarkAddPage( $pageId );
					break;

				case 'remove':
                			$pages = WidgetBookmarkRemovePage( $pageId );
					break;
			}
        	}
	}

	if ($pages == false) {
		$pages = WidgetBookmarkGetPages();
	}

	// count pages from current wiki
	$count = 0;

	if ( !empty($pages) ) {

		// the newest bookmarks on top
		$pages = array_reverse($pages);

		$list = '<ul><!-- '.count($pages).' bookmarks -->';

		foreach($pages as $page_id => $page) {
			// filter the list by cityId
			if (isset($page['city']) && $page['city'] == $wgCityId) {
				$list .= '<li><a href="'.$page['href'].'" title="'.htmlspecialchars($page['title']).'">'.
					htmlspecialchars(wfShortenText($page['title'], 25)).'</a>'.
					'<a class="WidgetBookmarkRemove" onclick="WidgetBookmarkDo('.$id.', \'remove\', \''.$page_id.'\')">x</a></li>';
				$count++;
			}
		}
		$list .= '</ul>';
	}

	if ($count == 0) {
		$list = wfMsg('widget-bookmark-empty');
	}

	// "add bookmark" icon
	$menu = '<div class="WidgetBookmarkMenu">'.
		'<a class="addBookmark" onclick="WidgetBookmarkDo('.$id.', \'add\', wgArticleId ? wgArticleId : wgPageName)" '.
		'title="'.wfMsg('export-addcat').'">&nbsp;</a></div>';

	wfProfileOut(__METHOD__);

	return $menu . $list;
}

function WidgetBookmarkGetPages() {
	global $wgUser;

	$pages = unserialize( $wgUser->getGlobalPreference('widget_bookmark_pages'), [ 'allowed_classes' => false ] );

	return $pages;
}

function WidgetBookmarkSavePages($pages) {

	wfProfileIn(__METHOD__);

	global $wgUser;

	$wgUser->setGlobalPreference('widget_bookmark_pages', serialize($pages));
        $wgUser->saveSettings();

	// commit UPDATE query
        $dbw = wfGetDB( DB_MASTER );
        $dbw->commit();

	wfProfileOut(__METHOD__);
}

function WidgetBookmarkAddPage($pageId) {

	global $wgCityId, $wgSitename;

	$key = $wgCityId . ':' . $pageId;

	if ( is_numeric($pageId) ) {
		// articles, talk pages...
		$title = Title::newFromID( $pageId );
	}
	else {
		// special pages, category pages...
		$title = Title::newFromText( $pageId );
	}

	// validate
	if (!$title) {
		return;
	}

	$pages = WidgetBookmarkGetPages();

	// don't duplicate entries
	if ( isset($pages[$key]) ) {
		return $pages;
	}

	// add page
	$pages[ $key ] = array(
		'city'  => $wgCityId,
		'wiki'  => $wgSitename,
		'title' => $title->getPrefixedText(),
		'href'  => $title->getFullURL(),
	);

	// limit number of pages to 20 (the last 20 pages)
	$pages = array_slice($pages, -20, 20, true);

	WidgetBookmarkSavePages($pages);

	return $pages;
}

function WidgetBookmarkRemovePage($pageId) {

	$pages = WidgetBookmarkGetPages();

	if ( !isset($pages[$pageId]) ) {
		return $pages;
	}

	// remove
	unset($pages[$pageId]);

	WidgetBookmarkSavePages($pages);

	return $pages;
}

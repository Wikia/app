<?php
/**
 * WidgetNewPages
 *
 * Widget displaying the "newest" articles created
 * See ticket #3517
 *
 * @author Maciej Błaszkowski (Marooned) <marooned at wikia-inc.com>
 * @date 2008-09-03
 * @copyright Copyright (C) 2008 Maciej Błaszkowski, Wikia Inc.
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 * @package MediaWiki
 * @subpackage Widget
 *
 */

if(!defined('MEDIAWIKI')) {
	die(1);
}

global $wgWidgets;
$wgWidgets['WidgetNewPages'] = array(
	'callback' => 'WidgetNewPages',
	'title' => 'widget-title-newpages',
	'desc' => 'widget-desc-newpages',
	'closeable' => true,
	'editable' => false
);

function WidgetNewPages($id, $params) {
	wfProfileIn(__METHOD__);

	$items = array();

	if ( class_exists( 'DataProvider' ) ) {
		$items = DataProvider::singleton()->GetNewlyCreatedArticles();
	}

	wfProfileOut(__METHOD__);
	return (count($items) > 0 ? WidgetFrameworkWrapLinks($items) . WidgetFrameworkMoreLink(Title::newFromText('Newpages', NS_SPECIAL)->getLocalURL()) : wfMsg('widget-empty-list'));
}

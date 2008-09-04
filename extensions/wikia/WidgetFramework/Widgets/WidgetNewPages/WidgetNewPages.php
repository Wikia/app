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
	'title' => array(
		'en' => 'Newest articles',
		'pl' => 'Najnowsze artykuły'
	),
	'desc' => array(
		'en' => 'A list of newest articles on this wiki',
		'pl' => 'Lista najnowszych artykułów na tej wiki'
	),
	'closeable' => true,
	'editable' => false
);

function WidgetNewPages($id, $params) {
	wfProfileIn(__METHOD__);

	$dbr =& wfGetDB( DB_SLAVE );

	$res = $dbr->select('recentchanges',						// table name
		array('rc_title'),										// fields to get
		array('rc_type = 1', 'rc_namespace' => NS_MAIN),		// WHERE conditions [only new articles in main namespace]
		__METHOD__,												// for profiling
		array('ORDER BY' => 'rc_cur_time DESC', 'LIMIT' => 5)	// ORDER BY creation timestamp
	);

	$items = array();

	while (($row = $dbr->fetchObject($res))) {
		$title = Title::makeTitleSafe(NS_MAIN, $row->rc_title);
		if(is_object($title)) {
			$items[] = array('href' => $title->getLocalUrl(), 'name' => $title->getPrefixedText());
		}
	}

	$dbr->freeResult($res);

	wfProfileOut(__METHOD__);

	return (count($items) > 0 ? WidgetFrameworkWrapLinks($items) . WidgetFrameworkMoreLink(Title::newFromText('Newpages', NS_SPECIAL)->getLocalURL()) : '(the list is empty)');
}

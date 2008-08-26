<?php
/**
 * @package MediaWiki
 * @subpackage TabView
 *
 * @author Inez Korczynski <lastname at gmail dot com>
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 * @version 0.3
 */

if (!defined('MEDIAWIKI')) {
	exit( 1 );
}

$wgExtensionCredits['parserhook'][] = array(
	'name' => 'TabView',
	'author' => 'Inez Korczynski'
);

$wgExtensionFunctions[] = 'wfSetupTabView';

$tabsCount = 0;

function wfSetupTabView() {
	global $wgParser;
	$wgParser->setHook( 'tabview', 'tabviewRender' );
}

function tabviewRender($input, $params, &$parser ) {
	global $tabsCount;

	if(isset($params['title']) && $params['title'] != '' && strpos($params['title'], '<') === false && strpos($params['title'], '>') === false) {
		$title = $params['title'];
	}

	if(isset($params['id']) && $params['id'] != '' && strpos($params['id'], '<') === false && strpos($params['id'], '>') === false) {
		$id = '_'.$params['id'];
	}

	if(empty($id)) {
		$id = $tabsCount++;
	}

	$out = '<div id="tabview_'.$id.'">';
	if(!empty($title)) {
		$out .= $title;
	}
	$out .= '</div>';

	$tabs = array_filter(split("\n",$input));

	if(isset($tabs[0]) && $tabs[0] == "") {
		unset($tabs[0]);
	}
	if($tabs[count($tabs)] == "") {
		unset($tabs[count($tabs)]);
	}

	$outJS = "var tabView_{$id} = new YAHOO.widget.TabView();";
	$tempJS = "tabView_%s.addTab( new YAHOO.widget.Tab({label: '%s', dataSrc: '%s'.replace('amp;',''), cacheData: %s, active: %s}));";

	foreach($tabs as $tab) {
		$onetab = split('\|', $tab);

		if(isset($onetab[0]) && strpos($onetab[0], '<') === false && strpos($onetab[0], '>') === false) {
			$titleObj = Title::newFromText($onetab[0]);
			if(is_object($titleObj) && $titleObj->exists()) {
				$url = $titleObj->getLocalURL('action=render');
				$text = $titleObj->getFullText();
				if(isset($onetab[1]) && strpos($onetab[1], '<') === false && strpos($onetab[1], '>') === false) {
					if($onetab[1] != '') {
						$text = $onetab[1];
					}
					if(isset($onetab[2])) {
						if($onetab[2] != '') {
							$cache = (bool) $onetab[2];
						}
						if(isset($onetab[3])) {
							if($onetab[3] != '') {
								$active = (bool) $onetab[3];
							}
						}
					}
				}
				$outJS .= sprintf($tempJS, $id, addslashes($text), $url, (!empty($cache) && $cache === false) ? 'false' : 'true', (!empty($active) && $active === true) ? 'true' : 'false');
			}
		}
		unset($url, $text, $cache, $active);
	}

	$outJS .= "tabView_{$id}.appendTo('tabview_" . $id . "');";
	$outJS = '<script type="text/javascript">if(!window.onloadFuncts) { var onloadFuncts = []; } onloadFuncts[onloadFuncts.length] = function() {' . $outJS . '};</script>';
	return $out.$outJS;
}
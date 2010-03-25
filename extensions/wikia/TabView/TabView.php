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
	'author' => array('Inez Korczynski', 'Maciej Brencz'),
	'description' => 'Gives an easy way of combining pages into one page with a tab for each sub-page.',
	'url' => 'http://help.wikia.com/wiki/Tabview',
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
		$id = $params['id'];
		$id = preg_replace('/[^A-Za-z0-9_]/', '', $id);
	}

	if(empty($id)) {
		$id = $tabsCount++;
	}

	// HTML wrapper
	$out = '<div id="tabview_'.$id.'">';
	if(!empty($title)) {
		$out .= $title;
	}

	$out .= '<div class="yui-navset yui-navset-top"><ul id="flytabs_'.$id.'" class="yui-nav"></ul></div>';
	$out .= '</div>';

	// remove empty lines
	$tabs = array_filter(explode("\n",$input));

	if(isset($tabs[0]) && $tabs[0] == "") {
		unset($tabs[0]);
	}
	if($tabs[count($tabs)] == "") {
		unset($tabs[count($tabs)]);
	}

	// prepeare tabs options array
	$optins = array();

	foreach($tabs as $tab) {
		$onetab = explode('|', trim($tab));

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
							$noCache = (strtolower($onetab[2]) == 'false');
						}
						if(isset($onetab[3])) {
							if($onetab[3] != '') {
								$active = (strtolower($onetab[3]) == 'true');
							}
						}
					}
				}

				// prepare flytab options array
				$options[] = array(
					'caption' => $text,
					'cache' => !empty($noCache) ? false : true,
					'status' => !empty($active) ? 'pinned' : 'off',
					'url' => $url,
				);

			}
		}
		unset($url, $text, $noCache, $active);
	}

	// tabview config
	$tab = array(
		'id' => $id,
		'options' => $options,
	);

	$outJS = '<script type="text/javascript">if (typeof window.__FlyTabs == "undefined") window.__FlyTabs = []; window.__FlyTabs.push(' . Wikia::json_encode($tab) . ');</script>';

	return $out . $outJS;
}

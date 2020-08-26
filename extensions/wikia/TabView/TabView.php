<?php
/**
 * @package MediaWiki
 * @subpackage TabView
 *
 * @author Inez Korczynski <lastname at gmail dot com>
 * @author Jakub 'Szeryf' Kurcek <jakub@wikia.com>
 *
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 * @version 0.4
 */

if (!defined('MEDIAWIKI')) {
	exit( 1 );
}

$wgExtensionCredits['parserhook'][] = array(
	'name' => 'TabView',
	'author' => array('Inez Korczynski', 'Maciej Brencz'),
	'description' => 'Gives an easy way of combining pages into one page with a tab for each sub-page.',
	'url' => 'http://community.wikia.com/wiki/Help:Tab_view',
);

$wgHooks['ParserFirstCallInit'][] = 'wfSetupTabView';

$tabsCount = 0;

function wfSetupTabView( $parser ) {
	$parser->setHook( 'tabview', 'tabviewRender' );
	return true;
}

function tabviewRender($input, $params, $parser ) {
	global $tabsCount;

	if(isset($params['id']) && $params['id'] != '' && strpos($params['id'], '<') === false && strpos($params['id'], '>') === false) {
		$id = $params['id'];
		$id = preg_replace('/[^A-Za-z0-9_]/', '', $id);
	}

	if(empty($id)) {
		$id = $tabsCount++;
	}

	// remove empty lines
	$tabs = array_filter(explode("\n",$input));

	if(isset($tabs[0]) && $tabs[0] == "") {
		unset($tabs[0]);
	}
	if($tabs[count($tabs) - 1] == "") {
		unset($tabs[count($tabs) - 1]);
	}

	// prepeare tabs options array
	$options = array();

	$optionsIndex = $index = 0;
	foreach($tabs as $tab) {
		$onetab = explode('|', trim($tab));

		if(isset($onetab[0]) && strpos($onetab[0], '<') === false && strpos($onetab[0], '>') === false) {
			$titleObj = Title::newFromText($onetab[0]);
			if(is_object($titleObj) && $titleObj->exists()) {
				$url = $titleObj->getLocalURL();
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
								if ( strtolower($onetab[3]) == 'true' ) $optionsIndex = $index;
							}
						}
					}
				}

				// prepare flytab options array
				$options[] = array(
					'caption' => $text,
					'url' => $url,
				);
			}
		}
		$index++;
		unset($url, $text, $noCache, $active);
	}

	//$out = '<script>wgAfterContentAndJS.push(function() { $.loadJQueryUI(function(){ $("#flytabs_'.$id.'").tabs({ cache: true, selected: '.$optionsIndex.' }); });});</script>';

	$out = '<div id="flytabs_'.$id.'"><ul>';
	foreach( $options as $option ){
			$out .= '<li><a href="'.$option['url'].'"><span>'.$option['caption'].'</span></a></li>';
	}
	$out .= '</ul></div>';

	// lazy load JS
	$out .= JSSnippets::addToStack(
		array( '/extensions/wikia/TabView/js/TabView.js',
			'/resources/wikia/libraries/mustache/mustache.js' ),
		array(),
		'TabView.init',
		array(
			'id' => 'flytabs_'.$id,
			'selected' => $optionsIndex,
		)
	);

	return $out;
}

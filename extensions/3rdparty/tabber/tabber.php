<?php

# Credits
$wgExtensionCredits['parserhook'][] = array(
    'name'=>'Tabber',
    'author'=>'Eric Fortin',
    'url'=>'http://www.mediawiki.org/wiki/Extension:Tabber',
    'description'=>'Create tabs that contain wiki compatible based data',
    'version'=>'1.01'
);

//Avoid unstubbing $wgParser on setHook() too early on modern (1.12+) MW versions, as per r35980
$wgHooks['ParserFirstCallInit'][] = 'wfTabber';

/**
 * @param Parser $parser
 * @return bool
 */
function wfTabber(&$parser) {
	$parser->setHook( 'tabber', 'renderTabber' );
	return true;
}

function renderTabber( $paramstring, $params, $parser ){
	global $wgExtensionsPath, $wgStyleVersion;

	$path = $wgExtensionsPath . '/3rdparty/tabber/';

	/*
	 * Wikia Change Start @author: marzjan
	 */
	$snippets = JSSnippets::addToStack(
		array('/extensions/3rdparty/tabber/tabber.js'),
		array('$.loadJQueryUI')
	);

	$htmlHeader = '<link rel="stylesheet" href="'.$path.'tabber.css?' . $wgStyleVersion . '" TYPE="text/css" MEDIA="screen">'
		. $snippets
		. '<div class="tabber">';
	$htmlFooter = '</div>';
	/*
	 * Wikia Change End
	 */

	$htmlTabs = "";

	$arr = explode("|-|", $paramstring);
	foreach($arr as $tab){
		$htmlTabs .= buildTab($tab, $parser); # macbre: pass Parser object (refs RT #34513)
	}

	return $htmlHeader . $htmlTabs . $htmlFooter;
}

/**
 * @param $tab
 * @param Parser $parser
 * @return string
 */
function buildTab($tab, $parser){
	if( trim($tab) == '' ) return '';

	$arr = explode("=",$tab);
	$tabName = array_shift( $arr );
	$tabBody = $parser->recursiveTagParse( implode("=",$arr) );

	$tab = '<div class="tabbertab" title="'.htmlspecialchars($tabName).'">'
		. '<p>'.$tabBody.'</p>'
		. '</div>';

	return $tab;
}

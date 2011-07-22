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

function wfTabber(&$parser) {
	$parser->setHook( 'tabber', 'renderTabber' );
	return true;
}

function renderTabber( $paramstring, $params, $parser ){
	global $wgExtensionsPath, $wgStyleVersion;

	$path = $wgExtensionsPath . '/3rdparty/tabber/';

	$htmlHeader = '<script type="text/javascript" src="'.$path.'tabber.js?' . $wgStyleVersion . '"></script>'
		. '<link rel="stylesheet" href="'.$path.'tabber.css?' . $wgStyleVersion . '" TYPE="text/css" MEDIA="screen">'
		. '<div class="tabber">';

	$htmlFooter = '</div>';

	$htmlTabs = "";

	$arr = explode("|-|", $paramstring);
	foreach($arr as $tab){
		$htmlTabs .= buildTab($tab, $parser); # macbre: pass Parser object (refs RT #34513)
	}

	return $htmlHeader . $htmlTabs . $htmlFooter;
}

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

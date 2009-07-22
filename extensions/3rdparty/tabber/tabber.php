<?php

# Credits	
$wgExtensionCredits['parserhook'][] = array(
    'name'=>'Tabber',
    'author'=>'Eric Fortin',
    'url'=>'http://www.mediawiki.org/wiki/Extension:Tabber',
    'description'=>'Create tabs that contain wiki compatible based data',
    'version'=>'1.0'
);

$wgExtensionFunctions[] = "wfTabber";

// function adds the wiki extension
function wfTabber() {
    global $wgParser;
    $wgParser->setHook( "tabber", "renderTabber" );
}

function renderTabber( $paramstring, $params = array() ){
	global $wgParser, $wgScriptPath;
	$wgParser->disableCache();
	
	$path = $wgScriptPath . '/extensions/tabber/';

	$htmlHeader = '<script type="text/javascript" src="'.$path.'tabber.js"></script>'
		. '<link rel="stylesheet" href="'.$path.'tabber.css" TYPE="text/css" MEDIA="screen">'
		. '<div class="tabber">';
		
	$htmlFooter = '</div>';
	
	$arr = explode("|-|", $paramstring);
	foreach($arr as $tab){
		$htmlTabs .= buildTab($tab);
	}

	return $htmlHeader . $htmlTabs . $htmlFooter;
}

function buildTab($tab){
	global $wgParser;
	
	if( trim($tab) == '' ) return '';
	
	$arr = split("=",$tab);
	$tabName = array_shift( $arr );
	$tabBody = $wgParser->recursiveTagParse( implode("=",$arr) );
	
	$tab = '<div class="tabbertab" title='.$tabName.'>'
		. '<p>'.$tabBody.'</p>'
		. '</div>';

	return $tab;
}












<?php


$wgHooks['ParserFirstCallInit'][] = "wfMainPage2";


function wfMainPage2( $parser ) {
    $parser->setHook( "MainPage2", "renderMainPage2" );
    return true;
}

function renderMainPage2( $input ) {
	global $wgUser;
	$sk =& $wgUser->getSkin();
	return $sk->getMainPage();
}

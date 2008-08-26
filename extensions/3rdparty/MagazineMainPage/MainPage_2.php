<?php


$wgExtensionFunctions[] = "wfMainPage2";


function wfMainPage2() {
    global $wgParser ,$wgOut;
    $wgParser->setHook( "MainPage2", "renderMainPage2" );
}

function renderMainPage2( $input ) {
	global $wgUser;
	$sk =& $wgUser->getSkin();
	return $sk->getMainPage();
}
?>

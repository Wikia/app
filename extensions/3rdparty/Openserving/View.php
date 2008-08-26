<?php


$wgExtensionFunctions[] = "wfOpenservingView";


function wfOpenservingView() {
        global $wgOut, $wgSiteView;
	require_once("viewClass.php");
	$wgSiteView = new SiteView();

	if($wgSiteView->getDomainName()!=""){
		$s .= '<link rel="stylesheet" href="index.php?title=Special:ViewCSS"  type="text/css" />' . "\n";
		
	}

}



?>
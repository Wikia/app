<?php


$wgExtensionFunctions[] = "wfRSSDiscoverable";


function wfRSSDiscoverable() {
        global $wgOut, $wgSitesRSS, $wgSitename;
	if($wgSitesRSS){
		if($wgSitesRSS[$wgSitename]["rss-url"]){
			$wgOut->addScript('<link rel="alternate" type="application/rss+xml" title="RSS Feed for ' . $wgSitename . '.wikia.com" href="' . $wgSitesRSS[$wgSitename]["rss-url"] . '" />');
		}
	}
	
}



?>
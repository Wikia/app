<?php

//GLOBAL VIDEO NAMESPACE REFERENCE
define( 'NS_COLLABLIB_TEMPLATE', 576 );
define( 'NS_COLLABLIB', 578 );

#$wgHooks['ArticleFromTitle'][] = 'wfCollabLibFromTitle';

//ArticleFromTitle
//Calls CollabLibPage instead of standard article
function wfCollabLibFromTitle( &$title, &$article ){
	global $wgUser, $wgRequest, $IP, $wgOut, $wgTitle, $wgMessageCache, $wgStyleVersion, $wgParser, 
	$wgSupressPageTitle, $wgSupressSubTitle, $wgSupressPageCategories;
	
	if ( NS_BLOG == $title->getNamespace()  ) {
		if( !$wgRequest->getVal("action") ){
			$wgSupressPageTitle = true;
		}
		
		$wgSupressSubTitle = true;
		$wgSupressPageCategories = true;
		
		$wgOut->enableClientCache(false);
		$wgParser->disableCache();
		
		require_once ( "$IP/extensions/wikia/CollabLibs/CollabLib.i18n.php" );
		foreach( efWikiaCollabLib() as $lang => $messages ){
			$wgMessageCache->addMessages( $messages, $lang );
		}
		
		require_once( "$IP/extensions/wikia/BlogPage/BlogPage.php" );
		$wgOut->addScript("<link rel='stylesheet' type='text/css' href=\"/extensions/wikia/BlogPage/BlogPage.css?{$wgStyleVersion}\"/>\n");
		
		$article = new BlogPage($wgTitle);
		
	}

	return true;
}

?>
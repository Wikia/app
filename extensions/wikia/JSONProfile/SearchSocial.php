<?php
$wgExtensionFunctions[] = 'wfSocialSearchReadLang';

//read in localisation messages
function wfSocialSearchReadLang(){
	global $wgMessageCache, $IP;
	require_once ( "Search.i18n.php" );
	foreach( efWikiaSearch() as $lang => $messages ){
		$wgMessageCache->addMessages( $messages, $lang );
	}
}
?>

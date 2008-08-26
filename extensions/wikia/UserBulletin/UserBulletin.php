<?php

$wgExtensionFunctions[] = 'wfUserBulletinReadLang';

//read in localisation messages
function wfUserBulletinReadLang(){
	global $wgMessageCache, $IP;
	require_once ( "UserBulletin.i18n.php" );
	foreach( efWikiaUserBulletin() as $lang => $messages ){
		$wgMessageCache->addMessages( $messages, $lang );
	}
}

?>
<?php
define( 'WMSG_REMOVE_SUCCESS', 900 );

$wgAutoloadClasses['UploadProfilePhoto'] = "{$wgUserProfileDirectory}/SpecialUploadProfilePhoto.php";
$wgSpecialPages['UploadProfilePhoto'] = 'UploadProfilePhoto';

$wgExtensionFunctions[] = 'wfUserProfilePhotoReadLang';

//read in localisation messages
function wfUserProfilePhotoReadLang(){
	global $wgMessageCache, $IP;
	require_once ( "UserProfilePhoto.i18n.php" );
	foreach( efWikiaUserProfilePhoto() as $lang => $messages ){
		$wgMessageCache->addMessages( $messages, $lang );
	}
}
?>

<?php
$wgExtensionFunctions[] = 'wfUserRelReadLang';

//read in localisation messages
function wfUserRelReadLang(){
	global $wgMessageCache;
	require_once ( "UserRelationship.i18n.php" );
	foreach( efWikiaUserRelationship() as $lang => $messages ){
		$wgMessageCache->addMessages( $messages, $lang );
	}
}

$wgAutoloadClasses['AddRelationship'] = "{$wgUserRelationshipDirectory}/SpecialAddRelationship.php";
$wgSpecialPages['AddRelationship'] = 'AddRelationship';
$wgSpecialPageGroups['AddRelationship'] = 'users';

$wgAutoloadClasses['RemoveRelationship'] = "{$wgUserRelationshipDirectory}/SpecialRemoveRelationship.php";
$wgSpecialPages['RemoveRelationship'] = 'RemoveRelationship';
$wgSpecialPageGroups['RemoveRelationship'] = 'users';

$wgAutoloadClasses['ViewRelationshipRequests'] = "{$wgUserRelationshipDirectory}/SpecialViewRelationshipRequests.php";
$wgSpecialPages['ViewRelationshipRequests'] = 'ViewRelationshipRequests'; 
$wgSpecialPageGroups['ViewRelationshipRequests'] = 'users';

$wgAutoloadClasses['ViewRelationships'] = "{$wgUserRelationshipDirectory}/SpecialViewRelationships.php";
$wgSpecialPages['ViewRelationships'] = 'ViewRelationships'; 
$wgSpecialPageGroups['ViewRelationships'] = 'users';

require_once ( "{$wgUserRelationshipDirectory}/Relationship_AjaxFunctions.php" );


$wgDisableFoeing = true;

$wgUserProfileDisplay['friends'] = true;
$wgUserProfileDisplay['foes'] = true;

$wgHooks['UserRename::Local'][] = "UserRelationshipUserRenameLocal";

function UserRelationshipUserRenameLocal( $dbw, $uid, $oldusername, $newusername, $process, $cityId, &$tasks ) {
	$tasks[] = array(
		'table' => 'user_relationship',
		'userid_column' => 'r_user_id',
		'username_column' => 'r_user_name',
	);
	$tasks[] = array(
		'table' => 'user_relationship_request',
		'userid_column' => 'ur_user_id',
		'username_column' => 'ur_user_name',
	);
	$tasks[] = array(
		'table' => 'user_relationship_stats',
		'userid_column' => 'rs_user_id',
		'username_column' => 'rs_user_name',
	);
	return true;
}

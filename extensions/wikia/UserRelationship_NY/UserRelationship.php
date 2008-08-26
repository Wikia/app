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

$wgAutoloadClasses['RemoveRelationship'] = "{$wgUserRelationshipDirectory}/SpecialRemoveRelationship.php";
$wgSpecialPages['RemoveRelationship'] = 'RemoveRelationship'; 

$wgAutoloadClasses['ViewRelationshipRequests'] = "{$wgUserRelationshipDirectory}/SpecialViewRelationshipRequests.php";
$wgSpecialPages['ViewRelationshipRequests'] = 'ViewRelationshipRequests'; 

$wgAutoloadClasses['ViewRelationships'] = "{$wgUserRelationshipDirectory}/SpecialViewRelationships.php";
$wgSpecialPages['ViewRelationships'] = 'ViewRelationships'; 

require_once ( "{$wgUserRelationshipDirectory}/Relationship_AjaxFunctions.php" );


$wgDisableFoeing = true;

$wgUserProfileDisplay['friends'] = true;
$wgUserProfileDisplay['foes'] = true;
?>

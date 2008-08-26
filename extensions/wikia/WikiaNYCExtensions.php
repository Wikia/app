<?php

/*
 * Temporary -> NYC 	
 * Additional user's page extensions 
 *
 */  
$wgFriendingEnabled = true;

$wgDefaultUserOptions['notifygift'] = 1;
$wgDefaultUserOptions['notiftyfriendrequest'] = 1;

$wgExtraNamespaces[207] = "UserProfile";
$wgDBStatsServer = "localhost";
$wgDBStats = "dbstats";
/*$wgAvatarPath = $wgUploadPath."/avatars";
$wgAvatarUploadPath = $wgUploadDirectory."/avatars";*/
/*$wgGiftImagePath = $wgUploadPath."/awards";
$wgGiftImageUploadPath = $wgUploadDirectory."/awards";*/
$wgImageCommonPath = "/images/common/common/";
require_once ("$IP/extensions/wikia/WikiaUserProfile/WikiaUserProfile.php");
require_once ("$IP/extensions/wikia/WikiaAvatar/SpecialWikiaAvatar.php");
require_once ("$IP/extensions/wikia/WikiaAvatar/SpecialWikiaRemoveAvatar.php");
 
/* 
$wgAvatarPath = "/images/avatars";
$wgGiftImagePath = "/images/awards"; 

//require_once("$IP/extensions/Avatar/Avatar.php"); //upload
//require_once("$IP/extensions/Avatar/AvatarClass.php"); //class to get avatar for a user

require_once($IP."/extensions/wikia/Invite/SpecialInviteContacts.php");
require_once($IP."/extensions/wikia/Invite/SpecialInviteContactsCSV.php");
require_once($IP."/extensions/wikia/Invite/SpecialInviteEmail.php");

require_once($IP."/extensions/wikia/UserRelationship/SpecialViewRelationshipRequests.php");
require_once($IP."/extensions/wikia/UserRelationship/SpecialViewRelationships.php");
require_once($IP."/extensions/wikia/UserRelationship/SpecialAddRelationship.php");
require_once($IP."/extensions/wikia/UserRelationship/SpecialUserRelationshipAction.php");

require_once($IP."/extensions/wikia/UserGifts/SpecialGiveGift.php");
require_once($IP."/extensions/wikia/UserGifts/SpecialViewGifts.php");
require_once($IP."/extensions/wikia/UserGifts/SpecialViewGift.php");
require_once($IP."/extensions/wikia/UserGifts/SpecialGiftManager.php");
require_once($IP."/extensions/wikia/UserGifts/SpecialGiftManagerLogo.php");
require_once($IP."/extensions/wikia/UserGifts/SpecialRemoveGift.php");

*/
?>

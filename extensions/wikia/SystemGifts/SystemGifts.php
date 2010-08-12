<?php

$wgAvailableRights[] = 'awardsmanage';
$wgGroupPermissions['staff']['awardsmanage'] = true;
$wgGroupPermissions['sysop']['awardsmanage'] = true;

//Special Pages
$wgAutoloadClasses['TopAwards'] = "{$wgSystemGiftsDirectory}/TopAwards.php";
$wgSpecialPages['TopAwards'] = 'TopAwards';
$wgSpecialPageGroups['TopAwards'] = 'users';

$wgAutoloadClasses['ViewSystemGifts'] = "{$wgSystemGiftsDirectory}/SpecialViewSystemGifts.php";
$wgSpecialPages['ViewSystemGifts'] = 'ViewSystemGifts';
$wgSpecialPageGroups['ViewSystemGifts'] = 'users';

$wgAutoloadClasses['ViewSystemGift'] = "{$wgSystemGiftsDirectory}/SpecialViewSystemGift.php";
$wgSpecialPages['ViewSystemGift'] = 'ViewSystemGift';
$wgSpecialPageGroups['ViewSystemGift'] = 'users';

$wgAutoloadClasses['SystemGiftManager'] = "{$wgSystemGiftsDirectory}/SpecialSystemGiftManager.php";
$wgSpecialPages['SystemGiftManager'] = 'SystemGiftManager';
$wgSpecialPageGroups['SystemGiftManager'] = 'users';

$wgAutoloadClasses['SystemGiftManagerLogo'] = "{$wgSystemGiftsDirectory}/SpecialSystemGiftManagerLogo.php";
$wgSpecialPages['SystemGiftManagerLogo'] = 'SystemGiftManagerLogo';
$wgSpecialPageGroups['SystemGiftManagerLogo'] = 'users';

include_once( "{$wgSystemGiftsDirectory}/SpecialPopulateAwards.php" );

$wgHooks['UserRename::Local'][] = "SystemGiftsUserRenameLocal";

function SystemGiftsUserRenameLocal( $dbw, $uid, $oldusername, $newusername, $process, $cityId, &$tasks ) {
	$tasks[] = array(
		'table' => 'user_system_gift',
		'userid_column' => 'sg_user_id',
		'username_column' => 'sg_user_name',
	);
	return true;
}

?>

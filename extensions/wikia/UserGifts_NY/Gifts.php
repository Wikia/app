<?php

$wgEnableGifts = true;
$wgAvailableRights[] = 'giftadmin';
$wgGroupPermissions['staff']['giftadmin'] = true;
$wgGroupPermissions['sysop']['giftadmin'] = true;

//Special Pages
$wgAutoloadClasses['GiveGift'] = "{$wgUserGiftsDirectory}/SpecialGiveGift.php";
$wgSpecialPages['GiveGift'] = 'GiveGift';
$wgSpecialPageGroups['GiveGift'] = 'users';

$wgAutoloadClasses['ViewGifts'] = "{$wgUserGiftsDirectory}/SpecialViewGifts.php";
$wgSpecialPages['ViewGifts'] = 'ViewGifts';
$wgSpecialPageGroups['ViewGifts'] = 'users';

$wgAutoloadClasses['ViewGift'] = "{$wgUserGiftsDirectory}/SpecialViewGift.php";
$wgSpecialPages['ViewGift'] = 'ViewGift';
$wgSpecialPageGroups['ViewGift'] = 'users';

$wgAutoloadClasses['GiftManager'] = "{$wgUserGiftsDirectory}/SpecialGiftManager.php";
$wgSpecialPages['GiftManager'] = 'GiftManager';
$wgSpecialPageGroups['GiftManager'] = 'wiki';

$wgAutoloadClasses['GiftManagerLogo'] = "{$wgUserGiftsDirectory}/SpecialGiftManagerLogo.php";
$wgSpecialPages['GiftManagerLogo'] = 'GiftManagerLogo';
$wgSpecialPageGroups['GiftManagerLogo'] = 'wiki';

$wgAutoloadClasses['RemoveMasterGift'] = "{$wgUserGiftsDirectory}/SpecialRemoveMasterGift.php";
$wgSpecialPages['RemoveMasterGift'] = 'RemoveMasterGift';
$wgSpecialPageGroups['RemoveMasterGift'] = 'wiki';

$wgAutoloadClasses['RemoveGift'] = "{$wgUserGiftsDirectory}/SpecialRemoveGift.php";
$wgSpecialPages['RemoveGift'] = 'RemoveGift';
$wgSpecialPageGroups['RemoveGift'] = 'users';

$wgHooks['UserRename::Local'][] = "UserGiftsUserRenameLocal";

function UserGiftsUserRenameLocal( $dbw, $uid, $oldusername, $newusername, $process, $cityId, &$tasks ) {
	$tasks[] = array(
		'table' => 'user_gift',
		'userid_column' => 'ug_user_id_to',
		'username_column' => 'ug_user_name_to',
	);
	$tasks[] = array(
		'table' => 'user_gift',
		'userid_column' => 'ug_user_id_from',
		'username_column' => 'ug_user_name_from',
	);
	return true;
}

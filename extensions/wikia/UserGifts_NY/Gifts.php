<?php

$wgAvailableRights[] = 'giftadmin';
$wgGroupPermissions['staff']['giftadmin'] = true;
$wgGroupPermissions['sysop']['giftadmin'] = true;

//Special Pages
$wgAutoloadClasses['GiveGift'] = "{$wgUserGiftsDirectory}/SpecialGiveGift.php";
$wgSpecialPages['GiveGift'] = 'GiveGift';

$wgAutoloadClasses['ViewGifts'] = "{$wgUserGiftsDirectory}/SpecialViewGifts.php";
$wgSpecialPages['ViewGifts'] = 'ViewGifts';

$wgAutoloadClasses['ViewGift'] = "{$wgUserGiftsDirectory}/SpecialViewGift.php";
$wgSpecialPages['ViewGift'] = 'ViewGift';

$wgAutoloadClasses['GiftManager'] = "{$wgUserGiftsDirectory}/SpecialGiftManager.php";
$wgSpecialPages['GiftManager'] = 'GiftManager';

$wgAutoloadClasses['GiftManagerLogo'] = "{$wgUserGiftsDirectory}/SpecialGiftManagerLogo.php";
$wgSpecialPages['GiftManagerLogo'] = 'GiftManagerLogo';

$wgAutoloadClasses['RemoveMasterGift'] = "{$wgUserGiftsDirectory}/SpecialRemoveMasterGift.php";
$wgSpecialPages['RemoveMasterGift'] = 'RemoveMasterGift';

$wgAutoloadClasses['RemoveGift'] = "{$wgUserGiftsDirectory}/SpecialRemoveGift.php";
$wgSpecialPages['RemoveGift'] = 'RemoveGift';
?>

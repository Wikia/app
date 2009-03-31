<?php

$wgAvailableRights[] = 'awardsmanage';
$wgGroupPermissions['awardsmanage']['awardsmanage'] = true;
$wgGroupPermissions['staff']['awardsmanage'] = true;
$wgGroupPermissions['sysop']['awardsmanage'] = true;

$wgSystemGiftsDirectory = "$IP/extensions/SocialProfile/SystemGifts";
$wgSystemGiftsScripts = "$wgScriptPath/extensions/SocialProfile/SystemGifts";

$wgAutoloadClasses['SystemGifts'] = "{$wgSystemGiftsDirectory}/SystemGiftsClass.php";
$wgAutoloadClasses['UserSystemGifts'] = "{$wgSystemGiftsDirectory}/UserSystemGiftsClass.php";

//Special Pages
$wgAutoloadClasses['TopAwards'] = "{$wgSystemGiftsDirectory}/TopAwards.php";
$wgSpecialPages['TopAwards'] = 'TopAwards';

$wgAutoloadClasses['ViewSystemGifts'] = "{$wgSystemGiftsDirectory}/SpecialViewSystemGifts.php";
$wgSpecialPages['ViewSystemGifts'] = 'ViewSystemGifts';

$wgAutoloadClasses['ViewSystemGift'] = "{$wgSystemGiftsDirectory}/SpecialViewSystemGift.php";
$wgSpecialPages['ViewSystemGift'] = 'ViewSystemGift';

$wgAutoloadClasses['SystemGiftManager'] = "{$wgSystemGiftsDirectory}/SpecialSystemGiftManager.php";
$wgSpecialPages['SystemGiftManager'] = 'SystemGiftManager';

$wgAutoloadClasses['SystemGiftManagerLogo'] = "{$wgSystemGiftsDirectory}/SpecialSystemGiftManagerLogo.php";
$wgSpecialPages['SystemGiftManagerLogo'] = 'SystemGiftManagerLogo';

$wgAutoloadClasses['PopulateAwards'] = "{$wgSystemGiftsDirectory}/SpecialPopulateAwards.php";
$wgSpecialPages['PopulateAwards'] = 'PopulateAwards';

$wgExtensionMessagesFiles['SystemGifts'] = $wgSystemGiftsDirectory . '/SystemGift.i18n.php';
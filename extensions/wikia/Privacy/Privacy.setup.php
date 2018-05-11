<?php

$GLOBALS['wgAutoloadClasses']['UserDataRemover'] = __DIR__ . '/UserDataRemover.php';
$GLOBALS['wgAutoloadClasses']['RemoveUserDataController'] = __DIR__ . '/RemoveUserDataController.php';
$GLOBALS['wgAutoloadClasses']['RemoveUserDataOnWikiTask'] = __DIR__ . '/RemoveUserDataOnWikiTask.php';
$GLOBALS['wgAutoloadClasses']['PermanentArticleDelete'] = __DIR__ . '/PermanentArticleDelete.php';
$GLOBALS['wgAutoloadClasses']['PermanentFileDelete'] = __DIR__ . '/PermanentFileDelete.php';

global $wgCityId;
if ( COMMUNITY_CENTRAL_CITY_ID === intval($wgCityId) ) {
	$GLOBALS['wgAutoloadClasses']['SpecialRequestToBeForgottenInternalController'] = __DIR__ . '/SpecialRequestToBeForgottenInternalController.php';
	$GLOBALS['wgSpecialPages']['RequestToBeForgottenInternal'] = 'SpecialRequestToBeForgottenInternalController';
}

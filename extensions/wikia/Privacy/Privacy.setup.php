<?php

$GLOBALS['wgAutoloadClasses']['UserDataRemover'] = __DIR__ . '/UserDataRemover.php';
$GLOBALS['wgAutoloadClasses']['LocalUserDataRemover'] = __DIR__ . '/LocalUserDataRemover.php';
$GLOBALS['wgAutoloadClasses']['RemoveUserDataController'] = __DIR__ . '/RemoveUserDataController.php';
$GLOBALS['wgAutoloadClasses']['RemoveUserDataOnWikiTask'] = __DIR__ . '/RemoveUserDataOnWikiTask.php';
$GLOBALS['wgAutoloadClasses']['PermanentArticleDelete'] = __DIR__ . '/PermanentArticleDelete.php';
$GLOBALS['wgAutoloadClasses']['PermanentFileDelete'] = __DIR__ . '/PermanentFileDelete.php';
$GLOBALS['wgAutoloadClasses']['RemovalAuditLog'] = __DIR__ . '/RemovalAuditLog.php';

if ( !empty( $wgEnableRequestToBeForgottenInternalSpecialPage ) ) {
	$GLOBALS['wgAutoloadClasses']['SpecialRequestToBeForgottenInternalController'] = __DIR__ . '/SpecialRequestToBeForgottenInternalController.php';
	$GLOBALS['wgSpecialPages']['RequestToBeForgottenInternal'] = 'SpecialRequestToBeForgottenInternalController';
}

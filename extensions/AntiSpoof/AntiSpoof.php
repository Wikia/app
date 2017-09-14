<?php
if ( !defined( 'MEDIAWIKI' ) ) {
	exit( 1 );
}

$wgExtensionCredits['antispam'][] = array(
	'path' => __FILE__,
	'name' => 'AntiSpoof',
	'url' => 'https://www.mediawiki.org/wiki/Extension:AntiSpoof',
	'author' => 'Brion Vibber',
	'descriptionmsg' => 'antispoof-desc',
);

/**
 * Set this to false to disable the active checks;
 * items will be logged but invalid or conflicting
 * accounts will not be stopped.
 *
 * Logged items will be marked with 'LOGGING' for
 * easier review of old logs' effect.
 */
$wgAntiSpoofAccounts = true;

$dir = dirname( __FILE__ );

$wgExtensionMessagesFiles['AntiSpoof'] = "$dir/AntiSpoof.i18n.php";

$wgAutoloadClasses['AntiSpoof'] = "$dir/AntiSpoof_body.php";
$wgAutoloadClasses['AntiSpoofHooks'] = "$dir/AntiSpoofHooks.php";
$wgAutoloadClasses['SpoofUser'] = "$dir/SpoofUser.php";
$wgAutoloadClasses['BatchAntiSpoof'] = "$dir/maintenance/batchAntiSpoof.php";

$wgHooks['LoadExtensionSchemaUpdates'][] = 'AntiSpoofHooks::asUpdateSchema';
$wgHooks['AbortNewAccount'][] = 'AntiSpoofHooks::asAbortNewAccountHook';
$wgHooks['UserCreateForm'][] = 'AntiSpoofHooks::asUserCreateFormHook';
$wgHooks['AddNewAccount'][] = 'AntiSpoofHooks::asAddNewAccountHook';
$wgHooks['RenameUserComplete'][] = 'AntiSpoofHooks::asAddRenameUserHook';

// Wikia Change
$wgHooks['UserRename::AfterGlobal'][] = 'AntiSpoofHooks::asAfterWikiaRenameUserHook';
// Wikia Change end
<?php
/** \file
* \brief Contains setup code for the Password Reset Extension.
*/

# Not a valid entry point, skip unless MEDIAWIKI is defined
if ( !defined( 'MEDIAWIKI' ) ) {
	echo "Password Reset extension";
	exit( 1 );
}

$wgExtensionCredits['specialpage'][] = array(
	'path'           => __FILE__,
	'name'           => 'Password Reset',
	'url'            => 'https://www.mediawiki.org/wiki/Extension:Password_Reset',
	'author'         => 'Tim Laqua',
	'descriptionmsg' => 'passwordreset-desc',
	'version'        => '1.7'
);

// Add permission required to access Special:PasswordReset and Special:Disabledusers
$wgAvailableRights[] = 'passwordreset';

$dir = dirname(__FILE__) . '/';
// Autoload Classes
$wgAutoloadClasses['PasswordReset'] = $dir . 'PasswordReset_body.php';
$wgAutoloadClasses['Disabledusers'] = $dir . 'PasswordReset_Disabledusers.php';

// Special Pages
$wgSpecialPages['PasswordReset'] = 'PasswordReset';
$wgSpecialPages['Disabledusers'] = 'Disabledusers';
$wgSpecialPageGroups['PasswordReset'] = 'users';
$wgSpecialPageGroups['Disabledusers'] = 'users';

// Messages
$wgExtensionMessagesFiles['PasswordReset'] = $dir . 'PasswordReset.i18n.php';
$wgExtensionMessagesFiles['PasswordResetAlias'] = $dir . 'PasswordReset.alias.php';

// Hooks
$wgHooks['GetBlockedStatus'][] = 'PasswordReset::GetBlockedStatus';

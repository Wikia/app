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
	'name'           => 'Password Reset',
	'url'            => 'http://www.mediawiki.org/wiki/Extension:Password_Reset',
	'author'         => 'Tim Laqua',
	'description'    => "Resets Wiki user's passwords - requires 'passwordreset' privileges",
	'descriptionmsg' => 'passwordreset-desc',
	'version'        => '1.7'
);

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
$wgExtensionAliasesFiles['PasswordReset'] = $dir . 'PasswordReset.alias.php';

// Hooks
$wgHooks['GetBlockedStatus'][] = 'PasswordReset::GetBlockedStatus';

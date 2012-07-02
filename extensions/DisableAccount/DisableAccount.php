<?php
// DisableAccount extension: quick extension to disable an account.
// Written by Andrew Garrett, 2010-12-02

$wgExtensionCredits['other'][] = array(
	'path' => __FILE__,
	'name' => 'Disable Account',
	'author' => array( 'Andrew Garrett' ),
	'url' => 'https://www.mediawiki.org/wiki/Extension:DisableAccount',
	'descriptionmsg' => 'disableaccount-desc',
);

$dir = dirname( __FILE__ ) . '/';

// Internationlization files
$wgExtensionMessagesFiles['DisableAccount'] = $dir . 'DisableAccount.i18n.php';
$wgExtensionMessagesFiles['DisableAccountAliases'] = $dir . 'DisableAccount.alias.php';

// Special page classes
$wgAutoloadClasses['SpecialDisableAccount'] = $dir . 'DisableAccount_body.php';
$wgSpecialPages['DisableAccount'] = 'SpecialDisableAccount';

// Add permission required to use Special:DisableAccount
$wgAvailableRights[] = 'disableaccount';

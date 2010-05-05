<?php

if (!defined('MEDIAWIKI')) {
        exit( 1 );
}

$wgExtensionCredits['specialpage'][] = array(
	'name' => 'Sign up',
	'author' => 'Bartek Lapinski',
	'url' => '',
	'description' => 'Alias extension for Special:Userlogin',
	'descriptionmsg' => '',
	'version' => '2.0.0',
);

$dir = dirname(__FILE__) . '/';

// special page
$wgAutoloadClasses['Signup'] = $dir.'SpecialSignup.class.php';

$wgSpecialPages['Signup'] = 'Signup';
$wgSpecialPageGroups['Signup'] = 'users';
$wgExtensionAliasesFiles['Signup'] = $dir . 'SpecialSignup.alias.php';

$wgExtensionMessagesFiles['Signup'] = $dir . 'Signup.i18n.php';

// hooks
$wgHooks ['OutputPageBeforeHTML'][] = 'Signup::TrackingOnSuccess';

<?php

if (!defined('MEDIAWIKI')) {
        exit( 1 );
}

$wgExtensionCredits['specialpage'][] = array(
	'name' => 'Sign up',
	'author' => 'Bartek Lapinski',
	'descriptionmsg' => 'signup-desc',
	'version' => '2.0.1',
);

$dir = dirname(__FILE__) . '/';

// special page
$wgAutoloadClasses['Signup'] = $dir.'SpecialSignup.class.php';

$wgSpecialPages['Signup'] = 'Signup';
$wgSpecialPageGroups['Signup'] = 'login';

$wgExtensionMessagesFiles['Signup'] = $dir . 'Signup.i18n.php';
$wgExtensionMessagesFiles['SignupAliases'] = $dir . 'SpecialSignup.alias.php';

// hooks
$wgHooks ['OutputPageBeforeHTML'][] = 'Signup::TrackingOnSuccess';

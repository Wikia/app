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
$wgExtensionAliasesFiles['Signup'] = $dir . 'SpecialSignup.alias.php';

$wgExtensionMessagesFiles['Signup'] = $dir . 'Signup.i18n.php';

// redirect all Special:Userlogin requests to the new page
$wgSpecialPages['Userlogin'] = array( 'SpecialRedirectToSpecial', 'Userlogin', 'Signup' );

// hooks
$wgHooks ['OutputPageBeforeHTML'][] = 'Signup::TrackingOnSuccess';

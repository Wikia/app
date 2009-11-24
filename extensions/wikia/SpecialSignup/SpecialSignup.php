<?php

if (!defined('MEDIAWIKI')) {
        exit( 1 );
}

$wgExtensionCredits['specialpage'][] = array(
	'name' => 'Sign up',
	'author' => 'Bartek Lapinski',
	'url' => 'http://www.mediawiki.org/wiki/Extension:MyExtension',
	'description' => 'Alias extension for Special:Userlogin',
	'descriptionmsg' => 'The new, improved Userlogin',
	'version' => '1.1.1',
);
 
$dir = dirname(__FILE__) . '/';

// special page
$wgAutoloadClasses['Signup'] = $dir.'SpecialSignup.class.php';
$wgAutoloadClasses['SignupTemplate'] = $dir.'templates/Signup.php';

$wgSpecialPages['Signup'] = 'Signup';
$wgSpecialPageGroups['Signup'] = 'users';
$wgExtensionAliasesFiles['Signup'] = $dir . 'SpecialSignup.alias.php';

$wgExtensionMessagesFiles['Signup'] = $dir . 'Signup.i18n.php';

// hooks
$wgHooks ['OutputPageBeforeHTML'][] = 'Signup::TrackingOnSuccess';


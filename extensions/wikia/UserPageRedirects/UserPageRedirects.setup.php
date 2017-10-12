<?php
if ( ! defined( 'MEDIAWIKI' ) )
	die( 1 );

$wgExtensionCredits['specialpage'][] = array(
	'name' => 'UserPageRedirects',
	'author' => 'Damian Jóźwiak',
	'descriptionmsg' => 'userpageredirects-desc',
	'version' => '1.0.0',
	'url' => 'https://github.com/Wikia/app/tree/dev/extensions/wikia/UserPageRedirects'
);

$dir = dirname(__FILE__) . '/';

//i18n
$wgExtensionMessagesFiles['UserPageRedirects'] = $dir . 'UserPageRedirects.i18n.php';

$wgAutoloadClasses['UserPageRedirectsHelper']  = $dir . 'UserPageRedirectsHelper.class.php';
$wgHooks['ArticleFromTitle'][] = 'UserPageRedirectsHelper::ArticleFromTitle';

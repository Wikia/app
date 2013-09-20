<?php
if ( ! defined( 'MEDIAWIKI' ) )
	die( 1 );

$wgExtensionCredits['specialpage'][] = array(
	'name' => 'UserPageRedirects',
	'author' => 'Damian Jóźwiak',
	'description' => 'redirects for UserPages for wikia.com',
	'version' => '1.0.0',
);

$dir = dirname(__FILE__) . '/';

$wgAutoloadClasses['UserPageRedirectsHelper']  = $dir . 'UserPageRedirectsHelper.class.php';
$wgHooks['ArticleFromTitle'][] = 'UserPageRedirectsHelper::ArticleFromTitle';

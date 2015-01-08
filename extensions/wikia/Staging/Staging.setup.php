<?php
/**
 * Code used to make staging environment more awesome!
 *
 * @author Damian Jóźwiak
 */
$dir = dirname(__FILE__) . '/';

$wgExtensionCredits['other'][] = array(
	'name' => 'StagingHooks',
	'description' => 'https://github.com/Wikia/app/tree/dev/extensions/wikia/Staging',
	'authors' => array(
		'Damian Jóźwiak',
	),
	'version' => 1.0
);

$wgAutoloadClasses['StagingHooks'] =  $dir . 'StagingHooks.class.php';

$wgHooks['MakeGlobalVariablesScript'][] = 'StagingHooks::onMakeGlobalVariablesScript';
$wgHooks['BeforePageRedirect'][] = 'StagingHooks::onBeforePageRedirect';

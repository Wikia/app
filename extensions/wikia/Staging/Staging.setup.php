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

/**
 * Vary memcache by environment
 *
 * We append wfWikiID() here as wfMemcKey() uses
 * $wgCachePrefix or wfWikiID() if the first one is not set
 *
 * @author macbre
 * @see PLATFORM-664
 */
$wgCachePrefix = gethostname() . '-' . wfWikiID(); // e.g. staging-s3-muppet / sandbox-qa02-glee / ...
$wgSharedKeyPrefix = gethostname() . '-' . $wgSharedKeyPrefix; // e.g. staging-s3-wikicities

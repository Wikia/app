<?php

/**
 * Implements queue that will wait for AMD modules being available
 *
 * @author Macbre
 */
 
 $wgExtensionCredits[ 'other' ][ ] = array(
	'name' => 'LoaderQueue',
	'author' => 'Macbre',
	'descriptionmsg' => 'loaderqueue-desc',
	'url' => 'https://github.com/Wikia/app/tree/dev/extensions/wikia/LoaderQueue',
);

//i18n
$wgExtensionMessagesFiles['LoaderQueue'] = __DIR__ '/LoaderQueue.i18n.php';

// ResourceLoader support (MW 1.17+)
$wgResourceModules['ext.wikia.loaderQueue'] = array(
	'scripts' => 'js/loaderQueue.js',
	'dependencies' => array(
		'amd',
		//'wikia.lazyQueue',
		'wikia.mw',
	),
	'localBasePath' => __DIR__,
	'remoteExtPath' => 'wikia/LoaderQueue'
);

$wgAutoloadClasses['LoaderQueueHooks'] =  __DIR__ . '/LoaderQueueHooks.class.php';
$wgHooks['WikiaSkinTopScripts'][] = 'LoaderQueueHooks::onWikiaSkinTopScripts';

<?php

/**
 * Implements queue that will wait for AMD modules being available
 *
 * Example:
 *
 * wgLoaderQueue.push({
 *  deps: ['jquery', 'wikia.log'], // names of AMD modules that will be passed to the callback
 *  callback: function($, log) {
 *
 *  }
 * });
 *
 * @author Macbre
 */

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

$app->registerClass('LoaderQueueHooks', __DIR__ . '/LoaderQueueHooks.class.php');
$app->registerHook('WikiaSkinTopScripts', 'LoaderQueueHooks', 'onWikiaSkinTopScripts');

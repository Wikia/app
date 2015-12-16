<?php

/**
 * This is a set of tools that automates the reporting of potential security problems
 *
 * @see PLATFORM-1491
 * @author macbre
 */

// register classes
$wgAutoloadClasses['Wikia\\Security\\CSRFDetector'] = __DIR__ . '/classes/CSRFDetector.class.php';
$wgAutoloadClasses['Wikia\\Security\\Exception'] = __DIR__ . '/classes/Exception.class.php';
$wgAutoloadClasses['Wikia\\Security\\Utils'] = __DIR__ . '/classes/Utils.class.php';

// set per-request flags
$wgHooks['UserMatchEditToken'][] = 'Wikia\\Security\\CSRFDetector::onUserMatchEditToken';
$wgHooks['WebRequestWasPosted'][] = 'Wikia\\Security\\CSRFDetector::onRequestWasPosted';
$wgHooks['WikiaRequestWasPosted'][] = 'Wikia\\Security\\CSRFDetector::onRequestWasPosted';

/**
 * CSRFDetector
 *
 * List of hooks to bind, actions that triggered them will be checked against token and HTTP method validation
 *
 * @see PLATFORM-1540
 */
$wgCSRFDetectorHooks = [
	// MAIN-5465: detect revision inserts not guarded by user's edit token check
	'RevisionInsertComplete',

	// PLATFORM-1531: detect file uploads (local files and via URL) not guarded by user's edit token check
	'UploadComplete',
	'UploadFromUrlReallyFetchFile',

	// CE-1224: detect user settings saves not guarded by user's edit token check
	'UserSaveSettings',

	// WikiFactory related actions should be protected as well
	'WikiFactoryChanged',
	'WikiFactoryVariableRemoved',

	// emails delivery should be protected as well
	'UserMailerSend',
];

// bind to all hooks defined in $wgCSRFDetectorHooks
$wgExtensionFunctions[] = 'Wikia\\Security\\CSRFDetector::setupHooks';

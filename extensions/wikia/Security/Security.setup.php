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

// PLATFORM-1540: detect revision inserts not guarded by user's edit token check
$wgHooks['UserMatchEditToken'][] = 'Wikia\\Security\\CSRFDetector::onUserMatchEditToken';
$wgHooks['RevisionInsertComplete'][] = 'Wikia\\Security\\CSRFDetector::onRevisionInsertComplete';

<?php

/**
 * This is an extension for distributing snapshot archives of extensions,
 * to be run on mediawiki.org
 */


/********************
 * Configuration
 */

/** Directory to put tar files in */
$wgExtDistTarDir = false;

/** URL corresponding to $wgExtDistTarDir */
$wgExtDistTarUrl = false;

/** Subversion /mediawiki working copy */
$wgExtDistWorkingCopy = false;

/** Supported branches, the first one is the default */
$wgExtDistBranches = array(
	'trunk' => array(
		'tarLabel' => 'trunk',
		'msgName' => 'extdist-current-version',
	),
	'branches/REL1_13' => array(
		'tarLabel' => 'MW1.13',
		'name' => '1.13.x',
	),
	'branches/REL1_12' => array(
		'tarLabel' => 'MW1.12',
		'name' => '1.12.x',
	),
	'branches/REL1_11' => array(
		'tarLabel' => 'MW1.11',
		'name' => '1.11.x',
	),
);

/** Remote socket for svn-invoker.php (optional) */
$wgExtDistRemoteClient = false;

/********************
 * Registration
 */
$dir = dirname(__FILE__) . '/';
$wgSpecialPages['ExtensionDistributor'] = 'ExtensionDistributorPage';
$wgSpecialPageGroups['ExtensionDistributor'] = 'developer';
$wgAutoloadClasses['ExtensionDistributorPage'] = $dir . 'ExtensionDistributor_body.php';
$wgExtensionMessagesFiles['ExtensionDistributor'] = $dir . 'ExtensionDistributor.i18n.php';

$wgExtensionCredits['specialpage'][] = array(
	'name'           => 'Extension Distributor',
	'author'         => 'Tim Starling',
	'svn-date'       => '$LastChangedDate: 2008-12-18 09:00:12 +0000 (Thu, 18 Dec 2008) $',
	'svn-revision'   => '$LastChangedRevision: 44758 $',
	'url'            => 'http://www.mediawiki.org/wiki/Extension:ExtensionDistributor',
	'description'    => 'This is an extension for distributing snapshot archives of extensions',
	'descriptionmsg' => 'extdist-desc',
);

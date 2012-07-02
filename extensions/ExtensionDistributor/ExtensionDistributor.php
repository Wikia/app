<?php

/**
 * This is an extension for distributing snapshot archives of extensions,
 * to be run on mediawiki.org
 */

$wgExtensionCredits['specialpage'][] = array(
	'path'           => __FILE__,
	'name'           => 'Extension Distributor',
	'author'         => 'Tim Starling',
	'url'            => 'https://www.mediawiki.org/wiki/Extension:ExtensionDistributor',
	'descriptionmsg' => 'extensiondistributor-desc',
);

/********************
 * Configuration
 */

/** Directory to put tar files in */
$wgExtDistTarDir = false;

/** URL corresponding to $wgExtDistTarDir */
$wgExtDistTarUrl = false;

/** Subversion /mediawiki working copy */
$wgExtDistWorkingCopy = false;

/** 
 * Supported branches, the first one is the default.
 * To add a branch, first check out the new branch in $wgExtDistWorkingCopy, and 
 * then add it here. Do not add a branch here without first checking it out.
 */
$wgExtDistBranches = array();

/** Remote socket for svn-invoker.php (optional) */
$wgExtDistRemoteClient = false;

/********************
 * Registration
 */
$dir = dirname( __FILE__ ) . '/';

// Internationlization files
$wgExtensionMessagesFiles['ExtensionDistributor'] = $dir . 'ExtensionDistributor.i18n.php';
$wgExtensionMessagesFiles['ExtensionDistributorAliases'] = $dir . 'ExtensionDistributor.alias.php';

// Special page classes
$wgSpecialPages['ExtensionDistributor'] = 'ExtensionDistributorPage';
$wgSpecialPageGroups['ExtensionDistributor'] = 'developer';
$wgAutoloadClasses['ExtensionDistributorPage'] = $dir . 'ExtensionDistributor_body.php';

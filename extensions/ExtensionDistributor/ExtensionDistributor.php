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
$dir = dirname(__FILE__) . '/';
$wgSpecialPages['ExtensionDistributor'] = 'ExtensionDistributorPage';
$wgSpecialPageGroups['ExtensionDistributor'] = 'developer';
$wgAutoloadClasses['ExtensionDistributorPage'] = $dir . 'ExtensionDistributor_body.php';
$wgExtensionMessagesFiles['ExtensionDistributor'] = $dir . 'ExtensionDistributor.i18n.php';

$wgExtensionCredits['specialpage'][] = array(
	'name'           => 'Extension Distributor',
	'author'         => 'Tim Starling',
	'svn-date'       => '$LastChangedDate: 2009-02-25 03:06:37 +0100 (śro, 25 lut 2009) $',
	'svn-revision'   => '$LastChangedRevision: 47777 $',
	'url'            => 'http://www.mediawiki.org/wiki/Extension:ExtensionDistributor',
	'description'    => 'This is an extension for distributing snapshot archives of extensions',
	'descriptionmsg' => 'extdist-desc',
);

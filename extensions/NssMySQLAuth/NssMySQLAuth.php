<?php

/**
 * A plugin to authenticate against a libnss-mysql database
 *
 * Copyright 2008 - Bryan Tong Minh / Delft Aerospace Rocket Engineering
 * Licensed under the terms of the GNU General Public License, version 2
 * or any later version.
 *
 */

 ### READ BEFORE USING ###
/**
 * This plugin allows authentication against an libnss-mysql database and thus
 * allows the use of the same login for MediaWiki as for shell.
 *
 */

$wgExtensionCredits['other'][] = array(
	'path'           => __FILE__,
	'name'           => 'NssMySQLAuth',
	'version'        => '1.0',
	'author'         => 'Bryan Tong Minh',
	'descriptionmsg' => 'nss-desc',
	'url'            => 'https://www.mediawiki.org/wiki/Extension:NssMySQLAuth',
);

$dir = dirname( __FILE__ ) . '/';
$wgExtensionMessagesFiles['nssmysqlauth'] = $dir . 'NssMySQLAuth.i18n.php';
$wgExtensionMessagesFiles['nssmysqlauthAlias'] = $dir . 'NssMySQLAuth.alias.php';

$wgAutoloadClasses['NssMySQLAuthPlugin'] = $dir . 'NssMySQLAuthPlugin.php';
$wgAutoloadClasses['Md5crypt'] = $dir . 'Md5crypt.php';
$wgAutoloadClasses['SpecialAccountManager'] = $dir . 'SpecialAccountManager.php';
$wgSpecialPages['AccountManager'] = 'SpecialAccountManager';

$wgNssMySQLAuthDB = false;

$wgExtensionFunctions[] = array( 'NssMySQLAuthPlugin', 'initialize' );

$wgUserProperties = array( 'address', 'city' );
$wgActivityModes = array( 'active', 'inactive' );

$wgDefaultGid = 1001;
$wgHomeDirectory = '/home/$1';

<?php

/*
 * A plugin to authenticate against a libnss-mysql database
 *
 * Copyright 2008 - Bryan Tong Minh / Delft Aerospace Rocket Engineering
 * Licensed under the terms of the GNU General Public License, version 2
 * or any later version.
 *
 */

 ### READ BEFORE USING ###
/*
 * This plugin allows authentication against an libnss-mysql database and thus
 * allows the use of the same login for MediaWiki as for shell.
 *
 */

$wgExtensionCredits['other'][] = array(
	'name'           => 'NssMySQLAuth',
	'version'        => '1.0',
	'author'         => 'Bryan Tong Minh',
	'description'    => 'A plugin to authenticate against a libnss-mysql database. Contains an [[Special:AccountManager|account manager]]',
	'descriptionmsg' => 'nss-desc',
	'url'            => 'http://www.mediawiki.org/wiki/Extension:NssMySQLAuth',
);

$dir = dirname( __FILE__ ) . '/';
$wgExtensionMessagesFiles['nssmysqlauth'] = $dir . 'NssMySQLAuth.i18n.php';
$wgExtensionAliasesFiles['nssmysqlauth'] = $dir . 'NssMySQLAuth.alias.php';

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

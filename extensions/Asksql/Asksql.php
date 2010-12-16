<?php
/* $Id: Asksql.php 49890 2009-04-26 05:22:33Z shinjiman $ */

/**
 * If enabled through $wgAllowSysopQueries = true, this class
 * let users with sysop right the possibility to make sql queries
 * against the cur table.
 * Heavy queries could slow down the database specially for the
 * biggest wikis.
 *
 * @addtogroup SpecialPage
 */

if (!defined('MEDIAWIKI'))
	exit;

$wgExtensionCredits['specialpage'][] = array(
	'path' => __FILE__,
	'name' => 'Ask SQL',
	'description' => 'Do SQL queries through a [[Special:Asksql|special page]]',
	'descriptionmsg' => 'asksql-desc',
	'author' => 'Brion Vibber',
	'url' => 'http://www.mediawiki.org/wiki/Extension:Asksql',
);

/** Dangerous if not configured properly. */
# Sysop SQL queries
#   The sql user shouldn't have too many rights other the database, restrict
#   it to SELECT only on 'page', 'revision' and 'text' tables for example
#
# Copy & paste the following three line into your localSettings.php and replace 'sqluser' and 'sqlpass' with the real values:
#$wgDBsqluser = 'sqluser';
#$wgDBsqlpassword = 'sqlpass';
#$wgGroupPermissions['sysop']['asksql'] = true;

$wgAllowSysopQueries = true;
$wgSqlLogFile = "{$wgUploadDirectory}/sqllog_mFhyRe6";
$wgAvailableRights[] = 'asksql';

$dir = dirname(__FILE__) . '/';
$wgExtensionMessagesFiles['Asksql'] = $dir . 'Asksql.i18n.php';
$wgExtensionAliasesFiles['Asksql'] = $dir . 'Asksql.alias.php';
$wgAutoloadClasses['SpecialAsksql'] = $dir . 'Asksql_body.php';
$wgSpecialPages['Asksql'] = 'SpecialAsksql';
$wgSpecialPageGroups['Asksql'] = 'wiki';

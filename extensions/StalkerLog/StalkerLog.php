<?php
/**
 * Extension:StalkerLog - Log everytime someone logs in or logs out,
 * great for tracking productivity in offices (or stalking).
 * 
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * @author Chad Horohoe <innocentkiller@gmail.com>
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */
 
$wgExtensionCredits['specialpage'][] = array(
        'name'				=> 'StalkerLog',
		'version'			=> '0.6',
        'url'				=> 'http://mediawiki.org/wiki/Extension:StalkerLog',
        'description'		=> 'Adds an entry to [[Special:Log]] on user login/logout',
        'author'			=> '[mailto:innocentkiller@gmail.com Chad Horohoe]',
        'descriptionmsg'	=> 'stalkerlog-desc',
);

# Basic setup
$wgExtensionMessagesFiles['stalkerlog'] = dirname(__FILE__) . '/' . 'StalkerLog.i18n.php';
$wgAdditionalRights[] = 'stalkerlog-view-log';
$wgGroupPermissions['*']['stalkerlog-view-log'] = true;
$wgHooks['UserLoginComplete'][] = 'wfStalkerLogin';

# Log setup
$wgLogTypes[] = 'stalkerlog';
$wgLogHeaders['stalkerlog'] = 'stalkerlog-log-text';
$wgLogNames['stalkerlog'] = 'stalkerlog-log-type';
$wgLogRestrictions['stalkerlog'] = 'stalkerlog-view-log';
$wgLogActions['stalkerlog/login'] = 'stalkerlog-log-login';

# 1.13+ setup only
if ( version_compare( $wgVersion, '1.13', '>=' ) ) {
	$wgHooks['UserLogoutComplete'][] = 'wfStalkerLogout';
	$wgLogActions['stalkerlog/logout'] = 'stalkerlog-log-logout';
}

# Login hook function
function wfStalkerLogin( &$user ) {
	wfLoadExtensionMessages('stalkerlog');
	$log = new LogPage( 'stalkerlog', false);
	$log->addEntry( 'login', $user->getUserPage(), '', null, $user );
	return true;
}

# Logout hook function
function wfStalkerLogout( &$user, &$inject_html, $old_name ) {
	wfLoadExtensionMessages('stalkerlog');
	$log = new LogPage( 'stalkerlog', false);
	$log->addEntry( 'logout', Title::newFromText( NS_USER, $old_name ), '', null, User::newFromName( $old_name ) );
	return true;
}

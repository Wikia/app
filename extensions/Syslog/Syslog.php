<?php
/**
 * Syslog.php -- an extension to log events to the system logger
 * Copyright © 2004 Evan Prodromou <evan@wikitravel.org>
 *
 *  This program is free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
 *  (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  You should have received a copy of the GNU General Public License
 *  along with this program; if not, write to the Free Software
 *  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
 *
 * @author Evan Prodromou <evan@wikitravel.org>
 * @author Alexandre Emsenhuber
 * @ingroup Extensions
 */

if ( !defined( 'MEDIAWIKI' ) ) {
	die( 1 );
}

$wgExtensionCredits['other'][] = array(
	'path' => __FILE__,
	'name' => 'Syslog',
	'author' => array( 'Evan Prodromou', 'Alexandre Emsenhuber' ),
	'url' => 'https://www.mediawiki.org/wiki/Extension:Syslog',
	'description' => 'An extension to log events to the system logger',
	'version' => '1.2'
);

$wgAutoloadClasses['SyslogHooks'] = dirname( __FILE__ ) . '/SyslogHooks.php';

# Setup globals

$wgSyslogIdentity = false;
$wgSyslogFacility = LOG_USER;

# Setup hooks

$wgHooks['ArticleDeleteComplete'][] = 'SyslogHooks::onArticleDeleteComplete';
$wgHooks['ArticleProtectComplete'][] = 'SyslogHooks::onArticleProtectComplete';
$wgHooks['ArticleSaveComplete'][] = 'SyslogHooks::onArticleSaveComplete';
$wgHooks['BlockIpComplete'][] = 'SyslogHooks::onBlockIpComplete';
$wgHooks['EmailUserComplete'][] = 'SyslogHooks::onEmailUserComplete';
$wgHooks['UnwatchArticleComplete'][] = 'SyslogHooks::onUnwatchArticleComplete';
$wgHooks['UserLoginComplete'][] = 'SyslogHooks::onUserLoginComplete';
$wgHooks['UserLogoutComplete'][] = 'SyslogHooks::onUserLogoutComplete';
$wgHooks['WatchArticleComplete'][] = 'SyslogHooks::onWatchArticleComplete';

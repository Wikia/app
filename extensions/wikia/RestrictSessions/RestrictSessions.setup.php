<?php

/**
 * Extension that restricts sessions to an IP address to make staff sessions slightly
 * more secure.
 *
 * @author Daniel Grunwell (Grunny) <grunny@wikia-inc.com>
 * @copyright (c) 2014 Daniel Grunwell, Wikia, Inc.
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

$wgExtensionCredits['other'][] = [
	'path' => __FILE__,
	'name' => 'RestrictSessions',
	'descriptionmsg' => 'restrictsessions-desc',
	'author' => [
		'[http://community.wikia.com/wiki/User:Grunny Daniel Grunwell (Grunny)]'
	],
	'license-name' => 'GPLv2',
	'url' => 'https://github.com/Wikia/app/tree/dev/extensions/wikia/RestrictSessions'
];

$wgAutoloadClasses['RestrictSessions\RestrictSessionsHooks'] =  __DIR__ . '/RestrictSessionsHooks.class.php';

$wgExtensionMessagesFiles['RestrictSessions'] = __DIR__ . '/RestrictSessions.i18n.php' ;

$wgExtensionFunctions[] = '\RestrictSessions\RestrictSessionsHooks::setupHooks';

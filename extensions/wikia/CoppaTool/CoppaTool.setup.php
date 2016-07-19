<?php
/**
 * Collection of tools to make handling COPPA reports easier
 *
 * @author Daniel Grunwell (Grunny) <grunny@wikia-inc.com>
 * @copyright (c) 2013 Daniel Grunwell, Wikia, Inc.
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

$wgExtensionCredits['specialpage'][] = [
	'name' => 'CoppaTool',
	'descriptionmsg' => 'coppatool-desc',
	'author' => [
		'[http://community.wikia.com/wiki/User:Grunny Daniel Grunwell (Grunny)]'
	],
	'url' => 'https://github.com/Wikia/app/tree/dev/extensions/wikia/CoppaTool',
];

$wgAutoloadClasses['CoppaToolSpecialController'] =  __DIR__ . '/CoppaToolSpecialController.class.php';
$wgAutoloadClasses['CoppaToolController'] =  __DIR__ . '/CoppaToolController.class.php';

$wgExtensionMessagesFiles['CoppaTool'] = __DIR__ . '/CoppaTool.i18n.php' ;

$wgSpecialPages['CoppaTool'] = 'CoppaToolSpecialController';
$wgSpecialPageGroups['CoppaTool'] = 'wikia';

$wgResourceModules['ext.coppaTool'] = [
	'localBasePath' => __DIR__ . '/modules',
	'remoteExtPath' => 'wikia/CoppaTool/modules',
	'scripts' => 'ext.coppaTool.js',
	'dependencies' => [
		'mediawiki.user'
	],
];

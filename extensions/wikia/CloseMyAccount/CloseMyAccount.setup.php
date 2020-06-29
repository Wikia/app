<?php
/**
 * Extension that enables users to close their own accounts
 *
 * @author Daniel Grunwell (Grunny) <grunny@wikia-inc.com>
 * @copyright (c) 2014 Daniel Grunwell, Wikia, Inc.
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

$wgExtensionCredits['specialpage'][] = [
	'path' => __FILE__,
	'name' => 'CloseMyAccount',
	'descriptionmsg' => 'closemyaccount-desc',
	'author' => [
		'[http://community.wikia.com/wiki/User:Grunny Daniel Grunwell (Grunny)]'
	],
	'url' => 'https://github.com/Wikia/app/tree/dev/extensions/wikia/CloseMyAccount',
	'license-name' => 'GPLv2',
];

$wgAutoloadClasses['CloseMyAccountSpecialController'] =  __DIR__ . '/CloseMyAccountSpecialController.class.php';
$wgAutoloadClasses['CloseMyAccountHooks'] =  __DIR__ . '/CloseMyAccountHooks.class.php';
$wgAutoloadClasses['CloseMyAccountHelper'] =  __DIR__ . '/CloseMyAccountHelper.class.php';

$wgExtensionMessagesFiles['CloseMyAccount'] = __DIR__ . '/CloseMyAccount.i18n.php' ;
$wgExtensionMessagesFiles['CloseMyAccountAliases'] = __DIR__ . '/CloseMyAccount.aliases.php';

$wgSpecialPages['CloseMyAccount'] = 'CloseMyAccountSpecialController';
$wgSpecialPageGroups['CloseMyAccount'] = 'wikia';

$wgHooks['UserSendConfirmationMail'][] = 'CloseMyAccountHooks::onUserSendConfirmationMail';

$wgResourceModules['ext.closeMyAccount'] = [
	'localBasePath' => __DIR__ . '/modules',
	'remoteExtPath' => 'wikia/CloseMyAccount/modules',
	'styles' => 'ext.closeMyAccount.scss',
];

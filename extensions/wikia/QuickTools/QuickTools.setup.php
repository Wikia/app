<?php
/**
 * Collection of tools to make the reversion of spam and vandalism, and other
 * tasks for staff and volunteers easier
 *
 * @author Daniel Grunwell (grunny) <grunny@wikia-inc.com>
 * @date 2012-10-22
 * @copyright (c) 2012 Daniel Grunwell, Wikia, Inc.
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

$wgExtensionCredits['antispam'][] = array(
	'name' => 'QuickTools',
	'descriptionmsg' => 'quicktools-desc',
	'author' => array(
		'[http://community.wikia.com/wiki/User:Grunny Daniel Grunwell (Grunny)]'
	),
	'url' => 'https://github.com/Wikia/app/tree/dev/extensions/wikia/QuickTools'
);

// Classes
$wgAutoloadClasses[ 'QuickToolsController'] =  __DIR__ . '/QuickToolsController.class.php';
$wgAutoloadClasses[ 'QuickToolsHelper'] =  __DIR__ . '/QuickToolsHelper.class.php';
$wgAutoloadClasses[ 'QuickToolsHooksHelper'] =  __DIR__ . '/QuickToolsHooksHelper.class.php';

// i18n
$wgExtensionMessagesFiles['QuickTools'] = __DIR__ . '/QuickTools.i18n.php';

// Resource Loader modules
$qtResourceTemplate = array(
	'localBasePath' => __DIR__ . '/modules',
	'remoteExtPath' => 'wikia/QuickTools/modules'
);
$wgResourceModules['ext.quickTools'] = $qtResourceTemplate + array(
	'scripts' => 'ext.quickTools.js',
	'styles' => 'ext.quickTools.css',
	'dependencies' => array(
		'mediawiki.user',
		'mediawiki.util'
	),
	'messages' => array(
		'quicktools-bot-reason',
		'quicktools-botflag-remove',
		'quicktools-adopt-success',
		'quicktools-adopt-error'
	)
);
$wgResourceModules['ext.createUserPage'] = $qtResourceTemplate + array(
	'scripts' => array( 'ext.createUserPage.js' ),
	'dependencies' => array(
		'mediawiki.user',
		'mediawiki.util'
	),
	'messages' => array(
		'quicktools-createuserpage-reason',
		'quicktools-createuserpage-success',
		'quicktools-createuserpage-exists',
		'quicktools-createuserpage-error',
	)
);
$wgResourceModules['ext.quickAdopt'] = $qtResourceTemplate + array(
	'scripts' => array( 'ext.quickAdopt.js' ),
	'dependencies' => array(
		'mediawiki.util',
		'ext.createUserPage'
	),
	'messages' => array(
		'quicktools-adopt-reason',
		'quicktools-adopt-success',
		'quicktools-adopt-error',
		'quicktools-adopt-confirm',
		'quicktools-adopt-confirm-ok',
		'quicktools-adopt-confirm-cancel',
		'quicktools-adopt-confirm-title'
	)
);

$wgHooks['ContributionsToolLinks'][] = 'QuickToolsHooksHelper::onContributionsToolLinks';
$wgHooks['AccountNavigationModuleAfterDropdownItems'][] = 'QuickToolsHooksHelper::onAccountNavigationModuleAfterDropdownItems';

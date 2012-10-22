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
	'description' => 'A collection of tools to make fighting spam and vandalism easier',
	'author' => array(
		'[http://community.wikia.com/wiki/User:Grunny Daniel Grunwell (grunny)]'
	),
);

$dir = dirname(__FILE__) . '/';
$app = F::app();

// Classes
$app->registerClass( 'QuickToolsController', $dir . 'QuickToolsController.class.php');
$app->registerClass( 'QuickToolsHooksHelper', $dir . 'QuickToolsHooksHelper.class.php');

// rights
$wgAvailableRights[] = 'quicktools';
$wgAvailableRights[] = 'quickadopt';
$wgGroupPermissions['util']['quicktools'] = true;
$wgGroupPermissions['vstf']['quicktools'] = true;
$wgGroupPermissions['util']['quickadopt'] = true;

// i18n
$app->registerExtensionMessageFile( 'QuickTools', $dir . 'QuickTools.i18n.php' );

// Resource Loader modules
$qtResourceTemplate = array(
	'localBasePath' => dirname( __FILE__ ) . '/modules',
	'remoteExtPath' => 'wikia/QuickTools/modules'
);
$wgResourceModules['ext.quickTools'] = $qtResourceTemplate + array(
	'scripts' => 'ext.quickTools.js',
	'styles' => 'ext.quickTools.css',
	'dependencies' => array(
		'mediawiki.util'
	),
	'messages' => array(
		'quicktools-bot-reason',
		'quicktools-botflag-remove'
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
		'quicktools-createuserpage-exists'
	)
);
$wgResourceModules['ext.quickAdopt'] = $qtResourceTemplate + array(
	'scripts' => array( 'ext.quickAdopt.js' ),
	'dependencies' => array(
		'mediawiki.user',
		'ext.createUserPage'
	),
	'messages' => array(
		'quicktools-adopt-reason',
		'quicktools-adopt-success',
		'quicktools-adopt-error'
	)
);

$wgHooks['ContributionsToolLinks'][] = 'QuickToolsHooksHelper::onContributionsToolLinks';
$wgHooks['AccountNavigationModuleAfterDropdownItems'][] = 'QuickToolsHooksHelper::onAccountNavigationModuleAfterDropdownItems';

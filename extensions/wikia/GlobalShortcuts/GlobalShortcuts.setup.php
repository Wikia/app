<?php
/**
 * Wikia GlobalShortcuts Extension
 *
 * Increase your browsing and editing experience using shortcut keys on Wikia.
 * Extension provides some key shortcuts to navigate to important pages or to perform certain actions.
 *
 * @author Kamil Koterba <kamil@wikia-inc.com>
 * @copyright (c) 2015 Wikia, Inc.
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

$wgExtensionCredits['other'][] = [
	'name'				=> 'Global Shortcuts',
	'version'			=> '1.0',
	'author'			=> [
		'Kamil Koterba',
	],
	'url'               => 'https://github.com/Wikia/app/tree/dev/extensions/wikia/GlobalShortcuts',
	'descriptionmsg'    => 'global-shortcuts-description',
];

/**
 * Controllers
 */
$wgAutoloadClasses['GlobalShortcutsController'] = __DIR__ . '/GlobalShortcutsController.class.php';

/**
 * Hooks
 */
$wgAutoloadClasses['Wikia\GlobalShortcuts\Hooks'] = __DIR__ . '/GlobalShortcuts.hooks.php';
$wgExtensionFunctions[] = 'Wikia\GlobalShortcuts\Hooks::register';

$wgHooks['WikiaHeaderButtons'][] = 'Wikia\\GlobalShortcuts\\Hooks::onWikiaHeaderButtons';

/**
 * Helper
 */
$wgAutoloadClasses['Wikia\GlobalShortcuts\Helper'] = __DIR__ . '/GlobalShortcutsHelper.php';

/**
 * Messages
 */
$wgExtensionMessagesFiles['GlobalShortcuts'] = __DIR__ . '/GlobalShortcuts.i18n.php';

JSMessages::registerPackage( 'GlobalShortcuts', [
	'global-shortcuts-caption-*',
] );

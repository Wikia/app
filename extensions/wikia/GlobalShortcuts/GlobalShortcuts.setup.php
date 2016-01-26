<?php
/**
 * Wikia GlobalShortcuts Extension
 *
 * Improve your browsing and editing experience using shortcut keys on Wikia.
 * This extension provides some key shortcuts and an actions explorer to help users navigate to important pages or perform certain actions.
 *
 * @author Kamil Koterba <kamil@wikia-inc.com>
 * @copyright (c) 2015 Wikia, Inc.
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

$wgExtensionCredits['other'][] = [
	'name' => 'Global Shortcuts',
	'version' => '1.0',
	'author' => [
		'Kamil Koterba',
		'Władysław Bodzek',
	],
	'url' => 'https://github.com/Wikia/app/tree/dev/extensions/wikia/GlobalShortcuts',
	'descriptionmsg' => 'global-shortcuts-description',
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
	'global-shortcuts-category-*',
	'global-shortcuts-key-*',
	'global-shortcuts-search-placeholder',
	'global-shortcuts-title-keyboard-shortcuts',
	// TODO remove template-class- prefix once messages come back from translations, as it's wrong naming
	'template-class-global-shortcuts-press-to-explore-shortcuts',
] );

/*
 * TODO move this block and message used below to TemplateClassification ext
 */
JSMessages::registerPackage( 'TemplateClassificationGlobalShortcuts', [
	'template-class-global-shortcuts-caption-classify-page',
] );

<?php

/**
 * Wikia Flags Extension
 *
 * Have you ever tried to a content of an article but had to scroll through a dozen of crazy
 * messages? They were saying something about missing sources and references, something about
 * an article being messy... While these notifications are very useful in general, you don't
 * want to see them all the time in every context.
 *
 * This extension provides a new way of storing and managing of the Flags that allows them
 * to be portable and behave accordingly to a given context.
 *
 * @author Adam Karmiński <adamk@wikia-inc.com>
 * @author Łukasz Konieczny <lukaszk@wikia-inc.com>
 * @author Kamil Koterba <kamil@wikia-inc.com>
 * @copyright (c) 2015 Wikia, Inc.
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

$wgExtensionCredits['other'][] = [
	'name'				=> 'Flags',
	'version'			=> '1.0',
	'author'			=> 'Adam Karmiński',
	'url'               => 'https://github.com/Wikia/app/tree/dev/extensions/wikia/Flags',
	'descriptionmsg'    => 'flags-desc',
];

/**
 * Special page
 */

$wgSpecialPages['Flags'] = 'SpecialFlagsController';
$wgSpecialPageGroups['Flags'] = 'wikia';

/**
 * Controllers
 */
$wgAutoloadClasses['SpecialFlagsController'] = __DIR__ . '/specials/SpecialFlagsController.class.php';
$wgAutoloadClasses['Flags\FlagsApiBaseController'] = __DIR__ . '/controllers/FlagsApiBaseController.class.php';
$wgAutoloadClasses['FlagsController'] = __DIR__ . '/controllers/FlagsController.class.php';
$wgAutoloadClasses['FlagsApiController'] = __DIR__ . '/controllers/FlagsApiController.class.php';
$wgWikiaApiControllers['FlagsApiController'] = __DIR__ . '/controllers/FlagsApiController.class.php';
$wgAutoloadClasses['FlaggedPagesApiController'] = __DIR__ . '/controllers/FlaggedPagesApiController.class.php';
$wgWikiaApiControllers['FlaggedPagesApiController'] = __DIR__ . '/controllers/FlaggedPagesApiController.class.php';

/**
 * Models
 */
$wgAutoloadClasses['Flags\Models\FlagsBaseModel'] = __DIR__ . '/models/FlagsBaseModel.class.php';
$wgAutoloadClasses['Flags\Models\Flag'] = __DIR__ . '/models/Flag.class.php';
$wgAutoloadClasses['Flags\Models\FlaggedPages'] = __DIR__ . '/models/FlaggedPages.class.php';
$wgAutoloadClasses['Flags\Models\FlagType'] = __DIR__ . '/models/FlagType.class.php';
$wgAutoloadClasses['Flags\Models\FlagParameter'] = __DIR__ . '/models/FlagParameter.class.php';

/**
 * Views
 */
$wgAutoloadClasses['Flags\Views\FlagView'] = __DIR__ . '/views/FlagView.class.php';

/**
 * Helpers
 */
$wgAutoloadClasses['Flags\FlagsExtractor'] = __DIR__ . '/FlagsExtractor.class.php';
$wgAutoloadClasses['Flags\FlagsHelper'] = __DIR__ . '/FlagsHelper.class.php';
$wgAutoloadClasses['Flags\FlagsCache'] = __DIR__ . '/FlagsCache.class.php';
$wgAutoloadClasses['Flags\FlaggedPagesCache'] = __DIR__ . '/FlaggedPagesCache.class.php';
$wgAutoloadClasses['Flags\FlagsParamsComparison'] = __DIR__ . '/FlagsParamsComparison.class.php';

/**
 * Tasks
 */
$wgAutoloadClasses['Flags\FlagsLogTask'] = __DIR__ . '/tasks/FlagsLogTask.php';
$wgAutoloadClasses['Flags\FlagsExtractTemplatesTask'] = __DIR__ . '/tasks/FlagsExtractTemplatesTask.php';

/**
 * Hooks
 */
$wgAutoloadClasses['Flags\Hooks'] = __DIR__ . '/Flags.hooks.php';
$wgHooks['ArticlePreviewAfterParse'][] = 'Flags\Hooks::onArticlePreviewAfterParse';
$wgHooks['BeforePageDisplay'][] = 'Flags\Hooks::onBeforePageDisplay';
$wgHooks['BeforeParserCacheSave'][] = 'Flags\Hooks::onBeforeParserCacheSave';
$wgHooks['PageHeaderDropdownActions'][] = 'Flags\Hooks::onPageHeaderDropdownActions';
$wgHooks['SkinTemplateNavigation'][] = 'Flags\Hooks::onSkinTemplateNavigation';
$wgHooks['ArticleSaveComplete'][] = 'Flags\Hooks::onArticleSaveComplete';
$wgHooks['EditPageLayoutShowIntro'][] = 'Flags\Hooks::onEditPageLayoutShowIntro';
$wgHooks['BeforeRefreshLinksForTitleUpdate'][] = 'Flags\Hooks::onBeforeRefreshLinksForTitleUpdate';

/**
 * Messages
 */
$wgExtensionMessagesFiles['Flags'] = __DIR__ . '/Flags.i18n.php';
$wgExtensionMessagesFiles['FlagsMagic'] = __DIR__ . '/Flags.magic.i18n.php';
$wgExtensionMessagesFiles['FlagsAliases'] = __DIR__ . '/specials/SpecialFlags.alias.i18n.php';

JSMessages::registerPackage( 'FlagsCreateForm', [
	'flags-special-create-*'
] );

JSMessages::registerPackage( 'FlagsSpecialAutoload', [
	'flags-special-autoload-*'
] );

/**
 * Resources Loader module
 */
$wgResourceModules['ext.wikia.Flags.EditFormMessages'] = [
	'messages' => [
		'flags-edit-flags-button-text',
		'flags-edit-modal-title',
		'flags-edit-modal-done-button-text',
		'flags-edit-modal-cancel-button-text',
		'flags-edit-modal-close-button-text',
	],
	'localBasePath' => __DIR__,
	'remoteExtPath' => 'wikia/Flags'
];

/**
 * Logs
 */
$wgLogTypes[] = 'flags';
$wgLogNames['flags'] = 'flags-log-name';
$wgLogHeaders['flags'] = 'flags-description';
$wgLogActionsHandlers[ 'flags/*' ] = 'LogFormatter';

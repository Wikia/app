<?php
/**
 * Wikia TemplateClassification Extension
 *
 * The journey towards structured content begins here! Classifying templates lets us understand
 * our content better.
 *
 * Is it an Infobox? No! Is it a Navbox? No! Is it a quote? Yeees!
 *
 * The extension is a MediaWiki client of the TemplateClassification Service.
 *
 * @author Adam Karmiński <adamk@wikia-inc.com>
 * @author Kamil Koterba <kamil@wikia-inc.com>
 * @copyright (c) 2015 Wikia, Inc.
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

$wgExtensionCredits['other'][] = [
	'name'				=> 'Template Classification',
	'version'			=> '1.0',
	'author'			=> [
		'Adam Karmiński',
		'Kamil Koterba',
	],
	'url'               => 'https://github.com/Wikia/app/tree/dev/extensions/wikia/TemplateClassification',
	'descriptionmsg'    => 'template-classification-description',
];

/**
 * Hooks
 */
$wgAutoloadClasses['Wikia\TemplateClassification\Hooks'] = __DIR__ . '/TemplateClassification.hooks.php';
$wgExtensionFunctions[] = 'Wikia\TemplateClassification\Hooks::register';

/**
 * UnusedTemplates
 */
$wgAutoloadClasses['Wikia\TemplateClassification\UnusedTemplates\Handler'] = __DIR__ . '/UnusedTemplates/UnusedTemplatesHandler.class.php';

/**
 * Controllers
 */
$wgAutoloadClasses['TemplateClassificationController'] = __DIR__ . '/TemplateClassificationController.class.php';
$wgAutoloadClasses['Wikia\TemplateClassification\Permissions'] = __DIR__ . '/Permissions.class.php';

/**
 * View
 */
$wgAutoloadClasses['Wikia\TemplateClassification\View'] = __DIR__ . '/TemplateClassificationView.php';

/**
 * Other
 */
$wgAutoloadClasses['Wikia\TemplateClassification\Logger'] = __DIR__ . '/Logger.class.php';

/**
 * Messages
 */
$wgExtensionMessagesFiles['TemplateClassification'] = __DIR__ . '/TemplateClassification.i18n.php';

JSMessages::registerPackage( 'TemplateClassificationModal', [
	'template-classification-edit-modal-*',
] );

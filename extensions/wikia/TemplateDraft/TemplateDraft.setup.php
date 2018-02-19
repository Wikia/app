<?php

/**
 * Wikia Template Draft Extension
 *
 * @author Adam Karmiński <adamk@wikia-inc.com>
 * @copyright (c) 2015 Wikia, Inc.
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

$GLOBALS['wgExtensionCredits']['other'][] = [
	'name'				=> 'TemplateDraft',
	'version'			=> '1.0',
	'author'			=> 'Adam Karmiński',
	'url'               => 'https://github.com/Wikia/app/tree/dev/extensions/wikia/TemplateDraft',
	'descriptionmsg'    => 'templatedraft-description',
];

/**
 * Messages
 */
$GLOBALS['wgExtensionMessagesFiles']['TemplateDraft'] = __DIR__ . '/TemplateDraft.i18n.php';

/**
 * Controllers
 */
$GLOBALS['wgAutoloadClasses']['TemplateDraftController'] = __DIR__ . '/controllers/TemplateDraftController.class.php';

/**
 * Hooks
 */
$GLOBALS['wgAutoloadClasses']['TemplateDraftHooks'] = __DIR__ . '/TemplateDraftHooks.class.php';
$GLOBALS['wgHooks']['EditFormPreloadText'][] = 'TemplateDraftHooks::onEditFormPreloadText';
$GLOBALS['wgHooks']['EditPageLayoutShowIntro'][] = 'TemplateDraftHooks::onEditPageLayoutShowIntro';
$GLOBALS['wgHooks']['GetRailModuleList'][] = 'TemplateDraftHooks::onGetRailModuleList';
$GLOBALS['wgHooks']['SkinAfterBottomScripts'][] = 'TemplateDraftHooks::onSkinAfterBottomScripts';

/**
 * Helpers
 */
$GLOBALS['wgAutoloadClasses']['TemplateDraftHelper'] = __DIR__ . '/TemplateDraftHelper.class.php';
$GLOBALS['wgAutoloadClasses']['TemplateConverter'] = __DIR__ . '/TemplateConverter.class.php';

/**
 * Right rail module
 */
$GLOBALS['wgAutoloadClasses']['TemplateDraftModuleController'] = $IP . '/skins/oasis/modules/TemplateDraftModuleController.class.php';

/**
 * Add approvedraft action (?action=apprevedraft)
 */
$GLOBALS['wgAutoloadLocalClasses']['ApprovedraftAction'] = __DIR__ . '/ApprovedraftAction.php';
$GLOBALS['wgActions']['approvedraft'] = true;

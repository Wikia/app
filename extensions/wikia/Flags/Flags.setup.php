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
 * @author Adam Karmiński
 * @copyright (c) 2015 Wikia, Inc.
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

$wgExtensionCredits['other'][] = [
	'name'				=> 'Flags',
	'version'			=> '1.0',
	'author'			=> 'Adam Karmiński',
	'url'               => 'https://github.com/Wikia/app/tree/dev/extensions/wikia/Flags',
	'descriptionmsg'    => 'flags-desc'
];

/**
 * Controllers
 */
$wgAutoloadClasses['FlagsController'] = __DIR__ . '/controllers/FlagsController.class.php';

/**
 * Models
 */
$wgAutoloadClasses['Flags\Models\FlagsBaseModel'] = __DIR__ . '/models/FlagsBaseModel.class.php';
$wgAutoloadClasses['Flags\Models\Flag'] = __DIR__ . '/models/Flag.class.php';
$wgAutoloadClasses['Flags\Models\FlagParameter'] = __DIR__ . '/models/FlagParameter.class.php';
$wgAutoloadClasses['Flags\Models\FlagType'] = __DIR__ . '/models/FlagType.class.php';

/**
 * Views
 */
$wgAutoloadClasses['Flags\Views\FlagView'] = __DIR__ . '/views/FlagView.class.php';

/**
 * Helpers
 */
$wgAutoloadClasses['Flags\Helper'] = __DIR__ . '/FlagsHelper.class.php';
$wgAutoloadClasses['Flags\FlagsCache'] = __DIR__ . '/FlagsCache.class.php';

/**
 * Hooks
 */
$wgAutoloadClasses['Flags\Hooks'] = __DIR__ . '/Flags.hooks.php';
$wgHooks['ParserBeforeInternalParse'][] = 'Flags\Hooks::onParserBeforeInternalParse';

/**
 * Messages
 */
$wgExtensionMessagesFiles['FlagsMagic'] = __DIR__ . '/Flags.magic.i18n.php';

<?php

/**
 * Wikia Broken Rename Fix Extension
 *
 * The extension provides a simple interface for re-running local rename jobs after an uncompleted
 * rename process. Simply by providing an old name, a new name and a user ID number you can
 * move remaining revisions on all wikias the user has contributed at.
 *
 * @author Adam Karmiński <adamk@wikia-inc.com>
 * @copyright (c) 2015 Wikia, Inc.
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 * @package BrokenRenameFix
 */

$wgExtensionCredits['other'][] = [
	'name'				=> 'Broken Renames Fix',
	'version'			=> '1.0',
	'author'			=> 'Adam Karmiński',
	'url'               => 'https://github.com/Wikia/app/tree/dev/extensions/wikia/BrokenRenameFix',
	'descriptionmsg'    => 'brf-desc',
];


/**
 * Messages
 */
$wgExtensionMessagesFiles['BrokenRenameFix'] = __DIR__ . '/BrokenRenameFix.i18n.php';

/**
 * Special pages
 */
$wgAutoloadClasses['BrokenRenameFixSpecialController'] = __DIR__ . '/BrokenRenameFixSpecialController.class.php';
$wgSpecialPages['BrokenRenameFix'] = 'BrokenRenameFixSpecialController';
$wgSpecialPageGroups['BrokenRenameFix'] = 'wikia';

/**
 * Tasks
 */
$wgAutoloadClasses['BrokenRenameFixTask'] = __DIR__ . '/BrokenRenameFixTask.class.php';

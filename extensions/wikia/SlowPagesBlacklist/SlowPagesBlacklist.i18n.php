<?php
/**
 * @file SlowPagesBlacklist.i18n.php
 * @brief I18n for the SlowPagesBlacklist MediaWiki extension.
 * @author Michał ‘Mix’ Roszka <mix@wikia-inc.com>
 * @date Tuesday, 17 December 2013 (created)
 */
$messages = [];
/**
 * Message documentation.
 */

$messages['qqq'] = [
	'slowpagesblacklist-desc' => 'A brief plain text description of the extension used on the Special:Version page.',
	'slowpagesblacklist-title' => 'The title of the error page.',
	'slowpagesblacklist-content' => 'The content of the error page.',
	'slowpagesblacklist-preview-unavailable' => 'The message diplayed instead of page preview.',
];

/**
 * English.
 */
$messages['en'] = [
	'slowpagesblacklist-desc' => 'Blacklist slow pages to prevent them from being rendered.',
	'slowpagesblacklist-title' => 'Page not available',
	'slowpagesblacklist-content' => 'Due to high server load, this page is currently unavailable. Feel free to check back shortly. Sorry for the trouble and thanks for your patience!',
	'slowpagesblacklist-preview-unavailable' => 'Due to high server load, preview of this page is currently unavailable. Feel free to check back shortly. Sorry for the trouble and thanks for your patience!',
	'right-forceview' => 'Force blacklisted slow pages to parse',
];


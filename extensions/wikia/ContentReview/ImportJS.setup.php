<?php

/**
 * Wikia Content Review ImportJS Extension
 *
 * Allows users to import reviewed JS pages from other wikis using a MediaWiki page.
 *
 * @author Adam Karmiński <adamk@wikia-inc.com>
 * @author Łukasz Konieczny <lukaszk@wikia-inc.com>
 * @copyright (c) 2015 Wikia, Inc.
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

$wgExtensionCredits['other'][] = [
	'name'				=> 'ImportJS',
	'version'			=> '1.0',
	'author'			=> [
		'Adam Karmiński',
		'Łukasz Konieczny',
		'Kamil Koterba',
		'Mariusz Czeszejko-Sochacki',
		'Daniel Grunwell'
	],
	'url'               => 'https://github.com/Wikia/app/tree/dev/extensions/wikia/ContentReview',
	'descriptionmsg'    => 'content-review-desc',
];

$wgAutoloadClasses['Wikia\ContentReview\ImportJS'] = __DIR__ . '/jsmodules/ImportJS.php';
$wgAutoloadClasses['Wikia\ContentReview\ProfileTags'] = __DIR__ . '/jsmodules/ProfileTags.php';

$wgAutoloadClasses['Wikia\ContentReview\ImportJSHooks'] = __DIR__ . '/ImportJS.hooks.php';
$wgExtensionFunctions[] = 'Wikia\ContentReview\ImportJSHooks::register';

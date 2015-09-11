<?php

/**
 * Wikia Content Review Extension
 *
 * After a major exploit of customizable JavaScript we can no longer allow for unreviewed code
 * to be executed on wikia's pages. This extension is the control room for code reviewing.
 *
 * @author Adam Karmiński <adamk@wikia-inc.com>
 * @author Łukasz Konieczny <lukaszk@wikia-inc.com>
 * @copyright (c) 2015 Wikia, Inc.
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

$wgExtensionCredits['other'][] = [
	'name'				=> 'Content Review',
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

/**
 * Groups and permissions
 */
$wgAvailableRights[] = 'content-review';
$wgGroupPermissions['*']['content-review'] = false;
$wgGroupPermissions['util']['content-review'] = true;
$wgGroupPermissions['staff']['content-review'] = true;

/**
 * Controllers
 */
$wgAutoloadClasses['ContentReviewApiController'] = __DIR__ . '/controllers/ContentReviewApiController.class.php';

/**
 * Models
 */
$wgAutoloadClasses['Wikia\ContentReview\Models\ContentReviewBaseModel'] = __DIR__ . '/models/ContentReviewBaseModel.php';
$wgAutoloadClasses['Wikia\ContentReview\Models\CurrentRevisionModel'] = __DIR__ . '/models/CurrentRevisionModel.php';
$wgAutoloadClasses['Wikia\ContentReview\Models\ReviewModel'] = __DIR__ . '/models/ReviewModel.php';
$wgAutoloadClasses['Wikia\ContentReview\Models\ReviewLogModel'] = __DIR__ . '/models/ReviewLogModel.php';

/**
 * Helpers
 */
$wgAutoloadClasses['Wikia\ContentReview\Helper'] = __DIR__ . '/ContentReviewHelper.php';

/**
 * Hooks
 */
$wgAutoloadClasses['Wikia\ContentReview\Hooks'] = __DIR__ . '/ContentReview.hooks.php';
$wgExtensionFunctions[] = 'Wikia\ContentReview\Hooks::register';

/**
 * Right rail module
 */
$wgAutoloadClasses['ContentReviewModuleController'] = $IP . '/skins/oasis/modules/ContentReviewModuleController.class.php';

/**
 * Messages
 */
$wgExtensionMessagesFiles['ContentReview'] = __DIR__ . '/ContentReview.i18n.php';

JSMessages::registerPackage( 'ContentReviewModule', [
	'content-review-module-*'
] );

JSMessages::registerPackage( 'ContentReviewTestMode', [
	'content-review-test-mode-*'
] );

JSMessages::registerPackage( 'ContentReviewDiffPage', [
	'content-review-diff-page-*'
] );

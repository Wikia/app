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
 * Controllers
 */
$wgAutoloadClasses['ContentReviewApiController'] = __DIR__ . '/controllers/ContentReviewApiController.class.php';
$wgAutoloadClasses['JSPagesSpecialController'] = __DIR__ . '/controllers/JSPagesSpecialController.class.php';
$wgAutoloadClasses['Wikia\ContentReview\ContentReviewDiffPage'] = __DIR__ . '/controllers/ContentReviewDiffPage.class.php';

/**
 * Special page
 */
$wgSpecialPages['JSPages'] = 'JSPagesSpecialController';

/**
 * Models
 */
$wgAutoloadClasses['Wikia\ContentReview\Models\ContentReviewBaseModel'] = __DIR__ . '/models/ContentReviewBaseModel.php';
$wgAutoloadClasses['Wikia\ContentReview\Models\CurrentRevisionModel'] = __DIR__ . '/models/CurrentRevisionModel.php';
$wgAutoloadClasses['Wikia\ContentReview\Models\ReviewModel'] = __DIR__ . '/models/ReviewModel.php';
$wgAutoloadClasses['Wikia\ContentReview\Models\ReviewLogModel'] = __DIR__ . '/models/ReviewLogModel.php';

/**
 * Services
 */
$wgAutoloadClasses['Wikia\ContentReview\ContentReviewService'] = __DIR__ . '/services/ContentReviewService.class.php';
$wgAutoloadClasses['Wikia\ContentReview\ContentReviewStatusesService'] = __DIR__ . '/services/ContentReviewStatusesService.class.php';

/**
 * Integrations
 */
$wgAutoloadClasses['Wikia\ContentReview\Integrations\SlackIntegration'] = __DIR__ . '/integrations/SlackIntegration.class.php';

/**
 * Helpers
 */
$wgAutoloadClasses['Wikia\ContentReview\Helper'] = __DIR__ . '/ContentReviewHelper.php';
$wgAutoloadClasses['Wikia\ContentReview\ImportJS'] = __DIR__ . '/jsmodules/ImportJS.php';
$wgAutoloadClasses['Wikia\ContentReview\ProfileTags'] = __DIR__ . '/jsmodules/ProfileTags.php';

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
$wgExtensionMessagesFiles['ContentReviewInternal'] = __DIR__ . '/ContentReviewInternal.i18n.php';

JSMessages::registerPackage( 'ContentReviewModule', [
	'content-review-module-*'
] );

JSMessages::registerPackage( 'ContentReviewTestMode', [
	'content-review-test-mode-*'
] );

JSMessages::registerPackage( 'ContentReviewDiffPage', [
	'content-review-diff-page-*'
] );

JSMessages::registerPackage( 'JSPagesSpecialPage', [
	'content-review-special-js-pages-*',
	'content-review-special-list-header-page-name',
	'content-review-special-list-header-actions',
	'content-review-module-header-latest',
	'content-review-module-header-last',
	'content-review-module-header-live'
] );

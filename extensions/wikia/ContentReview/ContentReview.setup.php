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
	'author'			=> 'Adam Karmiński',
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
$wgAutoloadClasses['SpecialContentReviewController'] = __DIR__ . '/controllers/SpecialContentReviewController.class.php';

/**
 * Models
 */
$wgAutoloadClasses['Wikia\ContentReview\Models\ReviewModel'] = __DIR__ . '/models/ReviewModel.php';

/**
 * Hooks
 */
$wgAutoloadClasses['Wikia\ContentReview\Hooks'] = __DIR__ . '/ContentReview.hooks.php';
$wgHooks['GetRailModuleList'][] = 'Wikia\ContentReview\Hooks::onGetRailModuleList';

/**
 * Right rail module
 */
$wgAutoloadClasses['ContentReviewModuleController'] = $IP . '/skins/oasis/modules/ContentReviewModuleController.class.php';

/**
 * Messages
 */
$wgExtensionMessagesFiles['ContentReview'] = __DIR__ . '/ContentReview.i18n.php';

/**
 * Special page
 */
$wgSpecialPages['ContentReview'] = 'SpecialContentReviewController';

<?php
/**
 * Internal tool to enable reviewing of images uploaded by users.
 * Developed for dealing COPPA reports.
 *
 * @author Daniel Grunwell (Grunny) <grunny@wikia-inc.com>
 * @copyright (c) 2013 Daniel Grunwell, Wikia, Inc.
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

// dependency on main component
if ( !class_exists( 'ImageReviewSpecialController' ) ) {
	include( "{$IP}/extensions/wikia/ImageReview/ImageReview.setup.php" );
}

$wgExtensionCredits['specialpage'][] = [
	'name' => 'COPPA Image Review',
	'descriptionmsg' => 'coppaimagereview-desc',
	'author' => [
		'[http://community.wikia.com/wiki/User:Grunny Daniel Grunwell (Grunny)]'
	],
];

$wgAutoloadClasses['CoppaImageReviewSpecialController'] =  __DIR__ . '/modules/CoppaImageReview/CoppaImageReviewSpecialController.class.php';
$wgAutoloadClasses['CoppaImageReviewHelper'] =  __DIR__ . '/modules/CoppaImageReview/CoppaImageReviewHelper.class.php';
$wgSpecialPages['CoppaImageReview'] = 'CoppaImageReviewSpecialController';

$wgExtensionMessagesFiles['CoppaImageReview'] = __DIR__ . '/modules/CoppaImageReview/CoppaImageReview.i18n.php';

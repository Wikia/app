<?php

/**
 * Wikia Content Review Special Page
 *
 * After a major exploit of customizable JavaScript we can no longer allow for unreviewed code
 * to be executed on wikia's pages. This extension is the control room for code reviewing.
 *
 * @author Adam Karmiński <adamk@wikia-inc.com>
 * @author Łukasz Konieczny <lukaszk@wikia-inc.com>
 * @author Kamil Koterba
 * @author Mariusz Czeszejko-Sochacki
 * @author Daniel Grunwell
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
$wgAutoloadClasses['ContentReviewSpecialController'] = __DIR__ . '/controllers/ContentReviewSpecialController.class.php';

/**
 * Special page
 */
$wgSpecialPages['ContentReview'] = 'ContentReviewSpecialController';

JSMessages::registerPackage( 'ContentReviewSpecialPage', [
	'content-review-special-page-*'
] );

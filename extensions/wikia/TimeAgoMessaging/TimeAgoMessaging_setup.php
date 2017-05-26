<?php
/**
 * TimeAgoMessaging
 *
 * Provides ability to localize messages used by jquery.timeago.js (RT #69946)
 *
 * @author Maciej Brencz (Macbre) <macbre at wikia-inc.com>
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 * @package MediaWiki
 */

if ( !defined( 'MEDIAWIKI' ) ) {
	echo "This is MediaWiki extension named TimeAgo Messaging.\n";
	exit( 1 );
}

$wgExtensionCredits['other'][] = [
	'author' => 'Maciej Brencz',
	'descriptionmsg' => 'timeagomessaging-desc',
	'name' => 'TimeAgo Messaging',
	'version' => '1.0',
	'url' => 'https://github.com/Wikia/app/tree/dev/extensions/wikia/TimeAgoMessaging',
];

// i18n
$wgExtensionMessagesFiles['TimeAgoMessaging'] = __DIR__ . '/TimeAgoMessaging.i18n.php';

$wgResourceModules['ext.wikia.timeAgoMessaging'] = [
	'scripts' => 'modules/jquery.timeago.js',
	'messages' => [
		'timeago-year',
		'timeago-month',
		'timeago-day',
		'timeago-hour',
		'timeago-minute',
		'timeago-second',
		'timeago-day',
		'timeago-hour',
		'timeago-minute',
		'timeago-second',

		'timeago-day-from-now',
		'timeago-hour-from-now',
		'timeago-minute-from-now',
		'timeago-second-from-now',
	],
	'dependencies' => [ 'mediawiki.jqueryMsg' ],

	'localBasePath' => __DIR__,
	'remoteExtPath' => 'wikia/TimeAgoMessaging',
];

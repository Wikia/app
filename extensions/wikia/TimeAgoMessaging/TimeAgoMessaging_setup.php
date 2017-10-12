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

if (!defined('MEDIAWIKI')) {
	echo "This is MediaWiki extension named TimeAgo Messaging.\n";
	exit(1) ;
}

$wgExtensionCredits['other'][] = array(
	'author' => 'Maciej Brencz',
	'descriptionmsg' => 'timeagomessaging-desc',
	'name' => 'TimeAgo Messaging',
	'version' => '1.0',
	'url' => 'https://github.com/Wikia/app/tree/dev/extensions/wikia/TimeAgoMessaging'
);

$dir = dirname(__FILE__);

// i18n

// hooks
$wgHooks['MakeGlobalVariablesScript'][] = 'TimeAgoMessaging::onMakeGlobalVariablesScript';

// classes
$wgAutoloadClasses['TimeAgoMessaging'] = "{$dir}/TimeAgoMessaging.class.php";

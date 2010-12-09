<?php
/**
 * TimeAgoMessaging
 *
 * Provides ability to localise messages used by jquery.timeago.js (RT #69946)
 *
 * @author Maciej Brencz (Macbre) <macbre at wikia-inc.com>
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 * @package MediaWiki
 */

$dir = dirname(__FILE__);

// i18n
$wgExtensionMessagesFiles['TimeAgoMessaging'] = "{$dir}/TimeAgoMessaging.i18n.php";

// hooks
$wgHooks['MakeGlobalVariablesScript'][] = 'TimeAgoMessaging::onMakeGlobalVariablesScript';

// classes
$wgAutoloadClasses['TimeAgoMessaging'] = "{$dir}/TimeAgoMessaging.class.php";

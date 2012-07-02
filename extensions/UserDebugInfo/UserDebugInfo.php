<?php
/**
 * @copyright Copyright © 2011 Sam Reed
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

$wgExtensionCredits['specialpage'][] = array(
	'path' => __FILE__,
	'name' => 'UserDebugInfo',
	'url' => 'https://www.mediawiki.org/wiki/Extension:UserDebugInfo',
	'author' => 'Sam Reed',
	'descriptionmsg' => 'userdebuginfo-desc',
);

$dir = dirname( __FILE__ ) . '/';

$wgAutoloadClasses['SpecialUserDebugInfo'] = $dir . 'SpecialUserDebugInfo.php';
$wgSpecialPages['UserDebugInfo'] = 'SpecialUserDebugInfo';
$wgSpecialPageGroups['UserDebugInfo'] = 'other';

$wgExtensionMessagesFiles['UserDebugInfo'] = $dir . 'UserDebugInfo.i18n.php';
$wgExtensionMessagesFiles['UserDebugInfoAlias'] = $dir . 'UserDebugInfo.alias.php';
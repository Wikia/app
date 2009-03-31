<?php
/**
 * What is my IP
 *
 * WhatIsMyIP extension for MediaWiki
 * shows user's IP address
 *
 * @author Łukasz Galezewski <lukasz@wikia.com>
 * @date 2008-01-22
 * @copyright Copyright © 2008 Łukasz Galezewski, Wikia Inc.
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 * @ingroup Extensions
 *
 * To activate this functionality, place this file in your extensions/
 * subdirectory, and add the following line to LocalSettings.php:
 * require_once("$IP/extensions/WhatIsMyIP/WhatIsMyIP.php");
 */

if (!defined('MEDIAWIKI')) {
	echo "This is a MediaWiki extension named WhatIsMyIP.\n";
	exit( 1 );
}
$wgExtensionCredits['specialpage'][] = array(
	'name' => 'WhatIsMyIP',
	'version' => '1.1',
	'description' => 'Shows current user\'s IP address on [[Special:WhatIsMyIP]]',
	'author' => 'Łukasz Galezewski',
	'url' => 'http://www.mediawiki.org/wiki/Extension:WhatIsMyIP',
	'descriptionmsg' => 'whatismyip-desc'
);

global $wgAvailableRights, $wgGroupPermissions;
$wgAvailableRights[] = 'whatismyip';
$wgGroupPermissions['*']['whatismyip'] = true;

$dir = dirname(__FILE__) . '/';
$wgExtensionMessagesFiles['WhatIsMyIP'] = $dir . 'WhatIsMyIP.i18n.php';
$wgExtensionAliasesFiles['WhatIsMyIP'] = $dir . 'WhatIsMyIP.alias.php';
$wgAutoloadClasses['WhatIsMyIP'] = $dir. 'WhatIsMyIP_body.php';
$wgSpecialPages['WhatIsMyIP'] = 'WhatIsMyIP';

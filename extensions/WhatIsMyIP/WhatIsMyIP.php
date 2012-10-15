<?php
/**
 * What is my IP
 *
 * WhatIsMyIP extension for MediaWiki
 * shows user's IP address
 *
 * @file
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

if ( !defined( 'MEDIAWIKI' ) ) {
	echo "This is a MediaWiki extension named WhatIsMyIP.\n";
	exit( 1 );
}

// Extension credits that show up on Special:Version
$wgExtensionCredits['specialpage'][] = array(
	'path' => __FILE__,
	'name' => 'WhatIsMyIP',
	'version' => '1.3',
	'author' => 'Łukasz Galezewski',
	'url' => 'https://www.mediawiki.org/wiki/Extension:WhatIsMyIP',
	'descriptionmsg' => 'whatismyip-desc'
);

// New user right, given to everyone by default (so even anonymous users can access the special page)
$wgAvailableRights[] = 'whatismyip';
$wgGroupPermissions['*']['whatismyip'] = true;

// Set up the special page
$dir = dirname( __FILE__ ) . '/';
$wgExtensionMessagesFiles['WhatIsMyIP'] = $dir . 'WhatIsMyIP.i18n.php';
$wgExtensionMessagesFiles['WhatIsMyIPAlias'] = $dir . 'WhatIsMyIP.alias.php';
$wgAutoloadClasses['WhatIsMyIP'] = $dir . 'WhatIsMyIP_body.php';
$wgSpecialPages['WhatIsMyIP'] = 'WhatIsMyIP';
// Special page group for MediaWiki 1.13+
$wgSpecialPageGroups['WhatIsMyIP'] = 'users';

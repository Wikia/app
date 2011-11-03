<?php
/**
 * What is my IP
 *
 * A WhatIsMyIP extension for MediaWiki
 * shows user's IP address
 *
 * @author Lukasz Galezewski <lukasz@wikia.com>
 * @date 2008-01-22
 * @copyright Copyright (C) 2008 Lukasz Galezewski, Wikia Inc.
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 * @package MediaWiki
 * @subpackage SpecialPage
 *
 * To activate this functionality, place this file in your extensions/
 * subdirectory, and add the following line to LocalSettings.php:
 * require_once("$IP/extensions/wikia/WhatIsMyIP/whatismyip.php");
 */

if (!defined('MEDIAWIKI')) 
{
	echo "This is MediaWiki extension named WhatIsMyIP.\n";
	exit( 1 ) ;
}

$dir = dirname(__FILE__) . '/';
$wgAutoloadClasses['WhatIsMyIP'] = $dir . 'whatismyip.php'; # Tell MediaWiki to load the extension body.
$wgExtensionMessagesFiles['WhatIsMyIP'] = $dir . 'WhatIsMyIP.i18n.php';

extAddSpecialPage( $dir . 'whatismyip_body.php', 'WhatIsMyIP', 'WhatIsMyIP' );

$wgSpecialPageGroups['WhatIsMyIP'] = 'wikia';

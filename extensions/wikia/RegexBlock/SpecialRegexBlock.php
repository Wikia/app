<?php

/**#@+
*	A special page with the interface for blocking, viewing and unblocking 
	user names and IP addresses
*
* @package MediaWiki
* @subpackage SpecialPage
*
* @author Bartek Łapiński, Piotr Molski moli at wikia.com
* @copyright Copyright © 2007, Wikia Inc.
* @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
*/

if ( !defined( 'MEDIAWIKI' ) ) {
    echo "This is MediaWiki extension named CreateWiki.\n";
    exit( 1 ) ;
}

$wgExtensionCredits['specialpage'][] = array(
   'name' => 'Regular Expression Name Block',
   'author' => 'Bartek Lapinski, Tomasz Klim, Piotr Molski',
   'description' => 'alternate user block (by given name, using regular expressions)'
);

#--- messages file
$wgExtensionMessagesFiles["RegexBlock"] = dirname(__FILE__) . '/RegexBlock.i18n.php';

$wgAvailableRights[] = 'regexblock';
$wgGroupPermissions['staff']['regexblock'] = true;

#--- helper file
require_once( dirname(__FILE__) . '/SpecialRegexBlock_helper.php' );

#--- register special page (MW 1.1x way)
if ( !function_exists( 'extAddSpecialPage' ) ) {
    require( "$IP/extensions/ExtensionFunctions.php" );
}

extAddSpecialPage( dirname(__FILE__) . '/SpecialRegexBlock_body.php', 'RegexBlock', 'RegexBlockForm' );

?>

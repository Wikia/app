<?php
/**#@+
*      Extension used for blocking users names and IP addresses with regular expressions. Contains both the blocking mechanism and a special page to add/manage blocks
*
* @package MediaWiki
* @subpackage SpecialPage
*
* @author Bartek Łapiński <bartek@wikia.com>
* @author Piotr Molski <moli@wikia.com>
* @copyright Copyright © 2007, Wikia Inc.
* @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
*/

if( !defined('REGEXBLOCK_TABLE') ) {
//bugId:10866 - hiphop returns an error here if extensions/regexBlock is included
	define ('REGEXBLOCK_TABLE', 'blockedby');
}

define ('WIKIA_REGEXBLOCK_STATS_TABLE', 'blockedby_stats');

if( !defined('REGEXBLOCK_TABLE') ) {
//bugId:10866 - hiphop returns an error here if extensions/regexBlock is included
	define ('REGEXBLOCK_MASK', '/^\d{1,3}\.\d{1,3}\.\d{1,3}\.(?:xxx|\d{1,3})$/');
}

/* modes for fetching data during blocking */
if( !defined('REGEXBLOCK_MODE_NAMES') ) {
//bugId:10866 - hiphop returns an error here if extensions/regexBlock is included
	define ('REGEXBLOCK_MODE_NAMES',0);
}

if( !defined('REGEXBLOCK_MODE_IPS') ) {
//bugId:10866 - hiphop returns an error here if extensions/regexBlock is included
	define ('REGEXBLOCK_MODE_IPS',1);
}

/* for future use */
if( !defined('REGEXBLOCK_USE_STATS') ) {
//bugId:10866 - hiphop returns an error here if extensions/regexBlock is included
	define ('REGEXBLOCK_USE_STATS', 1);
}

/* memcached expiration time (0 - infinite) */
if( !defined('REGEXBLOCK_EXPIRE') ) {
//bugId:10866 - hiphop returns an error here if extensions/regexBlock is included
	define ('REGEXBLOCK_EXPIRE', 0);
}

/* memcached keys */
if( !defined('REGEXBLOCK_USER_KEY') ) {
//bugId:10866 - hiphop returns an error here if extensions/regexBlock is included
	define ('REGEXBLOCK_USER_KEY', 'regex_user_block');
}

if( !defined('REGEXBLOCK_BLOCKERS_KEY') ) {
//bugId:10866 - hiphop returns an error here if extensions/regexBlock is included
	define ('REGEXBLOCK_BLOCKERS_KEY', 'regex_blockers');
}

if( !defined('REGEXBLOCK_SPECIAL_KEY') ) {
//bugId:10866 - hiphop returns an error here if extensions/regexBlock is included
	define ('REGEXBLOCK_SPECIAL_KEY', 'regexBlockSpecial');
}

if( !defined('REGEXBLOCK_SPECIAL_NUM_RECORD') ) {
//bugId:10866 - hiphop returns an error here if extensions/regexBlock is included
	define ('REGEXBLOCK_SPECIAL_NUM_RECORD', 'number_records');
}

/* add hook */
$wgHooks['GetBlockedStatus'][] = 'wfRegexBlockCheck';
$wgHooks['ContributionsToolLinks'][] = 'wfLoadRegexBlockLink';

$dir = dirname( __FILE__ ) . '/';

/* messages */
$wgExtensionMessagesFiles['RegexBlock'] = $dir . 'RegexBlock.i18n.php';

/* core includes */
require_once ($dir . '/RegexBlockCore.php'); 

/* special pages */
require_once ($dir . '/SpecialRegexBlock.php');
#require_once (dirname(__FILE__) . '/SpecialRegexBlockStats.php');

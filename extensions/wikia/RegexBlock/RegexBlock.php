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

define ('REGEXBLOCK_TABLE', 'blockedby');
define ('REGEXBLOCK_STATS_TABLE', 'blockedby_stats');
define ('REGEXBLOCK_MASK', '/^\d{1,3}\.\d{1,3}\.\d{1,3}\.(?:xxx|\d{1,3})$/'); 
/* modes for fetching data during blocking */
define ('REGEXBLOCK_MODE_NAMES',0);
define ('REGEXBLOCK_MODE_IPS',1);
/* for future use */
define ('REGEXBLOCK_USE_STATS', 1);
/* memcached expiration time (0 - infinite) */
define ('REGEXBLOCK_EXPIRE', 0);
/* memcached keys */
define ('REGEXBLOCK_USER_KEY', 'regex_user_block');
define ('REGEXBLOCK_BLOCKERS_KEY', 'regex_blockers');
define ('REGEXBLOCK_SPECIAL_KEY', 'regexBlockSpecial');
define ('REGEXBLOCK_SPECIAL_NUM_RECORD', 'number_records');

/* add hook */
$wgHooks['GetBlockedStatus'][] = 'wfRegexBlockCheck';

/* messages */
require_once (dirname(__FILE__) . '/RegexBlock.i18n.php'); 
/* core includes */
require_once (dirname(__FILE__) . '/RegexBlockCore.php'); 

/* special pages */
require_once (dirname(__FILE__) . '/SpecialRegexBlock.php');
#require_once (dirname(__FILE__) . '/SpecialRegexBlockStats.php');

?>

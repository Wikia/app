<?php
/**
 * Extension used for blocking users names and IP addresses with regular
 * expressions. Contains both the blocking mechanism and a special page to
 * add/manage blocks
 *
 * @file
 * @ingroup Extensions
 * @author Bartek Łapiński <bartek at wikia-inc.com>
 * @copyright Copyright © 2007, Wikia Inc.
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

/**
 * Protect against register_globals vulnerabilities.
 * This line must be present before any global variable is referenced.
 */
if( !defined('MEDIAWIKI') )
	die();

/* name of the block table */
define('REGEXBLOCK_TABLE', 'blockedby');
/* name of the statistic table */
define('REGEXBLOCK_STATS_TABLE', 'stats_blockedby');
define('REGEXBLOCK_MASK', '/^\d{1,3}\.\d{1,3}\.\d{1,3}\.(?:xxx|\d{1,3})$/'); 
/* modes for fetching data during blocking */
define('REGEXBLOCK_MODE_NAMES', 0);
define('REGEXBLOCK_MODE_IPS', 1);
/* for future use */
define('REGEXBLOCK_USE_STATS', 1);
/* memcached expiration time (0 - infinite) */
define('REGEXBLOCK_EXPIRE', 0);
/* memcached keys */
define('REGEXBLOCK_USER_KEY', 'regex_user_block');
define('REGEXBLOCK_BLOCKERS_KEY', 'regex_blockers');
define('REGEXBLOCK_SPECIAL_KEY', 'regexBlockSpecial');
define('REGEXBLOCK_SPECIAL_NUM_RECORD', 'number_records');

// generic reasons
$wgContactLink = '[[Special:Contact|contact us]]';
// Set this to the database to use for blockedby and stats_blockedby tables
// false means local database
// e.g. $wgRegexBlockDatabase = $wgSharedDB;
$wgRegexBlockDatabase = false;

// New user right
$wgAvailableRights[] = 'regexblock';
$wgGroupPermissions['staff']['regexblock'] = true;

// Extension credits that will show up on Special:Version
$wgExtensionCredits['specialpage'][] = array(
	'name' => 'regexBlock',
	'author' => array( 'Bartek Łapiński', 'Tomasz Klim', 'Piotr Molski', 'Adrian Wieczorek' ),
	'url' => 'http://www.mediawiki.org/wiki/Extension:RegexBlock',
	'version' => '1.2',
	'description' => 'Extension used for blocking users names and IP addresses with regular expressions. Contains both the blocking mechanism and a special page to add/manage blocks.',
	'descriptionmsg' => 'regexblock-desc',
);

// add hook
$wgHooks['GetBlockedStatus'][] = 'RegexBlock::check';

// Set up the new special page
$dir = dirname( __FILE__ ) . '/';
$wgExtensionMessagesFiles['RegexBlock'] = $dir . 'regexBlock.i18n.php';
$wgExtensionAliasesFiles['RegexBlock'] = $dir . 'regexBlock.alias.php';

$wgAutoloadClasses['RegexBlock'] = $dir . 'regexBlockCore.php';

// Special page
$wgAutoloadClasses['RegexBlockForm'] = $dir . 'SpecialRegexBlock.php';
$wgSpecialPages['RegexBlock'] = 'RegexBlockForm';
$wgSpecialPageGroups['RegexBlock'] = 'users';

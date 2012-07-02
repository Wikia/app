<?php
/**
 * Extension used for blocking users names and IP addresses with regular
 * expressions. Contains both the blocking mechanism and a special page to
 * add/manage blocks
 *
 * @file
 * @ingroup Extensions
 * @author Bartek Łapiński <bartek at wikia-inc.com>
 * @author Tomasz Klim
 * @author Piotr Molski <moli@wikia-inc.com>
 * @author Adrian 'ADi' Wieczorek <adi(at)wikia-inc.com>
 * @author Alexandre Emsenhuber
 * @author Jack Phoenix <jack@countervandalism.net>
 * @copyright Copyright © 2007, Wikia Inc.
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

/**
 * Protect against register_globals vulnerabilities.
 * This line must be present before any global variable is referenced.
 */
if( !defined( 'MEDIAWIKI' ) ){
	die( "This is not a valid entry point.\n" );
}

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

// Link to a page that users can use to contact the wiki administration if they've been blocked through regexBlock.
// Used in three interface messages (regexblock-reason-ip, regexblock-reason-name and regexblock-reason-regex)
$wgContactLink = 'Special:Contact';
// Set this to the database to use for blockedby and stats_blockedby tables
// false means local database
// e.g. $wgRegexBlockDatabase = $wgSharedDB;
$wgRegexBlockDatabase = false;

// New user right
$wgAvailableRights[] = 'regexblock';
$wgGroupPermissions['staff']['regexblock'] = true;

// Extension credits that will show up on Special:Version
$wgExtensionCredits['specialpage'][] = array(
	'path' => __FILE__,
	'name' => 'regexBlock',
	'author' => array( 'Bartek Łapiński', 'Tomasz Klim', 'Piotr Molski', 'Adrian Wieczorek', 'Alexandre Emsenhuber', 'Jack Phoenix' ),
	'url' => 'https://www.mediawiki.org/wiki/Extension:RegexBlock',
	'version' => '1.2.1',
	'descriptionmsg' => 'regexblock-desc',
);

// Hooked functions
$wgHooks['ContributionsToolLinks'][] = 'RegexBlock::loadContribsLink';
$wgHooks['GetBlockedStatus'][] = 'RegexBlock::check';

// Set up the new special page
$dir = dirname( __FILE__ ) . '/';
$wgExtensionMessagesFiles['RegexBlock'] = $dir . 'regexBlock.i18n.php';
$wgExtensionMessagesFiles['RegexBlockAliases'] = $dir . 'regexBlock.alias.php';
$wgAutoloadClasses['RegexBlock'] = $dir . 'regexBlockCore.php';
$wgAutoloadClasses['RegexBlockForm'] = $dir . 'SpecialRegexBlock.php';
$wgSpecialPages['RegexBlock'] = 'RegexBlockForm';
// Special page group for MW 1.13+
$wgSpecialPageGroups['RegexBlock'] = 'users';

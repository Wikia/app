<?php
/**
 * SpamRegex - A special page with the interface for blocking, viewing and unblocking of unwanted phrases
 *
 * @file
 * @ingroup Extensions
 * @author Bartek Łapiński <bartek(at)wikia-inc.com>
 * @author Alexandre Emsenhuber
 * @author Jack Phoenix <jack@countervandalism.net>
 * @version 1.2.2
 * @link http://www.mediawiki.org/wiki/Extension:SpamRegex Documentation
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

/**
 * Protect against register_globals vulnerabilities.
 * This line must be present before any global variable is referenced.
 */
if ( !defined( 'MEDIAWIKI' ) ){
	die( "This is not a valid entry point.\n" );
}

/* for memcached - expiration time */
define('SPAMREGEX_EXPIRE', 0);

/* two modes for two kinds of blocks */
define('SPAMREGEX_TEXTBOX', 0);
define('SPAMREGEX_SUMMARY', 1);

// Extension credits
$wgExtensionCredits['specialpage'][] = array(
	'path' => __FILE__,
	'name' => 'Regular Expression Spam Block',
	'version' => '1.2.2',
	'author' => array( 'Bartek Łapiński', 'Alexandre Emsenhuber', 'Jack Phoenix' ),
	'url' => 'https://www.mediawiki.org/wiki/Extension:SpamRegex',
	'descriptionmsg' => 'spamregex-desc',
);

/* return the proper db key for Memc */
function wfSpamRegexCacheKey( /*...*/ ) {
	global $wgSharedDB, $wgSharedTables, $wgSharedPrefix;
	$args = func_get_args();
	if( in_array( 'spam_regex', $wgSharedTables ) ) {
		$args = array_merge( array( $wgSharedDB, $wgSharedPrefix ), $args );
		return call_user_func_array( 'wfForeignMemcKey', $args );
	} else {
		return call_user_func_array( 'wfMemcKey', $args );
	}
}

// Set up the new special page
$dir = dirname(__FILE__) . '/';
$wgExtensionMessagesFiles['SpamRegex'] = $dir . 'SpamRegex.i18n.php';
$wgExtensionMessagesFiles['SpamRegexAlias'] = $dir . 'SpamRegex.alias.php';
$wgAutoloadClasses['SpamRegex'] = $dir . 'SpecialSpamRegex.php';
$wgAutoloadClasses['SpamRegexHooks'] = $dir . 'SpamRegexCore.php';
$wgSpecialPages['SpamRegex'] = 'SpamRegex';
$wgSpecialPageGroups['SpamRegex'] = 'pagetools';
// Hook it up
$wgHooks['EditFilter'][] = 'SpamRegexHooks::onEditFilter';
$wgHooks['AbortMove'][] = 'SpamRegexHooks::onAbortMove';

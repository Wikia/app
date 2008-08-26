<?php
if (!defined('MEDIAWIKI')) die();
/**
 * Add a new log to Special:Log that displays account creations in reverse
 * chronological order using the AddNewAccount hook
 *
 * @addtogroup Extensions
 *
 * @author Ævar Arnfjörð Bjarmason <avarab@gmail.com>
 * @copyright Copyright © 2005, Ævar Arnfjörð Bjarmason
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

$wgExtensionCredits['other'][] = array(
	'name'           => 'Newuserlog',
	'svn-date' => '$LastChangedDate: 2008-06-25 20:13:58 +0000 (Wed, 25 Jun 2008) $',
	'svn-revision' => '$LastChangedRevision: 36653 $',
	'description'    => 'Adds a [[Special:Log/newusers|log of account creations]] to [[Special:Log]]',
	'descriptionmsg' => 'newuserlog-desc',
	'url'            => 'http://www.mediawiki.org/wiki/Extension:Newuserlog',
	'author'         => 'Ævar Arnfjörð Bjarmason'
);

$wgExtensionMessagesFiles['Newuserlog'] = dirname(__FILE__) . '/Newuserlog.i18n.php';

# Add a new log type
$wgLogTypes[]                      = 'newusers';
$wgLogNames['newusers']            = 'newuserlogpage';
$wgLogHeaders['newusers']          = 'newuserlogpagetext';
$wgLogActions['newusers/newusers'] = 'newuserlogentry'; // For compatibility with older log entries
$wgLogActions['newusers/create']   = 'newuserlog-create-entry';
$wgLogActions['newusers/create2']  = 'newuserlog-create2-entry';
$wgLogActions['newusers/autocreate'] = 'newuserlog-autocreate-entry';
# Run this hook on new account creation
$wgHooks['AddNewAccount'][] = 'wfNewuserlogHook';
$wgHooks['AuthPluginAutoCreate'][] = 'wfNewuserlogAutoCreate';
# Run this hook on Special:Log
$wgHooks['LogLine'][] = 'wfNewuserlogLogLine';

function wfNewuserlogHook( $user = null, $byEmail = false ) {
	global $wgUser, $wgContLang;

	if( is_null( $user ) ) {
		// Compatibility with old versions which didn't pass the parameter
		$user = $wgUser;
	}
	wfLoadExtensionMessages( 'Newuserlog' );

	$talk = $wgContLang->getFormattedNsText( NS_TALK );

	if( $user->getName() == $wgUser->getName() ) {
		$action = 'create';
		$message = '';
	} else {
		$action = 'create2';
		$message = $byEmail ? wfMsgForContent( 'newuserlog-byemail' ) : '';
	}

	$log = new LogPage( 'newusers' );
	$log->addEntry( $action, $user->getUserPage(), $message, array( $user->getId() ) );

	return true;
}

function wfNewuserlogAutoCreate( $user ) {
	wfLoadExtensionMessages( 'Newuserlog' );
	$log = new LogPage( 'newusers', false );
	$log->addEntry( 'autocreate', $user->getUserPage(), '', array( $user->getId() ) );
	return true;
}

/**
 * Create user tool links for self created users
 * @param string $log_type
 * @param string $log_action
 * @param object $title
 * @param array $paramArray
 * @param string $comment
 * @param string $revert user tool links
 * @param string $time timestamp of the log entry
 * @return bool true
 */
function wfNewuserlogLogLine( $log_type = '', $log_action = '', $title = null, $paramArray = array(), &$comment = '', &$revert = '', $time = '' ) {
	if ( $log_action == 'create2' ) {
		global $wgUser;
		$skin = $wgUser->getSkin();
		if( isset( $paramArray[0] ) ) {
			$revert = $skin->userToolLinks( $paramArray[0], $title->getDBkey(), true );
		} else {
			# Fall back to a blue contributions link
			$revert = $skin->userToolLinks( 1, $title->getDBkey() );
		}
		if( $time < '20080129000000' ) {
			# Suppress $comment from old entries (before 2008-01-29), not needed and can contain incorrect links
			$comment = '';
		}
	}
	return true;
}

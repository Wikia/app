<?php
/**
 * WhosOnline extension - creates a list of logged-in users & anons currently online
 * The list can be viewed at Special:WhosOnline
 *
 * @file
 * @ingroup Extensions
 * @author Maciej Brencz <macbre(at)-spam-wikia.com> - minor fixes and improvements
 * @author ChekMate Security Group - original code
 * @see http://www.chekmate.org/wiki/index.php/MW:_Whos_Online_Extension
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

/**
 * Protect against arbitrary execution
 * This line must be present before any global variable is referenced.
 */
if ( !defined( 'MEDIAWIKI' ) ) {
	die( 'This is not a valid entry point.' );
}

// Extension credits that show up on Special:Version
$wgExtensionCredits['other'][] = array(
	'path' => __FILE__,
	'name' => 'WhosOnline',
	'version' => '1.3.1',
	'author' => 'Maciej Brencz',
	'descriptionmsg' => 'whosonline-desc',
	'url' => 'https://www.mediawiki.org/wiki/Extension:WhosOnline',
);

// Showing anonymous users' IP addresses can be a security threat!
$wgWhosOnlineShowAnons = false;

// Set up the special page
$dir = dirname( __FILE__ ) . '/';
$wgAutoloadClasses['SpecialWhosOnline'] = $dir . 'WhosOnlineSpecialPage.php';
$wgExtensionMessagesFiles['WhosOnline'] = $dir . 'WhosOnline.i18n.php';
$wgExtensionMessagesFiles['WhosOnlineAlias'] = $dir . 'WhosOnline.alias.php';
$wgSpecialPages['WhosOnline'] = 'SpecialWhosOnline';

$wgHooks['BeforePageDisplay'][] = 'wfWhosOnline_update_data';
// update online data
function wfWhosOnline_update_data() {
	global $wgUser, $wgDBname;

	wfProfileIn( __METHOD__ );

	// write to DB (use master)
	$db = wfGetDB( DB_MASTER );
	$db->selectDB( $wgDBname );

	$now = gmdate( 'YmdHis', time() );

	// row to insert to table
	$row = array(
		'userid' => $wgUser->getID(),
		'username' => $wgUser->getName(),
		'timestamp' => $now
	);

	$ignore = $db->ignoreErrors( true );
	$db->insert( 'online', $row, __METHOD__, 'DELAYED' );
	$db->ignoreErrors( $ignore );

	wfProfileOut( __METHOD__ );

	return true;
}

// Register database operations
$wgHooks['LoadExtensionSchemaUpdates'][] = 'wfWhosOnlineCheckSchema';

function wfWhosOnlineCheckSchema( $updater = null ) {
	if ( $updater === null ) {
		global $wgExtNewTables;
		$wgExtNewTables[] = array( 'online',
			dirname( __FILE__  ) . '/whosonline.sql' );
	} else {
		$updater->addExtensionUpdate( array( 'addTable', 'online',
			dirname( __FILE__  ) . '/whosonline.sql', true ) );
	}
	return true;
}

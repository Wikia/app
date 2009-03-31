<?php
/**
 * WhosOnline extension - creates a list of logged-in users & anons currently online
 * The list can be viewed at Special:WhosOnline
 * @ingroup Extensions
 *
 * @author Maciej Brencz <macbre(at)-spam-wikia.com> - minor fixes and improvements
 * @author ChekMate Security Group - original code
 * @see http://www.chekmate.org/wiki/index.php/MW:_Whos_Online_Extension
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

$wgHooks['BeforePageDisplay'][] = 'wfWhosOnline_update_data';

$wgExtensionCredits['other'][] = array(
	'name' => 'WhosOnline',
	'version' => '1.3',
	'author' => 'Maciej Brencz',
	'description' => 'Creates list of logged-in & anons currently online',
	'descriptionmsg' => 'whosonline-desc',
	'url' => 'http://www.mediawiki.org/wiki/Extension:WhosOnline',
);

$dir = dirname(__FILE__) . '/';
$wgAutoloadClasses['SpecialWhosOnline'] = $dir . 'WhosOnlineSpecialPage.php';
$wgExtensionMessagesFiles['WhosOnline'] = $dir . 'WhosOnline.i18n.php';
$wgExtensionAliasesFiles['WhosOnline'] = $dir . 'WhosOnline.alias.php';
$wgSpecialPages['WhosOnline'] = 'SpecialWhosOnline';

// update online data
function wfWhosOnline_update_data() {
	global $wgUser, $wgDBname;

	wfProfileIn(__METHOD__);

	// write to DB (use master)
	$db = wfGetDB(DB_MASTER);
	$db->selectDB( $wgDBname );

	$now = gmdate("YmdHis", time());

	// row to insert to table
	$row = array (
		'userid' => $wgUser->getID(),
		'username' => $wgUser->getName(),
		'timestamp' => $now
	);

	$ignore = $db->ignoreErrors( true );
	$db->insert('online', $row, __METHOD__, 'DELAYED');
	$db->ignoreErrors( $ignore );

	wfProfileOut(__METHOD__);

	return true;
}

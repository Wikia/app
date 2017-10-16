<?php
/**
 * removeUserRightsOnLocalDB
 *
 * Maintenance script for removing rights for users in local tables
 *
 * @author Maciej Błaszkowski (Marooned) <marooned at wikia-inc.com>
 * @date 2010-11-19
 * @copyright Copyright (C) 2010 Maciej Błaszkowski, Wikia Inc.
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 * @package MediaWiki
 * @subpackage Maintanance
 *
 */

require_once('../commandLine.inc');

if (isset($options['help'])) {
	die( "Usage: php removeUserRightsOnLocalDB.php [--quiet]

		  --help     you are reading it right now
		  --quiet    do not print anything to output\n\n");
}

$quiet = isset($options['quiet']);

$conds = array(
	'ug_group' => 'heper',
	'ug_user' => array('96953')	//see RT#67513, RT#131567
);

$dbr = WikiFactory::db(DB_MASTER);

/**
 * get active databases from city_list
 */
$databases = array();
$res = $dbr->select(
	WikiFactory::table('city_list'),
	array('city_dbname', 'city_id'),
	array('city_public' => 1, 'city_useshared' => 1),
	__FUNCTION__
);
while ($row = $dbr->fetchObject($res)) {
	$databases[$row->city_id] = $row->city_dbname;
}
$dbr->freeResult($res);

foreach ($databases as $city_id => $database) {
	//skip central (global user rights)
	if ( in_array( $city_id, array( 177 ) ) ) {
		continue;
	}

	if (!$quiet) {
		echo "Connecting to wiki (ID:$city_id, dbname:$database)\n";
	}
	$dbw = wfGetDB(DB_MASTER, array(), $database);
	$dbw->delete(
		'user_groups',
		$conds,
		__FUNCTION__
	);
	$dbw->close();
	if (!$quiet) {
		echo "Removed rights for wiki (ID:$city_id, dbname:$database)\n";
	}
	wfWaitForSlaves();
}
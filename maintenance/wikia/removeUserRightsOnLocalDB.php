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
	'ug_group' => 'helper',
	'ug_user' => array('874612', '826221', '126681', '35784')	//see RT#67513
);

$dbw = WikiFactory::db(DB_MASTER);

/**
 * get active databases from city_list
 */
$databases = array();
$res = $dbw->select(
	WikiFactory::table('city_list'),
	array('city_dbname', 'city_id'),
	array('city_public' => 1, 'city_useshared' => 1),
	__FUNCTION__
);
while ($row = $dbw->fetchObject($res)) {
	$databases[$row->city_id] = $row->city_dbname;
}
$dbw->freeResult($res);

foreach ($databases as $city_id => $database) {
	$dbw->selectDB($database);
	$dbw->delete('user_groups',
		$conds,
		__FUNCTION__
	);

	if (!$quiet) {
		echo "Removed rights for wiki (ID:$city_id, dbname:$database)\n";
	}
	wfWaitForSlaves(5);
}
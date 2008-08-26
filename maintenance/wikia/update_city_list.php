<?php
/**
 * Update field `city_title` in table `city_list` from wgSiteName taken from `city_variables`.
 *
 * @package MediaWiki
 * @subpackage Maintanance
 *
 * @author: Maciej Błaszkowski (Marooned) <marooned@wikia.com>
 *
 * @copyright Copyright (C) 2008 Maciej Błaszkowski (Marooned), Wikia, Inc.
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 *
 */

require_once('../commandLine.inc');

if (isset($options['help'])) {
	die( "Update field `city_title` in table `city_list` from wgSiteName taken from `city_variables`.\n
		  Usage: php update_city_list.php [--verbose] [--dryrun]

		  --help     you are reading it right now
		  --verbose  print out information on each operation
		  --dryrun   do not perform and operations on the database\n\n");
}

$db = wfGetDB(DB_MASTER);
$db->selectDB($wgSharedDB);

$sql = 'SELECT cv_id FROM `city_variables_pool` WHERE cv_name="wgSiteName"';
$res = $db->query($sql);
$cv_id = $db->fetchObject($res);
$cv_id = $cv_id->cv_id;
$db->freeResult($res);

$sql = "SELECT cv_city_id, cv_value, city_title FROM `city_variables` LEFT JOIN `city_list` ON cv_city_id=city_id WHERE cv_variable_id=$cv_id";
$res = $db->query($sql);
$sql = '';
$countAll = $countNoEmpty = 0;
while ($row = $db->fetchObject($res)) {
	$countAll++;
	$title = unserialize($row->cv_value);
	if ($title != '' && $title != $row->city_title) {
		$countNoEmpty++;
		$sql .= "/* city_title = '{$row->city_title}' */ UPDATE city_list SET city_title=" . $db->addQuotes($title) . " where city_id={$row->cv_city_id};\n";
	}
}

if (isset($options['verbose'])) print($sql. "\n");
if (!isset($options['dryrun'])) $db->query($sql);

echo "Found $countAll rows, $countNoEmpty with the wgSiteName set to a different value than city_title.\n";
?>
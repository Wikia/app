<?php
/**
 * Close invalid Wikis
 *
 * @package MediaWiki
 * @subpackage Maintanance
 *
 * @author: Moli <moli@wikia-inc.com>
 *
 */

require_once('../commandLine.inc');

if (isset($options['help'])) {
	die( "Usage: php close_invalid_wikis.php [--dryrun]

		  --help     you are reading it right now
		  --dryrun   do not perform and operations on the database\n\n");
}

global $wgExternalSharedDB;
$db_wiki = wfGetDB(DB_MASTER, array(), $wgExternalSharedDB);

$oRes = $db_wiki->select(
	"city_list", 
	array("city_url, group_concat(city_dbname) as db_list, count(*) as cnt"), 
	array("city_public in (0, 1)"),
	__METHOD__,
	array( "GROUP BY" => "city_url", "HAVING" => "count(*)>1" )
);
$DB = array();
while ( $oRow = $db_wiki->fetchObject( $oRes ) ) {
	$dbl = explode(",", $oRow->db_list);
	if (!empty($dbl)) {
		foreach ($dbl as $dbname) {
			$DB[] = $dbname;
		}
	}
};

$invalidDB = array();
$loop = 0;
$flags = array(WikiFactory::FLAG_DELETE_DB_IMAGES, WikiFactory::FLAG_FREE_WIKI_URL, WikiFactory::FLAG_HIDE_DB_IMAGES);
if ( !empty($DB) ) {
	$city_flags = 0;
	foreach ($flags as $flag) {
		$city_flags |= $flag;
	}
	foreach ($DB as $dbname) {
		$db = wfGetDB(DB_SLAVE, array(), $dbname);
		if (!$db->tableExists('revision')) {
			$city_id = WikiFactory::DBtoID($dbname);
			$sql = "update city_list set city_public = ". WikiFactory::HIDE_ACTION .", city_flags = {$city_flags} where city_id = {$city_id}";
			if ( isset($options['dryrun'])) {
				echo $sql . ";\n";
			} else {
			#	$db_wiki->query($sql);
			}
			$loop++;
		}
	}
}

echo "Found $loop invalid wikis\n";

<?php
/**
 * Update field `city_description` in table `city_list`
 *
 * @package MediaWiki
 * @subpackage Maintanance
 *
 * @author:  Tomasz Odrobny (Tomek) tomek@wikia-inc.com
 *
 * @copyright Copyright (C) 2008 Tomasz Odrobny (Tomek), Wikia, Inc.
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 *
 */

require_once('../commandLine.inc');

if (isset($options['help'])) {
	die( " Clear old tags from stats" );
}


function deleteScript($document){
	$search = array('@<script[^>]*?>.*?</script>@si');
	$text = preg_replace($search, '', $document);
	return trim(strip_tags($text)); 
};

$sql = 'select id,name,group_concat(city_id) as ids from city_tag left join city_tag_map on city_tag.id = city_tag_map.tag_id 
		where tag_id = 1 
		group by city_tag.id ';

$db = WikiFactory::db( DB_MASTER );
$res = $db->query($sql);
$countAll = $countNoEmpty = 0;
$sql = '';
$countNoEmpty = 0;


$tables = 
	array( 
		"tags_top_blogs" => array( "tag_id" => "tb_tag_id", "city_id" => "tb_city_id" ),
		"tags_top_articles" => array( "tag_id" => "ta_tag_id", "city_id" => "ta_city_id" ),
		"tags_pv" => array( "tag_id" => "tag_id", "city_id" => "city_id" ),	
	);

global $wgStatsDB;
$dbs = wfGetDB( DB_MASTER, array(), $wgStatsDB);

while ($row = $db->fetchRow($res)) {
	$row['ids'] = trim($row['ids']);

	if ( substr($row['ids'], -1) == ","){
		$row['ids'] .= "0";
	} 

	if( (strlen($row['ids']) > 0)  && ($row['name'] == "pc") ) {
		$countAll++;			
		echo "\n================================================================================================\n";
		echo "Tag:" .$row['name']. "\n";
		echo "Tag ID:" .$row['id']. "\n";
		echo "IN tag IDs:" . $row['ids']."\n"."\n";
		
		foreach ($tables as $key => $value) {			
			$conditions = array( " (".$value['tag_id']." = ". $row['id'] .") and (".$value['city_id']." not in (". $row['ids'] ."))" );
			$res_out = $dbs->select(
				array( $key ),
				array( 'group_concat( distinct '.$value['city_id'].') as ids ' ),
				$conditions );
			$out = $dbs->fetchRow($res_out);	
		
			echo "Table :".$key. " IDs:" . $out['ids']."\n";
			
			$out['ids'] = trim($out['ids']);	
				
			$dbs->begin();

			$dbs->delete( $key, $conditions );

			$dbs->commit();	
		}
	}
}

echo "\n\nDONE !!!!";
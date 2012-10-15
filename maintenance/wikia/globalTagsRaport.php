<?php
/**
 * create raport for tags use  
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
//error_reporting(E_ALL);
require_once('../commandLine.inc');

if (isset($options['help'])) {
	die( "indexer for blog listing pages" );
}

$db = wfGetDB(DB_MASTER, array(), $wgStatsDB);
$res = $db->select(
            array( 'city_used_tags' ),
            array( 'distinct ct_kind'),
            "",
            "",
            array( ));

$base_array = array(); 
            
while ($row = $db->fetchRow($res)) {
	$base_array[$row['ct_kind']] = 0;
}

$res = $db->select(
            array( 'city_used_tags' ),
            array( 'count(*) as cnt,ct_wikia_id,ct_kind'),
            "",
            "",
            array( 
             	'GROUP BY' => 'ct_wikia_id,ct_kind',
            	'ORDER BY' => 'ct_wikia_id', 
            ));

$out = array();
while ($row = $db->fetchRow($res)) {
	$city_id = $row['ct_wikia_id'];
	if(empty($out[$city_id])) {
		$out[$city_id] = $base_array;
	}
	$out[$city_id][ $row['ct_kind'] ] = $row[ 'cnt' ];
}

$csvdata = ';'.implode(';',array_keys($base_array))."\n";

foreach ($out as $key => $value) {
	$csvdata .= "'".WikiFactory::getVarValueByName("wgSitename", $key)."';".implode(";", $out[$key])."\n";
}

$fname = 'out.csv';
$fp = fopen($fname,'w');
fwrite($fp,$csvdata);
fclose($fp);

<?php
/**
 * indexer for images order in articles
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
define("package_size", 100);
$optionsWithArgs = array( 'list' );

ini_set( "include_path", dirname(__FILE__)."/../" );
require( "commandLine.inc" );

if (isset($options['help'])) {
	die( "indexer for blog listing pages" );
}

global $wgSharedDB;

$db = wfGetDB(DB_SLAVE, array(), $wgSharedDB);

/*
 * first time it run only count on pages and then it run this script with param -do and list 
 * it is hack for problem with memory leak from parser 
 */

$res = $db->query('select 
							city_dbname, city_id
				 from city_list 
				 	where city_id in 
				(select city_id from  city_variables where cv_variable_id =  989 and cv_value = "b:1;");');

echo "List of pages\n";

while ($row = $db->fetchRow($res)) {
	try {
		$dbl = wfGetDB(DB_SLAVE, array(), $row['city_dbname'] );
		$resl = $dbl->query('select count(*) as cnt from plb_page');
		$rowCount = $dbl->fetchRow($resl);
		echo "{$row['city_dbname']}:{$rowCount['cnt']}\n";
		if($rowCount['cnt'] == 0) {
			WikiFactory::setVarByName("wgEnablePageLayoutBuilder", $row['city_id'], false );
		}
	} catch (Exception $e) {

	}
}

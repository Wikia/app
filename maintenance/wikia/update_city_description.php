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
	die( "Update field `city_description` in table `city_list` base on media wiki msg ");
}

function deleteScript($document){
	$search = array('@<script[^>]*?>.*?</script>@si');
	$text = preg_replace($search, '', $document);
	return trim(strip_tags($text)); 
};

$sql = 'SELECT cv_id, city_url, city_description FROM `city_list`';

$db = WikiFactory::db( DB_MASTER );
$res = $db->query($sql);
$countAll = $countNoEmpty = 0;
$sql = '';
$countNoEmpty = 0;
while ($row = $db->fetchRow($res)) {
	$countAll++;
	$url =  $row['city_url']."index.php?title=MediaWiki:Description&action=render";
	
	$out = HTTP::get( $url );
	$out = deleteScript($out);
	
	if ($out != $row['city_description']) {
		echo $row['city_id'].":".$row[' city_sitename'].":".$countNoEmpty."\n";
		$sql = " UPDATE city_list SET city_description =" . $db->addQuotes($out) . " where city_id=".$row['city_id'].";\n";
		$db->query($sql);
		$countNoEmpty ++;
	} else {
		echo "is up to date\n";
	}
} 

echo "Found $countAll rows, $countNoEmpty with the wiki description updated.\n";

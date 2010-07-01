<?php
/**
 * indexer for blog listing pages
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

$db = wfGetDB(DB_MASTER, array(), $wgExternalDatawareDB);
$res = $db->select(
            array( 'pages' ),
            array( 'page_wikia_id',
                   'page_title'),
            "page_namespace = 502",
            __METHOD__,
            array(
                'LIMIT' => 10
	));
$countAll = $countNoEmpty = 0;
$sql = '';

$countNoEmpty = 0;

while ($row = $db->fetchRow($res)) {

    
    $link = WikiFactory::getVarValueByName("wgServer", $row['page_wikia_id']);
    $link .= '/wiki/Special:CreateBlogListingPage?article='.$row['page_title'].'&makeindex=1&cb='.  rand(0, 999999);
    
    echo "working on city id:". $row['page_wikia_id']." ".$link."\n";
    if (Http::get($link) === false) {
        echo "fail";
    } else {
        echo "ok";
    }
    echo "\n";
}
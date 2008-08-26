<?php
/**
 * @package MediaWiki
 * @addtopackage maintenance
 *
 * clear wikifactory variables cache
 *
 * Usage:
 * (particular wiki)
 * maintenance/wikia/clear_wikifactory_cache.php -i <city_id_from_city_list>
 *
 * or
 * (whole cache, all wikis)
 * maintenance/wikia/clear_wikifactory_cache.php
 */

ini_set( "include_path", dirname(__FILE__)."/.." );
require_once( "commandLine.inc" );

$dbr = new Database( "10.8.2.12", "wowwiki", "l33tw0ww1k1", "wowwiki" );

$oldusers = array();
$oRes = $dbr->query( "SELECT * FROM user", __METHOD__ );
while( $row = $dbr->fetchObject( $oRes ) ) {
    $oldusers[ $row->user_id ] = $row->user_name;
}
$dbr->freeResult( $oRes );
$dbr->close();

$newusers = array();
$dbr = wfGetDB( DB_SLAVE );
$dbr->selectDB( "wowwiki" );
$oRes = $dbr->query( "SELECT * FROM user", __METHOD__ );
while( $row = $dbr->fetchObject( $oRes ) ) {
    $newusers[ $row->user_id ] = $row->user_name;
}
$dbr->freeResult( $oRes );
$dbr->close();

echo "Users in new ".sizeof( $newusers )." in old " . sizeof( $oldusers ) . "\n";
foreach( $newusers as $id => $user ) {
    if( isset( $oldusers[ $id ] ) ) {
        if( $newusers[ $id ] !== $oldusers[ $id ] ) {
            echo "Not match, new user {$id} {$newusers[ $id ]} <> {$oldusers[ $id ]}\n";
        }
    }
    else {
        echo "new user {$id} {$newusers[ $id ]} is not old database\n";
    }
}

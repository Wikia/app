<?php
/**
 * User: artur
 * Date: 16.04.13
 * Time: 15:49
 */

global $IP;
require_once(__DIR__ . '/../../commandLine.inc');
require_once($IP . '/lib/GoogleWebmasterTools/WebmasterToolsService.php');



global $wgExternalSharedDB;
$app = F::app();
$db = $app->wf->getDB( DB_MASTER, array(), $wgExternalSharedDB);

echo $wgExternalSharedDB . "\n";


function generateUserId( $db ) {
	$res = $db->select("webmaster_user_accounts",
		array('max(user_id) as maxid'),
		array(),
		__METHOD__
	);
	return $res->fetchObject()->maxid + 1;
}

function tryInsertUser( $db ,$u ) {
	$res = $db->select("webmaster_user_accounts",
		array('user_id'),
		array(
			"user_name" => $u->getEmail(),
		),
		__METHOD__
	);
	$obj = null;
	if ( $obj = $res->fetchObject() ) return $obj->user_id;
	echo "insert: " . $u->getEmail() . "\n";
	$user_id = generateUserId( $db );
	if( $db->insert("webmaster_user_accounts", array(
			"user_id" => $user_id,
			"user_name" => $u->getEmail(),
			"user_password" => $u->getPassword(),
		)) ) {
		throw new Exception("can't insert user id = " . $user_id . " name = " . $u->getEmail());
	}
	return $user_id;
}

function tryInsertWiki( $db ,$wikiId ) {
	if( is_string( $wikiId ) ) {
		$w = WikiFactory::UrlToID( $wikiId );
		if( $w == null ) throw new Exception("Can't resolve " . $wikiId );
		$wikiId = $w;
	}
	$res = $db->select("webmaster_sitemaps",
		array('wiki_id'),
		array(
			"wiki_id" => $wikiId,
		),
		__METHOD__
	);
	if ( $res->fetchRow() ) return false;
	echo "insert: " . $wikiId . "\n";
	if ( ! $db->insert("webmaster_sitemaps", array(
			"wiki_id" => $wikiId,
		))) {
		throw new Exception("can't insert wiki id = " . $wikiId);
	}
}

function tryUpdateWiki( $db, $wikiId, $user ) {
	if( is_string( $wikiId ) ) {
		$w = WikiFactory::UrlToID( $wikiId );
		if( $w == null ) throw new Exception("Can't resolve " . $wikiId);
		$wikiId = $w;
	}
	$userId = tryInsertUser( $db, $user );

	$res = $db->update("webmaster_sitemaps",
		array(
			"user_id" => $userId,
		),
		array(
			"wiki_id" => $wikiId,
		));
	if( !$res ) throw new Exception("Failed to update " . $userId . " " . $wikiId);
}

foreach( $accounts as $i => $u ) {
	tryInsertUser( $db, $u );
}

$count = 0;
$service = new WebmasterToolsService();
foreach( $accounts as $i => $u ) {
	$sites = $service->getSites( $u );
	foreach( $sites as $j => $site ) {
		$count ++;
		try {
			tryInsertWiki( $db, $site );
			tryUpdateWiki( $db, $site, $u );
			if( $count %100 == 0 ) sleep( 1 );
			echo $u->getEmail() . " " . $site . " success \n";
		} catch( Exception $e ) {
			echo $u->getEmail() . " " . $site . " failed \n";
			echo $e->getMessage() . "\n";
		}
	}
}

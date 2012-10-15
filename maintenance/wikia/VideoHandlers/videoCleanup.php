<?php
$_SERVER['QUERY_STRING'] = 'VideoCleanup';

function fixLinksFromArticle( $id ) {
	global $wgTitle, $wgParser;

	$wgTitle = Title::newFromID( $id );
	$dbw = wfGetDB( DB_MASTER );

	$linkCache =& LinkCache::singleton();
	$linkCache->clear();

	if ( is_null( $wgTitle ) ) {
		return;
	}
	$dbw->begin();

	$revision = Revision::newFromTitle( $wgTitle );
	if ( !$revision ) {
		return;
	}

	$options = new ParserOptions;
	$parserOutput = $wgParser->parse( $revision->getText(), $wgTitle, $options, true, true, $revision->getId() );
	$update = new LinksUpdate( $wgTitle, $parserOutput, false );
	$update->doUpdate();
	$dbw->commit();
}

function createImageTableCache() {
	global $dbw, $imageTableCache;
	$rows = $dbw->select(
		'image',
		'*'
	);

	while( $image = $dbw->fetchObject( $rows ) ) {
		$imageTableCache[ $image->img_name ] = $image;
	}
	$dbw->freeResult( $rows );
}

function hasImageTableEntry( $img_name ) {
	global $imageTableCache;

	return (isset($imageTableCache[$img_name])) ? true : false;

}

function createCategoryLinksTableCache() {
	global $categoryLinksTableCache;
	global $dbw;
	$rows = $dbw->select(
		'categorylinks',
		'*'
	);
	while( $link = $dbw->fetchObject( $rows ) ) {
		$to = $link->cl_to;
		if( $to == 'Video' || $to == 'Videos' || $to == wfMsgForContent( 'videohandler-category' ) ) {
			$categoryLinksTableCache[ $link->cl_from ] = $link;
		}
	}
	$dbw->freeResult( $rows );
}

function articleIsFromVideoCategory( $id ) {
	global $categoryLinksTableCache;

	return (isset($categoryLinksTableCache[$id])) ? true : false;

}


ini_set( "include_path", dirname(__FILE__)."/.." );

ini_set( 'display_errors', 'stdout' );
$options = array('help');
require_once( '../../commandLine.inc' );

global $IP, $wgCityId, $wgExternalDatawareDB;

echo "***Cleanup*** script running for $wgCityId\n";


$dbw = wfGetDB( DB_MASTER );
$dbw_dataware = wfGetDB( DB_MASTER, array(), $wgExternalDatawareDB );

$imageTableCache = array();
createImageTableCache();
echo "Image cache: " . count($imageTableCache) . "\n";
$categoryLinksTableCache = array();
createCategoryLinksTableCache();
echo "Category cache: " . count($categoryLinksTableCache) . "\n";


$rows = $dbw->query( "SELECT * FROM image WHERE img_name like ':%' OR img_name like 'Video:%'" );
$rowCount = $rows->numRows();
echo( ": {$rowCount} old-style videos found\n" );

while( $file = $dbw->fetchObject( $rows ) ) {
	echo "Backing up " . $file->img_name . "\n";
	$dbw_dataware->insert('video_imagetable_backup',
		array(
			'wiki_id' => $wgCityId,
			'img_name' => $file->img_name,
			'img_metadata' => $file->img_metadata,
			'img_user' => $file->img_user,
			'img_user_text' => $file->img_user_text,
			'img_timestamp' => $file->img_timestamp
		)
	);
}
$dbw->freeResult( $rows );

$dbw->query( "DELETE FROM image WHERE img_name like ':%' OR img_name like 'Video:%'", 'videoCleanup' );
$dbw->query( "DELETE FROM oldimage WHERE oi_name like ':%' OR oi_name like 'Video:%'", 'videoCleanup' );
$dbw->query( "DELETE FROM filearchive WHERE fa_name like ':%' OR fa_name like 'Video:%'", 'videoCleanup' );

$rows = $dbw->query( "SELECT page_id, page_namespace, page_title
					  FROM page
					  WHERE page_namespace = 400",
					'videoCleanup' );
$rowCount = $rows->numRows();

echo( ": Found {$rowCount} articles to remove (namespace 400)\n" );

while( $page = $dbw->fetchObject( $rows ) ) {
	echo "Removing article " . $page->page_title . "[NS:400]\n";
	$article = Article::newFromID( $page->page_id );
	$article->doDeleteArticle('VideoRefactoring cleanup', true);
}

$dbw->freeResult( $rows );

echo( "Cleaning up video articles from namespace 6 that don't have corresponding File\n");
$rows = $dbw->query( "SELECT page_id, page_namespace, page_title
					  FROM page
					  WHERE page_namespace = 6" );
$rowCount = $rows->numRows();

echo( ": Found {$rowCount} articles in NS=6 (not all will be removed)\n" );
while( $page = $dbw->fetchObject( $rows ) ) {
	$i = var_export(hasImageTableEntry( $page->page_title ), 1);
	$v = var_export(articleIsFromVideoCategory( $page->page_id ), 1);
	//echo "Checking " . $page->page_title . "[i:$i, v:$v]\n";

	if( !hasImageTableEntry( $page->page_title ) && articleIsFromVideoCategory( $page->page_id ) ) {
		echo "Removing article " . $page->page_title . "[NS:6]\n";
		$article = Article::newFromID( $page->page_id );
		$article->doDeleteArticle('VideoRefactoring cleanup', true);
	}
}
$dbw->freeResult( $rows );



$rows = $dbw->query( "SELECT distinct pl_from
					  FROM pagelinks
					  WHERE pl_namespace = " . NS_LEGACY_VIDEO,
		'videoCleanup' );
$rowCount = $rows->numRows();

echo( ": Found {$rowCount} pagelinks to 400 namespace\n" );
while( $page = $dbw->fetchObject( $rows ) ) {
	echo "Fixing links in article " . $page->pl_from . "\n";

	$pid = pcntl_fork();
	if ($pid == -1) {
		echo "I think I'm gonna die\n";
		die('Could not fork');
	} else if ($pid) {
		// we are the parent
		$status = null;
		pcntl_wait($status); //Protect against Zombie children
		$st = pcntl_wexitstatus($status);
		if ($st != 0) {
			// need to log those fatal errors here
		}
		//echo "parent end of fork\n";
	} else {
		//echo "child\n";
		fixLinksFromArticle( $page->pl_from );
		//echo "child end of fork\n";
		exit();
	}
	//echo "outside of fork\n";


}
$dbw->freeResult( $rows );


wfWaitForSlaves( 2 );



?>
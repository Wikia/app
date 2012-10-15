<?php

/**
 * @usage: SERVER_ID=177 php videoCount.php --conf=/usr/wikia/docroot/wiki.factory/LocalSettings.php
 *
*/

ini_set( 'display_errors', 'stdout' );
$options = array();

require_once( '../../commandLine.inc' );

global $wgCityId, $wgExternalDatawareDB, $wgContentNamespaces;

echo "Video count script running for: $wgCityId\n";

$dbw = wfGetDB( DB_SLAVE );

// is MUT enabled on this wiki? this needs to be saved in warehouse as well
$mut = !empty($wgMediaToolExt) ? 'enabled' : 'disabled';
echo "MUT is *{$mut}*\n";

// 1. count number of articles in content namespace

$queryArticleCnt = "SELECT COUNT(*) AS cnt FROM page WHERE page_namespace IN ( ".implode(",", $wgContentNamespaces).")";
$rows = $dbw->query( $queryArticleCnt );
$row = $dbw->fetchObject($rows);

$totalArticleCnt = $row->cnt;

echo "Total articles in content namespaces: " . $totalArticleCnt ." \n";



// 2. count number of local videos in articles

$queryLocalVideo = "SELECT COUNT(*) AS cnt
 		    FROM imagelinks il LEFT JOIN image i ON il.il_to = i.img_name
 		    WHERE i.img_major_mime = 'video' ";

$rows = $dbw->query( $queryLocalVideo );
$row = $dbw->fetchObject($rows);

$localVideoCnt = $row->cnt;

echo "Local video cnt in articles: " . $localVideoCnt ." \n";

// 3. count number of videos from video wiki

$queryRepositoryVideo = "SELECT il.*, i.img_major_mime
			 FROM imagelinks il LEFT JOIN image i ON il.il_to = i.img_name
			 WHERE i.img_major_mime IS NULL ";


$rows = $dbw->query( $queryRepositoryVideo );
$aAllFiles = array();
while( $file = $dbw->fetchObject( $rows ) ) {
	$aAllFiles[] = $file->il_to;
}

$repositoryVideoCnt = 0;

if ( count( $aAllFiles ) > 0 ) {

	foreach ( $aAllFiles as $fileName ) {

		$oTitle = Title::newFromText( $fileName, NS_FILE );
		$oFile = wfFindFile( $oTitle );
		if ( !empty( $oFile ) && WikiaFileHelper::isFileTypeVideo( $oFile ) ) {

			$repositoryVideoCnt++;
		}
	}
}

echo "Repo video cnt in articles: " . $repositoryVideoCnt . "\n";


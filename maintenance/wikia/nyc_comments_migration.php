<?php

require( '/usr/wikia/source/trunk/maintenance/commandLine.inc' );

$dbr = wfGetDB( DB_SLAVE );

$res = $dbr->select( 'Comments', '*' );

while( $row = $res->fetchObject() ) {

	$content = $row->Comment_Text;
	$user = User::newFromName( $row->Comment_Username );

	$cTitle = $row->Comment_page_title;
	$cNamespace = $row->Comment_page_namespace;
	$cContent = $row->Comment_Text;

	try {
		$date = new DateTime( $row->Comment_Date );
	} catch (Exception $e) {
		echo $e->getMessage();
		exit(1);
	}

	$date_suffix = $date->format('YmdGis');

	$newTitle = $cTitle . '/' . '@comment-' . $row->Comment_Username . '-' . $date_suffix;

	$wTitle = Title::newFromText( $newTitle, $cNamespace + 1 );

	$parentTitle = Title::newFromText( $cTitle, $cNamespace );

	$wArticle = new Article( $wTitle );
	if ( !$wArticle->exists() && is_object( $parentTitle ) && $parentTitle->exists() ) {
		wfWaitForSlaves( 5 );

		$wArticle->doEdit( $content, 'Importing comments from old armchair', 0, false, $user );
	}

	$i++;

	if ( $i % 10 == 0 ) {
		echo $i . "\n";
	}
}

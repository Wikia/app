<?php

/**
 alter table Comments ADD COLUMN Comment_page_title varchar(255);
 alter table Comments ADD COLUMN Comment_page_namespace varchar(255);

 update Comments join page on Comment_page_ID = page_id set Comment_page_title = page_title, Comment_page_namespace = page_namespace;
 */

require( '/usr/wikia/source/trunk/maintenance/commandLine.inc' );

$dbr = wfGetDB( DB_SLAVE );

$res = $dbr->query( 'select * from Comments join page on Comment_Page_ID = page_id where page_namespace = 500' );

while( $row = $res->fetchObject() ) {

	$content = $row->Comment_Text;
	$user = User::newFromName( $row->Comment_Username );

	$cTitle = $row->page_title;
	$cNamespace = 500;
	$cContent = $row->Comment_Text;

	try {
		$date = new DateTime( $row->Comment_Date );
	} catch (Exception $e) {
		echo $e->getMessage();
		exit(1);
	}

	$date_suffix = $date->format('YmdGis');

	$newTitle = $cTitle . '/' . '@comment-' . $row->Comment_Username . '-' . $date_suffix;

	$wTitle = Title::newFromText( $newTitle, 500 + 1 );

	$parentTitle = Title::newFromText( $cTitle, $cNamespace );

	$wArticle = new Article( $wTitle );
	if ( !$wArticle->exists() && is_object( $parentTitle ) && $parentTitle->exists() ) {
		wfWaitForSlaves( 3 );

		$wArticle->doEdit( $content, 'Importing comments from old armchair', EDIT_FORCE_BOT, false, $user );

		wfWaitForSlaves( 3 );
	} else {
		echo "skipped one: ID {$row->Comment_ID}\n";
	}

	$i++;

	if ( $i % 10 == 0 ) {
		echo $i . "\n";
	}

}

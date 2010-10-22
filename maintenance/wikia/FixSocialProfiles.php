<?php

include( '../commandLine.inc' );

$wgShowExceptionDetails = true;

$wgUser = User::newFromName( 'Wikia' );

$dbr = wfGetDB( DB_SLAVE );

$res = $dbr->select( 'page', array( 'page_title' ), array( 'page_namespace' => 200 ), 'BlameTor', array( 'LIMIT' => 5 ) );

while ( $row = $dbr->fetchObject( $res ) ) {
	$wikiTitle = Title::newFromText( $row->page_title, 200 );
	$wikiArticle = new Article( $wikiTitle );

	$userTitle = Title::newFromText( $wikiTitle->getText(), NS_USER );
	if ( !$userTitle->exists() ) {
		// move to new location
		$wikiTitle->moveNoAuth( $userTitle );
		echo "Moved " . $wikiTitle->getText() . "\n";
		continue;
	}

	$userArticle = new Article( $userTitle );
	if ( $wikiArticle->getContent() !== '' && $userArticle->getContent() == '' ) {
		// delete
		$userArticle->doDeleteArticle( 'making way for user page move', true, $userArticle->mTitle->getArticleID( GAID_FOR_UPDATE ) );
		echo "Deleted " . $userTitle->getText() . "\n";

		// then move the page
		$wikiTitle->moveNoAuth( $userTitle );
		echo "Moved " . $wikiTitle->getText() . "\n";

		continue;
	}

	echo "Nothing happened\n";
}

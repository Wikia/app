<?php

require_once( dirname( __FILE__ ) . '/../commandLine.inc' );

function isCorrupted() {
	$title = Title::newFromText( 'Main_Page' );
	$mainPage = Article::newFromID( $title->getArticleID() );
	$pattern = '/<hero description="My description" imagename="" cropposition="" \/>/';
	$raw = $mainPage->getContent();

	return preg_match($pattern, $raw) === 1;
}

if ( isCorrupted() ) {
	$today = date( 'd-m-Y' );
	$this->output( "\n" . $today . "\n" );
}

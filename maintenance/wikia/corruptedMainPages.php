<?php

require_once( dirname( __FILE__ ) . '/../commandLine.inc' );

function isCorrupted() {
	global $wgCityId;

	$title = Title::newFromText( 'Main_Page' );
	if ( empty ($title) || !$title->exists() ) {
		echo( "\n Title doesn't exist on wiki " . $wgCityId );
		return false;
	}

	$mainPage = Article::newFromID( $title->getArticleID() );
	if ( empty ($mainPage) || !$mainPage->exists() ) {
		echo( "\n Article doesn't exist on wiki " . $wgCityId );
		return false;
	}

	$pattern = '/<hero .*\/>/Am';
	$raw = $mainPage->getContent();

	return preg_match($pattern, $raw) === 1;
}

global $wgCityId;

echo( "\n Processing..." );
if ( isCorrupted() ) {
	echo( "\n" . $wgCityId);
}

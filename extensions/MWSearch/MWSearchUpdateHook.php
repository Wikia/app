<?php

require_once( 'MWSearchUpdater.php' );

$wgExtensionFunctions[] = 'mwSearchUpdateHookSetup';

function mwSearchUpdateHookSetup() {
	global $wgHooks;
	$wgHooks['ArticleSaveComplete'  ][] = 'mwSearchUpdateSave';
	$wgHooks['ArticleDeleteComplete'][] = 'mwSearchUpdateDelete';
	$wgHooks['TitleMoveComplete'    ][] = 'mwSearchUpdateMove';
}

/**
 * @param $article Article
 * @param $user
 * @param $text
 * @param $summary
 * @param $isminor
 * @param $iswatch
 * @param $section
 * @return bool
 */
function mwSearchUpdateSave( $article, $user, $text, $summary, $isminor, $iswatch, $section ) {
	global $wgDBname;
	MWSearchUpdater::updatePage( $wgDBname, $article->getTitle(), $text );
	return true;
}

/**
 * @param $article Article
 * @param $user
 * @param $reason
 * @return bool
 */
function mwSearchUpdateDelete( $article, $user, $reason ) {
	global $wgDBname;
	MWSearchUpdater::deletePage( $wgDBname, $article->getTitle() );
	return true;
}

/**
 * @param $from
 * @param $to Title
 * @param $user
 * @param $pageid
 * @param $redirid
 * @return bool
 */
function mwSearchUpdateMove( $from, $to, $user, $pageid, $redirid ) {
	global $wgDBname;
	
	$db = wfGetDB( DB_MASTER );
	$pageRevision = Revision::loadFromPageId( $db, $pageid );
	if( !is_null( $pageRevision ) ) {
		MWSearchUpdater::updatePage( $wgDBname, $to, $pageRevision->getText() );
	}
	
	$redirText = '#REDIRECT [[' . $to->getPrefixedText() . "]]\n";
	MWSearchUpdater::updatePage( $wgDBname, $from, $redirText );
	return true;
}


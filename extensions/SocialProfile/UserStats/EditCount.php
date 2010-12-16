<?php
/**
 * Protect against register_globals vulnerabilities.
 * This line must be present before any global variable is referenced.
 */
if ( !defined( 'MEDIAWIKI' ) ) {
	die( "This is not a valid entry point.\n" );
}

$wgHooks['NewRevisionFromEditComplete'][] = 'incEditCount';

function incEditCount( $article, $revision, $baseRevId ) {
	global $wgUser, $wgNamespacesForEditPoints;

	// only keep tally for allowable namespaces
	if (
		!is_array( $wgNamespacesForEditPoints ) ||
		in_array( $article->getTitle()->getNamespace(), $wgNamespacesForEditPoints )
	) {
		$stats = new UserStatsTrack( $wgUser->getID(), $wgUser->getName() );
		$stats->incStatField( 'edit' );
	}

	return true;
}

$wgHooks['ArticleDelete'][] = 'removeDeletedEdits';

function removeDeletedEdits( &$article, &$user, &$reason ) {
	global $wgNamespacesForEditPoints;

	// only keep tally for allowable namespaces
	if (
		!is_array( $wgNamespacesForEditPoints ) ||
		in_array( $article->getTitle()->getNamespace(), $wgNamespacesForEditPoints )
	) {
		$dbr = wfGetDB( DB_MASTER );
		$res = $dbr->select(
			'revision',
			array( 'rev_user_text', 'rev_user', 'COUNT(*) AS the_count' ),
			array( 'rev_page' => $article->getID(), 'rev_user <> 0' ),
			__METHOD__,
			array( 'GROUP BY' => 'rev_user_text' )
		);
		foreach ( $res as $row ) {
			$stats = new UserStatsTrack( $row->rev_user, $row->rev_user_text );
			$stats->decStatField( 'edit', $row->the_count );
		}
	}

	return true;
}

$wgHooks['ArticleUndelete'][] = 'restoreDeletedEdits';

function restoreDeletedEdits( &$title, $new ) {
	global $wgNamespacesForEditPoints;

	// only keep tally for allowable namespaces
	if (
		!is_array( $wgNamespacesForEditPoints ) ||
		in_array( $title->getNamespace(), $wgNamespacesForEditPoints )
	) {
		$dbr = wfGetDB( DB_MASTER );
		$res = $dbr->select(
			'revision',
			array( 'rev_user_text', 'rev_user', 'COUNT(*) AS the_count' ),
			array( 'rev_page' => $title->getArticleID(), 'rev_user <> 0' ),
			__METHOD__,
			array( 'GROUP BY' => 'rev_user_text' )
		);
		foreach ( $res as $row ) {
			$stats = new UserStatsTrack( $row->rev_user, $row->rev_user_text );
			$stats->incStatField( 'edit', $row->the_count );
		}
	}

	return true;
}

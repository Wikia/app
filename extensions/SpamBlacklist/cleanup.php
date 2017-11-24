<?php

/**
 * An aggressive spam cleanup script.
 * Searches the database for matching pages, and reverts them to the last non-spammed revision.
 * If all revisions contain spam, deletes the page
 */

require_once( '../../maintenance/commandLine.inc' );
require_once( 'SpamBlacklist_body.php' );

/**
 * Find the latest revision of the article that does not contain spam and revert to it
 */
function cleanupArticle( $rev, $regexes, $match ) {
	$title = $rev->getTitle();
	$revId = $rev->getId();
	while ( $rev ) {
		$matches = false;
		foreach( $regexes as $regex ) {
			$matches = $matches || preg_match( $regex, $rev->getText() );
		}
		if( !$matches ) {
			// Didn't find any spam
			break;
		}
		# Revision::getPrevious can't be used in this way before MW 1.6 (Revision.php 1.26)
		#$rev = $rev->getPrevious();
		$revId = $title->getPreviousRevisionID( $revId );
		if ( $revId ) {
			$rev = Revision::newFromTitle( $title, $revId );
		} else {
			$rev = false;
		}
	}
	$dbw = wfGetDB( DB_MASTER );
	$dbw->begin();
	if ( !$rev ) {
		// Didn't find a non-spammy revision, delete the page
/*
		print "All revisions are spam, deleting...\n";
		$article = new Article( $title );
		$article->doDeleteArticle( "All revisions matched the spam blacklist" );
*/
		// Too scary, blank instead
		print "All revisions are spam, blanking...\n";
		$text = '';
		$comment = "All revisions matched the spam blacklist ($match), blanking";
	} else {
		// Revert to this revision
		$text = $rev->getText();
		$comment = "Cleaning up links to $match";
	}
	$article = new Article( $title );
	$article->doEdit( $text, $comment );
	$dbw->commit();
}

//------------------------------------------------------------------------------


if ( isset( $options['n'] ) ) {
	$dryRun = true;
} else {
	$dryRun = false;
}

$sb = new SpamBlacklist( $wgBlacklistSettings['spam'] );
if ( $wgBlacklistSettings['spam']['files'] ) {
	$sb->files = $wgBlacklistSettings['spam']['files'];
}
$regexes = $sb->getBlacklists();
if ( !$regexes ) {
	print "Invalid regex, can't clean up spam\n";
	exit(1);
}

$dbr = wfGetDB( DB_SLAVE );
$maxID = $dbr->selectField( 'page', 'MAX(page_id)' );
$reportingInterval = 100;

print "Regexes are " . implode( ', ', array_map( 'count', $regexes ) ) . " bytes\n";
print "Searching for spam in $maxID pages...\n";
if ( $dryRun ) {
	print "Dry run only\n";
}

for ( $id=1; $id <= $maxID; $id++ ) {
	if ( $id % $reportingInterval == 0 ) {
		printf( "%-8d  %-5.2f%%\r", $id, $id / $maxID * 100 );
	}
	$revision = Revision::loadFromPageId( $dbr, $id );
	if ( $revision ) {
		$text = $revision->getText();
		if ( $text ) {
			foreach( $regexes as $regex ) {
				if ( preg_match( $regex, $text, $matches ) ) {
					$title = $revision->getTitle();
					$titleText = $title->getPrefixedText();
					if ( $dryRun ) {
						print "\nFound spam in [[$titleText]]\n";
					} else {
						print "\nCleaning up links to {$matches[0]} in [[$titleText]]\n";
						$match = preg_replace( '!^https?://!', '', $matches[0] );
						cleanupArticle( $revision, $regexes, $match );
					}
				}
			}
		}
	}
}
// Just for satisfaction
printf( "%-8d  %-5.2f%%\n", $id-1, ($id-1) / $maxID * 100 );


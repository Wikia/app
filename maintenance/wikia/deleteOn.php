<?php

# this is a modified version, specially for MultiDelete extension and task
# bartek@wikia.com

# delete a batch of pages
# Usage: php deleteOn.php [-u <user>] [-r <reason>] [-i <interval>] [--id <page_id> | -t <title>] <listfile>
# where
# 	<listfile> is a file where each line contains the title of a page to be deleted.
#	<user> is the username
#	<reason> is the delete reason
#	<interval> is the number of seconds to sleep for after each delete
#	<wiki> is the wiki on which we want
#	<page_id> is what we want to delete (in page ID form)
#	<title> is what we want to delete (in text form)

$oldCwd = getcwd();
ini_set( "include_path", dirname(__FILE__)."/.." );
$optionsWithArgs = array( 'u', 'r', 'i', 't', 'id' );
require_once( 'commandLine.inc' );

chdir( $oldCwd );

# Options processing

$user = 'Delete page script';
$reason = '';
$interval = 0;

if ( isset( $args[0] ) ) {
	$filename = $args[0];
}
if ( isset( $options['u'] ) ) {
	$user = $options['u'];
}
if ( isset( $options['r'] ) ) {
	$reason = $options['r'];
}
if ( isset( $options['i'] ) ) {
	$interval = $options['i'];
}

$wgUser = User::newFromName( $user );
if ( !$wgUser ) {
	print "Invalid username\n";
	exit( 1 );
}
if ( $wgUser->isAnon() ) {
	$wgUser->addToDatabase();
}

# Setup complete, now start

$dbw = wfGetDB( DB_MASTER );

	if ( isset( $options['id'] ) ) {
		$page = Title::newFromId( $options['id'] );
	} else {
		$page = Title::newFromText( $options['t'] );
	}
	if ( is_null( $page ) ) {
		print "Invalid title or page does not exist\n";
		exit (1) ;
	}
	if( !$page->exists() ) {
		print "Skipping nonexistent page '" . $page->getPrefixedText () . "'\n";
		exit (1) ;
	}

	$wgTitle = $page; // this cannot be NULL

	print $page->getPrefixedText();
	$dbw->begin();
	$nspace = $page->getNamespace();
	$success = 0; $removed = 0;
	if ( in_array( $nspace, array(NS_IMAGE, NS_FILE) ) ) {
		$file = wfLocalFile( $page );
		if ( $file ) {
			$oldimage = null; // Must be passed by reference
			$success = FileDeleteForm::doDelete( $page, $file, $oldimage, $reason, false )->isOK();
			$removed = 1;
		} 
	}

	if ( $removed == 0 ) {
		$page_id = $page->getArticleID();
		$art = new Article( $page );
		$success = $art->doDeleteArticle( $reason );
		if ( $success ) {
			wfRunHooks('ArticleDeleteComplete', array(&$art, &$wgUser, $reason, $page_id));
		}
	}
	$dbw->commit();

	if ( $success ) {
		print "\n";
	} else {
		print " FAILED\n";
	}

	if ( $interval ) {
		sleep( $interval );
	}
	wfWaitForSlaves( 5 );

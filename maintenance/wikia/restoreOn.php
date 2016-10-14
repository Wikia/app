<?php

# this is roughly based on stuff from Special:Undelete
# bartek@wikia.com

# restore a batch of pages (presumably deleted)
#
# NOTE: parameters are subject to change...
#
# Usage: php restoreOn.php [-u <user>] [-r <reason>] [-i <interval>] [-t <title>] <listfile>
# where
# 	<listfile> is a file where each line contains the title of a page to be deleted.
#	<user> is the username
#	<reason> is the delete reason
#	<interval> is the number of seconds to sleep for after each delete
#	<wiki> is the wiki on which we want
#	<title> is what we want to delete

$oldCwd = getcwd();
ini_set( "include_path", dirname(__FILE__)."/.." );
$optionsWithArgs = array( 'u', 'r', 'i', 't', 'n' );
require_once( 'commandLine.inc' );

chdir( $oldCwd );

# Options processing

# Delete page script, Edit page script, Restore page script... we are gaining numbers of script users :)
$user = 'Restore page script';
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
	$page = Title::newFromText( $options['t'], intval($options['n']) );
	if ( is_null( $page ) ) {
		print "Invalid title\n";
		exit (1) ;
	}
	$article = new Article( $page );
        # Does this page already exist? We'll have to update it...
        $options = 'FOR UPDATE';
        $page_r = $dbw->selectRow( 'page',
        array( 'page_id', 'page_latest' ),
        array( 'page_namespace' => $page->getNamespace(),
               'page_title'     => $page->getDBkey() ),
               __METHOD__,
               $options );

        if( $page_r ) {
        	# Page already exists. Import the history, and if necessary
        	# we'll update the latest revision field in the record.
        	$newid             = 0;
        	$pageId            = $page_r->page_id;
        	$previousRevId     = $page_r->page_latest;
        } else {
                # Have to create a new article...
                $newid  = $article->insertOn( $dbw );
                $pageId = $newid;
                $previousRevId = 0;
       }
       $oldones = '1 = 1'; # All revisions...

		/**
                 * Restore each revision...
                 */
                $result = $dbw->select( 'archive',
                        /* fields */ array(
                                'ar_rev_id',
                                'ar_text',
                                'ar_comment',
                                'ar_user',
                                'ar_user_text',
                                'ar_timestamp',
                                'ar_minor_edit',
                                'ar_flags',
                                'ar_text_id',
                                'ar_page_id',
                                'ar_len' ),
                        /* WHERE */ array(
                                'ar_namespace' => $page->getNamespace(),
                                'ar_title'     => $page->getDBkey(),
                                $oldones ),
                        __METHOD__,
                        /* options */ array(
                                'ORDER BY' => 'ar_timestamp' )
                        ) ;

                $revision = null;
                $restored = 0;

                while( $row = $dbw->fetchObject( $result ) ) {
                        if( $row->ar_text_id ) {
                                // Revision was deleted in 1.5+; text is in
                                // the regular text table, use the reference.
                                // Specify null here so the so the text is
                                // dereferenced for page length info if needed.
                                $revText = null;
                        } else {
                                // Revision was deleted in 1.4 or earlier.
                                // Text is squashed into the archive row, and
                                // a new text table entry will be created for it.
                                $revText = Revision::getRevisionText( $row, 'ar_' );
                        }

			if ( is_numeric( $row->ar_user ) && $row->ar_user > 0 ) {
				$userName = User::newFromId( $row->ar_user )->getName();
			} else {
				$userName = $row->ar_user_text;
			}
                        $revision = new Revision( array(
				'page'       => $pageId,
                                'id'         => $row->ar_rev_id,
                                'text'       => $revText,
                                'comment'    => $row->ar_comment,
                                'user'       => $row->ar_user,
                                'user_text'  => $userName,
                                'timestamp'  => $row->ar_timestamp,
                                'minor_edit' => $row->ar_minor_edit,
                                'text_id'    => $row->ar_text_id,
                                'len'            => $row->ar_len
                                ) );
                        $revision->insertOn( $dbw );
                        $restored++;
                }
                // Was anything restored at all?
                if($restored == 0) {
			print "Nothing was restored\n" ;
                        exit (1) ;
		}
                if( $revision ) {
                        // Attach the latest revision to the page...
                        $wasnew = $article->updateIfNewerOn( $dbw, $revision, $previousRevId );

                        if( $newid || $wasnew ) {
                                // Update site stats, link tables, etc
                                $article->createUpdates( $revision );
                        }

                        if( $newid ) {
                                Article::onArticleCreate( $page );
                        } else {
                                Article::onArticleEdit( $page );
                        }

                        if( $page->getNamespace() == NS_IMAGE ) {
                                $update = new HTMLCacheUpdate( $page, 'imagelinks' );
                                $update->doUpdate();
                        }
                } else {
                        // Revision couldn't be created. This is very weird
			print "We got an unknown error\n" ;
                        exit (1) ;
                }

                # Now that it's safely stored, take it out of the archive
                $dbw->delete( 'archive',
                        /* WHERE */ array(
                                'ar_namespace' => $page->getNamespace(),
                                'ar_title' => $page->getDBkey(),
                                $oldones ),
                        __METHOD__ );

	print $page->getPrefixedText();			
	if ( $restored ) {
		print "\n";
	} else {
		print " FAILED\n";
	}

	if ( $interval ) {
		sleep( $interval );
	}
	wfWaitForSlaves();
?>

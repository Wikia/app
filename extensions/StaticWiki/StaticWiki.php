<?php
/*
This extension will turn a MediaWiki installation into "import-only" mode, at least for the article namespace.

CONFIGURATION:
Set $wgStaticWikiExternalSite to the URL of the "target" wiki, like "http://.../w/". Do this AFTER the include in LocalSettings.php, otherwise en.wikipedia will become the default.
Set $wgStaticWikiNamespaces as an array of namespace numbers to import. By default, namespaces 0 (main), 10 (templates), 14 (categories) are imported.
*/

# BEGIN CONFIGURATION

$wgStaticWikiExternalSite = "http://en.wikipedia.org/w/" ; # Default, change in LocalSettings.php
$wgStaticWikiNamespaces = array ( 0 , 10 , 14 ) ;

# END CONFIGURATION

if (!defined('MEDIAWIKI')) die();

$wgHooks['AlternateEdit'][] = 'wfStaticEditHook' ;

function wfStaticWikiGetRevisionText ( $url_title , $revision ) {
	global $wgStaticWikiExternalSite ;
	$url = $wgStaticWikiExternalSite . "index.php?title=" . $url_title . "&oldid=" . $revision . "&action=raw" ;
	$text = Http::get( $url ) ;
	return $text ;
	}

function wfStaticEditHook ( $a ) {
	global $wgStaticWikiExternalSite , $wgStaticWikiNamespaces ;
	global $wgOut , $wgTitle , $wgRequest ;
	
	if ( !in_array ( $wgTitle->getNamespace() , $wgStaticWikiNamespaces ) ) return true ; # This article namespace is not imported => normal edit

	if ( ! $a->mTitle->userCan( 'edit' ) ) { # Only users that can edit may import as well
			wfDebug( "$fname: user can't edit\n" );
			$wgOut->readOnlyPage( $this->mArticle->getContent( true ), true );
			wfProfileOut( $fname );
			return true;
		}
		
	$url_title = $wgTitle->getPrefixedDBkey() ;
	$title = $wgTitle->getText () ;	
	$wgOut->setPageTitle ( 'Importing ' . $wgTitle->getPrefixedText() ) ;
	
	if ( $wgRequest->getVal( 'wpSection', $wgRequest->getVal( 'section' ) ) != '' ) {
		$wgOut->addHTML ( "<h2>No section importing, sorry!</h2>" ) ;
		return false ;
	}

	$do_import = $wgRequest->getText ( "importrevision" , "" ) ;
	if ( $do_import != "" ) {
		$a->textbox1 = wfStaticWikiGetRevisionText ( $url_title , $do_import ) ;
		$a->summary = "Import of revision " . $do_import ;
		$a->minoredit = false ;
		$a->edittime = $a->mArticle->getTimestamp() ;
		$a->attemptSave () ;
		return false ;
	}

	$pstyle = "style='border-bottom:1px solid black; font-size:12pt; font-weight:bold'" ;

	# Read list of latest revisions
	$side = "" ;
	$history = Http::get ( $wgStaticWikiExternalSite . "index.php?title=" . urlencode ( $url_title ) . "&action=history" ) ;
	$history = explode ( "<li>" , $history ) ;
	array_shift ( $history ) ;
	$match = "/w/index.php?title=" . str_replace ( "%3A" , ":" , urlencode ( $url_title ) ) . "&amp;oldid=" ;
	$revisions = array () ;
	foreach ( $history AS $line ) {
		$a = explode ( 'href="' , $line ) ;
		array_shift ( $a ) ;
		foreach ( $a AS $x ) {
			$y = explode ( '"' , $x ) ;
			$x = array_shift ( $y ) ;
			if ( substr ( $x , 0 , strlen ( $match ) ) != $match ) continue ;
			$x = substr ( $x , strlen ( $match ) ) ;
			$revisions[] = $x ;
			array_shift ( $y ) ;
			$y = implode ( '"' , $y ) ;
			$y = explode ( '>' , $y ) ;
			array_shift ( $y ) ;
			$y = implode ( ">" , $y ) ;
			$y = explode ( "<" , $y ) ;
			$y = trim ( array_shift ( $y ) ) ;
			$date[$x] = $y ;
		}
	}

	# Revision to view
	$show_revision = $wgRequest->getText ( "showrevision" , $revisions[0] ) ;
	
	# Generating list of links for the sidebar
	$side = "<p {$pstyle}>" . "The last " . count ( $revisions ) . " revisions" . "</p>\n" ;
	$side .= "<table cellspacing=0 cellpadding=2>" ;
	foreach ( $revisions AS $r ) {
		$link_title = ' title="#' . $r . " (" . $date[$r] . ')"' ;
		$l1 = '<a href="?title=' . $url_title . '&action=edit&showrevision=' . $r . '"' . $link_title . '>' . $date[$r] . '</a>' ;
		$l2 = '<a href="?title=' . $url_title . '&action=edit&importrevision=' . $r . '"' . $link_title . '>' . "Import" . '</a>' ;
		$l3 = '<a href="' . $wgStaticWikiExternalSite . 'index.php?title=' . $url_title . '&oldid=' . $r . '"' . $link_title . '>' . "Original" . '</a>' ;
		$s = "<td align='right'>" . $l1 . "</td><td>" . $l2 . "</td><td>" . $l3 . "</td>\n" ;
		if ( $r == $show_revision ) $s = "<tr style='background-color:#DDDDDD'>{$s}</tr>" ;
		else $s = "<tr>{$s}</tr>" ;
		$side .= $s ;
	}
	$side .= "</table>" ;
	
	# Retrieving source text for the revision
	$text = wfStaticWikiGetRevisionText ( $url_title , $show_revision ) ;
	
	# Output	
	$wgOut->addHTML ( "<table width='100%'><tr><td style='border-right:1px solid black' valign='top' width='100%'>" ) ;
	$wgOut->addHTML ( "<p {$pstyle}>Revision #" . $show_revision . " at " . $date[$show_revision] . " of <i>" . $wgTitle->getPrefixedText() . "</i></p>\n" ) ;
	$wgOut->addWikiText ( $text ) ;
	$wgOut->addHTML ( "</td><td nowrap valign='top'>" . $side . "</td></tr></table>" ) ;
	return false ;
}




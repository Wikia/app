<?php
////
// Author: Sean Colombo
// Date: 20081201 - Date of dumpTitles.php creation.
// Date: 20100113 - Forked to create a mapping from page ids to titles.
//
// This script creates a dump file of all of the page titles, page_ids and redirects in the system.
//
// WARNING: Make sure that the calling code can handle redirection properly.  The page_id to title mapping
// will not take into account redirects (because the titles of the redirects themselves are needed for matching
// against Gracenote titles).  The redirects file will be created also which should allow processing to occur.
//
// Mapping file line format:
// [page_id]\t[isRedirect{0,1}]\t[page_title]\n
////

ini_set('memory_limit', '2048M'); // this script balloons when making redirects

///// CONFIGURATION /////
$titleFilename = "lw_pageIdsToTitles";
$redirFilename = "lw_redirs";
$DO_REDIRECTS_FILE = true;

// Max number of rows to fetch at a given time for the big query (actual number will be a little lower since not all pages are in namespace 0).
// Unlike the normal dumpTitles.php script, since we use max(page_id) for knowing when to terminate, there is no danger of terminating early
// by setting this number too small, optimize it for performance.
// See: http://www.seancolombo.com/2009/07/05/quick-tip-do-huge-mysql-queries-in-batches-when-using-php/
// TODO: MAKE dumpTitles.php USE max(page_id) 
$QUERY_BATCH_SIZE = 1000; 
///// CONFIGURATION /////
GLOBAL $pre;
$pre = "";

ini_set( "include_path", dirname(__FILE__)."/.." );
require_once 'commandLine.inc';

GLOBAL $db, $dataware_db;
$db = &wfGetDB(DB_SLAVE)->getProperty('mConn');
#mysql_select_db('lyricwiki', $db);
$dataware_db = &wfGetDB(DB_SLAVE, array(), 'dataware')->getProperty('mConn');

print "Memory usage before huge loop:    ".memory_get_usage(true)."\n";
$numPageTitles = 0;
$redirectCache = array();
$TITLE_FILE = fopen($titleFilename."_".date("Ymd").".txt", "w");
$offset = 0;
$startTime = time();
$GN_NAMESPACE = 220;

// Find the largest id so that we know when to stop looping.
$queryString = "SELECT MAX(page_id) FROM $pre"."page";
if($result = mysql_query($queryString, $db)){
	$row = mysql_fetch_row($result);
	$MAX_PAGE_ID = $row[0];
	print "The max page_id is $MAX_PAGE_ID.\n";

	$namespaces = array(0, $GN_NAMESPACE);
	$nsCondition = "(page_namespace=" . implode(" OR page_namespace=", $namespaces) .")";

	$offset = 0;
	while($offset < $MAX_PAGE_ID){
		$queryString = "SELECT page_namespace, page_id, page_title, page_is_redirect FROM $pre"."page WHERE $nsCondition AND page_id > $offset AND page_id <= ".($offset+$QUERY_BATCH_SIZE)." ORDER BY page_id";
		if($result = mysql_query($queryString, $db)){
			if(($numRows = mysql_num_rows($result)) && $numRows > 0){
				for($cnt=0; $cnt < $numRows; $cnt++){
					$page_ns = mysql_result($result, $cnt, "page_namespace");
					$page_id = mysql_result($result, $cnt, "page_id");
					$title = mysql_result($result, $cnt, "page_title");
					$isRedirString = mysql_result($result, $cnt, "page_is_redirect");
					$isRedirect = ($isRedirString != "0");

					// FIXME: Is there a better way to find the namespace prefix? There is a mapping somewhere.  Find it & use that instead.
					if($page_ns == $GN_NAMESPACE){
						$title = "Gracenote:$title";
					}

					if($isRedirect){
						if($DO_REDIRECTS_FILE){
							$redirectCache[] = $title;
						}
					} else {
						$numPageTitles++;
						fwrite($TITLE_FILE, "$page_id\t$isRedirString\t".formatForUb("$title")."\n");
					}
				}
			}
			mysql_free_result($result);
		} else {
			print "Error with query:\n$queryString\n".mysql_error()."\n";
		}
		print "\tDone through id ".($offset+$QUERY_BATCH_SIZE)." - (pageTitles written out".($DO_REDIRECTS_FILE?", redirects cached":"")."). \n";

		$offset += $QUERY_BATCH_SIZE;
	}

} else {
	print "ERROR: Could not get the max(page_id) from page!  We wouldn't know how long to loop.\n";
}

$endTime = time();
print "Total time to cache results: ".($endTime - $startTime)." seconds.\n";
fclose($TITLE_FILE);
print "All pageTitles written to file.";
if($DO_REDIRECTS_FILE){
	print " Redirects cached in memory.";
}
print "\n";
print "Memory usage after freeing result: ".memory_get_usage(true)."\n";

if($DO_REDIRECTS_FILE){
	$numRedirects = count($redirectCache);
	print "Non-redirect pages: $numPageTitles\n";
	print "Redirects found:    $numRedirects\n";

	print "Writing out all redirects (after following them to their ends)...\n";
	$REDIR_FILE = fopen($redirFilename."_".date("Ymd").".txt", "w");
	$startTime = time();
	for($cnt=0; $cnt < $numRedirects; $cnt++){
		$title = $redirectCache[$cnt];
		$redirTo = "NULL";

		// Ignore the result - just doing it to fill the 'redirTo'.
		$titleObj = Title::newFromDBkey($title);
		if( $titleObj ) {
			if($titleObj->exists()){
				$article = Article::newFromID($titleObj->getArticleID());
				if($article && $article->isRedirect()){
					$reTitle = $article->followRedirect(); // follows redirects recursively
					if($reTitle && is_object($reTitle)){
						//unset($article); // hint to garbage collector - doesn't appear to do anything in this case
						$article = Article::newFromId($reTitle->getArticleID());
					}
				}
				if($article){
					$redirTo = $article->getTitle()->getDBkey();
					//$retVal = $article->getRawText(); // don't need the final page text.
					//unset($article); // hint to garbage collector - doesn't appear to do anything in this case
					fwrite($REDIR_FILE, formatForUb("$title")."\t\t".formatForUb("$redirTo")."\n");
				}
			}
		}

		// Output progress occasionally (but not constantly to avoid just filling the buffer constantly.
		if($cnt % 100 == 0){
			print "Progress update - row $cnt of $numRedirects: \"$title\"...\n";
		}
		if($cnt % 1000 == 0){
			$elapsedSeconds = (time() - $startTime);
			$elapsedMinutes = intval($elapsedSeconds / 60);
			$numDone = $cnt + 1;
			$secondsPerRedirect = ($elapsedSeconds / $numDone); // will hopefully be way less than 1 (and will be greater than 0).
			$estTotalMinutes = intval(($secondsPerRedirect * $numRedirects) / 60);
			$estMinutesRemaining = ($estTotalMinutes - $elapsedMinutes);
			print "Profiling:\n";
			print "   Current memory usage:           ".memory_get_usage(true)."\n"; // differing indentation is to line up with other memory usage lines.
			print "   Number of redirects done: $numDone\n";
			print "   Percent completed:        ".round(($numDone * 100) / $numRedirects)."%\n";
			print "   Elapsed time in minutes:  $elapsedMinutes\n";
			print "   Predicted total minutes:  $estTotalMinutes\n";
			print "   Est. minutes remaining:   $estMinutesRemaining\n";
			// If the estimated completion time is going up, then something is making this progressively slower.  Maybe MySQL cache-thrashing up by all of the non-overlapping requests?
			print "   Est. completion time:     ".date("Y-m-d H:i:s", time() + (60 * $estMinutesRemaining))."\n";
		}
		if($cnt % 10000 == 0){
			$NAP_SECONDS = 20;
			print "TAKING A NAP FOR $NAP_SECONDS SECONDS TO LET THE SLAVE CATCH UP IN CASE IT IS BEHIND.\n";
			sleep($NAP_SECONDS);
			print "Awake again.  Continuing...\n";
		}
	}
	fclose($REDIR_FILE);
}

print "Done.\n";

////
// Returns the inputted text in a format that can be written to a file in a way
// that is readable by ÜberBot.
////
function formatForUb($title){
	$title = rawurlencode($title);
	$title = str_replace("%3A", ":", $title); // to make it a little more human-readable.
	return $title;
} // end formatForUb()

////
// Returns the correctly formatted pagename from the artist and the song.
//
// If allowAllCaps is true, the ARTIST name will be kept as all-capitals if that is how it was passed in.
////
function lw_getTitle($artist, $song='', $applyUnicode=true, $allowAllCaps=true){
	if(!$allowAllCaps){
		$artist = strtolower($artist); // if left as all caps, ucwords won't change it
	}
	if($song != ''){
		$title = rawurldecode(ucwords($artist).":".ucwords(strtolower($song)));
	} else {
		$title = rawurldecode(ucwords($artist));
	}
	if($applyUnicode){
		$title = utf8_encode($title);
	}
	$title = str_replace("|", "/", $title); # TODO: Figure out if this is the right solution.
	$title = preg_replace('/([-\("\.\/:_])([a-z])/e', '"$1".strtoupper("$2")', $title);
	$title = preg_replace('/\b(O)[\']([a-z])/ei', '"$1".strtoupper("\'$2")', $title); // single-quotes like above, but this is needed to avoid escaping the single-quote here.  Does it to "O'Riley" but not "I'm" or "Don't"
	$title = preg_replace('/( \()[\']([a-z])/ei', '"$1".strtoupper("\'$2")', $title); // single-quotes like above, but this is needed to avoid escaping the single-quote here.
	$title = preg_replace('/ [\']([a-z])/ei', '" ".strtoupper("\'$1")', $title); // single-quotes like above, but this is needed to avoid escaping the single-quote here.
	$title = strtr($title, " ", "_"); // Warning: multiple-byte substitutions don't seem to work here, so smart-quotes can't be fixed in this line.
	return $title;
} // end lw_getTitle()

?>

<?php
////
// Author: Sean Colombo
// Date: 20090314
//
// This special page shows pages which link to redirects.  This helps make
// our special processing of Lonelypages be more simplified since all of these
// links can be corrected to point directly to end-articles.  Therefore our
// concept of "sneaky Lonelypages" can be simplified to be 'pages which
// only have redirects pointing to them' and we won't have to worry about what's
// pointing to those redirects.
//
// The structure of this special page was just copied from our Soapfailures extension.
////

require_once 'lw_cache.php'; // Caches the results of this processor-intensive query.

if(!defined('MEDIAWIKI')) die();

// Allows anyone to view the page.
$wgAvailableRights[] = 'linkstoredirects';
$wgGroupPermissions['*']['linkstoredirects'] = true;
$wgGroupPermissions['user']['linkstoredirects'] = true;
$wgGroupPermissions['sysop']['linkstoredirects'] = true;

$wgExtensionFunctions[] = 'wfSetupLinksToRedirects';
$wgExtensionCredits['specialpage'][] = array(
	'name' => 'Links To Redirects',
	'author' => '[http://www.lyricwiki.org/User:Sean_Colombo Sean Colombo]',
	'description' => 'Special page showing all links which point to redirects',
	'version' => '0.1',
);

function wfSetupLinksToRedirects(){
	global $IP, $wgMessageCache;
	require_once($IP . '/includes/SpecialPage.php');
	SpecialPage::addPage(new SpecialPage('Linkstoredirects', 'linkstoredirects', true, 'wfLinksToRedirects', false));
	$wgMessageCache->addMessage('linkstoredirects', 'Links To Redirects');
}

function wfLinksToRedirects(){
	global $wgOut;
	global $wgRequest, $wgUser;
	
	$CACHE_KEY = "LINKS_TO_REDIRECTS";

	$wgOut->setPageTitle("Links To Redirects");

/*
	// This processes any requested for removal of an item from the list.
	if(isset($_GET['artist']) && isset($_GET['song'])){
	
// TODO: THIS IS WHERE WE SHOULD ALLOW A SINGLE LINK TO BE REMOVED FROM THE CACHE (IF WE DECIDE TO DO THAT).
	
	
		$artist = $_GET['artist'];
		$song = $_GET['song'];
		$songResult = array();
		$failedLyrics = "Not found";

		// Pull in the NuSOAP code
		require_once('nusoap.php');
		// Create the client instance
		$client = new soapclient('http://lyricwiki.org/server.php?wsdl', true);
		$err = $client->getError();
		if ($err) {
			echo '<h2>Constructor error</h2><pre>' . $err . '</pre>';
		} else {
			// Create the proxy
			$proxy = $client->getProxy();
			GLOBAL $LW_USERNAME,$LW_PASSWORD;
			if(($LW_USERNAME != "") || ($LW_PASSWORD != "")){
				$headers = "<username>$LW_USERNAME</username><password>$LW_PASSWORD</password>\n";
				$proxy->setHeaders($headers);
			}
			$songResult = $proxy->getSongResult($artist, $song);
		}

		if(($songResult['lyrics'] == $failedLyrics) || ($songResult['lyrics'] == "")){
			print "<div style='background-color:#fcc'>Sorry, but $artist:$song song still failed.</div>\n";
		} else {
			$artist = str_replace("'", "\\'", $artist);
			$song = str_replace("'", "\\'", $song);

			// lw_connect does not work from inside this request for some reason.
			GLOBAL $wgDBserver,$wgDBuser,$wgDBpassword,$wgDBname;
			GLOBAL $lw_host;$lw_host = $wgDBserver;
			GLOBAL $lw_user;$lw_user = $wgDBuser;
			GLOBAL $lw_pass;$lw_pass = $wgDBpassword;
			GLOBAL $lw_name;$lw_name = $wgDBname;
			$db = mysql_connect($lw_host, $lw_user, $lw_pass);
			mysql_select_db($lw_name, $db);

			print "Deleting record... ";
			if(mysql_query("DELETE FROM lw_soap_failures WHERE request_artist='$artist' AND request_song='$song'", $db)){
				print "Deleted.";
			} else {
				print "Failed. ".mysql_error();
			}
			print "<br/>Clearing the cache... ";
			if(mysql_query("UPDATE map SET value='2006-02-05 00:00:00' WHERE keyName='CACHE_TIME_$CACHE_KEY'", $db)){
				print "Cleared.";
			} else {
				print "Failed. ".mysql_error();
			}

			print "<div style='background-color:#cfc'>The song was retrieved successfully and ";
			print "was removed from the failed requests list.";
			print "</div>\n";
		}
		print "<br/>Back to <a href='/Special:Soapfailures'>SOAP Failures</a>\n";
		exit; // wiki system throws database-connection errors if the page is allowed to display itself.
	} else {
*/
		$msg = "";

		// Allow the cache to be manually cleared.
		if(isset($_GET['cache']) && $_GET['cache']=="clear"){
			// lw_connect does not work from inside this request for some reason.
			GLOBAL $wgDBserver,$wgDBuser,$wgDBpassword,$wgDBname;
			GLOBAL $lw_host;$lw_host = $wgDBserver;
			GLOBAL $lw_user;$lw_user = $wgDBuser;
			GLOBAL $lw_pass;$lw_pass = $wgDBpassword;
			GLOBAL $lw_name;$lw_name = $wgDBname;
			$db = mysql_connect($lw_host, $lw_user, $lw_pass);
			mysql_select_db($lw_name, $db);
			$msg.= "Forced clearing of the cache...\n";
			if(mysql_query("UPDATE map SET value='2006-02-05 00:00:00' WHERE keyName='CACHE_TIME_$CACHE_KEY'", $db)){
				$msg.= "Cleared.";
			} else {
				$msg.= "Failed. ".mysql_error();
			}
			unset($_GET['cache']);
			$_SERVER['REQUEST_URI'] = str_replace("?cache=clear", "", $_SERVER['REQUEST_URI']);
			$_SERVER['REQUEST_URI'] = str_replace("&cache=clear", "", $_SERVER['REQUEST_URI']);
		}

		$cache = new Cache();
		$content = $cache->fetchExpire( $CACHE_KEY, strtotime("-2 hour") );
		if(!$content){
			ob_start();
	
			GLOBAL $lw_db;
			if(isset($lw_db)){
				$db = $lw_db;
			} else {
				GLOBAL $lw_host,$lw_user,$lw_pass,$lw_name;
				$db = mysql_connect($lw_host, $lw_user, $lw_pass);
				mysql_select_db($lw_name, $db);
				$lw_db = $db;
			}
			
			// TODO: Write an intro to this page and link to relevant simlar pages (Lonelypages and HiddenLonelypages).

// TODO: YOU ARE HERE! :D
// TODO: YOU ARE HERE! :D
// TODO: YOU ARE HERE! :D
// TODO: YOU ARE HERE! :D
// TODO: YOU ARE HERE! :D
// TODO: YOU ARE HERE! :D
// TODO: YOU ARE HERE! :D
// TODO: YOU ARE HERE! :D
// TODO: YOU ARE HERE! :D
// TODO: YOU ARE HERE! :D
// TODO: YOU ARE HERE! :D

			print "This page is cached every 2 hours - \n";
			print "last cached: <strong>".date('m/d/Y \a\t g:ia')."</strong>\n";
			
			// Make a mapping of all source page-id => targets
			// This is an array of pairs instead of a mapping since both page-ids and targets can occur multiple times in the list.
			$LIMIT = 1000;
			$queryString = "SELECT pl.pl_from AS from_id, page_title AS links_to
							FROM wiki_page
							LEFT JOIN wiki_pagelinks AS pl ON page_namespace=pl_namespace AND page_title=pl.pl_title
							LEFT JOIN wiki_templatelinks ON page_namespace=tl_namespace AND page_title=tl_title
							RIGHT JOIN wiki_pagelinks AS links2 ON page_id=links2.pl_from
							WHERE page_namespace=0 AND page_is_redirect=1 AND (pl.pl_title IS NOT NULL or tl_title IS NOT NULL) LIMIT $LIMIT";
			$ids = array();
			$allListings = array();
			if($result = mysql_query($queryString,$db)){
				if(($numRows = mysql_num_rows($result)) && ($numRows > 0)){
					$totalResults = $numRows; // stored because numRows will get overwritten by the next query.
					for($cnt=0; $cnt<$numRows; $cnt++){
						$pageId = mysql_result($result, $cnt, "from_id");
						$target = mysql_result($result, $cnt, "links_to");
						$allListings[] = array($pageId, $target);
						
						// Somehow, a blank from_id can slip into the results (which messes up the query).
						if($pageId != ""){
							$ids[] = $pageId; // will uniquify later
						}
					}
					
					// Find the page titles of all of the source pages by id (uniquify the id array).
					GLOBAL $wgSitename;
					$nsMapping = array(
									1 => "Talk",
									2 => "User",
									3 => "User_talk",
									4 => $wgSitename,
									5 => $wgSitename."_talk",
									6 => ":File",
									7 => "File_talk",
									8 => "MediaWiki",
									9 => "MediaWiki_talk",
									10 => ":Template",
									11 => "Template_talk",
									12 => "Help",
									13 => "Help_talk",
									14 => ":Category",
									15 => "Category_talk"
								);
					$idToTitle = array();
					$ids = array_unique($ids);
					$queryString = "SELECT page_id, page_namespace, page_title FROM wiki_page WHERE page_id IN (".implode(",", $ids).")";
					if($result = mysql_query($queryString,$db)){
						if(($numRows = mysql_num_rows($result)) && ($numRows > 0)){
							for($cnt=0; $cnt<$numRows; $cnt++){
								$id = mysql_result($result, $cnt, "page_id");
								$ns = mysql_result($result, $cnt, "page_namespace");
								$title = mysql_result($result, $cnt, "page_title");

								if(isset($nsMapping[$ns])){
									$title = $nsMapping[$ns].":$title";
								}

								$idToTitle[$id] = $title;
							}
						}
					}
					
					$missing = "";
					print "The following source pages link to redirects:<br/>\n";
					print "<table>\n";
					print "<tr><th nowrap='nowrap'>Source Page</th><th>Redirect Page</th></tr>\n";
					$index = 0;
					foreach($allListings as $pair){
						$fromId = $pair[0];
						$to = $pair[1];
						if(isset($idToTitle[$fromId])){
							$from = $idToTitle[$fromId];
							
							print "<tr".((($index % 2)==0)?"":" class='odd'")."><td>[[$from]]</td><td>[[$to]]</td></tr>\n";
							
/*
	// TODO: IMPLEMENT THIS IF WE WANT TO LET SINGLE ITEMS BE CLEARED
							$delim = "&amp;";
							$prefix = "";

							// If the short-url is in the REQUEST_URI, make sure to add the index.php?title= prefix to it.
							if(strpos($REQUEST_URI, "index.php?title=") === false){
								$prefix = "/index.php?title=";
								
								// If we're adding the index.php ourselves, but the request still started with a slash, remove it because that would break the request if it came after the "title="
								if(substr($REQUEST_URI,0,1) == "/"){
									$REQUEST_URI = substr($REQUEST_URI, 1);
								}
							}
							print "	- (report as [{{SERVER}}$prefix$REQUEST_URI$delim"."artist=".urlencode($artist)."&amp;song=".urlencode($song)." fixed])";
							print "</td></tr>";
*/
						} else {
							$missing .= "Could not find the page_title for id $fromId which linked to <strong>[[$to]]</strong>.  Try [[Special:WhatLinksHere/$to]] instead.<br/>\n";
						}
						$index++;
					}
					print "</table><br/>\n";
					print "$missing<br/>\n";
					if($totalResults < $LIMIT){
						print "There are <strong>$totalResults </strong> links to redirects left on the site.  They are all listed above.";
					} else {
						print "There are <strong>$totalResults </strong> links to redirects on this page but we set a limit of $LIMIT, so there are probably more.<br/>\n";
					}
				} else {
					print "<em>No more links to redirects found. <strong>(Yay!)</strong></em>\n";
				}
			}

			$content = ob_get_clean();
			$cache->cacheValue($CACHE_KEY, $content);
		}
		$msg = ($msg==""?"":"<pre>$msg</pre>");
		$wgOut->addHTML("<style>table{border-collapse:collapse;}tr.odd{background-color:#eef}</style>\n");
		$wgOut->addWikiText("$msg$content");
//} // TODO: REMOVE UNLESS WE ADD DELETION OF SINGLE RECORDS.
}

?>

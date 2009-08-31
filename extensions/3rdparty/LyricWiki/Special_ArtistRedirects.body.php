<?php
////
// Author: Sean Colombo
// Date: 20080331
//
// The actual SpecialPage class for the Artist Redirects.
////

require_once 'extras.php';
class ArtistRedirects extends SpecialPage
{
	function ArtistRedirects(){
		SpecialPage::SpecialPage("ArtistRedirects");
		wfLoadExtensionMessages('ArtistRedirects');
	}

	function execute($par){
		$this->setHeaders();	// this is required for 1.7.1 to work
		global $wgRequest, $wgOut;

		$this->wfArtistRedirects();
	}

	// Outputs the actual page (has its own built in caching mechanisms).
	function wfArtistRedirects(){
		global $wgOut;
		global $wgRequest, $wgUser;

		$wgOut->setPageTitle("Artist Redirects");
		
		$msg = "";

		// Allow the cache to be manually cleared using the standard MediaWiki action=purge command.
		$cacheKey = "ARTICLE_REDIRECTS";
		$cacheHours = 12;
		if(isset($_GET['action']) && $_GET['action']=="purge"){
			// lw_connect does not work from inside this request for some reason.
			GLOBAL $wgDBserver,$wgDBuser,$wgDBpassword,$wgDBname;
			GLOBAL $lw_host;$lw_host = $wgDBserver;
			GLOBAL $lw_user;$lw_user = $wgDBuser;
			GLOBAL $lw_pass;$lw_pass = $wgDBpassword;
			GLOBAL $lw_name;$lw_name = $wgDBname;

			// TODO: USE THE DB_SLAVE CONNECTION CODE THAT WAS SUCCESSFULLY ADDED ELSEWHERE.
			$db = mysql_connect($lw_host, $lw_user, $lw_pass);
			mysql_select_db($lw_name, $db);
			$msg.= "Forced clearing of the cache...\n";
			if(mysql_query("UPDATE map SET value='2006-02-05 00:00:00' WHERE keyName='CACHE_TIME_$cacheKey'", $db)){
				$msg.= "Cleared.";
			} else {
				$msg.= "Failed. ".mysql_error();
			}
			unset($_GET['cache']);
			$_SERVER['REQUEST_URI'] = str_replace("?action=purge", "", $_SERVER['REQUEST_URI']);
			$_SERVER['REQUEST_URI'] = str_replace("&action=purge", "", $_SERVER['REQUEST_URI']);
		}

		$cache = new Cache();
		$MAX_LIMIT = 100;
		// If there is no explicit offset and limit, then display links to the various paged results.
		if((!isset($_GET['offset'])) || (!isset($_GET['limit']))){
			$currCacheKey = $cacheKey."_index";
			$content = $cache->fetchExpire( $currCacheKey, strtotime("-$cacheHours hour") );
			if(!$content){
				ob_start();
				// TODO: Use the DB_SLAVE connections, etc. to make use of existing connections & use the slave whenever possible.
				GLOBAL $lw_db;
				if(isset($lw_db)){
					$db = $lw_db;
				} else {
					GLOBAL $lw_host,$lw_user,$lw_pass,$lw_name;
					$db = mysql_connect($lw_host, $lw_user, $lw_pass);
					mysql_select_db($lw_name, $db);
					$lw_db = $db;
				}
				$queryString = "SELECT COUNT(*) as numRedirs FROM wiki_page WHERE page_is_redirect=1 AND page_title NOT LIKE '%:%' ORDER BY page_title";
				// TODO: See if there is a simpleQuery() function available here... otherwise add one somewhere
				$numRedirs = 0;
				if($result = mysql_query($queryString,$db)){
					if(($numRows = mysql_num_rows($result)) && ($numRows > 0)){
						$cnt=0;
						$numRedirs = mysql_result($result, $cnt, "numRedirs");
					}
				}
				print "View results by pages:\n";
				print "<ul>\n";
				$REQUEST_URI = $_SERVER['REQUEST_URI'];
				$delim = "?";
				if(false !== strpos($REQUEST_URI, "?")){
					$delim = "&amp;";
				}
				for($offset = 0; $offset < $numRedirs; $offset += $MAX_LIMIT){
					print "\t<li><a href='$REQUEST_URI$delim"."offset=$offset&amp;limit=".$MAX_LIMIT."'>$offset - ".($offset+$MAX_LIMIT)."</a></li>\n";
				}
				print "</ul>\n";

				$content = ob_get_clean();
				$cache->cacheValue($currCacheKey, $content);
			}
		} else {
			$offset = max(0, $_GET['offset']);
			$limit = min($_GET['limit'], $MAX_LIMIT);
			$currCacheKey = $cacheKey."_$offset"."_$limit";
			$content = $cache->fetchExpire( $currCacheKey, strtotime("-$cacheHours hour") );
			if(!$content){
				ob_start();

				// TODO: Use the DB_SLAVE connections, etc. to make use of existing connections & use the slave whenever possible.
				GLOBAL $lw_db;
				if(isset($lw_db)){
					$db = $lw_db;
				} else {
					GLOBAL $lw_host,$lw_user,$lw_pass,$lw_name;
					$db = mysql_connect($lw_host, $lw_user, $lw_pass);
					mysql_select_db($lw_name, $db);
					$lw_db = $db;
				}

				print "This page lists artist redirects.  It will help you find abbreviations, nick-names, misspellings, and more. ";
				print "It may not be extremely interesting, but it also allows search engines to index all of these varaints so that ";
				print "the next time you search for lyrics, you don't need to worry which form you use... this is basically a way to pass ";
				print "our \"implied redirects\" through to search results.";

				print "<style>table{border-collapse:collapse;width:100%}tr.odd{background-color:#eef}td{padding:5px;border:1px #000 solid;}</style>\n";
				print "This page is cached every $cacheHours hours - \n";
				print "last cached: <strong>".date('m/d/Y \a\t g:ia')."</strong>\n";

				$queryString = "SELECT page_title FROM wiki_page WHERE page_is_redirect=1 AND page_title NOT LIKE '%:%' ORDER BY page_title LIMIT $offset,$limit";
				if($result = mysql_query($queryString,$db)){
					if(($numRows = mysql_num_rows($result)) && ($numRows > 0)){
						print "<table>\n";
						$COLS_TO_USE = 3;
						$REQUEST_URI = $_SERVER['REQUEST_URI'];
						for($cnt=0; $cnt<$numRows; $cnt++){
							$pageTitle = mysql_result($result, $cnt, "page_title");
							if(($cnt % $COLS_TO_USE) == 0){
								print "\t<tr".((($cnt%2)!=0)?" class='odd'":"").">\n\t\t";
							}
							print "<td>";
							print "<a href='/index.php?virtPage&amp;title=".urlencode($pageTitle)."'>";
							print utf8_encode(str_replace("_", " ", $pageTitle));
							print "</a>";
							print "</td>";
							if((($cnt+1) % $COLS_TO_USE) == 0){
								print "\n\t</tr>\n";
							}
						}
						while(($cnt % $COLS_TO_USE) != 0){
							print "<td>&nbsp;</td>";
							if((($cnt+1) % $COLS_TO_USE) == 0){
								print "\n\t</tr>\n";
							}
							$cnt++;
						}
						print "</table>\n";
					}
				}

				$content = ob_get_clean();
				$cache->cacheValue($currCacheKey, $content);
			}
		}
		$msg = ($msg==""?"":"<pre>$msg</pre>");
		$wgOut->addHTML("$msg$content");
	} // end wfArtistRedirects()

} // end class ArtistRedirects

?>

<?php
////
// Author: Sean Colombo
// Date: 20080331
//
// The actual SpecialPage class for the Artist Redirects.
////

include_once 'extras.php';
class ArtistRedirects extends SpecialPage
{
	function __construct(){
		parent::__construct("ArtistRedirects");
	}

	function execute($par){
		$this->setHeaders();	// this is required for 1.7.1 to work
		$this->wfArtistRedirects();
	}

	// Outputs the actual page (has its own built in caching mechanisms).
	function wfArtistRedirects(){
		global $wgOut;

		$wgOut->setPageTitle("Artist Redirects");

		$msg = "";

		// Allow the cache to be manually cleared using the standard MediaWiki action=purge command.
		GLOBAL $wgMemc;
		$cacheKey = "LW_ARTICLE_REDIRECTS";
		$cacheHours = 12;
		if(isset($_GET['action']) && $_GET['action']=="purge"){
			$wgMemc->delete($cacheKey); // purge the entry from memcached
			$wgMemc->delete($cacheKey."_index"); // purge the entry for the page-listing
			unset($_GET['cache']);
			$_SERVER['REQUEST_URI'] = str_replace("?action=purge", "", $_SERVER['REQUEST_URI']);
			$_SERVER['REQUEST_URI'] = str_replace("&action=purge", "", $_SERVER['REQUEST_URI']);
		}

		$MAX_LIMIT = 100;
		// If there is no explicit offset and limit, then display links to the various paged results.
		if((!isset($_GET['offset'])) || (!isset($_GET['limit']))){
			$currCacheKey = $cacheKey."_index";

			GLOBAL $wgMemc;
			$content = $wgMemc->get($currCacheKey);
			if(!$content){
				ob_start();

				$dbr = wfGetDB( DB_SLAVE );
				$numRedirs = $dbr->selectField(
					"page",
					"COUNT(*) as numRedirs",
					[
						"page_is_redirect" => 1,
						"page_title NOT LIKE '%:%'"
					], __METHOD__);

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
				$wgMemc->set($currCacheKey, $content, strtotime("+$cacheHours hour"));
			}
		} else {
			$request = $this->getRequest();
			$offset = max( 0, $request->getInt( 'offset' ) );
			$limit = min( $request->getInt( 'limit' ), $MAX_LIMIT );
			$currCacheKey = $cacheKey."_$offset"."_$limit";

			$content = $wgMemc->get($currCacheKey);
			if(!$content){
				ob_start();

				$db = wfGetDB( DB_SLAVE );

				print "This page lists artist redirects.  It will help you find abbreviations, nick-names, misspellings, and more. ";
				print "It may not be extremely interesting, but it also allows search engines to index all of these varaints so that ";
				print "the next time you search for lyrics, you don't need to worry which form you use... this is basically a way to pass ";
				print "our \"implied redirects\" through to search results.";

				print "<style>table{border-collapse:collapse;width:100%}tr.odd{background-color:#eef}td{padding:5px;border:1px #000 solid;}</style>\n";
				print "This page is cached every $cacheHours hours - \n";
				print "last cached: <strong>".date('m/d/Y \a\t g:ia')."</strong>\n";

				$result = $db->select(
					[ 'page' ],
					[ 'page_title' ],
					[
						'page_is_redirect' => 1,
						'page_title NOT ' . $db->buildLike( $db->anyString(), ':' , $db->anyString() ),
					],
					__METHOD__,
					[
						'ORDER BY' => 'page_title',
						'OFFSET' => $offset,
						'LIMIT' => $limit,
					]
				);
				if ( $result->numRows() > 0 ) {
					print "<table>\n";
					$COLS_TO_USE = 3;
					$REQUEST_URI = $_SERVER['REQUEST_URI'];
					foreach ( $result as $row ) {
						$pageTitle = $row->page_title;
						if(($cnt % $COLS_TO_USE) == 0){
							print "\t<tr".((($cnt%2)!=0)?" class='odd'":"").">\n\t\t";
						}
						print "<td>";
						print Xml::element( 'a', [ 'href' => '/index.php?virtPage&title=' . urlencode( $pageTitle ) ], utf8_encode( str_replace( '_', ' ', $pageTitle ) ) );
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

				$content = ob_get_clean();
				$wgMemc->set($currCacheKey, $content, strtotime("+$cacheHours hour"));
			}
		}
		$msg = ($msg==""?"":"<pre>$msg</pre>");
		$wgOut->addHTML("$msg$content");
	} // end wfArtistRedirects()

} // end class ArtistRedirects


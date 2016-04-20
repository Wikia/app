<?php
/**
 * Author: Sean Colombo
 * Date: 20061231 - 20100305
 *
 * This special page just shows which songs have the most failed requests from
 * the LyricWiki SOAP.
 *
 * The structure of this special page was just copied from Teknomunk's
 * Batch Move special page.
 *
 *DROP TABLE IF EXISTS lw_soap_failures;
 *CREATE TABLE lw_soap_failures(
 *	request_artist VARCHAR(255) NOT NULL,
 *	request_song VARCHAR(255) NOT NULL,
 *	numRequests INT(11) DEFAULT 1,
 *	lookedFor BLOB, # all of the titles (in order, \n-delimited) which the API actually checked for.
 *	PRIMARY KEY (request_artist, request_song)
 *);
 *DROP TABLE IF EXISTS lw_soap_failures_mobile;
 *CREATE TABLE lw_soap_failures_mobile(
 *	request_artist VARCHAR(255) NOT NULL,
 *	request_song VARCHAR(255) NOT NULL,
 *	numRequests INT(11) DEFAULT 1,
 *	lookedFor BLOB, # all of the titles (in order, \n-delimited) which the API actually checked for.
 *	PRIMARY KEY (request_artist, request_song)
 *);
 *
 * TODO: Make better use of Internationalization.  There are a bunch of hardcoded strings still.
 */

if(!defined('MEDIAWIKI')) die();

$wgExtensionCredits['specialpage'][] = array(
	'name' => 'SOAP Failures',
	'url' => 'http://lyrics.wikia.com/User:Sean_Colombo',
	'author' => '[http://www.seancolombo.com Sean Colombo]',
	'description' => 'SOAP Failures Log special page',
	'version' => '1.2',
);
$wgExtensionMessagesFiles['SpecialSoapFailures'] = dirname(__FILE__).'/Special_Soapfailures.i18n.php';

require_once($IP . '/includes/SpecialPage.php');
$wgSpecialPages['Soapfailures'] = 'Soapfailures';

class Soapfailures extends SpecialPage{

	public function __construct(){
		parent::__construct('Soapfailures');
	}

	/**
	 *
	 * @param $par String subpage string, if one was specified
	 */
	function execute( $par ){
		global $wgOut;
		global $wgRequest, $wgUser, $wgMemc;

		$MAX_RESULTS = 100;
		$CACHE_KEY_PREFIX = "LW_SOAP_FAILURES";
		$CACHE_KEY_DATA = wfMemcKey($CACHE_KEY_PREFIX, "data");
		$CACHE_KEY_TIME = wfMemcKey($CACHE_KEY_PREFIX, "cachedOn");
		$CACHE_KEY_STATS = wfMemcKey($CACHE_KEY_PREFIX, "stats");

		$wgOut->setPageTitle(wfMsg('soapfailures'));

		// This processes any requested for removal of an item from the list.
		if(isset($_POST['artist']) && isset($_POST['song'])){
			$artist = $_POST['artist'];
			$song = $_POST['song'];
			$songResult = array();
			$failedLyrics = "Not found";

			/*
			GLOBAL $IP;
			define('LYRICWIKI_SOAP_FUNCS_ONLY', true); // so that we can use the SOAP functions but not actually instantiate a SOAP server & process a request.
			include_once 'server.php'; // the SOAP functions

			$songResult = getSong($artist, $song);*/

			// Pull in the NuSOAP code
			$dir = dirname(__FILE__) . '/';
			require_once($dir . 'nusoap.php');
			// Create the client instance
			$wsdlUrl = 'http://'.$_SERVER['SERVER_NAME'].'/server.php?wsdl&1';

			// PLATFORM-1743
			global $wgHTTPProxy;
			list($PROXY_HOST, $PROXY_PORT) = explode(':', $wgHTTPProxy);

			$client = new nusoapclient($wsdlUrl, true, $PROXY_HOST, $PROXY_PORT);
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
				print "<html><head><title>Error</title></head><body>\n"; // TODO: i18n
				print '<div style="background-color:#fcc">Sorry, but ' . htmlspecialchars( $artist ) . ':' . htmlspecialchars( $song ) . " song still failed.</div>\n";
				print_r($songResult);
			} else {
				$dbw = wfGetDB( DB_MASTER );

				print "<html><head><title>Success</title></head><body>\n"; // TODO: i18n
				print "Deleting record... ";

				$result = $dbw->delete(
					'lw_soap_failures',
					[
						'request_artist' => $artist,
						'request_song' => $song,
					],
					__METHOD__
				);
				if ( $result ) {
					print "Deleted.";
				} else {
					print "Failed. ".mysql_error();
				}
				print "<br/>Clearing the cache... ";

				$wgMemc->delete($CACHE_KEY_DATA); // purge the entry from memcached
				$wgMemc->delete($CACHE_KEY_TIME);
				$wgMemc->delete($CACHE_KEY_STATS);

				print "<div style='background-color:#cfc'>The song was retrieved successfully and ";
				print "was removed from the failed requests list.";
				print "</div>\n";
			}
			global $wgScriptPath;
			print "<br/>Back to <a href='$wgScriptPath/Special:Soapfailures'>SOAP Failures</a>\n";
			print "</body></html>";
			exit; // wiki system throws database-connection errors if the page is allowed to display itself.
		} else {
			$wgOut->addHTML("<style type='text/css'>
				table.soapfailures{
					border-collapse:collapse;
				}
				.soapfailures tr.odd{background-color:#eef}
				.soapfailures td, .soapfailures th{
					border:1px solid;
					cell-padding:0px;
					cell-spacing:0px;
					vertical-align:top;
					padding:5px;
				}</style>\n");

			// Allow the cache to be manually cleared.
			$msg = "";
			if(isset($_GET['cache']) && $_GET['cache']=="clear"){
				$msg.= "Forced clearing of the cache...\n";
				$wgMemc->delete($CACHE_KEY_DATA); // purge the entry from memcached
				$wgMemc->delete($CACHE_KEY_TIME);
				$wgMemc->delete($CACHE_KEY_STATS);
				unset($_GET['cache']);
				$_SERVER['REQUEST_URI'] = str_replace("?cache=clear", "", $_SERVER['REQUEST_URI']);
				$_SERVER['REQUEST_URI'] = str_replace("&cache=clear", "", $_SERVER['REQUEST_URI']);
			}

			$msg = ($msg==""?"":"<pre>$msg</pre>");
			$wgOut->addWikiText($msg);

			// Form for clearing a fixed song.
			$wgOut->addHTML(wfMsg('soapfailures-mark-as-fixed') . "
							<form method='post'>
								".wfMsg('soapfailures-artist')." <input type='text' name='artist'/><br/>
								".wfMsg('soapfailures-song')." <input type='text' name='song'/><br/>
								<input type='submit' name='fixed' value='".wfMsg('soapfailures-fixed')."'/>
							</form><br/>");

			$data = $wgMemc->get($CACHE_KEY_DATA);
			$cachedOn = $wgMemc->get($CACHE_KEY_TIME);
			$statsHtml = $wgMemc->get($CACHE_KEY_STATS);
			if(!$data){
				$db = &wfGetDB(DB_SLAVE)->getProperty('mConn');
				$queryString = "SELECT * FROM lw_soap_failures ORDER BY numRequests DESC LIMIT $MAX_RESULTS";
				if($result = mysql_query($queryString,$db)){
					$data = array();
					if(($numRows = mysql_num_rows($result)) && ($numRows > 0)){
						for($cnt=0; $cnt<$numRows; $cnt++){
							$row = array();
							$row['artist'] = mysql_result($result, $cnt, "request_artist");
							$row['song'] = mysql_result($result, $cnt, "request_song");
							$row['numRequests'] = mysql_result($result, $cnt, "numRequests");
							$row['lookedFor'] = mysql_result($result, $cnt, "lookedFor");
							$row['lookedFor'] = formatLookedFor($row['lookedFor']);
							$data[] = $row;
						}
					}
				} else {
					$wgOut->addHTML("<br/><br/><strong>Error: with query</strong><br/><em>$queryString</em><br/><strong>Error message: </strong>".mysql_error($db));
				}

				$cachedOn = date('m/d/Y \a\t g:ia');
			}

			// Stats HTML is just an unimportant feature, hackily storing HTML instead of the data - FIXME: It's BAD to cache output rather than data.
			if(!$statsHtml){
				// Display some hit-rate stats.
				ob_start();
				include_once __DIR__ . "/soap_stats.php"; // for tracking success/failure
				print "<br/><br/><br/>";
				print "<em>".wfMsg('soapfailures-stats-header')."</em><br/>\n";
				print "<table border='1px' cellpadding='5px'>\n";
				print "\t<tr><th>".wfMsg('soapfailures-stats-timeperiod')."</th><th>".wfMsg('soapfailures-stats-numfound')."</th><th>".wfMsg('soapfailures-stats-numnotfound')."</th><th>&nbsp;</th></tr>\n";

				$stats = lw_soapStats_getStats(LW_TERM_DAILY, "", LW_API_TYPE_WEB);
				print "\t<tr><td>".wfMsg('soapfailures-stats-period-today')."</td><td>{$stats[LW_API_FOUND]}</td><td>{$stats[LW_API_NOT_FOUND]}</td><td>{$stats[LW_API_PERCENT_FOUND]}%</td></tr>\n";

				$stats = lw_soapStats_getStats(LW_TERM_WEEKLY, "", LW_API_TYPE_WEB);
				print "\t<tr><td>".wfMsg('soapfailures-stats-period-thisweek')."</td><td>{$stats[LW_API_FOUND]}</td><td>{$stats[LW_API_NOT_FOUND]}</td><td>{$stats[LW_API_PERCENT_FOUND]}%</td></tr>\n";

				$stats = lw_soapStats_getStats(LW_TERM_MONTHLY, "", LW_API_TYPE_WEB);
				print "\t<tr><td>".wfMsg('soapfailures-stats-period-thismonth')."</td><td>{$stats[LW_API_FOUND]}</td><td>{$stats[LW_API_NOT_FOUND]}</td><td>{$stats[LW_API_PERCENT_FOUND]}%</td></tr>\n";
				print "</table>\n";
				$statsHtml = ob_get_clean();
			}

			if($data){
				$wgOut->addWikiText(wfMsg('soapfailures-intro'));

				$wgOut->addHTML("This page is cached every 2 hours - \n"); // TODO: i18n
				$wgOut->addHTML("last cached: <strong>$cachedOn</strong>\n"); // TODO: i18n
				$totFailures = 0;
				if(!empty($data)){
					$wgOut->addHTML("<table class='soapfailures'>\n");
					$wgOut->addHTML("<tr><th nowrap='nowrap'>".wfMsg('soapfailures-header-requests')."</th><th>".wfMsg('soapfailures-header-artist')."</th><th>".wfMsg('soapfailures-header-song')."</th><th>".wfMsg('soapfailures-header-looked-for')."</th><th>".wfMsg('soapfailures-header-fixed')."</th></tr>\n");
					$REQUEST_URI = $_SERVER['REQUEST_URI'];
					$rowIndex=0;
					foreach($data as $row){
						$artist = $row['artist'];
						$song = $row['song'];
						$numRequests = $row['numRequests'];
						$lookedFor = $row['lookedFor'];
						$totFailures += $numRequests;
						$wgOut->addHTML(utf8_encode("<tr".((($rowIndex%2)!=0)?" class='odd'":"")."><td>$numRequests</td><td>"));
						$wgOut->addWikiText("[[$artist]]");
						$wgOut->addHTML("</td><td>");
						$wgOut->addWikiText("[[$artist:$song|$song]]");
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
						$wgOut->addHTML("</td><td>");
						$wgOut->addWikiText("$lookedFor");
						$wgOut->addHTML("</td><td>");
						$wgOut->addHTML("<form action='' method='POST' target='_blank'>
								<input type='hidden' name='artist' value=\"" . Sanitizer::encodeAttribute( $artist ) . "\"/>
								<input type='hidden' name='song' value=\"" . Sanitizer::encodeAttribute( $song ) . "\"/>
								<input type='submit' name='fixed' value=\"" . wfMessage( 'soapfailures-fixed' )->escaped() . "\"/>
							</form>\n");
						$wgOut->addHTML("</td>");
						$wgOut->addHTML("</tr>\n");

						$rowIndex++;
					}
					$wgOut->addHTML("</table>\n");
					$wgOut->addHTML("<br/>Total of <strong id='lw_numFailures'>$totFailures</strong> requests in the top $MAX_RESULTS.  This number will increase slightly over time, but we should fight to keep it as low as possible!");
				} else {
					$wgOut->addHTML("<em>No results found.</em>\n");
				}

				if(!empty($data)){
					$TWO_HOURS_IN_SECONDS = (60*60*2);
					$wgMemc->set($CACHE_KEY_TIME, $cachedOn, $TWO_HOURS_IN_SECONDS);
					$wgMemc->set($CACHE_KEY_STATS, $statsHtml, $TWO_HOURS_IN_SECONDS);

					// We use CACHE_KEY_DATA to determine when all of these keys have expired, so it should expire a few microseconds after the other two (that's why it's below the other set()s).
					$wgMemc->set($CACHE_KEY_DATA, $data, $TWO_HOURS_IN_SECONDS);
				}
			}

			$wgOut->addHTML($statsHtml);
		}
	} // end execute()
}

/**
 * Given the string of lookedFor titles, formats them into wikitext with one title (as a link) per line.
 */
function formatLookedFor($lookedFor){
	$titles = array_unique(explode("\n", $lookedFor));
	$lookedFor = "";
	foreach($titles as $pageTitle){
		if(trim($pageTitle) != ""){
			$pageTitle = str_replace("_", " ", $pageTitle);
			$lookedFor .= "[[$pageTitle]]<br/>";
		}
	}
	return $lookedFor;
} // end formatLookedFor()


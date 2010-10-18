<?php
////
// Author: Sean Colombo
// Date: 20061231 - 20100305
//
// This special page just shows which songs have the most failed requests from
// the LyricWiki SOAP.
//
// The structure of this special page was just copied from Teknomunk's
// Batch Move special page.
//
//DROP TABLE IF EXISTS lw_soap_failures;
//CREATE TABLE lw_soap_failures(
//	request_artist VARCHAR(255) NOT NULL,
//	request_song VARCHAR(255) NOT NULL,
//	numRequests INT(11) DEFAULT 1,
//	lookedFor BLOB, # all of the titles (in order, \n-delimited) which the API actually checked for.
//	PRIMARY KEY (request_artist, request_song)
//);
//
// TODO: Make better use of Internationalization.  There are a bunch of hardcoded strings still.
////

if(!defined('MEDIAWIKI')) die();

// Allows anyone to view the page.
$wgAvailableRights[] = 'soapfailures';
$wgGroupPermissions['*']['soapfailures'] = true;
$wgGroupPermissions['user']['soapfailures'] = true;
$wgGroupPermissions['sysop']['soapfailures'] = true;

$wgExtensionFunctions[] = 'wfSetupSoapFailures';
$wgExtensionCredits['specialpage'][] = array(
	'name' => 'SOAP Failures',
	'url' => 'http://lyrics.wikia.com/User:Sean_Colombo',
	'author' => '[http://www.seancolombo.com Sean Colombo]',
	'description' => 'SOAP Failures Log special page',
	'version' => '1.2',
);
$wgExtensionMessagesFiles['SpecialSoapFailures'] = dirname(__FILE__).'/Special_Soapfailures.i18n.php';

function wfSetupSoapFailures(){
	global $IP;
	wfLoadExtensionMessages('SpecialSoapFailures');
	require_once($IP . '/includes/SpecialPage.php');
	SpecialPage::addPage(new SpecialPage('Soapfailures', 'soapfailures', true, 'wfSoapFailures', false));
}

function wfSoapFailures(){
	global $wgOut;
	global $wgRequest, $wgUser, $wgMemc;
	
	$MAX_RESULTS = 100;
	$CACHE_KEY = "LW_SOAP_FAILURES";

	wfLoadExtensionMessages('SpecialSoapFailures');
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
		global $IP;
		require_once("$IP/extensions/3rdparty/LyricWiki/nusoap.php");
		// Create the client instance
		$wsdlUrl = 'http://'.$_SERVER['SERVER_NAME'].'/server.php?wsdl&1';
		$client = new nusoapclient($wsdlUrl, true);
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
			print_r($songResult);
		} else {
			$artist = str_replace("'", "\\'", $artist);
			$song = str_replace("'", "\\'", $song);

			$db = &wfGetDB(DB_MASTER)->getProperty('mConn');
			
			print "Deleting record... ";
			if(mysql_query("DELETE FROM lw_soap_failures WHERE request_artist='$artist' AND request_song='$song'", $db)){
				print "Deleted.";
			} else {
				print "Failed. ".mysql_error();
			}
			print "<br/>Clearing the cache... ";
			
			$wgMemc->delete($CACHE_KEY); // purge the entry from memcached

			print "<div style='background-color:#cfc'>The song was retrieved successfully and ";
			print "was removed from the failed requests list.";
			print "</div>\n";
		}
		global $wgScriptPath;
		print "<br/>Back to <a href='$wgScriptPath/Special:Soapfailures'>SOAP Failures</a>\n";
		exit; // wiki system throws database-connection errors if the page is allowed to display itself.
	} else {
		$msg = "";

		// Allow the cache to be manually cleared.
		if(isset($_GET['cache']) && $_GET['cache']=="clear"){
			$msg.= "Forced clearing of the cache...\n";
			$wgMemc->delete($CACHE_KEY); // purge the entry from memcached
			unset($_GET['cache']);
			$_SERVER['REQUEST_URI'] = str_replace("?cache=clear", "", $_SERVER['REQUEST_URI']);
			$_SERVER['REQUEST_URI'] = str_replace("&cache=clear", "", $_SERVER['REQUEST_URI']);
		}

		$content = $wgMemc->get($CACHE_KEY);
		if(!$content){
			ob_start();

			$db = &wfGetDB(DB_SLAVE)->getProperty('mConn');

			print wfMsg('soapfailures-intro');
			
			// Display some hit-rate stats.
			include "soap_stats.php"; // for tracking success/failure
			print "<table>\n";
			print "\t<tr><th>".wfMsg('soapfailures-stats-timeperiod')."</th><th>".wfMsg('soapfailures-stats-numfound')."</th><th>".wfMsg('soapfailures-stats-numnotfound')."</th><th>&nbsp;</th></tr>\n";

			$stats = lw_soapStats_getStats(LW_TERM_DAILY);
			print "\t<tr><td>".wfMsg('soapfailures-stats-period-today')."</td><td>{$stats[LW_API_FOUND]}</td><td>{$stats[LW_API_NOT_FOUND]}</td><td>{$stats[LW_API_PERCENT_FOUND]}%</td></tr>\n";

			$stats = lw_soapStats_getStats(LW_TERM_WEEKLY);
			print "\t<tr><td>".wfMsg('soapfailures-stats-period-thisweek')."</td><td>{$stats[LW_API_FOUND]}</td><td>{$stats[LW_API_NOT_FOUND]}</td><td>{$stats[LW_API_PERCENT_FOUND]}%</td></tr>\n";
			
			$stats = lw_soapStats_getStats(LW_TERM_MONTHLY);
			print "\t<tr><td>".wfMsg('soapfailures-stats-period-thismonth')."</td><td>{$stats[LW_API_FOUND]}</td><td>{$stats[LW_API_NOT_FOUND]}</td><td>{$stats[LW_API_PERCENT_FOUND]}%</td></tr>\n";
			print "</table>\n";

			
			print "This page is cached every 2 hours - \n";
			print "last cached: <strong>".date('m/d/Y \a\t g:ia')."</strong>\n";
			$queryString = "SELECT * FROM lw_soap_failures ORDER BY numRequests DESC LIMIT $MAX_RESULTS";
			$totFailures = 0;
			if($result = mysql_query($queryString,$db)){
				if(($numRows = mysql_num_rows($result)) && ($numRows > 0)){
					print "<table class='soapfailures'>\n";
					print "<tr><th nowrap='nowrap'>Requests</th><th>Artist</th><th>Song</th><th>Titles looked for</th></tr>\n";
					$REQUEST_URI = $_SERVER['REQUEST_URI'];
					for($cnt=0; $cnt<$numRows; $cnt++){
						$artist = mysql_result($result, $cnt, "request_artist");
						$song = mysql_result($result, $cnt, "request_song");
						$numRequests = mysql_result($result, $cnt, "numRequests");
						$lookedFor = mysql_result($result, $cnt, "lookedFor");
						$lookedFor = formatLookedFor($lookedFor);
						$totFailures += $numRequests;
						print utf8_encode("<tr".((($cnt%2)!=0)?" class='odd'":"")."><td>$numRequests</td><td>[[$artist]]</td><td>[[$artist:$song|$song]]");
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
						print "</td>";
						print "<td>$lookedFor</td></tr>";
					}
					print "</table>\n";
					print "<br/>Total of <strong>$totFailures</strong> requests in the top $MAX_RESULTS.  This number will increase slightly over time, but we should fight to keep it as low as possible!";
				} else {
					print "<em>No results found.</em>\n";
				}
			} else {
				print "<br/><br/><strong>Error: with query</strong><br/><em>$queryString</em><br/><strong>Error message: </strong>".mysql_error($db);
			}

			$content = ob_get_clean();
			$wgMemc->set($CACHE_KEY, $content, strtotime("+2 hour"));
		}
		$msg = ($msg==""?"":"<pre>$msg</pre>");
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
		
		// Form for clearing a fixed song.
		$wgOut->addHTML(wfMsg('soapfailures-mark-as-fixed') . "
						<form method='post'>
							".wfMsg('soapfailures-artist')." <input type='text' name='artist'/><br/>
							".wfMsg('soapfailures-song')." <input type='text' name='song'/><br/>
							<input type='submit' name='fixed' value='".wfMsg('soapfailures-fixed')."'/>
						</form><br/>");

		$wgOut->addWikiText("$msg$content");
	}
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

?>

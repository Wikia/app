<?php
////
// Author: Sean Colombo
// Date: 20060715
// Last modified: 20090103 (actually pretty frequently, and this generally doesn't get updated... see SVN for reliable date)
//
// The LyricWiki SOAP web service implementation.
//
// TODO: For the Kompoz lyrics, make it add special Kompoz data - update: 20080716... what ended up happening with Kompoz?  They still around & using LyricWiki?.
// TODO: When a user adds a song, make sure it is automatically merged into the artist page (User:Janitor makes this not too big of a deal since he finds orphans and adds them to the artist's Other Songs section).
//
// NOTES FOR DEVELOPERS:
// - When implementing a new method, make sure to check the global $SHUT_DOWN_API.
// - Before writing anything to the database, remember to check wfReadOnly().
////

include_once 'extras.php'; // for lw_simpleQuery to start
GLOBAL $LW_USE_PERSISTENT_CONNECTIONS;
$LW_USE_PERSISTENT_CONNECTIONS = true;
$ENABLE_LOGGING_SLOW_SOAP = false;
$MIN_SECONDS_TO_LOG = 15; // if the script takes longer than this many seconds to run, the request will be logged.
$startTime = microtime(true);

define('TRACK_REQUEST_RUNTIMES', false);
GLOBAL $REQUEST_TYPE;
$REQUEST_TYPE = isset($REQUEST_TYPE)?$REQUEST_TYPE:"SOAP";

// This will only show up if SHUT_DOWN_API is set to true (and still, only on methods that have a decent field in which to display it).
GLOBAL $SHUT_DOWN_API_REASON;
$SHUT_DOWN_API_REASON = "API is temporarily disabled due to high traffic.  We expect it to be re-enabled on February 1st after some changes are completed.";
GLOBAL $SHUT_DOWN_API;
if(empty($SHUT_DOWN_API)){
	$SHUT_DOWN_API = false;
}
//$SHUT_DOWN_API = true; // Use this to quickly turn the API on and off to control flow of traffic.
//if(rand(0,1) != 0){ // TODO: REMOVE - THIS DUMPS RANDOM REQUESTS (was an overly basic traffic-throttling method).
//	$SHUT_DOWN_API = true;
//}

// This is for the basic MediaWiki functionality (currently used by checkSongExists).
// For advanced MediaWiki functionality, call the lw_moreWiki() function
if((!defined('LYRICWIKI_KEEP_IP')) || (!LYRICWIKI_KEEP_IP)){
	unset($IP);
}

GLOBAL $LW_PATH;
$LW_PATH = (isset($LW_PATH)?$LW_PATH:"./");
GLOBAL $wgScriptPath;
// This wrap protects us from connecting to the DB when the API is shut down - at least it's intended to: we haven't verified this yet.
if(!$SHUT_DOWN_API){
	if(!defined('MEDIAWIKI')){
		define( 'MEDIAWIKI', true );
	}
	if(!defined('LYRICWIKI_SOAP')){
		define( 'LYRICWIKI_SOAP', true ); // so that LocalSettings.php knows not to include extra files.
	}

	require_once $LW_PATH."includes/Defines.php";

	if($LW_PATH != "./"){ // another (probably futile) attempt to allow entry points other than in the root directory.
		$wgScriptPath = $LW_PATH;
	}

	require (dirname(__FILE__) . '/../../../includes/WebStart.php');
} else if(!function_exists("wfReadOnly")){
	// Since we skip the MediaWiki stack when the API is disabled, this stub is needed.
	function wfReadOnly(){return true;}
}

GLOBAL $wgUser;
GLOBAL $server; // so that the functions can get the headers to log in.

GLOBAL $amazonRoot;
$affiliateTag = 'wikia-20';
$amazonRoot = "http://www.amazon.com/exec/obidos/redirect?link_code=ur2&tag=$affiliateTag&camp=1789&creative=9325&path=external-search%3Fsearch-type=ss%26index=music%26keyword=";

if(!function_exists("getVal")){
	////
	// Returns the value set in the data array, or empty string on failure.
	////
	function getVal($dataArray, $key, $default=''){
		return ((isset($dataArray[$key]))?$dataArray[$key]:$default);
	} // end getVal
}

// TODO: Extract the lw_connect() and lw_connect_readOnly() methods into a separate file and remove the different declarations from all of the scripts that use it.
// TODO: Extract the lw_connect() and lw_connect_readOnly() methods into a separate file and remove the different declarations from all of the scripts that use it.

if(!function_exists("lw_connect")){ // Function is in several scripts.  This prevents collisions regardless of include-order.
	// Persistent connections don't work well for the API (a ton of clients connecting once every couple of minutes causes way to many connections to hang around - pconns stay for 15 seconds by default).
	// So here, we manually figure out which server to use and connect to it in a non-persistent (volitile? disposable?) way.
	GLOBAL $LW_USE_PERSISTENT_CONNECTIONS;
//	$LW_USE_PERSISTENT_CONNECTIONS = false;

	////
	// Connects to the wiki database using the configured settings.
	// Only connects once per page-load so it's safe to call as many times as
	// needed without additional overhead.
	////
	function lw_connect(){
		return wfGetDB(DB_MASTER)->getProperty('mConn');
	} // end lw_connect()
}

if(!function_exists("lw_connect_readOnly")){
	////
	// Returns a connection to the database just like lw_connect, but this reference will
	// be to the slave (read-only replica) which will be faster for read but doesn't allow writes.
	////
	function lw_connect_readOnly(){
		return wfGetDB(DB_SLAVE)->getProperty('mConn');
	} // end lw_connect_readOnly()
}

// If another local script wants to use these functions, it can just include
// this file with LYRICWIKI_SOAP_FUNCS_ONLY and then call the
// functions directly.
$funcsOnly = (defined('LYRICWIKI_SOAP_FUNCS_ONLY') && LYRICWIKI_SOAP_FUNCS_ONLY);
if(!$funcsOnly){
	// Really basic logging for the requests.
	// $LOG_FILE = fopen("./lw_API_log.txt", "a");
	// fwrite($LOG_FILE, date("Y-m-d H:i:s")." - ".$_SERVER['REQUEST_URI']."\n");
	// fclose($LOG_FILE);

	require_once('nusoap.php');
	$server = new soap_server();
	$server->soap_defencoding = 'UTF-8';

	// Initialize WSDL support
	$ns = "urn:LyricWiki";
	$action = $ns;
	$server->configureWSDL('LyricWiki', $ns);
	$server->wsdl->addComplexType(
		'ArrayOfstring',
		'complexType',
		'array',
		'',
		'SOAP-ENC:Array',
		array(),
		array(array('ref'=>'SOAP-ENC:arrayType','wsdl:arrayType'=>'string[]')),
		'xsd:string'
	);
	$server->wsdl->addComplexType(
		'AlbumResultArray',
		'complexType',
		'array',
		'',
		'SOAP-ENC:Array',
		array(),
		array(array('ref'=>'SOAP-ENC:arrayType','wsdl:arrayType'=>'AlbumResult[]')),
		'tns:AlbumResult'
	);
	$server->wsdl->addComplexType(
		'AlbumResult',
		'complexType',
		'struct',
		'all',
		'',
		array(
			'artist' => array('name' => 'artist', 'type' => 'xsd:string'),
			'album' => array('name' => 'album', 'type' => 'xsd:string'),
			'year' => array('name' => 'year', 'type' => 'xsd:int')
		)
	);
	$server->wsdl->addComplexType(
		'SongResult',
		'complexType',
		'struct',
		'all',
		'',
		array(
			'artist' => array('name' => 'artist', 'type' => 'xsd:string'),
			'song' => array('name' => 'song', 'type' => 'xsd:string')
		)
	);
	$server->wsdl->addComplexType(
		'LyricsResult',
		'complexType',
		'struct',
		'all',
		'',
		array(
			'artist' => array('name' => 'artist', 'type' => 'xsd:string'),
			'song' => array('name' => 'song', 'type' => 'xsd:string'),
			'lyrics' => array('name' => 'lyrics', 'type' => 'xsd:string'),
			'url' => array('name' => 'url', 'type' => 'xsd:string')
		)
	);
	$server->wsdl->addComplexType(
		'SOTDResult',
		'complexType',
		'struct',
		'all',
		'',
		array(
			'artist' => array('name' => 'artist', 'type' => 'xsd:string'),
			'song' => array('name' => 'song', 'type' => 'xsd:string'),
			'nominatedBy' => array('name' => 'nominatedBy', 'type' => 'xsd:string'),
			'reason' => array('name' => 'reason', 'type' => 'xsd:string'),
			'lyrics' => array('name' => 'lyrics', 'type' => 'xsd:string')
		)
	);
	$server->wsdl->addComplexType(
		'AlbumDataArray',
		'complexType',
		'array',
		'',
		'SOAP-ENC:Array',
		array(),
		array(array('ref'=>'SOAP-ENC:arrayType','wsdl:arrayType'=>'AlbumData[]')),
		'tns:AlbumData'
	);
	$server->wsdl->addComplexType(
		'AlbumData',
		'complexType',
		'struct',
		'all',
		'',
		array(
			'album' => array('name' => 'album', 'type' => 'xsd:string'),
			'year' => array('name' => 'year', 'type' => 'xsd:int'),
			'amazonLink' => array('name' => 'amazonLink', 'type' => 'xsd:string'),
			'songs' => array('name' => 'songs', 'type' => 'tns:ArrayOfstring')
		)
	);

	//////////////////////////////////////////////////////////////////////////////
	///////// SEARCHING METHODS - BEGIN /////////
	$server->register('checkSongExists',
		array('artist' => 'xsd:string', 'song' => 'xsd:string'),
		array('return' => 'xsd:boolean'),
		$ns,
		"$action#checkSongExists",
		'rpc',
		'encoded',
		'Check if a song exists in the LyricWiki database yet'
	);

	$server->register('searchArtists',
		array('searchString' => 'xsd:string'),
		array('return' => 'tns:ArrayOfstring'),
		$ns,
		"$action#searchArtists",
		'rpc',
		'encoded',
		'Search for an artist by name and return up to 10 close matches'
	);

	$server->register('searchAlbums',
		array('artist' => 'xsd:string', 'album' => 'xsd:string', 'year' => 'xsd:int'),
		array('return' => 'tns:AlbumResultArray'),
		$ns,
		"$action#searchAlbums",
		'rpc',
		'encoded',
		'Search for an album on LyricWiki and return up to 10 close matches (year optional)'
	);

	$server->register('searchSongs',
		array('artist' => 'xsd:string', 'song' => 'xsd:string'),
		array('return' => 'tns:SongResult'),
		$ns,
		"$action#searchSongs",
		'rpc',
		'encoded',
		'Search for a song on LyricWiki and get up to 10 close matches'
	);
	///////// SEARCHING METHODS - END /////////
	//////////////////////////////////////////////////////////////////////////////

	//////////////////////////////////////////////////////////////////////////////
	///////// FETCHING METHODS - BEGIN /////////
	$server->register('getSOTD',
		array(),
		array('return' => 'tns:SOTDResult'),
		$ns,
		"$action#getSOTD",
		'rpc',
		'encoded',
		'Get the lyrics for a the current Song of the Day on LyricWiki'
	);

	$server->register('getSong',
		array('artist' => 'xsd:string', 'song' => 'xsd:string'),
		array('return' => 'tns:LyricsResult'),
		$ns,
		"$action#getSong",
		'rpc',
		'encoded',
		'Get the lyrics for a LyricWiki song with the exact artist and song match'
	);
	$server->register('getSongResult',
		array('artist' => 'xsd:string', 'song' => 'xsd:string'),
		array('songResult' => 'tns:LyricsResult'),
		$ns,
		"$action#getSongResult",
		'rpc',
		'encoded',
		'Get the lyrics for a LyricWiki song with the exact artist and song match'
	);

	$server->register('getArtist',
		array('artist' => 'xsd:string'),
		array('artist' => 'xsd:string', 'albums' => 'tns:AlbumDataArray'),
		$ns,
		"$action#getArtist",
		'rpc',
		'encoded',
		'Gets the entire discography for an artist'
	);

	$server->register('getAlbum',
		array('artist' => 'xsd:string', 'album' => 'xsd:string', 'year' => 'xsd:int'),
		array('artist' => 'xsd:string', 'album' => 'xsd:string', 'year' => 'xsd:int', 'amazonLink' => 'xsd:string', 'songs' => 'tns:ArrayOfstring'),
		$ns,
		"$action#getAlbum",
		'rpc',
		'encoded',
		'Gets the track listing and amazon link for an album'
	);

	$server->register('getHometown',
		array('artist' => 'xsd:string'),
		array('country' => 'xsd:string', 'state' => 'xsd:string', 'hometown' => 'xsd:string'),
		$ns,
		"$action#getHometown",
		'rpc',
		'encoded',
		'Gets the hometown for an artist'
	);
	///////// FETCHING METHODS - END /////////
	//////////////////////////////////////////////////////////////////////////////

	//////////////////////////////////////////////////////////////////////////////
	///////// UPDATING METHODS - BEGIN /////////
	$server->register('postArtist',
		array('overwriteIfExists' => 'xsd:boolean', 'artist' => 'xsd:string', 'albums' => 'tns:AlbumDataArray'),
		array('artist' => 'xsd:string', 'dataUsed' => 'xsd:boolean', 'message' => 'xsd:string'),
		$ns,
		"$action#postArtist",
		'rpc',
		'encoded',
		'Posts data of an artist and their discography.  Will create any missing album pages based on the data passed in.'
	);

	$server->register('postAlbum',
		array('overwriteIfExists' => 'xsd:boolean', 'artist' => 'xsd:string', 'album' => 'xsd:string',
				'year' => 'xsd:int', 'asin' => 'xsd:string', 'songs' => 'tns:ArrayOfstring'),
		array('artist' => 'xsd:string', 'album' => 'xsd:string', 'year' => 'xsd:int',
				'dataUsed' => 'xsd:boolean', 'message' => 'xsd:string'),
		$ns,
		"$action#postAlbum",
		'rpc',
		'encoded',
		'Posts data for a single album including its track-list and optionally the amazon ASIN'
	);

	$doc = 'Posts data for a single song.  If correcting exiting lyrics, ';
	$doc.= 'make sure overwriteIfExists is set to true.  In the onAlbums array, ';
	$doc.= 'if artist is left blank, it will default to the artist of the song.';
	$server->register('postSong',
		array('overwriteIfExists' => 'xsd:boolean', 'artist' => 'xsd:string', 'song' => 'xsd:string',
				'lyrics' => 'xsd:string', 'onAlbums' => 'tns:AlbumResultArray'),
		array('artist' => 'xsd:string', 'song' => 'xsd:string',
				'dataUsed' => 'xsd:boolean', 'message' => 'xsd:string'),
		$ns,
		"$action#postSong",
		'rpc',
		'encoded',
		$doc
	);
	$doc.= "For the flags parameter, this is a comma-separated list of flags. ";
	$doc.= "For example, pass 'LW_SANDBOX' in to use the sandbox for testing and not actually update the site.";
	$server->register('postSong_flags',
		array('overwriteIfExists' => 'xsd:boolean', 'artist' => 'xsd:string', 'song' => 'xsd:string',
				'lyrics' => 'xsd:string', 'onAlbums' => 'tns:AlbumResultArray', 'flags' => 'xsd:string'),
		array('artist' => 'xsd:string', 'song' => 'xsd:string',
				'dataUsed' => 'xsd:boolean', 'message' => 'xsd:string'),
		$ns,
		"$action#postSong_flags",
		'rpc',
		'encoded',
		$doc
	);
	///////// UPDATING METHODS - END /////////
	//////////////////////////////////////////////////////////////////////////////

	// Use the request to (try to) invoke the service
	$HTTP_RAW_POST_DATA = isset($HTTP_RAW_POST_DATA) ? $HTTP_RAW_POST_DATA : '';
	$server->service($HTTP_RAW_POST_DATA);

	// If the script took a long time to run, log it here.
	if($ENABLE_LOGGING_SLOW_SOAP){
		$scriptTime = (microtime(true) - $startTime);
		if($scriptTime >= $MIN_SECONDS_TO_LOG){
			$fileName = "lw_SOAP_log.txt";
			if(is_writable($fileName)){
				error_log(date("Y-m-d H:i:s")." - $scriptTime - ".$_SERVER['REQUEST_URI']."\n", 3, $fileName);
				ob_start();
				print_r($HTTP_RAW_POST_DATA);
				error_log(ob_get_clean(), 3, $fileName);
			} else {
				error_log("File not writable: \"$fileName\"", 1, "sean.colombo@gmail.com");
			}
		}
	}

} // end if(!$funcsOnly)




// THE FUNCTIONS USED BY THE WEBSERVICE ARE BELOW.
// THEY ARE INCLUDED REGARDLESS OF WHETHER LYRICWIKI_SOAP_FUNCS_ONLY IS DEFINED.




//////////////////////////////////////////
// SEARCH METHODS
function checkSongExists($artist, $song="") {
	$id = requestStarted(__METHOD__, "$artist|$song");

	$retVal = false;
	global $SHUT_DOWN_API;
	if($SHUT_DOWN_API){
		// There's really no good way to communicate through this message that the API is disabled.
		// If there has to be a failure case, it's probably(?) less damaging to have this be false.
		$retVal = false;
	} else {
		$title = lw_getTitle($artist,$song);
		$tempTitle = Title::newFromDBkey($title);
		if(isset($tempTitle)){
			$retVal = $tempTitle->exists();
		}
	}

	requestFinished($id);
	return new soapval('return','boolean',$retVal);
	//return ($retVal?"true":"false"); // for some reason when I was experimenting upgrading to 1.14, it complained about soapval not having a toString().  This removed the error, but I didn't get to test if the output was still correct.
}

////
// Given an artist to look for, returns a list of similarly named artists.
////
function searchArtists($searchString){
	$id = requestStarted(__METHOD__, "$searchString");
	$MAX_RESULTS = 10;
	$artist = rawurldecode($searchString);
	$retVal = array();

	// Trick to show debug output.  Just add the debugSuffix to the end of the searchString, and debug output will be displayed.
	$debug = false;$debugSuffix = "_debug";
	if((strlen($artist) >= strlen($debugSuffix)) && (substr($artist, (0-strlen($debugSuffix))) == $debugSuffix)){
		$artist = substr($artist, 0, (strlen($artist)-strlen($debugSuffix)));
		$debug = true;
	}
	$artist = lw_fmtArtist($artist);
	$artist = str_replace("'", "\'", $artist);

	print (!$debug?"":"Starting title: \"$artist\".\n");

	GLOBAL $SHUT_DOWN_API;
	if(!$SHUT_DOWN_API){
// TODO: THIS FUNCTION IS USELESS.. HAVE IT FOLLOW REDIRECTS, FIND CLOSE MATCHES, ETC.

		// If the string starts or ends with %'s, trim them off.
		if(strlen($artist) >= 1){
			while((strlen($artist >= 1)) && (substr($artist, 0, 1) == "%")){
				$artist = substr($artist, 1);
			}
			while((strlen($artist >= 1)) && (substr($artist, -1) == "%")){
				$artist = substr($artist, 0, (strlen($artist)-1) );
			}
			print (!$debug?"":"After trimming '%'s off: \"$artist\".\n");

			$db = lw_connect_readOnly();
			$queryString = "SELECT page_title FROM page WHERE page_namespace=0 AND page_title NOT LIKE '%:%' AND page_title LIKE '$artist' LIMIT $MAX_RESULTS";
			if($result = mysql_query($queryString, $db)){
				if(($numRows = mysql_num_rows($result)) && ($numRows > 0)){
					for($cnt=0; $cnt<$numRows; $cnt++){
						$retVal[] = mysql_result($result, $cnt, "page_title");
					}
				} else {
					print (!$debug?"":"No matches for page_title LIKE \"$artist\".\n");
				}
			} else {
				print (!$debug?"":"Error with query: \"$queryString\"\nmysql_error: ".mysql_error());
			}

			// If there were no results at all, look for some with a more liberal query (which takes WAY too long to execute).
			if(count($retVal) == 0){
			// TODO: Figure out a better query.  This one takes 15 seconds to run on the live server (400,000+ rows and a bunch of connections at a time: max-connections=100).
			// NOTE: Now that we have a Lucene Search server, there may be a way to query that for results.
		//		$db = lw_connect_readOnly();
		//		$queryString = "SELECT page_title FROM wiki_page WHERE page_namespace=0 AND page_title NOT LIKE '%:%' AND page_title LIKE '%$artist%' LIMIT $MAX_RESULTS";
		//		if($result = mysql_query($queryString, $db)){
		//			if(($numRows = mysql_num_rows($result)) && ($numRows > 0)){
		//				for($cnt=0; $cnt<$numRows; $cnt++){
		//					$retVal[] = mysql_result($result, $cnt, "page_title");
		//				}
		//			} else {
		//				print (!$debug?"":"No matches for page_title LIKE \"$artist\".\n");
		//			}
		//		} else {
		//			print (!$debug?"":"Error with query: \"$queryString\"\nmysql_error: ".mysql_error());
		//		}
			}
		}
	}

	requestFinished($id);
	return $retVal;
}

function searchAlbums($artist, $album, $year){
	$id = requestStarted(__METHOD__, "$artist|$album|$year");
	$retVal = array();
	$retVal[] = array('artist' => 'Pink Floyd', 'album' => 'Dark Side Of The Moon', 'year' => 1973);
	$retVal[] = array('artist' => 'P1Nk F10yd', 'album' => 'D4rk S1d3 0f T3h M00n', 'year' => 2006);
	
	GLOBAL $SHUT_DOWN_API;
	if(!$SHUT_DOWN_API){
		// TODO: IMPLEMENT
		// TODO: IMPLEMENT
	}
	
	requestFinished($id);
	return $retVal;
}

function searchSongs($artist, $song){ // TODO: IMPLEMENT
	$id = requestStarted(__METHOD__, "$artist|$song");
	$retVal = array('artist' => 'Beethoven', 'song' => 'Moonlight Sonata');
	
	GLOBAL $SHUT_DOWN_API;
	if(!$SHUT_DOWN_API){
	
		// TODO: IMPLEMENT
		// TODO: IMPLEMENT
	
	}

	requestFinished($id);
	return $retVal;
}

//////////////////////////////////////////
// FETCHING METHODS
function getSOTD(){
	$id = requestStarted(__METHOD__, "");

	$retVal = array();
	GLOBAL $SHUT_DOWN_API;
	if($SHUT_DOWN_API){
		global $SHUT_DOWN_API_REASON;
		$retVal['artist'] = "";
		$retVal['song'] = "";
		$retVal['nominatedBy'] = "";
		$retVal['reason'] = $SHUT_DOWN_API_REASON;
	} else {
		$matches = array();
		$sotdPage = lw_getPage("Template:Song_Of_The_Day");
		$nominatedBy = $reason = "";
		if(0 == preg_match("/'''Song:\s*\[\[([^\]]*)\]\]('''|<br.?>)/si", $sotdPage, $matches)){
			$matches[1] = ''; // TODO: RETURN AN ERROR.
		} else {
			$fullTitle = $matches[1];
		}
		if(0<preg_match("/'''Nominated By:\s*\[\[(.*?)\]\]/si", $sotdPage, $matches)){
			$nominatedBy = $matches[1];
			if($index = strpos($nominatedBy, "|")){
				$nominatedBy = substr($nominatedBy, 0, $index); // chop off the alias
			}
		}
		if(0<preg_match("/'''Reason:(''')?\s*(.*?)\s*<!-- SOTD END -->/si", $sotdPage, $matches)){
			$reason = $matches[2];
		}

		// Have to break up the artist and songname because getSong retuns the result in the same format it is given the data (to make verification easier).
		if($index = strpos($fullTitle,":")){
			$artist = substr($fullTitle, 0, $index);
			$song = substr($fullTitle, $index+1);
		} else {
			$artist = $fullTitle; // lw_getTitle can handle this regardless of format (even if it had a colon already).
			$song = "";
		}
		$retVal = getSong($artist, $song);
		$retVal['artist'] = str_replace("_", " ", $retVal['artist']);
		$retVal['song'] = str_replace("_", " ", $retVal['song']);
		$retVal['nominatedBy'] = str_replace("_", " ", $nominatedBy);
		$retVal['reason'] = $reason;
	}

	requestFinished($id);
	return $retVal;
}

function getSongResult($artist, $song){
	return getSong($artist,$song);
}
function getSong($artist, $song="", $doHyphens=true){
	$id = requestStarted(__METHOD__, "$artist|$song");
	$debug = false;$debugSuffix = "_debug";
	$artist = rawurldecode($artist);
	$song = rawurldecode($song);
	$origArtist = $artist; // for logging the failed requests, record the original name before we start messing with it
	$origSong = $song;
	$lookedFor = ""; // which titles we looked for.  Used in SOAP failures

	// Trick to show debug output.  Just add the debugSuffix to the end of the song name, and debug output will be displayed.
	if((strlen($song) >= strlen($debugSuffix)) && (substr($song, (0-strlen($debugSuffix))) == $debugSuffix)){
		// Testing the UTF8 issues with incoming values.
		print "ARTIST: $artist\n";
		print "ENCODE: ".utf8_encode($artist)."\n";
		print "DECODE: ".utf8_decode($artist)."\n";
		$song = substr($song, 0, (strlen($song)-strlen($debugSuffix)));
		$debug = true;
	}
	//GLOBAL $debug; // Do NOT do this.  This will effectively un-set the local var.
	if($debug){
		//print "Song: $song\n";
	}

	$artist = trim(html_entity_decode($artist));
	$song = trim(html_entity_decode($song));
	$artist = preg_replace("/(\s)+/", "\\1", $artist); // removes multiple spaces in a row
	$song = preg_replace("/(\s)+/", "\\1", $song);
	if($artist == "-"){ // surprisingly common.  If this is the artist, the whole artist and song tend to be in the song.
		$artist = "";
		$song = str_replace(" - ", ":", $song);
	}
	$defaultLyrics = "Not found";
	$defaultUrl = "http://lyrics.wikia.com";
	$urlRoot = "http://lyrics.wikia.com/"; // may differ from default URL, should contain a slash after it.
	$instrumental = "Instrumental";
	$DENIED_NOTICE = "Unfortunately, due to licensing restrictions from some of the major music publishers we can no longer return lyrics through the LyricWiki API (where this application gets some or all of its lyrics).\n";
	$DENIED_NOTICE.= "\nThe lyrics for this song can be found at the following URL:\n";
	$DENIED_NOTICE_SUFFIX = "\n\n\n(Please note: this is not the fault of the developer who created this application, but is a restriction imposed by the music publishers themselves.)";
	//$TRUNCATION_NOTICE = "Our licenses prevent us from returning the full lyrics to this song via the API.  For full lyrics, please visit: $urlRoot"."$artist:$song";
	$retVal = array('artist' => $artist, 'song' => $song, 'lyrics' => $defaultLyrics, 'url' => $defaultUrl);

	GLOBAL $SHUT_DOWN_API;
	if($SHUT_DOWN_API){
		$retVal = array('artist' => $artist, 'song' => $song, 'lyrics' => $defaultLyrics, 'url' => 'http://lyrics.wikia.com');
		global $SHUT_DOWN_API_REASON;
		$retVal['lyrics'] = $SHUT_DOWN_API_REASON;
	} else {
		// WARNING: This may cause some unexpected results if these artists ever become actual pages.
		// These are "artists" which are very commonly accuring non-artists.  IE: Baby Einstein is a collection of classical music, Apple Inc. is just apple's (video?) podcasts
		$nonArtists = array(
			"Baby Einstein", "Apple Inc.", "Soundtrack", "Various", "Various Artists", "The Howard Stern Show"
		);

		// The vast majority of failures come from players passing clearly-invalid requests - skip those.
		//if(($artist == "") && (0<preg_match("/^Track [0-9]+$/i", $song))){ // covered by the next IF anyway, so this has been removed.
			// NOTE: For now we leave the 'defaultLyrics' message for players that handle this explicitly as not being a match.
		//} else

		// Lots of files are getting requested for some reason.
		if(strlen($song) >= 4){
			$ending = strtolower(substr($song, -4));
			if(($ending == ".php") || ($ending == ".png")){
				$song = ""; // not a valid song.
			}
		}

		if((($artist=="") || ($song=="") || (0 < preg_match("/^\?+$/", $artist))) && (strpos("$artist$song", ":") === false)){
			// NOTE: For now we leave the 'defaultLyrics' message for players that handle this explicitly as not being a match.
		} else if(($song == "unknown") || (((strtolower($artist) == "unknown") || (strtolower($artist) == "artist")) && (strtolower($song) == "unknown")) || (0<preg_match("/^Track [0-9]+$/i", $song)) || (strtolower($song) == "favicon.png")){
			// If the song is "unkown" (all lowercase) this is usually just a default failure.  If they are looking for a song named "Unknown", and they use the caps, it will get through (unless the band name also happens to be "Unknown")

			// NOTE: For now we leave the 'defaultLyrics' message for players that handle this explicitly as not being a match.
		} else if(in_array($artist, $nonArtists)){
			// These are "artists" which are very commonly accuring non-artists.  IE: Baby Einstein is a collection of classical music, Apple Inc. is just apple's (video?) podcasts
			// NOTE: For now we leave the 'defaultLyrics' message for players that handle this explicitly as not being a match.
		} else {
			// Attempt to interpret hyphen-delimited title/artist/ablum strings correctly.
			$lastHyphen = false; // if this isn't false and there is no result, then the whole thing will be tried again using hyphenSong as the song.
			if($doHyphens){ // can be turned off so that a second pass can be made without this hyphen trick if it doesn't work the first time.
				$song = str_replace("_", " ", $song); // just so that we can use one strrpos on just one format
				$HYPHEN_DELIM = " - ";
				$lastHyphen = strrpos($song, $HYPHEN_DELIM);
				if($lastHyphen !== false){
					$hyphenSong = $origSong; // in case there are no responses, this will be fed back into the same function but with this hyphen trick turned off
					$song = substr($song, $lastHyphen+strlen($HYPHEN_DELIM));
					print (!$debug?"":"Hyphens trimmed to new title: \"$artist:$song\"\n");
				}
			}

			// Wiki technical-restrictions.  See: http://www.lyricwiki.org/LyricWiki:Page_names#Technical_Restrictions
			print (!$debug?"":"Before substitutions: \"$artist:$song\"\n");
			$transArray = array(
				"<" => "Less Than", // < is not a valid character in wiki titles.
				">" => "Greater Than", // < is not a valid character in wiki titles.
				"#" => "Number ", // note the trailing space
				"{" => "(",
				"}" => ")"
			);
			$song = strtr($song, $transArray);
			$artist = strtr($artist, $transArray);
			if(strpos($song, "[") !== false){
				$song = preg_replace("/\s*\[.*/i", "", $song);
			}
			if(strpos($artist, "[") !== false){
				$artist = preg_replace("/\s*\[.*/i", "", $artist);
			}
			print (!$debug?"":"After substitutions: \"$artist:$song\"\n");

			// Naming conventions. See: http://www.lyricwiki.org/LyricWiki:Page_names
			// Common contractions.  Our standards USE the contractions.
			$song = preg_replace("/Aint([^a-z]|$)/", "Ain't$1", $song);
			$song = preg_replace("/Dont([^a-z]|$)/", "Don't$1", $song);
			$song = preg_replace("/Cant([^a-z]|$)/", "Can't$1", $song);
			$artist = preg_replace("/Aint([^a-z]|$)/", "Ain't$1", $artist);
			$artist = preg_replace("/Dont([^a-z]|$)/", "Don't$1", $artist);
			$artist = preg_replace("/Cant([^a-z]|$)/", "Can't$1", $artist);


			// Strip the "featuring" artists.
			$index = strpos(strtolower($artist), " ft.");
			$index = ($index===false?strpos(strtolower($artist), " feat."):$index);
			$index = ($index===false?strpos(strtolower($artist), " featuring"):$index);
			$index = ($index===false?strpos(strtolower($artist), " ft "):$index);
			if($index !== false){
				$artist = substr($artist, 0, $index);
			}

			// Strip the "featuring" from song names - SWC 20070912
			$index = strpos(strtolower($song), " ft.");
			$index = ($index===false?strpos(strtolower($song), " feat."):$index);
			$index = ($index===false?strpos(strtolower($song), " featuring"):$index);
			$index = ($index===false?strpos(strtolower($song), " ft "):$index);
			if($index !== false){
				$song = substr($song, 0, $index);
			}

			// Format the title (flexible for variously formated inputs).
			$isUTF = utf8_compliant("$artist:$song");
			print (!$debug?"":"Formatting \"$artist:$song\"\n");
			print (!$debug?"":"utf8_compliant: ".utf8_compliant("$artist:$song")."\n");
			$title = lw_getTitle($artist, $song, (!$isUTF)); // if isUTF, skips the utf8 encoding (that is only for the values from the db... from the URL they should be fine already).
			print (!$debug?"":"utf8_compliant: ".utf8_compliant("$title")." - $title\n");
			print (!$debug?"":"Looking for \"$title\"\n");
			// If the song was not found... use some tricks to try to find it. - SWC 20061209
			if(!lw_pageExists($title)){
				$lookedFor .= "$title\n";
				print (!$debug?"":"Not found...\n");

				// If the artist has a redirect on their own page, that generally means that all songs belong to that finalized name...
				// so try to grab the song using that version of the artist's name.
				$artistTitle = lw_getTitle($artist); // leaves the original version in tact
				$finalName = $artistTitle;
				$page = lw_getPage($artistTitle, array(), $finalName, $debug);
				print (!$debug?"":"found:\n$page");
				if($finalName != $artistTitle){
					print (!$debug?"":"Artist redirect found to \"$finalName\". Applying to song \"$song\".\n");
					// TODO: FIXME: Would passing in the third parameter (applyEncoding=false) remove the need for utf8_decode?
					$title = utf8_decode(lw_getTitle($finalName, $song)); // decode is used to prevent double-encode calls that would otherwise happen.  I'm skeptical as to whether this would always work (assuming the special char was in the original title instead of the redirected artist as tested).
					print (!$debug?"":"Title \"$title\"\n");
				}

				// If the song was still not found... chop off any trailing parentheses and try again. - SWC 20070101
				if(!lw_pageExists($title)){
					$lookedFor .= "$title\n";
					print (!$debug?"":"$title not found.\n");
					$finalSong = preg_replace("/\s*\(.*$/", "", $song);
					if($song != $finalSong){
						$title = lw_getTitle($finalName, $finalSong);
						print (!$debug?"":"Looking without parentheses for \"$title\"\n");
					}
				} else {
					print (!$debug?"":"$title found.\n");
				}
			}
			$lookedFor .= "$title\n";
			if(lw_pageExists($title)){
				$finalName = "";
				$content = lw_getPage($title, array(), $finalName, $debug);

				// Parse the lyrics from the content.
				$matches = array();
				if(0<preg_match("/<lyrics?>(.*)<.lyrics?>/si", $content, $matches) || (0<preg_match("/<lyrics?>(.*)/si", $content, $matches))){
					$content = $matches[1]; // Grabs lyrics if they are inside of lyrics tags.
					// Sometimes when people convert to the new lyrics tags, they forget to delete the spaces at the beginning of the lines.
					if(0<preg_match("/(\n [^\n]*)+/si", $content, $matches)){
						//$content = $matches[0];
						$content = str_replace("\n ", "\n", $content);
					}

					// In case the page uses the instrumental template but uses it inside of lyrics tags.
					if(0<preg_match("/\{\{instrumental\}\}/si", $content, $matches)){
						$content = $instrumental;
					}
				} else if(0<preg_match("/(\n [^\n]*)+/si", $content, $matches)){
					$content = $matches[0]; // Grabs lyrics if they use the space-at-the-beginning-of-the-line format.
					$content = str_replace("\n ", "\n", $content);
				} else if(0<preg_match("/\{\{instrumental\}\}/si", $content, $matches)){
					$content = $instrumental;
				} else if(strlen(trim($content)) > 0){
					// TODO: Log the page which didn't parse here for purposes of fixing poorly formatted pages.
				}
				$content = trim($content);
				$url = $urlRoot.str_replace("%3A", ":", urlencode($finalName)); // %3A as ":" is for readability.
				$retVal = array('artist' => $artist, 'song' => $song, 'lyrics' => $content, 'url' => $url);

				// Set the artist and song to the artist and song which were actually found (not what was passed in).
				$index = strpos($finalName, ":");
				if($index !== false){
					$retVal['artist'] = str_replace("_", " ", substr($finalName, 0, $index));
					$retVal['song'] = str_replace("_", " ", substr($finalName, ($index+1)));
				}
			}
			if(($retVal['lyrics'] == '') || ($retVal['lyrics'] == $defaultLyrics)){
				$url = $urlRoot."index.php?title=".str_replace("%3A", ":", urlencode($title)); // %3A as ":" is for readability.
				$retVal['url'] = "$url&amp;action=edit";
				$retVal['artist'] = $origArtist;
				$retVal['song'] = $origSong;

				// Log the looked-for-but-not-found lyrics here.  Make sure the logging keeps track of the total number of times
				// a song was looked for so that we can find the most desired lyrics and fill them in.
				$origArtistSql = str_replace("'", "\'", $origArtist);
				$origSongSql = str_replace("'", "\'", $origSong);
				$lookedForSql = str_replace("'", "\'", trim($lookedFor)); // \n-delimited list of titles looked for by the API which weren't found.

				// This section doesn't appear to do anything at the moment.  The artist and title still have bad-encoding even though lookedFor is encoded properly (lookedFor is a blob - does that matter?).
				if(!utf8_compliant("$origArtistSql")){
					$origArtistSql = utf8_encode($origArtistSql);
				}
				if(!utf8_compliant("$origSongSql")){
					$origSongSql = utf8_encode($origSongSql);
				}

				logSoapFailure($origArtistSql, $origSongSql, $lookedForSql);

				$resultFound = false;
			} else {
				$resultFound = true;
			}
			if(($resultFound === false) && ($lastHyphen !== false)){
				print (!$debug?"":"Trying again but assuming hyphens are part of the song name...\n");
				$retVal = getSong($origArtist, $hyphenSong, false); // the false stops the hyphen trick from being tried again
			} else {
				// Take the results and figure out if a result was served.  Log this to get a good percentage of how many requests are made and what percentage are handled.
				if(!$SHUT_DOWN_API){
					// SWC 20090501 - Shut this down to reduce database load.  I don't generally track the success rate right now, so it's pretty flat around 50%.
					// Can re-enable this later if we actually start paying attention to this again.
					//require_once "soap_stats.php"; // for tracking success/failure
					//lw_soapStats_logHit($resultFound);
				}

				// SWC 20090802 - Neuter the actual lyrics :( - return an explanation with a link to the LyricWiki page.
				// SWC 20091021 - Gil has determined that up to 17% of the lyrics can be returned as fair-use - we'll stick with 1/7th (about 14.3%) of the characters for safety.
				if(($retVal['lyrics'] != $defaultLyrics) && ($retVal['lyrics'] != $instrumental) && ($retVal['lyrics'] != "")){
					$urlLink = "\n\n<a href='".$retVal['url']."'>".$retVal['artist'].":".$retVal['song']."</a>";
					$lyrics = $retVal['lyrics'];

					if(strlen($lyrics) < 50){
						$lyrics = "";
					} else {
						$lyrics = mb_substr($lyrics, 0, max(0, round(strlen($lyrics) / 7)), 'UTF-8') . "[...]";
					}
					//$lyrics .= "\n\n\n\n$TRUNCATION_NOTICE".$retVal['url']."$urlLink"; // we'll let apps decide how to handle this.

					// We now return the truncated version instead of just a flat-out denial.
					$retVal['lyrics'] = $lyrics;
					//$retVal['lyrics'] = $DENIED_NOTICE . $retVal['url'] . $urlLink . $DENIED_NOTICE_SUFFIX;
				}

				// Make encoding work with UTF8 - NOTE: We do not apply this again to a result that the doHyphens/lastHyphen trick grabbed because that has already been encoded..
				$retVal['artist'] = utf8_encode($retVal['artist']);
				$retVal['song'] = utf8_encode($retVal['song']);
				$retVal['lyrics'] = utf8_encode($retVal['lyrics']);
				if(isset($_GET['test']) && $_GET['test']=="encoding"){
					$isUTF = utf8_compliant("$artist:$song:$lyrics");
					print "UTF8: ".($isUTF?"true":"false")."<br/>";
					print "UTF8-artist: ".(utf8_compliant($artist)?"true":"false")."<br/>";
					print "UTF8-song: ".(utf8_compliant($song)?"true":"false")."<br/>";
					print "UTF8-lyrics: ".(utf8_compliant($lyrics)?"true":"false")."<br/>";
				}
			}
		}
	} // end of the "if shut_down_api else"

	requestFinished($id);
	return $retVal;
} // end getSong()

////
// Returns the discography for an artist broken up into albums.
////
function getArtist($artist){
	$id = requestStarted(__METHOD__, "$artist");
	// For now the regex makes it only read the first disc and ignore beyond that (since it assumes the track listing is over).
	$albums = array();
	GLOBAL $amazonRoot;

	$debug = false;
	$debugSuffix = "_debug";
	if((strlen($artist) >= strlen($debugSuffix)) && (substr($artist, (0-strlen($debugSuffix))) == $debugSuffix)){
		$artist = substr($artist, 0, (strlen($artist)-strlen($debugSuffix)));
		$debug = true;
	} else {
		$debugSuffix = " debug";
		if((strlen($artist) >= strlen($debugSuffix)) && (substr($artist, (0-strlen($debugSuffix))) == $debugSuffix)){
			$artist = substr($artist, 0, (strlen($artist)-strlen($debugSuffix)));
			$debug = true;
		}
	}

	$artist = rawurldecode($artist);
	$isUTF = utf8_compliant("$artist");
	$title = lw_getTitle($artist, '', (!$isUTF)); // if isUTF, skips the utf8 encoding (that is only for the values from the db... from the URL they should be fine already).

	GLOBAL $SHUT_DOWN_API;
	$correctArtist = $artist; // this will be overwritten (by reference) in lw_getPage().
	if((!$SHUT_DOWN_API) && lw_pageExists($title)){
		$content = lw_getPage($title, array(), $correctArtist, $debug);
		$albums = parseDiscographies($content, $correctArtist);
		if($debug){
			$albums[] = array(
				"album" => "Raw Wikitext",
				"year" => 2008,
				"amazonLink" => "http://www.amazon.com",
				"songs" => array($content)
			);
		}
	}

	$correctArtist = str_replace("_", " ", $correctArtist);
	$retVal = array('artist' => $correctArtist, 'albums' => $albums);

	// Make encoding work with UTF8.
	$isUTF = utf8_compliant("$correctArtist");
	if($isUTF === false){
		$retVal['artist'] = utf8_encode($retVal['artist']);
	}

	requestFinished($id);
	return $retVal;
} // end getArtist()

////
// Given the wikitext from an artist page, parse out the discographies and return them
// as an array of albums.
//
// This has been extracted from the getArtist function so that it can be tested on its own
// by runTests.php
//
// Current implementation was done by Stefan Fussenegger stf@molindo.at
////
function parseDiscographies($content, $correctArtist){
	$albums = array();

	$lines = explode("\n", $content);
	$headingStack = array();

	for ($i = 0; $i < count($lines); $i++) {
		$lines[$i] = trim($lines[$i]);
		$line =& $lines[$i];
		$heading = lw_getHeadingFromLine($line);
		if (is_array($heading)) {
			lw_pushHeading($headingStack, $heading, $albums, $correctArtist);
		} else if ((strlen($line) > 0) && ($line{0} == "#" || $line{0} == "*")) {
			$link = lw_getLinkFromLine($line);
			if (is_array($link)) {
				lw_pushSong($headingStack, $link, $correctArtist);
			}
		} else {
			//echo "ignoring '$line'\n";
		}
	}

	// clear stack
	for ($i = 0; $i < count($headingStack); $i++) {
		lw_pushAlbum($headingStack[$i], $albums);
	}

	return $albums;
} // end parseDiscographies()

////
// starts with '={2,5}' and ends with '={2,5}'
//
// returns array, with level in array[0] and name in array[1]
////
function lw_getHeadingFromLine(&$line) {
	if (strlen($line) == 0 || $line{0} != "=") {
		// performance
		return NULL;
	}

	$matches = array();
	if (preg_match('/^(={2,5})(.*)={2,5}$/', $line, $matches) > 0) {
		return array(
			'level' => strlen($matches[1])-1,
			'heading' => &$matches[2]
		);
	} else {
		return NULL;
	}
} // end lw_getHeadingFromLine()

////
// looking for internal links with a ':'
// [[artist:song]]
// [[artist:song|something]]
//
////
function lw_getLinkFromLine(&$line) {
	$matches = array();
	if (preg_match('/\[\[([^:\]]+):([^\]|]+)(\|([^\]]*))?\]\]/S', $line, $matches) > 0) {
		return array(
			'artist' => &$matches[1],
			'song' => &$matches[2]
			//'linkLabel' => (!empty($matches[4]) ? $matches[4] : $matches[2])
		);
	} else {
		return NULL;
	}
} // end lw_getLinkFromLine()

////
// add a new heading, where heading is an array with 'level' and 'heading'. pop all headings from stack
// with lower or equal level and add these as album
////
function lw_pushHeading(&$headingStack, &$heading, &$albums, &$artist) {
	$size = count($headingStack);
	while (($size = count($headingStack)) > 0 && $headingStack[$size-1]['level'] >= $heading['level']) {
		lw_pushAlbum(array_pop($headingStack), $albums);
	}

	$link = lw_getLinkFromLine($heading['heading']);
	$hasLink = is_array($link);

	if ($hasLink || $size == 0) {
		$headingStack[] = array (
			'level' => $heading['level'],
			'artistName' => $hasLink ? $link['artist'] : $artist,
		 	'albumName' => $hasLink ? $link['song'] : $heading['heading'],
			'songs' => array()
		);
	}
} // end lw_pushHeading()

////
// add new album from heading, ignore headings without songs
////
function lw_pushAlbum(&$heading, &$albums) {
	global $amazonRoot;

	if (count($heading['songs'])) {
		$albumName =& $heading['albumName'];

		$yearMatches = array();
		if(0<preg_match("/ \(([0-9\?]{4})\)$/si", $albumName, $yearMatches)){
			$year = $yearMatches[1];
			$albumName = substr($albumName, 0, (strlen($albumName)-strlen(" (YYYY)")));
		}

		$albums[] = array(
			'album' => &$albumName,
			'year' => &$year,
			'amazonLink' => $amazonRoot.str_replace(" ", "%20", $heading['artistName']." ".$heading['albumName']),
			'songs' => &$heading['songs']
		);
	}
} // end lw_pushAlbum()

////
// add new song to last heading in stack
////
function lw_pushSong(&$headingStack, &$song, &$artist) {
	if (($size = count($headingStack)) > 0) {
		$foundArtist = trim(str_replace("_", " ", $song['artist']));
		$title = trim(str_replace("_", " ", $song['song']));

		if(strcasecmp($foundArtist, str_replace("_", " ", $artist)) !== 0){
			$title = "$foundArtist:$title";
		}

		$headingStack[$size-1]['songs'][] =& $title;
	}
} // end lw_pushSong()

////
// Given the chunks of wikitext returned from regexes for the album names and track-listing code,
// returns the albums that were found.
////
function lw_getTracksFromWikiText($artist, $albumNames, $listing){
	GLOBAL $amazonRoot;
	$albums = array();
	$artist = str_replace("_", " ", $artist);

	// Process each album
	for($cnt=0; $cnt<count($albumNames); $cnt++){
		$currName = str_replace("_", " ", $albumNames[$cnt]);

		if(false !== ($index = strrpos($currName, ":"))){
			$foundArtist = substr($currName, 0, $index);
			$albumName = substr($currName, $index+1);
		} else {
			$foundArtist = "";
			$albumName = $currName;
		}
		$year = 0;
		$yearMatches = array();
		if(0<preg_match("/ \(([0-9\?]{4})\)$/si", $albumName, $yearMatches)){
			$year = $yearMatches[1];
			$albumName = substr($albumName, 0, (strlen($albumName)-strlen(" (YYYY)")));
		}

		// Special case for "Other Songs" section.
		if($albumName == ""){$albumName = "Other Songs";}
		if($year == 0){$year = "";}

		$currAlbum = array();
		$currAlbum['album'] = $albumName;
		$currAlbum['year'] = $year;
		$currAlbum['amazonLink'] = $amazonRoot.str_replace(" ", "%20", "$foundArtist $albumName");
		$tracks = array();
		$trackCode = $listing[$cnt];
		$trackMatches = array();
		if(0<preg_match_all("/\[\[(.*?):(.*?)(\||\]\])/", $trackCode, $trackMatches)){
			$trackArtists = $trackMatches[1];
			$trackTitles = $trackMatches[2];
			for($index=0; $index<count($trackTitles); $index++){
				$foundArtist = str_replace("_", " ", $trackArtists[$index]);
				$title = $trackTitles[$index];
				if(strtolower($foundArtist) != strtolower($artist)){
					$title = "$foundArtist:$title";
				}
				$tracks[] = trim(str_replace("_", " ", $title));
			}
		}
		$currAlbum['songs'] = $tracks;
		$albums[] = $currAlbum;
	}

	return $albums;
} // end lw_getTracksFromWikiText()

function getAlbum($artist){ // TODO: IMPLEMENT - UM... THIS DOESN'T LOOK LIKE IT HAS ENOUGH PARAMETERS YET.
	$id = requestStarted(__METHOD__, "$artist");
	$link = "http://www.amazon.com/exec/obidos/redirect?link_code=ur2&tag=motiveforcell-20&camp=1789&creative=9325&path=http%3A%2F%2Fwww.amazon.com%2Fgp%2Fproduct%2FB0009X777W%2Fsr%3D8-1%2Fqid%3D1147400297%2Fref%3Dpd_bbs_1%3F%255Fencoding%3DUTF8";
	$songs = array('Run Away', 'Right Here', 'Paper Jesus', 'Schizophrenic Conversations',
					'Falling', 'Cross To Bear', 'Devil', 'Please', 'Everything Changes',
					'Take This', 'King Of All Excuses', 'Reply');

	// TODO: If album page doesn't exist, search the artist page for that album.

	$retVal = array('artist' => 'Staind', 'album' => 'Chapter V', 'year' => 2005, 'amazonLink' => $link, 'songs' => $songs);
	
	GLOBAL $SHUT_DOWN_API;
	if(!$SHUT_DOWN_API){
		// TODO: IMPLEMENT
		// TODO: IMPLEMENT
	}

	requestFinished($id);
	return $retVal;
} // end getAlbum(...)

////
// Gets the hometown for an artist.
////
function getHometown($artist){
	$id = requestStarted(__METHOD__, "$artist");
	$country = $state = $hometown = "";
	$artist = rawurldecode($artist);

	// Figure out if this is debug mode.
	$debug = false;$debugSuffix = "_debug";
	if((strlen($artist) >= strlen($debugSuffix)) && (substr($artist, (0-strlen($debugSuffix))) == $debugSuffix)){
		$artist = substr($artist, 0, (strlen($artist)-strlen($debugSuffix)));
		print "ARTIST: $artist\n";
		$debug = true;
	}

	$artist = trim(html_entity_decode($artist));
	$isUTF = utf8_compliant("$artist");
	GLOBAL $SHUT_DOWN_API;
	if(!$SHUT_DOWN_API){
		print (!$debug?"":"Formatting \"$artist\"\n");
		print (!$debug?"":"utf8_compliant: ".utf8_compliant("$artist")."\n");
		$title = lw_getTitle($artist, "", (!$isUTF)); // if isUTF, skips the utf8 encoding (that is only for the values from the db... from the URL they should be fine already).
		print (!$debug?"":"utf8_compliant: ".utf8_compliant("$title")." - $title\n");
		print (!$debug?"":"Looking for \"$title\"\n");
		$finalName = "";
		if(lw_pageExists($title)){
			$page = lw_getPage($title, array(), $finalName, $debug);

			$matches = array();
			if(0 < preg_match("/\{\{Hometown[\s*\|]+country\s*=\s*([a-z _]*)[\s*\|]+state\s*=\s*([a-z _]*)[\s*\|]+hometown\s*=\s*([a-z _]*)/is", $page, $matches)){
				$country = $matches[1];
				$state = $matches[2];
				$hometown = $matches[3];
			} else if(0 < preg_match("/\|\s*country\s*=\s*([a-z _]*)[\s*\|]+state\s*=\s*([a-z _]*)[\s*\|]+hometown\s*=\s*([a-z _]*)/is", $page, $matches)){
				$country = $matches[1];
				$state = $matches[2];
				$hometown = $matches[3];
			}
		}
	}

	$retVal = array('country' => $country, 'state' => $state, 'hometown' => $hometown);
	requestFinished($id);
	return $retVal;
} // end getHometown(..)

//////////////////////////////////////////
// POSTING FUNCTIONS
function postArtist($overwriteIfExists, $artist, $albums){ // TODO: IMPLEMENT
	ob_start();
	print_r($albums);
	$albumStr = ob_get_clean();
	$id = requestStarted(__METHOD__, $overwriteIfExists?"overwrite":"no-overwrite"."$artist|$albumStr");

	$retVal = array('artist' => $artist, 'dataUsed' => false,
					'message' => 'Not implemented yet.  This would give info on whether some of the data, none, or all of it was used');

	global $SHUT_DOWN_API;
	if($SHUT_DOWN_API){
		global $SHUT_DOWN_API_REASON;
		$retVal['message'] = $SHUT_DOWN_API_REASON;
	} else {
		lw_tryLogin();

		$artistName = lw_getTitle($artist);
		$pageTitle = Title::newFromDBkey(utf8_decode(htmlspecialchars_decode($artistName)));
		$pageExists = $pageTitle && $pageTitle->exists(); // call here and store the result to check after page is created to determine if it was an overwrite
		if($pageExists){

			// TODO: REMOVE
			if(false){

			$currData = getArtist($artist);
			$currAlbums = $currData['albums'];
			$content = lw_getPage($artistName);

			// Find the appropriate place chronologically for the album and insert it.
			for($cnt=0; $cnt<count($albums); $cnt++){
				$activeAlbum = $albums[$cnt]; // the album we are going to insert
				$activeAlbum = $activeAlbum['albums']; // weird side-effect... every album is wrapped in an 'albums' array.
				if(strtolower($activeAlbum['album'])=="other songs"){
					$activeAlbum['year'] = 0;
				}

		/*if($artist == "Sahara Hotnights"){
			print "Active album:\n";
			print_r($activeAlbum);
			print "\nAll albums:\n";
			print_r($albums);
		}
		print (($artist!="Sahara Hotnights")?"":"Active album: *".$activeAlbum['album']."*\n");
		*/
				// Find correct order to insert in.
				$insertBefore = -1;
				$doneAdding = false;
				for($index=0; $index<count($currAlbums); $index++){
					$comparisonAlbum = $currAlbums[$index];
					if(($activeAlbum['year'] < $comparisonAlbum['year']) && (strtolower($activeAlbum['album']) != "other songs")){
						$insertBefore = $index;
						$index = count($currAlbums); // stop looping
					} else if($activeAlbum['year'] == $comparisonAlbum['year']){
						if(strtolower($activeAlbum['album']) == strtolower($comparisonAlbum['album'])){
							// Album already exists, just merge the track listings.
							$doneAdding = true; // album already exists, don't add whole album to the code
							$additionalTracks = array();
							$tracks = $activeAlbum['songs'];
							$tracksFound = $comparisonAlbum['songs'];

							foreach($tracks as $currTrack){
								$found = false;
								for($trackNum=0; (($trackNum<count($tracksFound)) && (!$found)); $trackNum++){
									if($currTrack == $tracksFound[$trackNum]){
										$found = true;
									}
								}
								if(!$found){
									$additionalTracks[] = $currTrack;
								}
							}

							// If there were extra tracks, add them to the end of the track listing
							if(count($additionalTracks) > 0){
								$wikiCode = lw_tracksToWiki($artistName, $additionalTracks);
								$wikiCode = trim($wikiCode);
								$albumName = $comparisonAlbum['album'];
								$albumYear = $comparisonAlbum['year'];
								$albumName = str_replace(" ", "_", $albumName);
								$albumName = str_replace("_", "[_ ]", $albumName);
								$artistReg = str_replace(" ", "_", $artistName);
								$artistReg = str_replace("_", "[_ ]", $artistReg);
								if(strtolower($activeAlbum['album']) == "other songs"){
		//print (($artist!="Sahara Hotnights")?"":"Other songs merged\n");
									$content = preg_replace("/(==\s*\[\[$artistReg:$albumName(\|.*?\]\]|\]\])\s*==\s*.*?)(\n[^#*{])/si", "$1\n$wikiCode$3",$content);
								} else {
		//print (($artist!="Sahara Hotnights")?"":"Normal album merged\n");
									$content = preg_replace("/(==\s*\[\[$artistReg:$albumName"."[_ ]\($albumYear\)(\|.*?\]\]|\]\])\s*==\s*.*?)(\n[^#*{])/si", "$1\n$wikiCode$3",$content);
								}
							}
						}
					}
				}

				// Search for a match in the code of where this album goes.
				if(!$doneAdding){
		//print (($artist!="Sahara Hotnights")?"":"Still looking for album\n");
					if($insertBefore == -1){
		//print (($artist!="Sahara Hotnights")?"":"Album goes at end\n");
						// Insert after the last album (if there is an Other Songs album, do it before that but after the last real album).
						$wikiCode = lw_albumDataToWiki($artist, $activeAlbum);
						if(count($currAlbums) > 0){
							$lastAlbum = $currAlbums[count($currAlbums)-1];
							if((strtolower($lastAlbum['album']) == "other songs") && (count($currAlbums) > 1)){
								$lastAlbum = $currAlbums[count($currAlbums)-2]; // put new album after last REAL album.
							}
							$lastAlbumName = $lastAlbum['album'];
							$lastAlbumYear = $lastAlbum['year'];

							$wikiCode = trim($wikiCode)."\n"; // only needs one new line-break, not the traditional two
							$lastAlbumName = str_replace(" ", "_", $lastAlbumName);
							$lastAlbumName = str_replace("_", "[_ ]", $lastAlbumName);
							$artistReg = str_replace(" ", "_", $artistName);
							$artistReg = str_replace("_", "[_ ]", $artistReg);
							$content = preg_replace("/(==\s*\[\[$artistReg:$lastAlbumName"."[_ ]\($lastAlbumYear\)(\|.*?\]\]|\]\])\s*==\s*.*?\n[^#*{])/si", "$1$wikiCode",$content);
						} else {
		//print (($artist!="Sahara Hotnights")?"":"No albums existed\n");
							$content = $wikiCode.$content; // if there were no albums yet, just throw the new album on the beginning.
						}
					} else {
		//print (($artist!="Sahara Hotnights")?"":"Album goes before $insertBefore\n");
						$beforeAlbum = $currAlbums[$insertBefore]['album'];
						$beforeYear = $currAlbums[$insertBefore]['year'];
						$albumWiki = lw_albumDataToWiki($artist, $activeAlbum);
						$origContent = $content;
						$beforeAlbum = str_replace(" ", "_", $beforeAlbum);
						$beforeAlbum = str_replace("_", "[_ ]", $beforeAlbum);
						$artistReg = str_replace(" ", "_", $artistName);
						$artistReg = str_replace("_", "[_ ]", $artistReg);
						$content = preg_replace("/(==\s*\[\[$artistReg:$beforeAlbum"."[_ ]\($beforeYear\))/si", "$albumWiki$1", $content);
						if($origContent == $content){
		//print (($artist!="Sahara Hotnights")?"":"That didn't work... just throwing on top.\n");
							// Couldn't find place... stuff it at top of the file to minimize damage; a human can sort it out later.
							$content = $albumWiki.$content;
						}
					}
				}
			}


		// TODO: OMG REMOVE!
		/*if($artist == "Sahara Hotnights"){
			print "Exiting because this is a test.\n";
			exit;
		}*/


			// Send the updated code here.
			$content = "[[Category:Review_Me]]\n".$content; // TODO: REMOVE AFTER UBERBOT SUBMISSIONS
			$summary = "Page ".(($pageExists)?"edited":"created")." using [[LyricWiki:SOAP|LyricWiki's SOAP Webservice]]";
			$returnStr = lw_createPage($pageTitle, $content, $summary);
			$retVal['dataUsed'] = true;
			if(isset($pageTitle) && $pageExists){
				$retVal['message'] = "Page overwritten. ".($returnStr==""?"":"($returnStr)");
			} else {
				$retVal['message'] = "Page created. ".($returnStr==""?"":"($returnStr)");
			}
			}
		} else {
			// The artist page doesn't exist yet... create it.
			$content = "";
			$content.= "[[Category:Review_Me]]\n"; // TODO: REMOVE AFTER UBERBOT SUBMISSIONS
			$content.= "{{Wikipedia}}\n\n";

			// Build the page-content.
			foreach($albums as $albumWrapper){
				$currAlbum = $albumWrapper['albums']; // weird side-effect... every album is wrapped in an 'albums' array.
				$content .= lw_albumDataToWiki($currAlbum);
			}
			$content.= "{{Artist}}\n\n";
			$fLetter = lw_fLetter($artistName);
			$content.= "[[Category:Artists $fLetter]]\n";

			$summary = "Page ".(($pageExists)?"edited":"created")." using [[LyricWiki:SOAP|LyricWiki's SOAP Webservice]]";
			$returnStr = lw_createPage($pageTitle, $content, $summary);

			$retVal['dataUsed'] = true;
			if(isset($pageTitle) && $pageExists){
				$retVal['message'] = "Page overwritten. ".($returnStr==""?"":"($returnStr)");
			} else {
				$retVal['message'] = "Page created. ".($returnStr==""?"":"($returnStr)");
			}

			// Also create pages for all of the albums that appeared on this page.
			$numUsed = $numSkipped = 0;
			foreach($albums as $albumWrapper){
				$currAlbum = $albumWrapper['albums'];
				$albumName = $currAlbum['album'];
				$year = $currAlbum['year'];
				$asin = $currAlbum['amazonLink'];
				$songs = $currAlbum['songs'];
				$albumResponse = postAlbum($overwriteIfExists, $artistName, $albumName, $year, $asin, $songs);
				if($albumResponse['dataUsed']){
					$numUsed++;
				} else {
					$numSkipped++;
				}
			}
			if(($numUsed>0) || ($numSkipped>0)){
				$retVal['message'] .= " - album pages: $numUsed made, $numSkipped skipped";
			}
		}
	}

	requestFinished($id);
	return $retVal;
} // end postArtist()

////
//
////
function postAlbum($overwriteIfExists, $artist, $album, $year, $asin, $songs){
	ob_start();
	print_r($songs);
	$songsStr = ob_get_clean();
	$id = requestStarted(__METHOD__, $overwriteIfExists?"overwrite":"no-overwrite"."$artist|$album|$year|$asin|$songsStr");

	$retVal = array('artist' => $artist, 'album' => $album, 'year' => $year, 'dataUsed' => false,
					'message' => 'Default message.  There must have been an error during processing.  Please report this.');
	
	global $SHUT_DOWN_API;
	if($SHUT_DOWN_API){
		global $SHUT_DOWN_API_REASON;
		$retVal['message'] = $SHUT_DOWN_API_REASON;
	} else {
		lw_tryLogin();
		$isOther = false;
		if(strtolower($album) == "other songs"){
			$isOther = true;
			$title = lw_fmtArtist($artist).":Other Songs";
		} else {
			$title = lw_getTitle($artist,$album);
			$title.= " ($year)";
		}
		$pageTitle = Title::newFromDBkey(utf8_decode(htmlspecialchars_decode($title)));
		$pageExists = $pageTitle->exists(); // call here and store the result to check after page is created to determine if it was an overwrite
		if(isset($pageTitle) && $pageExists && (!$overwriteIfExists)){
			$retVal['dataUsed'] = false;
			$retVal['message'] = "Album already exists and overwriteIfExists was not set to true.";
		} else {
			$content = "";
			$content.= "[[Category:Review_Me]]\n"; // TODO: REMOVE AFTER UBERBOT SUBMISSIONS
			$artistName = lw_fmtArtist($artist);
			$albumName = lw_fmtAlbum($album, $year);
			$fLetter = lw_fLetter($album);

			// Build the page-content.
			if($isOther){
				$content .= "{{OtherSongs|$artist}}\n\n";
			} else {
				$content .= "{{Album|\n";
				$content .= "|fLetter     = $fLetter\n";
				$content .= "|Artist      = $artist\n";
				$content .= "|Album       = $album\n";
				$content .= "|Released    = $year\n";
				$content .= "|Genre       = \n";
				$content .= "|Cover       = \n";
				$content .= "|Length      = \n";
				$content .= "}}\n\n";
			}
			foreach($songs as $currSong){
				// If no artist is specified, default to the artist who makes the album.
				// This makes most cases easy and allows overriding of artist for compilations, etc.
				if(false === strpos($currSong, ":")){
					$currSong = "$artist:$currSong";
				}
				$justSong = $currSong;
				if($index = strrpos($currSong, ":")){
					$justSong = substr($currSong, $index+1);
				}
				$content .= "# '''[[$currSong|$justSong]]'''\n";
			}
			$content .= "<div style=\"clear:both;\"></div>\n";
			if($isOther === false){
				$content .= "==External Links==\n";
				if(0<preg_match("/^[0-9A-Z]{10}$/i", $asin)){
					$content .= "* {{asin|$asin|$album}} on Amazon\n";
				} else {
					$content .= "*Search for {{Search Amazon||$album}} on Amazon\n";
				}
			}
			$summary = "Page ".(($pageExists)?"edited":"created")." using [[LyricWiki:SOAP|LyricWiki's SOAP Webservice]]";
			$returnStr = lw_createPage($pageTitle, $content, $summary);

			$retVal['dataUsed'] = true;
			if(isset($pageTitle) && $pageExists){
				$retVal['message'] = "Page overwritten. ".($returnStr==""?"":"($returnStr)");
			} else {
				$retVal['message'] = "Page created. ".($returnStr==""?"":"($returnStr)");
			}
		}
	}

	requestFinished($id);
	return $retVal;
} // end postAlbum()

function postSong_flags($overwriteIfExists, $artist, $song, $lyrics, $onAlbums, $flags=""){return postSong($overwriteIfExists, $artist, $song, $lyrics, $onAlbums, $flags);}
function postSong($overwriteIfExists, $artist, $song, $lyrics, $onAlbums, $flags=""){
	ob_start();
	print_r($onAlbums);
	$albumStr = ob_get_clean();
	$id = requestStarted(__METHOD__, $overwriteIfExists?"overwrite":"no-overwrite"."$artist|$song|$albumStr|$flags|LYRICS[$lyrics]");

	$retVal = array('artist' => $artist, 'song' => $song, 'dataUsed' => false,
					'message' => 'Default message.  There must have been an error during processing.  Please report this.');

	global $SHUT_DOWN_API;
	if($SHUT_DOWN_API){
		global $SHUT_DOWN_API_REASON;
		$retVal['message'] = $SHUT_DOWN_API_REASON;
	} else {
		lw_tryLogin();

		// Flags is a comma-delimited list of pre-defined strings.
		$flags = strtoupper(str_replace(" ", "", ",$flags,"));
		$isSandbox = (false !== strpos($flags, ",LW_SANDBOX,"));
		$isKompoz = (false !== strpos($flags, ",LW_KOMPOZ,"));

		$title = lw_getTitle($artist,$song);
		$pageTitle = Title::newFromDBkey(utf8_decode(htmlspecialchars_decode($title)));
		$pageExists = (is_object($pageTitle) && $pageTitle->exists()); // call here and store the result to check after page is created to determine if it was an overwrite
		if(isset($pageTitle) && $pageExists && (!$overwriteIfExists)){
			$retVal['dataUsed'] = false;
			$retVal['message'] = "Song already exists and overwriteIfExists was not set to true.";
		} else {
			$content = '';
			$content.= "[[Category:Review_Me]]\n"; // TODO: REMOVE AFTER UBERBOT SUBMISSIONS
			$artistName = lw_fmtArtist($artist);
			$songName = lw_fmtSong($song);
			$albumName = '';
			if(is_array($onAlbums) && (count($onAlbums) > 0)){ // will show up as an empty string if song is not on any albums
				for($cnt=0; $cnt<count($onAlbums); $cnt++){
					$currArtist = $onAlbums[$cnt]['artist']; // needed because of compilations
					$currArtist = ($currArtist==""?$artist:$currArtist); // default to artist of this song.
					$albumName = $onAlbums[$cnt]['album']." (".$onAlbums[$cnt]['year'].")";
					$content .= "{{Song|$albumName|$currArtist}}\n";
				}
			} else {
				$content .= "{{Song||".str_replace("_", " ", $artistName)."}}\n";
			}
			$content .= "<lyrics>\n$lyrics</lyrics>\n";
			$fLetter = lw_fLetter($song);
			$content .= "{{SongFooter\n|artist=$artist\n|song=$song\n|fLetter=".$fLetter."\n}}";
			$summary = "Page ".(($pageExists)?"edited":"created")." using [[LyricWiki:SOAP|LyricWiki's SOAP Webservice]]";
			if($isSandbox){
				$returnStr = "Sandbox used.  Page would have been created otherwise.";
			} else {
				$returnStr = lw_createPage($pageTitle, $content, $summary);
			}
			if($isKompoz){
				$returnStr .= " Kompoz flag detected.";
			}

			$retVal['dataUsed'] = true;
			if(isset($pageTitle) && $pageExists){
				$retVal['message'] = "Page overwritten. ".($returnStr==""?"":"($returnStr)");
			} else {
				$retVal['message'] = "Page created. ".($returnStr==""?"":"($returnStr)");
			}
		}
	}
	requestFinished($id);
	return $retVal;
} // end postSong()


//////////////////////////////////////////////////////////////////////////////
// Helper functions for the SOAP

////
// Takes in an array of the AlbumData format and returns wikitext for that
// album as it would appear on an artist's page.
////
function lw_albumDataToWiki($album){
	$retVal = "";
	$artistName = lw_fmtArtist($artist);
	$albumName = $album['album'];
	$year = $album['year'];
	$asin = $album['amazonLink'];
	$songs = $album['songs'];
	if(strtolower($albumName) == "other songs"){
		$retVal .= "==[[$artistName:Other Songs|Other Songs]]==\n";
	} else {
		$retVal .= "==[[$artistName:$albumName ($year)|$albumName ($year)]]==\n";
	}
	$retVal .= lw_tracksToWiki($artistName, $songs);
	$retVal .= "\n";
	return $retVal;
} // end lw_albumDataToWiki()

////
// Returns the wikitext for the track-listing part of the album.
////
function lw_tracksToWiki($artistName, $songs){
	$retVal = "";
	if(is_array($songs) && (count($songs)>0)){
		foreach($songs as $currSong){
			// If no artist is specified, default to the artist who makes the album.
			// This makes most cases easy and allows overriding of artist for compilations, etc.
			if(false === strpos($currSong, ":")){
				$currSong = lw_getTitle($artistName, $currSong);
			}
			$justSong = $currSong;
			if($index = strrpos($currSong, ":")){
				$justSong = substr($currSong, $index+1);
			}
			$justSong = lw_fmtSong($justSong);
			$retVal .= "# '''[[$currSong|$justSong]]'''\n";
		}
	}
	return $retVal;
} // end lw_tracksToWiki()

////
// Returns the standardly formatted artist name.
////
function lw_fmtArtist($artist){
	$retVal = rawurldecode(ucwords($artist));
	$retVal = preg_replace('/([-\("\.])([a-z])/e', '"$1".strtoupper("$2")', $retVal);
	$retVal = str_replace(" ", "_", $retVal);
	return $retVal;
} // end lw_fmtArtist()

function lw_fmtAlbum($album,$year){
	$year = ($year==""?"????":$year);
	return lw_fmtSong($album)." ($year)";
}

////
// Returns the standardly formatted song name.
////
function lw_fmtSong($song){
	$retVal = rawurldecode(ucwords($song));
	$retVal = preg_replace('/([-\("\.])([a-z])/e', '"$1".strtoupper("$2")', $retVal);
	$retVal = str_replace(" ", "_", $retVal);
	return $retVal;
} // end lw_fmtSong()

////
// Returns the first letter of a string based on the way categorization is done.  For instance,
// symbols and number are special cases.
////
function lw_fLetter($input){
	$fLetter = strtoupper(substr($input,0,1));
	if(($fLetter >= '0') && ($fLetter <= '9')){
		$fLetter = "0-9";
	} else if($fLetter < 'A' || $fLetter > 'Z'){
		$fLetter = "Symbol";
	}
	return $fLetter;
}

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

////
// Simple function to see if a page exists given its properly formatted page name.
// Returns a boolean, true if page exists, false if it doesn't.
//
// Caches results, so it is safe to call multiple times.
////
GLOBAL $EXIST_CACHE;
function lw_pageExists($pageTitle){
	GLOBAL $EXIST_CACHE;
	if(!isset($EXIST_CACHE)){
		$EXIST_CACHE = array();
	}

	if(isset($EXIST_CACHE[$pageTitle])){
		$retVal = $EXIST_CACHE[$pageTitle];
	} else {
		$queryTitle = str_replace("'", "\'", $pageTitle);
		$retVal = (0 < lw_simpleQuery("SELECT COUNT(*) FROM page WHERE page_title='$queryTitle' AND page_namespace='0'")); // the page_namespace='0' speeds it up significantly
		$EXIST_CACHE[$pageTitle] = $retVal;
	}
	return $retVal;
} // end lw_pageExists()

////
// Returns the content of the page with the given page title.
// Returns an empty string if the page is not found.
// Automatically compensates for redirects.  Pages array contains the pages
// already attempted in order to prevent run-away recursion.
//
// If there are redirects, finalName will be modified to contain the pageName
// of the page which the redirection stops upon.
////
function lw_getPage($pageTitle, $pages=array(), &$finalName='', $debug=false){
	$retVal = "";
	$finalName = $pageTitle;

	// Get the text of the end-point article and record what the final article name is.
	$title = Title::newFromDBkey($pageTitle);
	if( $title ) {
		if($title->exists()){
			$article = Article::newFromID($title->getArticleID());
			if($article->isRedirect()){
				$reTitle = $article->followRedirect(); // follows redirects recursively
				$article = Article::newFromId($reTitle->getArticleID());
			}
			if(is_object($article)){
				$finalName = $article->getTitle()->getDBkey();
				$retVal = $article->getRawText();
			}
		}
	}
	print (!$debug?"":"page code\n$retVal\n");

	return $retVal;
} // end lw_getPage()

////
// Given the vital information for a page, creates it.
// WARNING: MUST CHECK FIRST TO SEE IF THE PAGE EXISTS
// pageTitle is not a string but an object of type Title.
////
function lw_createPage($pageTitle, $content, $summary="Page created using [[LyricWiki:SOAP|LyricWiki's SOAP Webservice]]"){
	GLOBAL $wgRequestTime,$wgRUstart,$mediaWiki,$wgTitle;
	GLOBAL $wgOut,$wgLang,$wgUser,$wgRequest;
	$retVal = 'lw_createPage';

	lw_initAdvanced();
	$wgTitle = $pageTitle; // must be done after lw_initAdvanced()

	// Some of this is used in Wiki.php and EditPage.php to do an edit:
	$article = $mediaWiki->articleFromTitle(Title::newFromText($pageTitle));
	$editor = new EditPage($article);

	# These fields need to be checked for encoding.
	# Also remove trailing whitespace, but don't remove _initial_
	# whitespace from the text boxes. This may be significant formatting.
//	$this->textbox1 = $this->safeUnicodeInput( $request, 'wpTextbox1' );
//	$this->textbox2 = $this->safeUnicodeInput( $request, 'wpTextbox2' );
//	$this->mMetaData = rtrim( $request->getText( 'metadata'   ) );
	# Truncate for whole multibyte characters. +5 bytes for ellipsis
//	$this->summary   = $wgLang->truncate( $request->getText( 'wpSummary'  ), 250 );

	$editor->textbox1  = $content;
	$editor->textbox2  = '';
	$editor->mMetaData = '';
	$editor->summary   = $summary;
	$editor->starttime = wfTimestampNow();
	if($wgTitle->exists()){ // if this is an edit, load the edittime
		$editor->edittime = $editor->mArticle->getTimestamp();
	} else {
		$editor->edittime = wfTimestampNow();
	}
	$editor->preview   = false;
	$editor->save      = true;
	$editor->diff	 = false;
	$editor->minoredit = false;
	$editor->watchthis = false;
	$editor->recreate  = false;
	$editor->oldid = 0;
	$editor->section = '';
	$editor->live = false;
	$editor->editintro = '';

	// Store it.
	$fname = 'LW_SOAP::EditPage::edit';
	$wgOut->setArticleFlag(false);
	$editor->firsttime = false;
	if ( ! $editor	->mTitle->userCanEdit() ) {
		wfDebug( "$fname: user can't edit\n" );
		$retVal = "User cannot edit this page.";
		//$wgOut->readOnlyPage( $editor->getContent(), true );
		wfProfileOut( $fname );
		return $retVal;
	}

	wfDebug( "$fname: Checking blocks\n" );
	if ( !$editor->preview && !$editor->diff && $wgUser->isBlockedFrom( $editor->mTitle, !$editor->save ) ) {
		# When previewing, don't check blocked state - will get caught at save time.
		# Also, check when starting edition is done against slave to improve performance.
		wfDebug( "$fname: user is blocked\n" );
		$retVal = "User is blocked.";
		$editor->blockedPage();
		wfProfileOut( $fname );
		return $retVal;
	}
	if ( !$wgUser->isAllowed('edit') ) {
		if ( $wgUser->isAnon() ) {
			wfDebug( "$fname: user must log in\n" );
			$editor->userNotLoggedInPage();
			$retVal = "Must log in first.";
			wfProfileOut( $fname );
			return $retVal;
		} else {
			wfDebug( "$fname: read-only page\n" );
			$retVal = "This page is read only.\n";
			$wgOut->readOnlyPage( $editor->getContent(), true );
			wfProfileOut( $fname );
			return $retVal;
		}
	}
	if ($wgEmailConfirmToEdit && !$wgUser->isEmailConfirmed()) {
		wfDebug("$fname: user must confirm e-mail address\n");
		$retVal = "You must confirm your email address before editing this page.";
		$editor->userNotConfirmedPage();
		wfProfileOut($fname);
		return $retVal;
	}
	if ( !$editor->mTitle->userCanCreate() && !$editor->mTitle->exists() ) {
		wfDebug( "$fname: no create permission\n" );
		$retVal = "You do not have permision to create pages.";
		$editor->noCreatePermission();
		wfProfileOut( $fname );
		return $retVal;
	}
	if ( wfReadOnly() ) {
		wfDebug( "$fname: read-only mode is engaged\n" );
		if( $editor->save || $editor->preview ) {
			$editor->formtype = 'preview';
		} else if ( $editor->diff ) {
			$editor->formtype = 'diff';
		} else {
			$wgOut->readOnlyPage( $editor->getContent() );
			$retVal = "Page (site?) is in read-only mode.";
			wfProfileOut( $fname );
			return $retVal;
		}
	} else {
		if ( $editor->save ) {
			$editor->formtype = 'save';
		} else if ( $editor->preview ) {
			$editor->formtype = 'preview';
		} else if ( $editor->diff ) {
			$editor->formtype = 'diff';
		} else { # First time through
			$editor->firsttime = true;
			if( $editor->previewOnOpen() ) {
				$editor->formtype = 'preview';
			} else {
				$editor->extractMetaDataFromArticle () ;
				$editor->formtype = 'initial';
			}
		}
	}

	wfProfileIn( "$fname-business-end" );

	$editor->isConflict = false;
	// css / js subpages of user pages get a special treatment
	$editor->isCssJsSubpage      = $wgTitle->isCssJsSubpage();
	$editor->isValidCssJsSubpage = $wgTitle->isValidCssJsSubpage();

	/* Notice that we can't use isDeleted, because it returns true if article is ever deleted
	 * no matter it's current state
	 */
	$editor->deletedSinceEdit = false;
	if ( $editor->edittime != '' ) {
		/* Note that we rely on logging table, which hasn't been always there,
		 * but that doesn't matter, because this only applies to brand new
		 * deletes. This is done on every preview and save request. Move it further down
		 * to only perform it on saves
		 */
		if ( $editor->mTitle->isDeleted() ) {
			$editor->lastDelete = $editor->getLastDelete();
			if ( !is_null($editor->lastDelete) ) {
				$deletetime = $editor->lastDelete->log_timestamp;
				if ( ($deletetime - $editor->starttime) > 0 ) {
					$editor->deletedSinceEdit = true;
				}
			}
		}
	}

	if(!$editor->mTitle->getArticleID() && ('initial' == $editor->formtype || $editor->firsttime )) { # new article
		$editor->showIntro();
	}
	if( $editor->mTitle->isTalkPage() ) {
		$wgOut->addWikiText( wfMsg( 'talkpagetext' ) );
	}

	# Attempt submission here.  This will check for edit conflicts,
	# and redundantly check for locked database, blocked IPs, etc.
	# that edit() already checked just in case someone tries to sneak
	# in the back door with a hand-edited submission URL.
	if ( 'save' == $editor->formtype ) {
		if ( !$editor->attemptSave() ) {
			wfProfileOut( "$fname-business-end" );
			wfProfileOut( $fname );
			$retVal = "Page saved.";
			return $retVal;
		} else {
			$retVal = "Save attempt failed.";
		}
	}

	# First time through: get contents, set time for conflict
	# checking, etc.
	if ( 'initial' == $editor->formtype || $editor->firsttime ) {
		$editor->initialiseForm();
		if( !$editor->mTitle->getArticleId() )
			wfRunHooks( 'EditFormPreloadText', array( &$editor->textbox1, &$editor->mTitle ) );
	}

	$editor->showEditForm();
	wfProfileOut( "$fname-business-end" );
	wfProfileOut( $fname );

	$retVal = ($retVal==""?"Page created successfully.":$retVal);
	return $retVal;
}

////
// Performs more advanced initialization.  Too much unneeded work for most functions, but can be used in several.
////
function lw_initAdvanced(&$title='', &$action=''){
	// SWC 20060906 - This is a modified version of the code in MediaWiki's index.php
	GLOBAL $wgRequest,$wgRequestTime,$wgRUstart,$mediaWiki,$wgTitle;
	$wgRequestTime = microtime(true);

	# getrusage() does not exist on the Microsoft Windows platforms, catching this
	if ( function_exists ( 'getrusage' ) ) {
		$wgRUstart = getrusage();
	} else {
		$wgRUstart = array();
	}

	unset( $IP );
	@ini_set( 'allow_url_fopen', 0 ); # For security...

	if ( isset( $_REQUEST['GLOBALS'] ) ) {
		die( '<a href="http://www.hardened-php.net/index.76.html">$GLOBALS overwrite vulnerability</a>');
	}

	# Valid web server entry point, enable includes.
	# Please don't move this line to includes/Defines.php. This line essentially
	# defines a valid entry point. If you put it in includes/Defines.php, then
	# any script that includes it becomes an entry point, thereby defeating
	# its purpose.
	// These commented-out settings are already initialized just by calling this SOAP.
	//define( 'MEDIAWIKI', true );
	//require_once( './includes/Defines.php' ); # Load up some global defines.
	//require_once( './LocalSettings.php' ); # Include this site setttings
	//require_once( 'includes/Setup.php' ); # Prepare MediaWiki
	require_once( "includes/Wiki.php" ); # Initialize MediaWiki base class
	$mediaWiki = new MediaWiki();

	wfProfileIn( 'main-misc-setup' );
	OutputPage::setEncodings(); # Not really used yet

	# Query string fields
	if($action == ''){
		$action = $wgRequest->getVal( 'action', 'view' );
	}
	// NOTE: This must be passed in params in LyricWiki version.
	// $title = $wgRequest->getVal( 'title' );

	# Send Ajax requests to the Ajax dispatcher (this will most likely not be used in the SOAP, but it is an option).
	if ( $wgUseAjax && $action == 'ajax' ) {
		require_once( 'AjaxDispatcher.php' );
		$dispatcher = new AjaxDispatcher();
		$dispatcher->performAction();
		exit;
	}

	$wgTitle = $mediaWiki->checkInitialQueries( $title,$action,$wgOut, $wgRequest, $wgContLang );
	if ($wgTitle == NULL) {
		unset( $wgTitle );
	}

	wfProfileOut( 'main-misc-setup' );

	# Setting global variables in mediaWiki
	$mediaWiki->setVal( 'Server', $wgServer );
	$mediaWiki->setVal( 'DisableInternalSearch', $wgDisableInternalSearch );
	$mediaWiki->setVal( 'action', $action );
	$mediaWiki->setVal( 'SquidMaxage', $wgSquidMaxage );
	$mediaWiki->setVal( 'EnableDublinCoreRdf', $wgEnableDublinCoreRdf );
	$mediaWiki->setVal( 'EnableCreativeCommonsRdf', $wgEnableCreativeCommonsRdf );
	$mediaWiki->setVal( 'CommandLineMode', $wgCommandLineMode );
	$mediaWiki->setVal( 'UseExternalEditor', $wgUseExternalEditor );
	$mediaWiki->setVal( 'DisabledActions', $wgDisabledActions );
} // end lw_initAdvanced()

////
// If there was a username/password passed in the SOAP headers, this will use them to login.
////
function lw_tryLogin(){
	GLOBAL $server;
	$headers = $server->requestHeaders;
	$username = $password = "";
	$matches = array();
	if(0<preg_match("/<username>(.*?)<\/username>/si", $headers, $matches)){
		$username = $matches[1];
		$matches = array();
		if(0<preg_match("/<password>(.*?)<\/password>/si", $headers, $matches)){
			$password = $matches[1];
		}
		if(($username != "") || ($password != "")){
			login($username,$password);
		}
	}
} // end lw_tryLogin()

////
// Given a username/password combination, logs in for this page-load only (since SOAPs can't remember sessions).
////
function login($username, $password) {
	$retVal = false;
	$err = ""; // not returned to user currently... but loaded (helps at least for debug).
	$rememberMe = false; // possibly allow this as function parameter (can SOAPs do optional params?).
	GLOBAL $wgUser, $wgAuth, $wgReservedUsernames;

	$username = utf8_encode($username); // allow special characters such as umlauts.
	$password = utf8_encode($password);
	$u = User::newFromName($username);
	if( is_null( $u ) || in_array( $u->getName(), $wgReservedUsernames ) ) {
		$err .= "Please enter a username.\n";
	} else {
		if ( 0 == $u->getID() ) {
			global $wgAuth;
			/**
			 * If the external authentication plugin allows it,
			 * automatically create a new account for users that
			 * are externally defined but have not yet logged in.
			 */
			if ( $wgAuth->autoCreate() && $wgAuth->userExists( $u->getName() ) ) {
				if ( $wgAuth->authenticate($u->getName(), $password) ) {
					$u =& $this->initUser( $u );
				} else {
					$err .= "Incorrect password.\n";
				}
			} else {
				$err .= "There is no user by that username.\n";
			}
		} else {
			$u->loadFromDatabase();
			if (!$u->checkPassword($password)) {
				$err .= ($password==""?"Please enter a password.\n":"Incorrect password.\n");
			} else {
				# We've verified now, update the real record
				if($rememberMe){
					$r = 1;
				} else {
					$r = 0;
				}
				$u->setOption( 'rememberpassword', $r );
				$wgAuth->updateUser( $u );
				$wgUser = $u;
				$wgUser->setCookies();
				$wgUser->saveSettings();
				$retVal = true;
			}
		}
	}
	// TODO: REMOVE
	if($retVal === false){
		print $err."\n";
	}

	return $retVal;
} // end login()

////
// Returns true if the string passed in is a well-formed UTF8 string.
//
// Function from:
// http://www.phpwact.org/php/i18n/charsets#checking_utf-8_for_well_formedness
////
function utf8_compliant($str){
    if(strlen($str) == 0){
        return TRUE;
    }
    // If even just the first character can be matched, when the /u
    // modifier is used, then it's valid UTF-8. If the UTF-8 is somehow
    // invalid, nothing at all will match, even if the string contains
    // some valid sequences
    return (preg_match('/^.{1}/us',$str,$ar) == 1);
} // end utf8_compliant(...)

////
// Given the artist, song, and titles that were looked-for, stores a record of
// the failure so that we can know what songs (or redirects) are desired that we don't have yet.
////
function logSoapFailure($origArtistSql, $origSongSql, $lookedForSql){
	global $wgReadOnly;
	if( !wfReadOnly() ) {
		GLOBAL $wgMemc;
		$NUM_FAILS_TO_SPOOL = 10;
		
		// Spool a certain number of updates in memcache before writing to db.
		$memkey = wfMemcKey( 'lw_soap_failure', $origArtistSql, $origSongSql );
		$numFails = $wgMemc->get( $memkey );
		if(empty($numFails)){
			$wgMemc->set($memkey, 1);
		} else if(($numFails + 1) >= $NUM_FAILS_TO_SPOOL){
			$numFails += 1;
			$db = lw_connect();
			$queryString = "INSERT INTO lw_soap_failures (request_artist,request_song, lookedFor, numRequests) VALUES ('$origArtistSql', '$origSongSql', '$lookedForSql', '$numFails') ON DUPLICATE KEY UPDATE numRequests=numRequests+$numFails";
			mysql_query($queryString, $db);
		} else {
			$wgMemc->set($memkey, $numFails + 1);
		}
	}
} // end logSoapFailure()

////
// If request-tracking is enabled, this function will record some stats about the request and return
// a row-id of the row which is now being tracked (or false if there is an error).
//
// The parameters are:
// - funcName: The web-method function name (eg: getArtist)
// - requestData: Data used to make the request, this can be in different formats for each request type as long
// 			as they are useful in identifying the request (so that it can be reproduced).
////
function requestStarted($funcName, $requestData){
	// The system used to make the request. Typically just "SOAP" or "REST"
	GLOBAL $REQUEST_TYPE;
	$retVal = false;

	/**
	 * rt#27684/eloy
	 */
	if( !wfReadOnly() ) {
		if(defined('TRACK_REQUEST_RUNTIMES') && TRACK_REQUEST_RUNTIMES) {
			$db = lw_connect();
			$requestData = str_replace("'", "[&apos;]", $requestData);
			$queryString = "INSERT INTO apiRequests (requestedThrough, requestedFunction, requestData, requestTime)";
			$queryString.= " VALUES ('$REQUEST_TYPE', '$funcName', '$requestData', NOW())";
			if( mysql_query($queryString, $db ) ){
				$retVal = mysql_insert_id( $db );
			}
		}
	}
	return $retVal;
} // end requestStarted()

////
// If request-tracking is enabled, this function will delete the record of the request since it is now finished being tracked.
//
// Later, if we start logging statistics on the requests, this function will be responsible for keeping track of the elapsed-time
// of the request.
////
function requestFinished($id){
	if( !wfReadOnly() ) {
		if(defined('TRACK_REQUEST_RUNTIMES') && TRACK_REQUEST_RUNTIMES){
			$db = lw_connect();
			mysql_query("DELETE FROM apiRequests WHERE id=$id", $db);
		}
	}
} // end requestFinished()

<?php
////
// Author: Sean Colombo
// Date: 20060715
// Last modified: 20110810 (actually pretty frequently, and this generally doesn't get updated... see SVN for reliable date).
//
// The LyricWiki SOAP web service implementation (also has the functions which power the internals
// of the REST API which are wrapped by code in /extensions/wikia/WikiaApi/WikiaApiLyricwiki.php
//
// TODO: For the Kompoz lyrics, make it add special Kompoz data - update: 20080716... what ended up happening with Kompoz?  They still around & using LyricWiki?.
// TODO: When a user adds a song, make sure it is automatically merged into the artist page (User:Janitor makes this not too big of a deal since he finds orphans and adds them to the artist's Other Songs section).
//
// NOTES FOR DEVELOPERS:
// - When implementing a new method, make sure to check the global $SHUT_DOWN_API.
// - Before writing anything to the database, remember to check wfReadOnly().
// - See Special_Soapfailures.php for SQL to create the tables needed for logging inside of here.
//
// GENERAL WISHES FOR IMPROVEMENT IN NEXT API:
// - Better versioning.  This may be best to do using the Accept header (look into that again). There also needs to be a graceful way to keep the code separate for the different versions and handle deprecation, etc.
// - API Keys so that we can contact developers using old versions to ask them to update & so we can contact devs if they're accidentally doing too many requests, etc.
// - Some standard way of enabling & displaying debug output for every function and return-format (would be optimal to keep this standard with MediaWiki API and other Wikia APIs (eg: Nirvana)).
// - Indicate failures with extra fields, (or in REST: with status-codes), rather than hardcoded stuff like "Not Found" for the lyrics.
// - A good unit-test suite from the start so that we can add edge-cases as we find them so that we never have the same bug-report more than once (we do a good job of no regressions right now... but mostly because we're avoiding sweeping changes... the API would be much more agile if it could make sweeping changes safely).
// - TODO: Tracklisting format which isn't tied to a master artist or album.  This is needed for parsing list pages, etc. It will require a different structure for song-names since they will have the artist in them.  Should name it differently to avoid confusion (eg: "song" is current, this would be "pageTitle" or "fullTitle" or something - just keep in mind to avoid confusion related to namespaces when naming this return value... eg: 'fullPageTitle' would be wrong since "Gracenote:" wouldn't go in there).
////

include_once 'extras.php'; // for lw_simpleQuery to start
GLOBAL $LW_USE_PERSISTENT_CONNECTIONS;
$LW_USE_PERSISTENT_CONNECTIONS = true;
$ENABLE_LOGGING_SLOW_SOAP = false;
$MIN_SECONDS_TO_LOG = 15; // if the script takes longer than this many seconds to run, the request will be logged.
$startTime = microtime(true);
global $funcsOnly;
$funcsOnly = (defined('LYRICWIKI_SOAP_FUNCS_ONLY') && LYRICWIKI_SOAP_FUNCS_ONLY);

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
	if(!defined('LYRICWIKI_SOAP')){
		define( 'LYRICWIKI_SOAP', true ); // so that LocalSettings.php knows not to include extra files.
	}

	if(!$funcsOnly){
		if(!defined('MEDIAWIKI')){
			define( 'MEDIAWIKI', true );
		}

		require_once $LW_PATH."includes/Defines.php";

		if($LW_PATH != "./"){ // another (probably futile) attempt to allow entry points other than in the root directory.
			$wgScriptPath = $LW_PATH;
		}

		require (dirname(__FILE__) . '/../../../includes/WebStart.php');
	}
} else if(!function_exists("wfReadOnly")){
	// Since we skip the MediaWiki stack when the API is disabled, this stub is needed.
	function wfReadOnly(){return true;}
}

wfDebug("LWSOAP: Done initializing MediaWiki.  Proceeding to SOAP-specific initialization.\n");

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
	/***
	 * Returns a connection to the database just like lw_connect, but this reference will
	 * be to the slave (read-only replica) which will be faster for read but doesn't allow writes.
	 *
	 * @return Resource
	 */
	function lw_connect_readOnly(){
		return wfGetDB(DB_SLAVE)->getProperty('mConn');
	} // end lw_connect_readOnly()
}

// If another local script wants to use these functions, it can just include
// this file with LYRICWIKI_SOAP_FUNCS_ONLY and then call the
// functions directly.
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
# TODO: Add the image into the results for getSotd - use ImageServing extension
#			'imgUrl' => array('name' => 'imgUrl', 'type' => 'xsd:string'),
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
	$server->wsdl->addComplexType( // TODO: Make this data structure be the same as what is returned by getAlbum
		'AlbumData',
		'complexType',
		'struct',
		'all',
		'',
		array(
			'album' => array('name' => 'album', 'type' => 'xsd:string'),
			'year' => array('name' => 'year', 'type' => 'xsd:int'),
			'amazonLink' => array('name' => 'amazonLink', 'type' => 'xsd:string'),
			'imgUrl' => array('name' => 'imgUrl', 'type' => 'xsd:string'),
			'url' => array('name' => 'url', 'type' => 'xsd:string'),
			'songs' => array('name' => 'songs', 'type' => 'tns:ArrayOfstring')
		)
	);

	$server->wsdl->addComplexType(
		'TopSongsArray',
		'complexType',
		'array',
		'',
		'SOAP-ENC:Array',
		array(),
		array(array('ref'=>'SOAP-ENC:arrayType','wsdl:arrayType'=>'TopSong[]')),
		'tns:TopSong'
	);
	$server->wsdl->addComplexType(
		'TopSong',
		'complexType',
		'struct',
		'all',
		'',
		array(
			'rank' => array('name' => 'rank', 'type' => 'xsd:int'),
			'artist' => array('name' => 'artist', 'type' => 'xsd:string'),
			'song' => array('name' => 'song', 'type' => 'xsd:string'),
			'image' => array('name' => 'image', 'type' => 'xsd:string'),
			'itunes' => array('name' => 'itunes', 'type' => 'xsd:string'),
			'url' => array('name' => 'url', 'type' => 'xsd:string')
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
		array(	'artist' => 'xsd:string', // TODO: Should this return AlbumData or not? Right now it seems it shouldn't since it has 'artist' as a sibling to the 'album', but that seems sloppy to have them be able to get out of sync. Is there a good way to keep them in-sync?
				'album' => 'xsd:string',
				'year' => 'xsd:int',
				'amazonLink' => 'xsd:string',
				'imgUrl' => 'xsd:string',
				'url' => 'xsd:string',
				'songs' => 'tns:ArrayOfstring'),
		$ns,
		"$action#getAlbum",
		'rpc',
		'encoded',
		'Gets the track listing, album cover, and amazon link for an album'
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

	$server->register('getTopSongs',
		array('limit' => 'xsd:string'),
		array('topSongs' => 'tns:TopSongsArray'),
		$ns,
		"$action#getTopSongs",
		'rpc',
		'encoded',
		'Gets the most popular songs. Currently, this data comes from the iTunes Top 100 feed, so the largest possible value of "limit" is 100.  Limit defaults to 10.'
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
				'lyrics' => 'xsd:string', 'language' => 'xsd:string', 'onAlbums' => 'tns:AlbumResultArray'),
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
				'lyrics' => 'xsd:string', 'onAlbums' => 'tns:AlbumResultArray', 'flags' => 'xsd:string', 'language' => 'xsd:string'),
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

	wfDebug("LWSOAP: Done setting up SOAP functions, about to process...\n");

	// Use the request to (try to) invoke the service
	$rawPostData = file_get_contents("php://input"); // preferred to HTTP_RAW_POST_DATA in PHP 5.6+
	wfDebug("LWSOAP: Dispatching to the ->service().\n");
	$server->service($rawPostData);
	wfDebug("LWSOAP: Returned from ->service().");

	// If the script took a long time to run, log it here.
	if($ENABLE_LOGGING_SLOW_SOAP){
		$scriptTime = (microtime(true) - $startTime);
		if($scriptTime >= $MIN_SECONDS_TO_LOG){
			$fileName = "lw_SOAP_log.txt";
			if(is_writable($fileName)){
				error_log(date("Y-m-d H:i:s")." - $scriptTime - ".$_SERVER['REQUEST_URI']."\n", 3, $fileName);
				ob_start();
				print_r($rawPostData);
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

	print (!$debug?"":"Starting title: \"$artist\".\n");

	GLOBAL $SHUT_DOWN_API;
	if(!$SHUT_DOWN_API){
// TODO: HAVE IT FOLLOW REDIRECTS, FIND CLOSE MATCHES, ETC.? or just use SimpleSearch now?

		// If the string starts or ends with %'s, trim them off.
		if(strlen($artist) >= 1){
			while((strlen($artist >= 1)) && (substr($artist, 0, 1) == "%")){
				$artist = substr($artist, 1);
			}
			while((strlen($artist >= 1)) && (substr($artist, -1) == "%")){
				$artist = substr($artist, 0, (strlen($artist)-1) );
			}
			print (!$debug?"":"After trimming '%'s off: \"$artist\".\n");

			// TODO: Is it even worth trying this initial query before the SimpleSearch service?
			$db = wfGetDB( DB_SLAVE );
			$result = $db->select(
				[ 'page' ],
				[ 'page_title' ],
				[
					'page_namespace' => NS_MAIN,
					'page_title NOT ' . $db->buildLike( $db->anyString(), ':' , $db->anyString() ),
					'page_title' => $artist,
				],
				__METHOD__,
				[
					'LIMIT' => $MAX_RESULTS,
				]
			);

			foreach ( $result as $row ) {
				$retVal[] = $row->page_title;
			}

			// If there were no results at all, look for some with a more liberal query.
			if(count($retVal) == 0){
				// Under the hood this uses the SimpleSearch service which is powered by Lucene.
				$searchResults = lw_getSearchResults($artist, $MAX_RESULTS * 3); // select more than max so that we can filter after-the-fact for artists.
				foreach($searchResults as $searchResult){
					// Only use the result if it is an artist page (has no colon in it).
					// TODO: FIXME: is there any good way to easily check if the page is actually an artist page for an artist which has a colon in their name?
					if(strpos($searchResult, ":") === false){
						$retVal[] = $searchResult;
					}
				}
			}
		}

		// Limit the number of results returned to what was specified.
		$retVal = array_slice($retVal, 0, $MAX_RESULTS);
	}

	requestFinished($id);
	return $retVal;
} // end searchArtists()

/**
 * Given the album to search for, returns an array which contains
 * associative arrays whose keys are 'artist', 'album', 'year'.
 */
function searchAlbums($artist, $album, $year){
	$id = requestStarted(__METHOD__, "$artist|$album|$year");
	$retVal = array();
	$MAX_RESULTS = 10;

	GLOBAL $SHUT_DOWN_API;
	if(!$SHUT_DOWN_API){
		$searchResults = lw_getSearchResults("$artist $album", $MAX_RESULTS * 3); // select more than max so that we can filter after-the-fact for artists.
		foreach($searchResults as $searchResult){
			// Only use the result if it is an album page (has a colon in it and ends with a year).
			$matches = array();
			if(0 < preg_match("/^(.*):(.*?)\(([0-9]{4})\)$/", $searchResult, $matches)){
				$retVal[] = array(
								'artist' => $matches[1],
								'album' => $matches[2],
								'year' => $matches[3]
							);
			}
		}

		// Trim the array to the size desired by the client.
		$retVal = array_slice($retVal, 0, $MAX_RESULTS);
	}

	requestFinished($id);
	return $retVal;
} // end searchAlbums()

/**
 * Given an artist and song to search for, returns close matches in the form of an
 * array which contains associative arrays whose keys are 'artist' and 'song'.
 */
function searchSongs($artist, $song){
	$id = requestStarted(__METHOD__, "$artist|$song");
	$MAX_RESULTS = 10;

	GLOBAL $SHUT_DOWN_API;
	if(!$SHUT_DOWN_API){
		$searchResults = lw_getSearchResults("$artist $song", $MAX_RESULTS * 2); // select more than max so that we can filter after-the-fact for artists.
		foreach($searchResults as $searchResult){
			// Only use the result if it is a song page (has a colon in it).
			$matches = array();
			if(0 < preg_match("/^(.*):(.*?)$/", $searchResult, $matches)){
				$retVal[] = array('artist' => $matches[1], 'song' => $matches[2]);
			}
		}

		// Trim the array to the size desired by the client.
		$retVal = array_slice($retVal, 0, $MAX_RESULTS);
	}

	requestFinished($id);
	return $retVal;
} // end searchSongs()

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
		if(0 == preg_match("/'''Song:[\s\"']*\[\[([^\]\|]*)(\||\]\])/si", $sotdPage, $matches)){
			$matches[1] = ''; // TODO: RETURN AN ERROR.
		} else {
			$fullTitle = $matches[1];
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
		}

		// TODO: Could memcache this result since the getSong will be called a bunch for this song & it shouldn't change for a day.
		$retVal = getSong($artist, $song);

		$retVal['artist'] = str_replace("_", " ", $retVal['artist']);
		$retVal['song'] = str_replace("_", " ", $retVal['song']);
		$retVal['nominatedBy'] = str_replace("_", " ", $nominatedBy);
		$retVal['reason'] = $reason;
	}

	requestFinished($id);
	return $retVal;
}

/**
 * The most commonly called function in the API... attempts to find a match for a provided artist/song name and return
 * a fair-use snippet of lyrics along with a link to the page.  Internally handles "fuzzy" title matching to get close matches
 * and follow "implied redirects" (eg: "Prodigy" redirects
 * to "The Prodigy", therefore we can infer that "Prodigy:Firestarter" => "The Prodigy:Firestarter").
 *
 * @params doHyphens is a bool which will be true initially and indicates that the function should try to remove hyphens.  Recursive calls might not do this.
 * @param ns the namespace to use when looking for songs.
 * @param isOuterRequest is a bool which represents if this is the actual request from the SOAP or REST APIs.  It will be set to false by all recursive calls.
 * @param lyricsTagFound is a bool which is modified by reference and will indicate whether a lyrics tag (or equivalent formatting including an {{instrumental}} template) of any kind was found to indicate that the resulting wikitext is most likely lyrics.
 * @param allowFullLyrics is a bool which is the default for whether the lyrics need to be truncated. For direct calls this should always be left to 'false' for legal reasons... however, there are currently hacks which want the full text of a page so they can post-process the wikitext.
 */
function getSongResult($artist, $song){ return getSong($artist,$song); } // Alias. (think it was needed for Flash or one of the SOAP libraries)
function getSong($artist, $song="", $doHyphens=true, $ns=NS_MAIN, $isOuterRequest=true, $debug=false, &$lyricsTagFound=false, $allowFullLyrics = false){
	wfProfileIn( __METHOD__ );

	wfDebug("LWSOAP: inside " . __METHOD__ . "\n");
	if($isOuterRequest){
		$id = requestStarted(__METHOD__, "$artist|$song");
	}

	$lyricsTagFound = false;
	$debugSuffix = "_debug";
	$artist = rawurldecode($artist);
	$song = rawurldecode($song);

	// Trick to show debug output.  Just add the debugSuffix to the end of the song name, and debug output will be displayed.
	if((strlen($song) >= strlen($debugSuffix)) && (substr($song, (0-strlen($debugSuffix))) == $debugSuffix)){
		$song = substr($song, 0, (strlen($song)-strlen($debugSuffix))); // remove debug-suffix
		$debug = true;
	}
	//GLOBAL $debug; // Do NOT do this.  This will effectively un-set the local var.
	if($debug){
		// Testing the UTF8 issues with incoming values.
		print "ARTIST: $artist\n";
		print "ENCODE: ".utf8_encode($artist)."\n";
		print "DECODE: ".utf8_decode($artist)."\n";
	}

	$LW_NS_STRING = "LyricWiki"; // TODO: FIXME: There MUST be a more programattic way to get this :P
	if($artist == $LW_NS_STRING){
		$artist = $song;
		$song = "";
		$ns = NS_PROJECT;
		print (!$debug?"":"LyricWiki page was explicitly requested. Now looking for \"$artist\" in the LyricWiki namespace.");
	}

	$origArtist = $artist; // for logging the failed requests, record the original name before we start messing with it
	$origSong = $song;
	$lookedFor = ""; // which titles we looked for.  Used in SOAP failures - TODO: REFACTOR TO BE AN ARRAY... SRSLY.

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
	$nsString = ($ns == NS_PROJECT ? $LW_NS_STRING.":" : "");
	$urlRoot = "http://lyrics.wikia.com/"; // may differ from default URL, should contain a slash after it.
	$instrumental = "Instrumental";
	$DENIED_NOTICE = "Unfortunately, due to licensing restrictions from some of the major music publishers we can no longer return lyrics through the LyricWiki API (where this application gets some or all of its lyrics).\n";
	$DENIED_NOTICE.= "\nThe lyrics for this song can be found at the following URL:\n";
	$DENIED_NOTICE_SUFFIX = "\n\n\n(Please note: this is not the fault of the developer who created this application, but is a restriction imposed by the music publishers themselves.)";
	//$TRUNCATION_NOTICE = "Our licenses prevent us from returning the full lyrics to this song via the API.  For full lyrics, please visit: $urlRoot"."$nsString$artist:$song";
	$retVal = array('artist' => $artist, 'song' => $song, 'lyrics' => $defaultLyrics, 'url' => $defaultUrl, 'page_namespace' => '', 'page_id' => '', 'isOnTakedownList' => false);

	GLOBAL $SHUT_DOWN_API;
	if($SHUT_DOWN_API){
		$retVal = array('artist' => $artist, 'song' => $song, 'lyrics' => $defaultLyrics, 'url' => 'http://lyrics.wikia.com', 'page_namespace' => '', 'page_id' => '', 'isOnTakedownList' => false);
		global $SHUT_DOWN_API_REASON;
		$retVal['lyrics'] = $SHUT_DOWN_API_REASON;
	} else {
		// WARNING: This may cause some unexpected results if these artists ever become actual pages.
		// These are "artists" which are very commonly accuring non-artists.  IE: Baby Einstein is a collection of classical music, Apple Inc. is just apple's (video?) podcasts
		$nonArtists = array(
			"baby einstein", "apple inc.", "soundtrack", "various", "various artists", "the howard stern show", "frequence3.fr", "frequence3",
			"http://www.radiofg.com", "radio paradise", "webex", "brought to you by santrex.net", "3fm", "no artist", "thank you for using starplayr"
		);

		// Lots of files are getting requested for some reason.
		if(strlen($song) >= 4){
			$ending = strtolower(substr($song, -4));
			if(($ending == ".php") || ($ending == ".png")){
				$song = ""; // not a valid song.
			}
		}

		global $wgRequest;
		$lowerSong = strtolower($song);
		$lowerArtist = strtolower($artist);
		if((($artist=="") || ($song=="") || (0 < preg_match("/^\?+$/", $artist))) && (strpos("$artist$song", ":") === false) && ($ns != NS_PROJECT)){
			// NOTE: For now we leave the 'defaultLyrics' message for players that handle this explicitly as not being a match.
			print (!$debug?"":"Title doesn't appear to be a valid song title. Artist: \"$artist\" Song: \"$song\"\n");
		} else if(($song == "unknown") || ((($lowerArtist == "unknown") || ($lowerArtist == "artist")) && ($lowerSong == "unknown")) || (0<preg_match("/^Track [0-9]+$/i", $song)) || (strtolower($song) == "favicon.png")){
			// If the song is "unkown" (all lowercase) this is usually just a default failure.  If they are looking for a song named "Unknown", and they use the caps, it will get through (unless the band name also happens to be "Unknown")
			print (!$debug?"":"Found title which is a commonly-passed-in error title (usually bad metadata on song files).\n");

			// NOTE: For now we leave the 'defaultLyrics' message for players that handle this explicitly as not being a match.
		} else if(in_array($lowerArtist, $nonArtists)){
			// These are "artists" which are very commonly accuring non-artists.  IE: Baby Einstein is a collection of classical music, Apple Inc. is just apple's (video?) podcasts
			print (!$debug?"":"Found a 'non-artist' which is often a radio station, podcast, etc..\n");
			// NOTE: For now we leave the 'defaultLyrics' message for players that handle this explicitly as not being a match.
		} else {
			// TODO: SHOULDN'T MOST OF THE REWRITES BELOW BE IN lw_getTitle() INSTEAD OF HERE??

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
				"#" => "Number ", // note the trailing space - TODO: FIXME: IS THIS STILL A RESTRICTION?? - it appears to be ("select page_title from page where page_title like '%#%' LIMIT 10;" yielded no results in production).
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
			if(!lw_pageExists($title, $ns)){
				$lookedFor .= "$title\n";
				print (!$debug?"":"Not found...\n");

				/** ATTEMPT: IMPLIED REDIRECTS **/
				// If the artist has a redirect on their own page, that generally means that all songs belong to that finalized name...
				// so try to grab the song using that version of the artist's name.
				$artistTitle = lw_getTitle($artist); // leaves the original version in tact
				$finalName = $artistTitle;
				// NOTE: This is intentionally ONLY in NS_MAIN rather than '$ns'. Artist redirects should all be done in the main namespace.
				$page = lw_getPage($artistTitle, $finalName, $debug, NS_MAIN); // this is done for the side-effects of setting finalName.
				print (!$debug?"":"found:\n$page");
				if($finalName != $artistTitle){
					print (!$debug?"":"Artist redirect found to \"$finalName\". Applying to song \"$song\".\n");

					// If the redirect is just to different capitalization, then use the special
					// caps instead of letting lw_getTitle() overwrite this capitalization-change.
					if(strtolower($finalName) == strtolower($artistTitle)){
						$title = "$finalName:" . lw_getTitle($song, "", false); // 'false' is to prevent re-utf8_encoding the strings
					} else {
						$title = lw_getTitle($finalName, $song, false); // 'false' is to prevent re-utf8_encoding the strings
					}
					print (!$debug?"":"Title \"$title\"\n");
				}

				$lookedFor .= "$title\n";
				if(!lw_pageExists($title, $ns)){
					print (!$debug?"":"Not found...\n");

					/** ATTEMPT: REMOVE TRAILING PARENTHESES **/
					// If the song was still not found... chop off any trailing parentheses and try again. - SWC 20070101
					print (!$debug?"":"$title not found.\n");
					$finalSong = preg_replace("/\s*\(.*$/", "", $song);
					if($song != $finalSong){
						$title = lw_getTitle($finalName, $finalSong);
						print (!$debug?"":"Looking without parentheses for \"$title\"\n");
					}
				} else {
					print (!$debug?"":"$title found.\n");
				}

				$lookedFor .= "$title\n";
				if(!lw_pageExists($title, $ns)){
					print (!$debug?"":"Not found...\n");

					/** ATTEMPT: ORIGINAL SONG CAPITALIZATION - SWC 20110609 **/
					// If the title wasn't found from any previous tricks, try the original song capitalization that was passed in (with the possibly-rewritten artist name).
					// NOTE: lw_pageExists() caches results, so re-looking up the same one if capitalization is the same, is not a problem... however, if that ends up being
					// a lot of overhead at some point, we could make it only try this again if the new $title is not in $lookedFor already.
					if($isOuterRequest){
						$title = "$finalName:" . utf8_encode($song); // not lw_getTitle so that original capitalization survives
					} else {
						$title = "$finalName:$song"; // this was an inner (eg: recursive) request. encoding was already done.
					}
					print (!$debug?"":"Looking with original song capitalization for \"$title\"\n");
				} else {
					print (!$debug?"":"$title found.\n");
				}
			}
			$lookedFor .= "$title\n";
			if(lw_pageExists($title, $ns, $debug)){
				$finalName = $page_id = "";
				$content = lw_getPage($title, $finalName, $debug, $ns, $page_id);

				// LYR-7 - if pages are on LyricFind takedown list, remove their content here.
				$pageRemovedProp = wfGetWikiaPageProp(WPP_LYRICFIND_MARKED_FOR_REMOVAL, $page_id);
				if(!empty($pageRemovedProp)){
					// Overwrite with the same content that normal takedowns used before LF API (this lets the
					// Community easily update the text since it's a template).
					$content = "{{lyricfind_takedown}}";
				}

				// Parse the lyrics from the content.
				$matches = array();
				if(0<preg_match("/<(gracenotelyrics|lyrics?)>(.*)<.(gracenotelyrics|lyrics?)>/si", $content, $matches) || (0<preg_match("/<(gracenotelyrics|lyrics?)>(.*)/si", $content, $matches))){
					$content = $matches[2]; // Grabs lyrics if they are inside of lyrics tags.
					// Sometimes when people convert to the new lyrics tags, they forget to delete the spaces at the beginning of the lines.
					if(0<preg_match("/(\n [^\n]*)+/si", $content, $matches)){
						//$content = $matches[0];
						$content = str_replace("\n ", "\n", $content);
					}

					// In case the page uses the instrumental template but uses it inside of lyrics tags.
					if(0<preg_match("/\{\{instrumental\}\}/si", $content, $matches)){
						$content = $instrumental;
					}

					$lyricsTagFound = true;
				} else if(0<preg_match("/(\n [^\n]*)+/si", $content, $matches)){
					$content = $matches[0]; // Grabs lyrics if they use the space-at-the-beginning-of-the-line format.
					$content = str_replace("\n ", "\n", $content);
					$lyricsTagFound = true;
				} else if(0<preg_match("/\{\{instrumental\}\}/si", $content, $matches)){
					$content = $instrumental;
					$lyricsTagFound = true;
				} else if(strlen(trim($content)) > 0){
					$lyricsTagFound = false;
					// TODO: Log the page which didn't parse here for purposes of fixing poorly formatted pages.

					// NOTE: at the moment, getAlbum() depends on this result still being wikitext and parses it. This dependency will be removed when the code is refactored so that the fuzzy title-matching is not in THIS function.
				}
				$content = trim($content);
				$url = $urlRoot.$nsString.str_replace("%3A", ":", urlencode($finalName)); // %3A as ":" is for readability.
				$retVal['artist'] = $artist;
				$retVal['song'] = $song;
				$retVal['lyrics'] = $content;
				$retVal['url'] = $url;

				// Additional data to help with tracking the hits (formerly for Gracenote royalty payments, now we use LF API instead).
				$retVal['page_namespace'] = $ns;
				$retVal['page_id'] = $page_id;

				// Set the artist and song to the artist and song which were actually found (not what was passed in).
				$index = strpos($finalName, ":");
				if($index !== false){
					$retVal['artist'] = str_replace("_", " ", substr($finalName, 0, $index));
					$retVal['song'] = str_replace("_", " ", substr($finalName, ($index+1)));
				}
			}
			if(($retVal['lyrics'] == '') || ($retVal['lyrics'] == $defaultLyrics)){
				$url = $urlRoot."index.php?title=$nsString".str_replace("%3A", ":", urlencode($title)); // %3A as ":" is for readability.
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
			}

			// If there was no result, give it another try without the hyphen trick.
			if(($retVal['lyrics'] == $defaultLyrics) && ($lastHyphen !== false)){ // this logic should be kept even if isOuterRequest is false
				print (!$debug?"":"Trying again but assuming hyphens are part of the song name...\n");
				$retVal = getSong($origArtist, $hyphenSong, false, $ns, false, $debug); // the first false stops the hyphen trick from being tried again, the second false indicates that this is a recursive call
			}

			// Done looking for matches, there is either a match or not at this point.
			// Do cleanup tasks like recording stats & truncating lyrics for copyright reasons.
			// Fallback search is done afterwards.
			if($isOuterRequest){
				// Record whether a successful result was served.  Log this to get a good percentage of how many requests are made and what percentage are handled.
				if(!$SHUT_DOWN_API){
					// SWC 20090501 - Shut this down to reduce database load.  I don't generally track the success rate right now, so it's pretty flat around 50%.
					// Can re-enable this later if we actually start paying attention to this again.

					// SWC 20101017 - Rewriting this to use memcached.  Should be fast enough now.
					include_once __DIR__ . "/soap_stats.php"; // for tracking success/failure
					$resultFound = ($retVal['lyrics'] != $defaultLyrics);
					$reqType = (($wgRequest->getVal("fullApiAuth", "") == "")? LW_API_TYPE_WEB : LW_API_TYPE_MOBILE);
					lw_soapStats_logHit($resultFound, $reqType);
				}

				// Determine if this result was from the takedown list (must be done before truncating to a snippet, below).
				$retVal['isOnTakedownList'] = (0 < preg_match("/\{\{(gracenote|lyricfind)[ _]takedown\}\}/", $retVal['lyrics']));

				// SWC 20090802 - Neuter the actual lyrics :( - return an explanation with a link to the LyricWiki page.
				// SWC 20091021 - Gil has determined that up to 17% of the lyrics can be returned as fair-use - we'll stick with 1/7th (about 14.3%) of the characters for safety.
				// SWC 20151006 - allowFullLyrics is not likely to be true anymore. That was a previous feature to allow the original LyricWiki app (from 2010) to access
				// lyrics. The newer LyricWiki app (Lyrically) does NOT use this feature, it uses its own API. To see the code which handled the signature, roll back the commit
				// in which this comment appeared.
				if(!$allowFullLyrics){
					if(($retVal['lyrics'] != $defaultLyrics) && ($retVal['lyrics'] != $instrumental) && ($retVal['lyrics'] != "")){
						$urlLink = "\n\n<a href='".$retVal['url']."'>".$retVal['artist'].":".$retVal['song']."</a>";
						$lyrics = $retVal['lyrics'];

						if(mb_strlen($lyrics) < 50){
							if($lyrics == "{{lyricfind_takedown}}"){
								// TODO: INJECT THE ACTUAL RESULT OF THE TEMPLATE IN HERE INSTEAD!!
								$lyrics = "We don't currently have a license for these lyrics. Please try again in a few days!";
							} else {
								$lyrics = "[...]";
							}
						} else {
							$lyrics = mb_substr($lyrics, 0, max(0, round(mb_strlen($lyrics) / 7)), 'UTF-8') . "[...]";
						}
						//$lyrics .= "\n\n\n\n$TRUNCATION_NOTICE".$retVal['url']."$urlLink"; // we'll let apps decide how to handle this.

						// We now return the truncated version instead of just a flat-out denial.
						$retVal['lyrics'] = $lyrics;
						//$retVal['lyrics'] = $DENIED_NOTICE . $retVal['url'] . $urlLink . $DENIED_NOTICE_SUFFIX;
					}
				}

				// Make encoding work with UTF8 - NOTE: We do not apply this again to a result that the doHyphens/lastHyphen trick grabbed because that has already been encoded.
				$retVal['artist'] = utf8_encode($retVal['artist']);
				$retVal['song'] = utf8_encode($retVal['song']);
				$retVal['lyrics'] = utf8_encode($retVal['lyrics']);
			}
		}

		// If configured to do so, fallback to full wiki search.
		if($wgRequest->getBool('fallbackSearch') && ($retVal['lyrics'] == $defaultLyrics)){
			$retVal['searchResults'] = lw_getSearchResults("$artist $song");
		}
	} // end of the "if shut_down_api else"

	if($isOuterRequest){
		$retVal['isOnTakedownList'] = ($retVal['isOnTakedownList'] ? "1" : "0"); // turn it into a string
		requestFinished($id);
	}

	$retVal['lyrics'] = removeWikitextFromLyrics($retVal['lyrics']);

	wfProfileOut( __METHOD__ );
	return $retVal;
} // end getSong()

////
// Returns the discography for an artist broken up into albums.
////
function getArtist($artist){
	$id = requestStarted(__METHOD__, "$artist");
	// For now the regex makes it only read the first disc and ignore beyond that (since it assumes the track listing is over).
	$albums = array();
	GLOBAL $amazonRoot, $wgRequest;

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

	$artist = trim(rawurldecode($artist));
	$isUTF = utf8_compliant("$artist");
	$title = lw_getTitle($artist, '', (!$isUTF)); // if isUTF, skips the utf8 encoding (that is only for the values from the db... from the URL they should be fine already).

	GLOBAL $SHUT_DOWN_API;
	$correctArtist = $artist; // this will be overwritten (by reference) in lw_getPage().
	if((!$SHUT_DOWN_API) && lw_pageExists($title)){
		$content = lw_getPage($title, $correctArtist, $debug);

		// Some artists with a ton of albums have a "split catalog" which just links to the other albums.
		if(strpos($content, "SplitCatalog") !== false){
			// Find all of the albums on the page.
			$matches = array();
			if(0 < preg_match_all("/[^\n]*\[\[([^\n]*?):([^\n\|]*)\(([0-9]{4})\)(\||\]\])[^\n]*/", $content, $matches)){
				$lines = $matches[0];
				$artists = $matches[1];
				$albums = $matches[2];
				$years = $matches[3];
				for($index = 0; $index < count($artists); $index++){
					$albumPageTitle = $artists[$index].":".$albums[$index]." (".$years[$index].")";

					// Grab the content of the album page and stuff it in where the link was.
					$line = $lines[$index];
					$albumContent = lw_getPage($albumPageTitle);

					// Strip out headings from the album page (the discogrphy parser expects headings to be the album names).
					$albumContent = preg_replace("/==[^\n]*==/", "", $albumContent);

					$albumContent = "== $line ==\n$albumContent"; // needs to have the album header there so that it can be parsed.
					$content = str_replace($line, $albumContent, $content);
				}
			}
		}

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

	// If configured to do so, fallback to full wiki search.
	if($wgRequest->getBool('fallbackSearch') && (count($retVal['albums']) == 0)){
		$retVal['searchResults'] = lw_getSearchResults("$artist");
	}

	requestFinished($id);
	return $retVal;
} // end getArtist()

////
// Given the wikitext from an artist page, parse out the discographies and return them
// as an array of albums where each value is an associative array of album-data.
// eg:
// $albums = array(
//				array('album' => 'Dark Side Of The Moon', 'year' => 1973),
//				array('album' => 'Test', 'year' => 2010) // actual array will have more keys than just {album,year}
//			);
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

		// Sometimes singles are being put into the page as songs, don't add those to the discography.
		if(preg_match("/[_ ]\([0-9]{4}\)$/", $title) == 0){
			$headingStack[$size-1]['songs'][] =& $title;
		}
	}
} // end lw_pushSong()

////
// Given the chunks of wikitext returned from regexes for the album names and track-listing code,
// returns the albums that were found.
//
// TODO: REMOVE? This may not be used anymore because of the parseDiscographies stacking method.
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

/**
 * Given an artist, album-name, and year, attempts to return a matching album data (including track-listing).
 *
 * @param artist
 * @param album - album name (not including the year)
 * @param year - year the album was published
 * @return an array whose keys are 'artist', 'album' (the album name), 'year', 'amazonLink', 'imgUrl', and 'songs' which is
 * itself an array of the page-titles (as strings) of all of the songs on the album (in the order that they appear
 * on the album). The image returned will be the album cover or other appropriate image (such as the image of the artist) if
 * a suitable match can be found.  If no suitable match can be found, an empty string will be returned.
 *
 * TODO: Right now there are no guarantees about image dimensions. Should we make this method promise to only return square images
 * and use ImageServing/ImageService to do that even for the Artist images (which are the fallback)?
 */
function getAlbum($artist, $album, $year){
	wfProfileIn( __METHOD__ );
	global $amazonRoot;
	$id = requestStarted(__METHOD__, "$artist");

	// Set up the default return value
	$link = $amazonRoot . urlencode("$artist $album");
	$retVal = array('artist' => 'Staind',
					'album' => $album,
					'year' => $year,
					'amazonLink' => $link,
					'imgUrl' => '', // TODO: Should we use the default album cover here or not?
					'url' => '', // TODO: Link to the LyricWiki page
					'songs' => array());

	// TODO: ADD ALBUM-ART IMG INTO RESULT ONCE THERE IS A SERVICE TO GET IT (use the ImageService... for albums we won't even need the LyricWiki hooks for fallback to artist to start with since many, many album pages have images).
	// TODO: ADD ALBUM-ART IMG INTO RESULT ONCE THERE IS A SERVICE TO GET IT (use the ImageService... for albums we won't even need the LyricWiki hooks for fallback to artist to start with since many, many album pages have images).

	GLOBAL $SHUT_DOWN_API;
	if(!$SHUT_DOWN_API){
		// TODO: For now, we use the horrible hack of calling getSong(), then parsing the result... once the title-finding code is extracted better (that's already been done on the Vostro computer, we just need to merge that change back in and TEST the damn thing... NEEEEEEED UNIT TESTSSS!!!1!one!! FIXME!)
		$doHyphens=true; $ns=NS_MAIN; $isOuterRequest=true; $debug=false; $lyricsTagFound=false; // defaults
		$GIMME_FULL_WIKITEXT = true; // don't allow the default lyrics-truncation to happen... we need the full article
		$songResult = getSong($artist, "$album ($year)", $doHyphens, $ns, $isOuterRequest, $debug, $lyricsTagFound, $GIMME_FULL_WIKITEXT); // TODO: SWITCH TO LINE BELOW... JUST TRYING TO ENABLE DEBUG.

		$retVal['artist'] = $songResult['artist'];

		// If the title was fixed (due to capitalization, redirects, etc.), use the final version
		$matches = array();
		$finalAlbum = $songResult['song'];
		if(0 < preg_match("/^(.*) \(([0-9]{4})\)$/i", $finalAlbum, $matches)){
			$album = $matches[1];
			$year = $matches[2];
			$retVal['album'] = $album;
			$retVal['year'] = $year;
			$retVal['amazonLink'] = $amazonRoot . urlencode("$artist $album");
			$finalName = $retVal['artist'].":".$retVal['album']." (".$retVal['year'].")";
		} else {
			$finalName = $songResult['artist'].":".$songResult['song'];
		}
		$finalName = str_replace(" ", "_", $finalName);

		// TODO: Link to the LyricWiki page
		$ns = $songResult['page_namespace'];
		$LW_NS_STRING = "LyricWiki";
		$nsString = ($ns == NS_PROJECT ? $LW_NS_STRING.":" : ""); // TODO: is there a better way to get this?
		$urlRoot = "http://lyrics.wikia.com/"; // may differ from default URL, should contain a slash after it. - TODO: This is also defined in getSong()... refactor it to be global or make it a member function of a class.
		$url = $urlRoot.$nsString.str_replace("%3A", ":", urlencode($finalName)); // %3A as ":" is for readability.
		$retVal['url'] = $url;

		$content = $songResult['lyrics']; // getSong is used as a temporary hack (until the refactoring) to get the full wikitext of the article.
		if(0 < preg_match_all("/#[^\n]*\[\[(.*?)(\||\]\])/is", $content, $matches)){
			$fullNames = $matches[1];
			$songNames = array();
			foreach($fullNames as $songName){
				// Remove the artist name from the front of the link if it belongs to the same artist (to be consistent with getArtist()).
				if(startsWith($songName, $songResult['artist'].":")){
					$songName = substr($songName, strlen($songResult['artist'].":"));
				}
				$songNames[] = $songName;
			}
			$retVal['songs'] = $songNames;
		}
 	}

	requestFinished($id);
	wfProfileOut( __METHOD__ );
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
			$page = lw_getPage($title, $finalName, $debug);

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
} // end getHometown()

////
// Returns a list of the Top Songs of the moment. The list will
// contain up to 'limit' items (with a maximum of 100 and a default of 10).
//
// Currently, this is powered by the iTunes Top 100 (see http://lyrics.wikia.com/LW:100 ).
// The results contain a rank, an image URL (which may be album art for the song, an artist
// picture, or a placeholder image if nothing better is available).
////
function getTopSongs($limit){
	global $wgMemc;
	wfProfileIn( __METHOD__ );
	$id = requestStarted(__METHOD__, "$limit");

	$DEFAULT_LIMIT = 10;
	$limit = (empty($limit)?$DEFAULT_LIMIT:$limit);
	$defaultUrl = "http://lyrics.wikia.com";
	$urlRoot = "http://lyrics.wikia.com/"; // may differ from default URL, should contain a slash after it.

	// Grab the data from memcached if possible.
	$memKey = wfMemcKey('LyricWikiApi', 'server.php', 'getTopSongs');
	$retVal = $wgMemc->get($memKey);
	if(empty($retVal)){
		$retVal = array();

		$ITUNES_TOP_100_FEED_URL = "http://ax.phobos.apple.com.edgesuite.net/WebObjects/MZStore.woa/wpa/MRSS/topsongs/limit=100/rss.xml";
		$rss = Http::get($ITUNES_TOP_100_FEED_URL);

		$rank = 1;
		$matches = array();
		if(0 < preg_match_all("/<item>(.*?)<\/item>/is", $rss, $matches)){
			for($index=0; $index < count($matches[1]); $index++){
				$item = $matches[1][$index];

				$artist = $song = $image = $itunes = $url = "";

				// Grab the initial data out of the RSS feed (we'll have to post-process some of it).
				$itemMatches = array();
				if(0 < preg_match("/<itms:artist>(.*?)<\/itms:artist>/i", $item, $itemMatches)){
					$artist = htmlspecialchars_decode($itemMatches[1]);
				}
				if(0 < preg_match("/<itms:song>(.*?)<\/itms:song>/i", $item, $itemMatches)){
					$song = htmlspecialchars_decode($itemMatches[1]);
				}
				if(0 < preg_match("/<itms:coverArt height=['\"]100['\"] width=['\"]100['\"]>(.*?)<\/itms:coverArt>/i", $item, $itemMatches)){
					$image = htmlspecialchars_decode($itemMatches[1]);

					// There is a bigger size available (doesn't show up in _this_ RSS feed, but it's in others). Convert.
					$image = str_replace("100x100", "170x170", $image);
				}
				if(0 < preg_match("/<itms:link>(.*?)<\/itms:link>/i", $item, $itemMatches)){
					$link = htmlspecialchars_decode($itemMatches[1]);

					// Convert the iTunes URL into one with our affiliate link built into it.
					$matches = array();
					if(0 < preg_match("/[^w]id([0-9]+).*?[^w]i=([0-9]+)/i", $link, $matches)){
						$id = $matches[1];
						$i = $matches[2];

						$link = "http://click.linksynergy.com/fs-bin/stat?id=gRMzf83mih4&amp;offerid=78941&amp;type=3&amp;subid=0&amp;tmpid=1826&amp;RD_PARM1=http%253A%252F%252Fitunes.apple.com%252Fus%252Falbum%252F";
						$link .= "id$id%253Fi%253D3$i";
						$link .= "%2526partnerId%253D30";
					}

					$itunes = $link;
				}

				// Make LW url.
				$url = $defaultUrl;
// TODO: FORMAT THE artist/song correctly and use lw_pageExists or whatever to figure out the correct name (or call getSong on it?).
// TEMP HACK TO JUST MAKE THIS URL UP... WILL NOTTTT BE OKAY TO RELEASE IT LIKE THIS SINCE IT WOULD GIVE A TON OF BAD URLs EVEN WHEN WE HAVE GOOD URLS:
$finalName = "$artist:$song";
// TODO: ACCOMPLISH THIS BY EXTRACTING THE TITLE-MATCHING, IMPLIED REDIRECTS, ETC. FROM getSong() INTO A DIFF FUNCTION (maybe call it findMatchingPageTitle?).  ...when doing that, checkSongExists() should probably also use the new function.
				$finalName = str_replace(" ", "_", $finalName);
				$url = $urlRoot.str_replace("%3A", ":", urlencode($finalName)); // %3A as ":" is for readability.

				// LATER: Add album to the return array? (could build it from itms:artist, itms:album, and itms:releasedate).

				$itemData = array(
					'rank' => $rank++,
					'artist' => $artist,
					'song' => $song,
					'image' => $image,
					'itunes' => $itunes,
					'url' => $url,
				);

				$retVal[] = $itemData;
			}

			// Store this maximum-sized array of results in memcached.
			$HOURS_TO_CACHE = 2;
			$wgMemc->set($memKey, $retVal, 60 * 60 * $HOURS_TO_CACHE);
		}
	}

	// Trim the array to the size desired by the client.
	$retVal = array_slice($retVal, 0, $limit);

	requestFinished($id);
	wfProfileOut( __METHOD__ );

	return $retVal;
} // end getTopSongs()

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
		global $wgUser;
		if(!$wgUser->isLoggedIn()){
			// If this is a SOAP request, the credentials may be in the SOAP headers.
			global $funcsOnly;
			if($funcsOnly){
				// Not a SOAP request, so we have to already be logged in.
				$retVal['message'] = "Must be logged in to use postArtist().";
			} else {
				lw_tryLogin();
			}
		}

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
			$editWorked = lw_createPage($pageTitle, $content, $summary);
			$retVal['dataUsed'] = true;
			if($editWorked !== true){
				$retVal['message'] = "Error from EditPage: $editWorked";
			} else if(isset($pageTitle) && $pageExists){
				$retVal['message'] = "Page overwritten. ";
			} else {
				$retVal['message'] = "Page created. ";
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
function postSong($overwriteIfExists, $artist, $song, $lyrics, $onAlbums, $flags="", $language=""){
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
		global $wgUser;
		if(!$wgUser->isLoggedIn()){
			// If this is a SOAP request, the credentials may be in the SOAP headers.
			global $funcsOnly;
			if($funcsOnly){
				// Not a SOAP request, so we have to already be logged in.
				$retVal['message'] = "Must be logged in to use postSong()."; // NOTE: Not enforced... anons can edit.
			} else {
				lw_tryLogin();
			}
		}

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
				$mainAlbum = array_shift($onAlbums);
				$mainAlbumName = $mainAlbum['album']." (".$mainAlbum['year'].")";
				$content .= "{{Song|$mainAlbumName|$artist|star=green}}\n";

				// If there are additional albums, they go in the AddAlb template.
				if(count($onAlbums) > 0){
					$content .= "{{AddAlb\n";
					for($cnt=0; $cnt<count($onAlbums); $cnt++){
						$currArtist = $onAlbums[$cnt]['artist']; // needed because of compilations
						$albumName = $onAlbums[$cnt]['album']." (".$onAlbums[$cnt]['year'].")";
						if($currArtist != "" && $currArtist != $artist){
							$albumName = "$currArtist:$albumName"; // if this is an artist other than the current song's artist, prepend their name
							$content .= "|album".($cnt+2)."=$albumName |".($cnt+2)."type=compilation\n";
						} else {
							// Parameters start with "album2".
							$content .= "|album".($cnt+2)."=$albumName\n";
						}
					}
					$content .= "}}\n";
				}
			} else {
				$content .= "{{Song||".str_replace("_", " ", $artistName)."}}\n";
			}
			$content .= "<lyrics>\n$lyrics</lyrics>\n";
			$fLetter = lw_fLetter($song);
			$content .= "
{{SongFooter
|fLetter     = $fLetter
|song        = $song
|language    = $language
|youtube     =
|goear       =
|asin        =
|iTunes      =
|musicbrainz =
|allmusic    =
}}";
			$summary = "Page ".(($pageExists)?"edited":"created")." using the [[LyricWiki:API|LyricWiki API]]";
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

/**
 * Uses our search backend via the SimpleSearch module to find reasonable matches
 * for the search string. These aren't perfect at exact matches, etc. and is more
 * designed as a fallback to use when exact matches can't be found.
 *
 * @param searchString - the text string to search for using SimpleSearch.
 * @return an array of strings which are the textForm of the page title (eg: "Cake:Dime").
 */
function lw_getSearchResults($searchString, $maxResults=25){
	global $wgCityId;
	$titles = array();

	try {
		$wikiaSearchConfig = new Wikia\Search\Config();
		$wikiaSearchConfig->setNamespaces( array( NS_MAIN ) )
			->setQuery( $searchString )
			->setLimit( $maxResults );

		$wikiaSearch = (new Wikia\Search\QueryService\Factory)->getFromConfig( $wikiaSearchConfig );
		$resultSet = $wikiaSearch->search();
		$found = $resultSet->getResultsFound();

		if ( !empty( $found ) ) {
			foreach ( $resultSet as $result ) {
				$titles[] = $result->getTitle();
			}
		}
	} catch( WikiaException $e ) {
		// TODO: Add logging of some sort.  For now, just return empty results and don't handle the error.
	}

	return $titles;
} // end lw_getSearchResults()

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
	$retVal = preg_replace_callback('/([-\("\.])([a-z])/', function($m){ return $m[1].strtoupper($m[2]); }, $retVal);
	$retVal = str_replace(" ", "_", $retVal);
	return $retVal;
} // end lw_fmtArtist()

function lw_fmtAlbum($album,$year){
	$year = ($year==""?"????":$year);
	return lw_fmtSong($album)." ($year)";
} // end lw_fmtAlbum()

////
// Returns the standardly formatted song name.
////
function lw_fmtSong($song){
	$retVal = ucwords(rawurldecode($song));
	$retVal = preg_replace_callback('/([-\("\.])([a-z])/', function($m){ return $m[1].strtoupper($m[2]); }, $retVal);
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
} // end lw_fLetter()

////
// Returns the correctly formatted pagename from the artist and the song.
//
// If allowAllCaps is true, the ARTIST name will be kept as all-capitals if that is how it was passed in.
////
function lw_getTitle($artist, $song='', $applyUnicode=true, $allowAllCaps=true){
	$artist = trim($artist);
	$song = trim($song);
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
	$title = preg_replace_callback('/([-\("\.\/:_])([a-z])/', function($m){ return $m[1].strtoupper($m[2]); }, $title);
	$title = preg_replace_callback('/\b(O)[\']([a-z])/i', function($m){ return $m[1].strtoupper("'".$m[2]); }, $title); // single-quotes like above, but this is needed to avoid escaping the single-quote here.  Does it to "O'Riley" but not "I'm" or "Don't"
	$title = preg_replace_callback('/( \()[\']([a-z])/i', function($m){ return $m[1].strtoupper("'".$m[2]); }, $title); // single-quotes like above, but this is needed to avoid escaping the single-quote here.
	$title = preg_replace_callback('/ [\']([a-z])/i', function($m){ return " ".strtoupper("'".$m[1]); }, $title); // single-quotes like above, but this is needed to avoid escaping the single-quote here.
	$title = strtr($title, " ", "_"); // Warning: multiple-byte substitutions don't seem to work here, so smart-quotes can't be fixed in this line.

	// Naming conventions. See: http://www.lyricwiki.org/LyricWiki:Page_names
	// Common contractions.  Our standards USE the contractions.
	$title = preg_replace("/Aint([^a-z]|$)/", "Ain't$1", $title);
	$title = preg_replace("/Dont([^a-z]|$)/", "Don't$1", $title);
	$title = preg_replace("/Cant([^a-z]|$)/", "Can't$1", $title);

	return $title;
} // end lw_getTitle()

////
// Simple function to see if a page exists given its properly formatted page name.
// Returns a boolean, true if page exists, false if it doesn't.
//
// Caches results, so it is safe to call multiple times on same run.
////
GLOBAL $EXIST_CACHE;
function lw_pageExists($pageTitle, $ns=NS_MAIN, $debug=false){
	wfProfileIn( __METHOD__ );

	GLOBAL $EXIST_CACHE;
	if(!isset($EXIST_CACHE)){
		$EXIST_CACHE = array();
	}
	$pageTitle = str_replace(" ", "_", $pageTitle);

	if(isset($EXIST_CACHE["$ns:$pageTitle"])){
		print (!$debug?"":"Using cached value for $ns:$pageTitle\n");
		$retVal = $EXIST_CACHE["$ns:$pageTitle"];
	} else {
		$pageTitleObj = Title::newFromText( $pageTitle, $ns );

		$retVal = $pageTitleObj instanceof Title && $pageTitleObj->exists();
		$EXIST_CACHE["$ns:$pageTitle"] = $retVal;
	}
	print (!$debug?"":"Page exists: ".($retVal?"yes":"no")."\n");

	wfProfileOut( __METHOD__ );
	return $retVal;
} // end lw_pageExists()

////
// Returns the content of the page with the given page title.
// Returns an empty string if the page is not found.
// Automatically compensates for redirects.
//
// @param finalName - If there are redirects, finalName will be modified to
//    contain the pageName of the page which the redirection stops upon.
// @param debug - if true, prints debugging statements
// @param page_namespace - is the namespace that the page is in
// @param page_id - If the page is found to be an existing article, then page_id will be set
// to the Article id (which matches page.page_id).
////
function lw_getPage($pageTitle, &$finalName='', $debug=false, $page_namespace=NS_MAIN, &$page_id=''){
	$retVal = "";
	$finalName = $pageTitle;

	// Get the text of the end-point article and record what the final article name is.
	$title = Title::newFromText($pageTitle, $page_namespace);
	if( $title ) {
		if($title->exists()){
			$page_id = $title->getArticleID();

			$article = Article::newFromID($title->getArticleID());
			if( is_object($article) ){
				/* @var $article WikiPage */
				if($article->isRedirect()){
					$reTitle = $article->followRedirect(); // follows redirects recursively
					if ($reTitle instanceof Title) {
						$article = Article::newFromId($reTitle->getArticleID());
					}
					else {
						$article = null;
					}
				}
				if( is_object($article) ){
					$finalName = $article->getTitle()->getDBkey();
					$retVal = $article->getRawText();
				}
			}
		}
	}
	//	print (!$debug?"":"page code\n$retVal\n");

	return $retVal;
} // end lw_getPage()

////
// Given the vital information for a page, creates it.
// WARNING: MUST CHECK FIRST TO SEE IF THE PAGE EXISTS
// @returns true on success, error-code from EditPage on failure.
////
function lw_createPage($titleObj, $content, $summary="Page created using [[LyricWiki:SOAP|LyricWiki's SOAP Webservice]]"){
	global $wgUser;
	wfProfileIn( __METHOD__ );

	$retVal = "";

	if($titleObj == null){
		$retVal = "Title object was null in lw_createPage. This probably means that the string used to create it was invalid (which could be caused by bad unicode characters).";
	} else if(is_string($titleObj)){
		$retVal = "Passed a string into lw_createPage() for the pageTitle instead of passing a Title object. Tip: use Title::newFromDBkey() to convert strings into titles.";
	} else if(!is_object($titleObj)){
		$retVal = "Title object not an object. Please pass a title object into lw_createPage().";
	} else {
		// Create the Article object.
		$article = new Article($titleObj); /* @var $article WikiPage */

		$result = null;

		$editPage = new EditPage( $article );
		$editPage->edittime = $article->getTimestamp();
		$editPage->textbox1 = $content;

		$bot = $wgUser->isAllowed('bot');
		//this function calls Article::onArticleCreate which clears cache for article and it's talk page - NOTE: I don't know what this comment refers to... it was coppied from /extensions/wikia/ArticleComments/ArticleComment.class.php
		$status = $editPage->internalAttemptSave( $result, $bot );

		$value = $status->value;

		if(($value == EditPage::AS_SUCCESS_NEW_ARTICLE) || ($value == EditPage::AS_SUCCESS_UPDATE)){
			$retVal = true;
		} else {
			$retVal = $status->getMessage();
		}
	}

	wfProfileOut( __METHOD__ );
	return $retVal;
} // end lw_createPage()

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
				$u->setGlobalPreference( 'rememberpassword', $r );
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
	wfProfileIn( __METHOD__ );

	if( !wfReadOnly() ) {
		GLOBAL $wgMemc, $wgRequest;
		$NUM_FAILS_TO_SPOOL = 10;

		// Store the soapfailures from mobile requests in a diff. table so that we know what users are
		// searching for in that specific use-case.
		$fullApiAuth = $wgRequest->getVal('fullApiAuth', '');
		if(empty($fullApiAuth)){
			$tableName = "lw_soap_failures";
		} else {
			$tableName = "lw_soap_failures_mobile";
			$NUM_FAILS_TO_SPOOL = 0; // there are way less requests to mobile, so don't spool for now.
		}

		wfDebug("LWSOAP: Recording failure for \"$origArtistSql:$origSongSql\"\n");

		// Spool a certain number of updates in memcache before writing to db.
		// macbre: added str_replace (RT #59011)
		// eloy, changed to md5
		$memkey = wfMemcKey( 'lw_soap_failure', md5( sprintf( "%s:%s", $origArtistSql, $origSongSql ) ) );
		$numFails = $wgMemc->get( $memkey );
		if(empty($numFails) && ($NUM_FAILS_TO_SPOOL > 0)){
			wfDebug("LWSOAP: Setting $memkey to 1\n");
			$wgMemc->set($memkey, 1);
		} else if(($numFails + 1) >= $NUM_FAILS_TO_SPOOL){
			wfDebug("LWSOAP: Storing the failure in the database.\n");
			$numFails += 1;

			$dbw = wfGetDB( DB_MASTER );
			$origSongSql = $dbw->strencode( $origSongSql );
			$origArtistSql = $dbw->strencode( $origArtistSql );
			$lookedForSql = $dbw->strencode( $lookedForSql );
			$queryString = "INSERT INTO $tableName (request_artist,request_song, lookedFor, numRequests) VALUES ('$origArtistSql', '$origSongSql', '$lookedForSql', '$numFails') ON DUPLICATE KEY UPDATE numRequests=numRequests+$numFails";
			if($dbw->query($queryString)){
				$dbw->commit();
				wfDebug("LWSOAP: Stored in the database successfully.\n");
				$wgMemc->delete($memkey);
			} else {
				wfDebug("LWSOAP: Error storing SOAP failure!! - " . mysql_error() . "\n");
			}
		} else {
			wfDebug("LWSOAP: Updating $memkey to " . ($numFails + 1) . "\n");
			$wgMemc->set($memkey, $numFails + 1);
		}
	}

	wfProfileOut( __METHOD__ );
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
			$queryString.= " VALUES ('$REQUEST_TYPE', '".mysql_real_escape_string($funcName, $db)."', '".mysql_real_escape_string($requestData, $db)."', NOW())";
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

////
// Given the lyrics (possibly containing wikitext) this will filter
// most wikitext out of them that is likely to appear in them.
////
function removeWikitextFromLyrics($lyrics){
	// Clean up wikipedia template to be plaintext
	$lyrics = preg_replace("/\{\{wp.*\|(.*?)\}\}/", "$1", $lyrics);

	// Clean up links & category-links to be plaintext
	$lyrics = preg_replace("/\[\[([^\|\]]*)\]\]/", "$1", $lyrics); // links with no alias (no pipe)
	$lyrics = preg_replace("/\[\[.*\|(.*?)\]\]/", "$1", $lyrics);

	// Filter out extra formatting markup
	$lyrics = preg_replace("/'''/", "", $lyrics); // rm bold
	$lyrics = preg_replace("/''/", "", $lyrics); // rm italics

	return $lyrics;
} // end removeWikitextFromLyrics()


<?php
/**
* Bot Query extension for MediaWiki 1.7+
*
* Copyright (C) 2006 Yuri Astrakhan <Firstname><Lastname>@gmail.com
* Uses bits from the original query.php code written by Tim Starling.
*
* This program is free software; you can redistribute it and/or modify
* it under the terms of the GNU General Public License as published by
* the Free Software Foundation; either version 2 of the License, or
* (at your option) any later version.
*
* This program is distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
* GNU General Public License for more details.
*
* You should have received a copy of the GNU General Public License along
* with this program; if not, write to the Free Software Foundation, Inc.,
* 59 Temple Place - Suite 330, Boston, MA 02111-1307, USA.
* http://www.gnu.org/copyleft/gpl.html
*/

$startTime = microtime(true);
$IP = getenv( 'MW_INSTALL_PATH' );
if ( $IP === false ) {
	$IP = dirname( realpath( __FILE__ ) ) . '/../..';
}
chdir( $IP );

// Allow requests to go to an alternative site (proxying)
$proxySite = GetCleanProxyValue('proxysite');
$proxyLang = GetCleanProxyValue('proxylang');

if ($proxySite || $proxyLang) {

	$_COOKIE = array();     // Security measure - treat all requests as anonymous

	// Set magic values $site & $lang.
	// This will only work if the target site is hosted on the same cluster
	if ($proxySite) $site = $proxySite;
	if ($proxyLang) $lang = $proxyLang;
}

if ( file_exists( "$IP/includes/WebStart.php" ) ) {
	require_once( "$IP/includes/WebStart.php" );
	# $startTime may have been unset by register_globals protector
	$startTime = $wgRequestTime;
} else {
	define( 'MEDIAWIKI', true );
	if ( isset( $_REQUEST['GLOBALS'] ) ) {
		echo '<a href="http://www.hardened-php.net/index.76.html">$GLOBALS overwrite vulnerability</a>';
		die( -1 );
	}

	define( 'MW_NO_OUTPUT_BUFFER', true );
	$wgNoOutputBuffer = true;

	require_once( "$IP/includes/Defines.php" );
	require_once( "$IP/LocalSettings.php" );
	require_once( "$IP/includes/Setup.php" );
}

// URL safety checks
//
// See RawPage.php for details; summary is that MSIE can override the
// Content-Type if it sees a recognized extension on the URL, such as
// might be appended via PATH_INFO after 'api.php'.
//
// Some data formats can end up containing unfiltered user-provided data
// which will end up triggering HTML detection and execution, hence
// XSS injection and all that entails.
//
// Ensure that all access is through the canonical entry point...
//
if( isset( $_SERVER['SCRIPT_URL'] ) ) {
	$url = $_SERVER['SCRIPT_URL'];
} else {
	$url = $_SERVER['PHP_SELF'];
}
if( !preg_match( '!/query\.php$!', $url ) ) {
	wfHttpError( 403, 'Forbidden',
		'API must be accessed through the primary script entry point.' );
	return;
}

wfProfileIn( 'query.php' );

define( 'GN_FUNC', 	   0 );
define( 'GN_MIME',     1 );
define( 'GN_ISMETA',   1 );
define( 'GN_PARAMS',   2 );
define( 'GN_DFLT', 	   3 );
define( 'GN_DESC',     4 );

// Multi-valued enums, limit the values user can supply for the parameter
define( 'GN_ENUM_DFLT',     0 );
define( 'GN_ENUM_ISMULTI',  1 );
define( 'GN_ENUM_CHOICES',  2 );

// Use this constant to avoid filtering by namespace
define( 'NS_ALL_NAMESPACES', -10123 );

// Forward-compat safety checks
if( !@$wgEnableAPI ) {
	wfHttpError( 403, 'Forbidden',
		"MediaWiki API is not enabled for this site. " .
		"Add the following line to your LocalSettings.php\n\n" .
		"\$wgEnableAPI=true;" );
	return;
}

if( !@$wgGroupPermissions['*']['read'] ) {
	wfHttpError( 403, 'Forbidden',
		"MediaWiki API is unavailable for this site due to restricted permissions." );
	return;
}

$bqp = new BotQueryProcessor( $startTime );
$bqp->execute();
$bqp->output();

wfProfileOut( 'query.php' );
if ( function_exists( 'wfLogProfilingData' ) ) {
	wfLogProfilingData();
}

class BotQueryProcessor {
	/**
	* Output generators - each format name points to an array of the following parameters:
	*     0) Function to call
	*     1) mime type
	*     2) array of accepted parameters
	*     3) array of default parameter values
	*     4) Format description
	*/
	var $outputGenerators = array(
		'xmlfm'=> array(
			GN_FUNC => 'printFormattedXML',
			GN_MIME => 'text/html',
			GN_PARAMS => array('nousage'),
			GN_DFLT => array(null),
			GN_DESC => array(
				"XML format in HTML (Default)",
				"The data is presented as an indented syntax-highlighted XML format.",
				"Errors will return this usage screen, unless 'nousage' parameter is given.",
				"Example: query.php?what=info&format=xmlfm",
			)),
		'jsonfm'=> array(
			GN_FUNC => 'printFormattedJSON',
			GN_MIME => 'text/html',
			GN_PARAMS => null,
			GN_DFLT => null,
			GN_DESC => array(
				"JSON format in HTML",
				"Example: query.php?what=info&format=jsonfm      (Format info: http://en.wikipedia.org/wiki/JSON)",
			)),
		'yamlfm'=> array(
			GN_FUNC => 'printFormattedYAML',
			GN_MIME => 'text/html',
			GN_PARAMS => null,
			GN_DFLT => null,
			GN_DESC => array(
				"YAML format in HTML",
				"Example: query.php?what=info&format=yamlfm      (Format info: http://en.wikipedia.org/wiki/YAML)",
			)),
		'txt' => array(
			GN_FUNC => 'printFormattedTXT',
			GN_MIME => 'text/html',
			GN_PARAMS => null,
			GN_DFLT => null,
			GN_DESC => array(
				"print_r() output (HTML)",
				"Example: query.php?what=info&format=txt         (Format info: http://www.php.net/print_r)",
			)),
		'dbg' => array(
			GN_FUNC => 'printFormattedDBG',
			GN_MIME => 'text/html',
			GN_PARAMS => null,
			GN_DFLT => null,
			GN_DESC => array(
				"PHP source code using var_export() (HTML)",
				"Example: query.php?what=info&format=dbg         (Format info: http://www.php.net/var_export)",
				"", // empty line - following are all machine readable
			)),
		'xml' => array(
			GN_FUNC => 'printXML',
			GN_MIME => 'text/xml',
			GN_PARAMS => array('xmlindent', 'nousage'),
			GN_DFLT => array(null, null),
			GN_DESC => array(
				"XML format",
				"Optional indentation can be enabled by supplying 'xmlindent' parameter.",
				"Errors will return this usage screen, unless 'nousage' parameter is given.",
				"Internet Explorer is known to have many issues with text/xml output.",
				"Please use other browsers or switch to xmlfm format while debugging.",
				"Example: query.php?what=info&format=xml",
			)),
		'json'=> array(
			GN_FUNC => 'printJSON',
			GN_MIME => 'application/json',
			GN_PARAMS => null,
			GN_DFLT => null,
			GN_DESC => array(
				"JSON format",
				"Example: query.php?what=info&format=json        (Format info: http://en.wikipedia.org/wiki/JSON)",
			)),
		'php' => array(
			GN_FUNC => 'printPHP',
			GN_MIME => 'application/vnd.php.serialized',
			GN_PARAMS => null,
			GN_DFLT => null,
			GN_DESC => array(
				"PHP serialized format using serialize()",
				"Example: query.php?what=info&format=php         (Format info: http://www.php.net/serialize)",
			)),
		'yaml'=> array(
			GN_FUNC => 'printYAML',
			GN_MIME => 'application/yaml',
			GN_PARAMS => null,
			GN_DFLT => null,
			GN_DESC => array(
				"YAML format",
				"Example: query.php?what=info&format=yaml        (Format info: http://en.wikipedia.org/wiki/YAML)",
			)),
		'wddx' => array(
			GN_FUNC => 'printWDDX',
			GN_MIME => 'text/xml',
			GN_PARAMS => null,
			GN_DFLT => null,
			GN_DESC => array(
				"WDDX - Web Distributed Data eXchange format",
				"Example: query.php?what=info&format=wddx        (Format info: http://en.wikipedia.org/wiki/WDDX)",
			)),
	);

	/**
	* Properties generators - each property points to an array of the following parameters:
	*     0) Function to call
	*     1) true/false - does this property work on individual pages?  (false for site's metadata)
	*     2) array of accepted parameters
	*     3) array of default parameter values. If the default value is an array itself, only the listed values are allowed, and the 1st value is taken as default.
	*     4) Format description
	*/
	var $propGenerators = array(

		// Site-wide Generators
		'info'           => array(
			GN_FUNC => 'genMetaSiteInfo',
			GN_ISMETA => true,
			GN_PARAMS => null,
			GN_DFLT => null,
			GN_DESC => array(
				"General site information",
				"Example: query.php?what=info",
			)),
		'namespaces'     => array(
			GN_FUNC => 'genMetaNamespaceInfo',
			GN_ISMETA => true,
			GN_PARAMS => null,
			GN_DFLT => null,
			GN_DESC => array(
				"List of localized namespace names",
				"Example: query.php?what=namespaces",
			)),
		'userinfo'       => array(
			GN_FUNC => 'genMetaUserInfo',
			GN_ISMETA => true,
			GN_PARAMS => array( 'uiisblocked', 'uihasmsg', 'uiextended', 'uioptions' ),
			GN_DFLT => array( false, false, false, null ),
			GN_DESC => array(
				"Information about current user.",
				"The information will always include 'name' element, and optionally 'anonymous' or 'bot' flags.",
				"Parameters supported:",
				"uiisblocked- If present, and current user or IP is blocked, a 'blocked' flag will be added.",
				"uihasmsg   - If present, and current user or IP has messages waiting, a 'messages' flag will be added.",
				"uiextended - If present, includes additional information such as rights and groups.",
				"uioptions  - A list of user preference options to get, separated by '|'. For the complete list see User.php source file.",
				"Example: query.php?what=userinfo&uiisblocked&uihasmsg&uiextended",
				"         query.php?what=userinfo&uioptions=timecorrection|skin  -- get user's timezone and chosen skin",
			)),
		'recentchanges'  => array(
			GN_FUNC => 'genMetaRecentChanges',
			GN_ISMETA => true,
			GN_PARAMS => array( 'rcfrom', 'rclimit', 'rchide' ),
			GN_DFLT => array( null, 50,
				array( GN_ENUM_DFLT => null,
					   GN_ENUM_ISMULTI => true,
					   GN_ENUM_CHOICES => array(null, 'minor', 'bots', 'anons', 'liu') )),
			GN_DESC => array(
				"Adds recently changed articles to the output list.",
				"Parameters supported:",
				"rcfrom     - Timestamp of the first entry to start from. The list order reverses.",
				"rclimit    - How many total links to return.",
				"             Smaller size is possible if pages changes multiple times.",
				"rchide     - Which entries to ignore 'minor', 'bots', 'anons', 'liu' (loged-in users).",
				"             Cannot specify both anons and liu.",
				"Example: query.php?what=recentchanges&rchide=liu|bots",
			)),
		'allpages'       => array(
			GN_FUNC => 'genMetaAllPages',
			GN_ISMETA => true,
			GN_PARAMS => array( 'aplimit', 'apfrom', 'apnamespace', 'apfilterredir' ),
			GN_DFLT => array( 50, '', 0,
				array( GN_ENUM_DFLT => 'all',
					   GN_ENUM_ISMULTI => false,
					   GN_ENUM_CHOICES => array('all', 'redirects', 'nonredirects') )),
			GN_DESC => array(
				"Enumerates all available pages to the output list.",
				"Parameters supported:",
				"aplimit      - How many total pages to return",
				"apfrom       - The page title to start enumerating from.",
				"apnamespace  - Limits which namespace to enumerate. Default 0 (Main)",
				"apfilterredir- Which pages to list: 'all' (default), 'redirects', or 'nonredirects'",
				"Example: query.php?what=allpages&aplimit=50    (first 50 pages)",
				"         query.php?what=allpages&aplimit=20&apnamespace=10&apfrom=C&apfilterredir=nonredirects",
				"                                               (20 templates starting with 'C' that are not redirects)",
			)),
		'nolanglinks'    => array(
			GN_FUNC => 'genMetaNoLangLinksPages',
			GN_ISMETA => true,
			GN_PARAMS => array( 'nllimit', 'nlfrom', 'nlnamespace' ),
			GN_DFLT => array( 50, '', 0 ),
			GN_DESC => array(
				"Enumerates pages without language links to the output list (automatically filters out redirects).",
				"Parameters supported:",
				"nllimit      - How many total pages to return",
				"nlfrom       - The page title to start enumerating from.",
				"nlnamespace  - Limits which namespace to enumerate. Default 0 (Main)",
				"Example: query.php?what=nolanglinks&nllimit=10&nlfrom=A",
			)),
		'category'       => array(
			GN_FUNC => 'genPagesInCategory',
			GN_ISMETA => true,
			GN_PARAMS => array( 'cptitle', 'cplimit', 'cpfrom', 'cpnamespace', 'cpextended' ),
			GN_DFLT => array( null, 200, '', NS_ALL_NAMESPACES, false ),
			GN_DESC => array(
				"Adds pages in a given category to the output list.",
				"Parameters supported:",
				"cptitle    - A category name, either with or without the 'Category:' prefix.",
				"cplimit    - How many total pages (in category) to return.",
				"cpfrom     - The category sort key to continue paging. Starts at the beginning by default.",
				"cpnamespace- Optional namespace id: Includes only the pages in the category that are in one namespace.",
				"cpextended - Add extra information like sortkey and timestamp to the category output.",
				"Example: query.php?what=category&cptitle=Days",
				"         query.php?what=category&cptitle=Time&cpnamespace=14 -- show subcategories of category Time",
			)),
		'users'          => array(
			GN_FUNC => 'genUserPages',
			GN_ISMETA => true,
			GN_PARAMS => array( 'usfrom', 'uslimit' ),
			GN_DFLT => array( null, 50 ),
			GN_DESC => array(
				"Adds user pages to the output list.",
				"Parameters supported:",
				"usfrom     - Start user listing from...",
				"uslimit    - How many total links to return.",
				"Example: query.php?what=users&usfrom=Y",
			)),
//		'watchlist'      => array(
//			GN_FUNC => 'genUserWatchlist',
//			GN_ISMETA => true,
//			GN_PARAMS => null,
//			GN_DFLT => null,
//			GN_DESC => array(
//				"Adds user's watchlist pages to the output list.",
//				"Example: query.php?what=watchlist",
//			)),

		//
		// Page-specific Generators
		//
		'redirects'      => array(
			GN_FUNC => 'genRedirectInfo',
			GN_ISMETA => false,
			GN_PARAMS => null,
			GN_DFLT => null,
			GN_DESC => array(
				"For all given redirects, provides additional information such as page IDs and double-redirection",
				"Example: query.php?what=redirects&titles=Main_page",
				"         query.php?what=recentchanges|redirects  (Which of the recent changes are redirects?)",
			)),
		'permissions'    => array(
			GN_FUNC => 'genPermissionsInfo',
			GN_ISMETA => false,
			GN_PARAMS => array( 'prcanmove' ),
			GN_DFLT => array( false ),
			GN_DESC => array(
				"For all found pages, check if the user can edit them.",
				"Parameters supported:",
				"prcanmove  - Also check if the page can be moved.",
				"Example: query.php?what=permissions&titles=Main_page|User%20Talk:Yurik",
			)),
		'links'          => array(
			GN_FUNC => 'genPageLinksHelper',
			GN_ISMETA => false,
			GN_PARAMS => null,
			GN_DFLT => null,
			GN_DESC => array(
				"List of regular page links",
				"Example: query.php?what=links&titles=MediaWiki|Wikipedia",
			)),
		'langlinks'      => array(
			GN_FUNC => 'genPageLinksHelper',
			GN_ISMETA => false,
			GN_PARAMS => null,
			GN_DFLT => null,
			GN_DESC => array(
				"Inter-language links",
				"Example: query.php?what=langlinks&titles=MediaWiki|Wikipedia",
			)),
		'templates'      => array(
			GN_FUNC => 'genPageLinksHelper',
			GN_ISMETA => false,
			GN_PARAMS => null,
			GN_DFLT => null,
			GN_DESC => array(
				"List of used templates",
				"Example: query.php?what=templates&titles=Main_Page",
			)),
		'categories'     => array(
			GN_FUNC => 'genPageCategoryLinks',
			GN_ISMETA => false,
			GN_PARAMS => array( 'clextended' ),
			GN_DFLT => array( false ),
			GN_DESC => array(
				"List of categories the page belongs to",
				"Parameters supported:",
				"clextended - Add extra information like sortkey and timestamp",
				"Example: query.php?what=categories&titles=Albert%20Einstein&clextended",
			)),
		'backlinks'      => array(
			GN_FUNC => 'genPageBackLinksHelper',
			GN_ISMETA => false,
			GN_PARAMS => array( 'bllimit', 'blcontfrom', 'blnamespace', 'blfilter' ),
			GN_DFLT => array( 50, null, NS_ALL_NAMESPACES,
				array( GN_ENUM_DFLT => 'existing',
					   GN_ENUM_ISMULTI => false,
					   GN_ENUM_CHOICES => array('redirects', 'nonredirects', 'existing', 'all') )),
			GN_DESC => array(
				"What pages link to this page(s)",
				"Parameters supported:",
				"blfilter   - Of all given pages, which should be queried:",
				"  'redirects', 'nonredirects', 'existing' (blue links, default), or 'all' (red links)",
				"blnamespace- Optional namespace id: limits the namespace of the originating pages",
				"bllimit    - How many total links to return",
				"blcontfrom - From which point to continue. Use the 'next' value from the previous queries.",
				"Example: query.php?what=backlinks&titles=Main%20Page&bllimit=10",
			)),
		'embeddedin'     => array(
			GN_FUNC => 'genPageBackLinksHelper',
			GN_ISMETA => false,
			GN_PARAMS => array( 'eilimit', 'eicontfrom', 'einamespace', 'eifilter' ),
			GN_DFLT => array( 50, null, NS_ALL_NAMESPACES,
				array( GN_ENUM_DFLT => 'existing',
					   GN_ENUM_ISMULTI => false,
					   GN_ENUM_CHOICES => array('redirects', 'nonredirects', 'existing', 'all') )),
			GN_DESC => array(
				"What pages include this page(s) as template(s)",
				"Parameters supported:",
				"eifilter   - Of all given pages, which should be queried:",
				"  'redirects', 'nonredirects', 'existing' (blue links, default), or 'all' (red links)",
				"einamespace- Optional namespace id: limits the namespace of the originating pages",
				"eilimit    - How many total links to return",
				"eicontfrom - From which point to continue. Use the 'next' value from the previous queries.",
				"Example: query.php?what=embeddedin&titles=Template:Stub&eilimit=10",
			)),
		'imagelinks'     => array(
			GN_FUNC => 'genPageBackLinksHelper',
			GN_ISMETA => false,
			GN_PARAMS => array( 'illimit', 'ilcontfrom', 'ilnamespace', 'ilfilter' ),
			GN_DFLT => array( 50, null, NS_ALL_NAMESPACES,
				array( GN_ENUM_DFLT => 'all',
					   GN_ENUM_ISMULTI => false,
					   GN_ENUM_CHOICES => array('existing', 'all') )),
			GN_DESC => array(
				"What pages use this image(s)",
				"ilfilter   - Of all given images, which should be queried:",
				"  'existing', 'all' (default, includes non-existent or those stored on Wikimedia Commons)",
				"ilnamespace- Optional namespace id: limits the namespace of the originating pages",
				"illimit    - How many total links to return",
				"ilcontfrom - From which point to continue. Use the 'next' value from the previous queries.",
				"Example: query.php?what=imagelinks&titles=Image:HermitageAcrossNeva.jpg&illimit=10",
			)),
		'revisions'      => array(
			GN_FUNC => 'genPageRevisions',
			GN_ISMETA => false,
			GN_PARAMS => array( 'rvuniqusr', 'rvcomments', 'rvcontent', 'rvlimit', 'rvoffset', 'rvstart', 'rvend', 'rvrbtoken' ),
			GN_DFLT => array( false, false, false, 10, 0, null, null, false ),
			GN_DESC => array(
				"Revision history - Lists edits performed to the given pages",
				"Parameters supported:",
				"rvuniqusr  - Get last #rvlimit revisions by unique authors. *slow query*",
				"rvcomments - Include summary strings.",
				"rvcontent  - Include raw wiki text. *slow query*",
				"rvlimit    - How many links to return *for each title*. Defaults to 10, or 0 if revids=... was specified.",
				"rvoffset   - When too many results are found, use this to page. *obsolete* This option is likely to disappear soon.",
				"rvstart    - Timestamp of the earliest entry.",
				"rvend      - Timestamp of the latest entry.",
				"rvrbtoken  - If logged in as an admin, a rollback tokens for top revisions will be included in the output.",
				"Example: query.php?what=revisions&titles=Main%20Page&rvlimit=10&rvcomments  -- last 10 revisions of the Main Page",
				"         query.php?what=revisions&titles=Main%20Page&rvuniqusr&rvlimit=3&rvcomments  -- 3 last unique users with their last revisions.",
			)),
		'usercontribs'   => array(
			GN_FUNC => 'genUserContributions',
			GN_ISMETA => false,
			GN_PARAMS => array( 'uccomments', 'uclimit', 'ucrbtoken', 'ucstart', 'ucend', 'uctop' ),
			GN_DFLT => array( false, 50, false, null, null,
				array( GN_ENUM_DFLT => 'all',
					   GN_ENUM_ISMULTI => false,
					   GN_ENUM_CHOICES => array('all','only','exclude') )),
			GN_DESC => array(
				"User contribution history - Lists last edits performed by the given user(s)",
				"Parameters supported:",
				"uccomments - If specified, the result will include summary strings.",
				"uclimit    - How many links to return *for each user*.",
				"uctop      - Filter results by contributions that are still on top:",
				"  'all' (default), 'only' (only the ones marked as top), 'exclude' (all non-top ones)",
				"ucstart    - Timestamp of the earliest entry.",
				"ucend      - Timestamp of the latest entry.",
				"ucrbtoken  - If logged in as an admin, a rollback tokens for top revisions will be included in the output.",
				"Example: query.php?what=usercontribs&titles=User:YurikBot&uclimit=20&uccomments",
			)),
			
		'contribcounter'   => array(
			GN_FUNC => 'genContributionsCounter',
			GN_ISMETA => false,
			GN_PARAMS => array(),
			GN_DFLT => array(),
			GN_DESC => array(
				"User contributions counter",
				"Example: query.php?what=contribcounter&titles=User:Yurik",
			)),
		'imageinfo'      => array(
			GN_FUNC => 'genImageInfo',
			GN_ISMETA => false,
			GN_PARAMS => array( 'iihistory', 'iiurl', 'iishared' ),
			GN_DFLT => array( false, false, false ),
			GN_DESC => array(
				"Image information",
				"Parameters supported:",
				"iiurl      - Add image URLs.",
				"iihistory  - Include all past revisions of the image.",
				"iishared   - Include image info from the shared image repository (commons)",
				"Example: query.php?what=imageinfo|allpages&aplimit=10&apnamespace=6&iiurl  -- show first 10 images with URLs",
			)),
		'content'        => array(
			GN_FUNC => 'genPageContent',
			GN_ISMETA => false,
			GN_PARAMS => null,
			GN_DFLT => null,
			GN_DESC => array(
				"Raw page content - Retrieves raw wiki markup for all found pages.",
				"*slow query* Please optimize content requests to reduce load on the servers.",
				"Duplicate results may be obtained through revisions+rvcontent request",
				"Example: query.php?what=content&titles=Main%20Page",
			)),
	);

	/**
	* Object Constructor, uses a database connection as a parameter
	*/
	function BotQueryProcessor( $startTime )
	{
		global $wgRequest, $wgUser;

		// Initialize Error handler
		set_exception_handler( array($this, 'ExceptionHandler') );

		$this->startTime = $startTime;
		$this->totalDbTime = 0;

		$this->data = array();

		$this->pageIdByText = array();	// reverse page ID lookup
		$this->requestsize = 0;
		$this->db =& wfGetDB( DB_SLAVE );

		$this->isBot = $wgUser->isAllowed( 'bot' );

		$this->enableProfiling = !$wgRequest->getCheck('noprofile');
		$this->invalidPageIdCounter = -1;

		$this->format = 'xmlfm'; // set it here because if parseFormat fails, the usage output relies on this setting
		$this->format = $this->parseFormat( $wgRequest->getVal('format', 'xmlfm') );

		$allProperties = array_merge(array(null), array_keys( $this->propGenerators ));
		$this->properties = $this->parseMultiValue( 'what', null, true, $allProperties );

		// Neither one of these variables is referenced directly!
		// Meta generators may append titles or pageids to these varibales.
		// Do not modify this values directly - use the AddRaw() method
		$this->titles = null;
		$this->pageids = null;
		$this->revids = null;
		$this->normalizedTitles = array();

		// These fields contain ids useful for other generators (redirectPageIds + nonRedirPageIds == existingPageIds)
		$this->existingPageIds = array();	// all existsing pages
		$this->redirectPageIds = array();	// all redirect pages
		$this->nonRedirPageIds = array();	// all regular, non-redirect pages

		$this->revIdsArray     = array();	// all explicitly requested revision ids
	}

	/**
	 * Exception handler which simulates the appropriate catch() handling:
	 *
	 *   try {
	 *       ...
	 *   } catch ( MWException $e ) {
	 *       dieUsage()
	 *   } catch ( Exception $e ) {
	 *       echo $e->__toString();
	 *   }
	 */
	function ExceptionHandler( $e ) {
		global $wgFullyInitialised;
		if ( is_a( $e, 'MWException' ) ) {
			try {
				$this->dieUsage( "Exception Caught: {$e->getMessage()}\n\n{$e->getTraceAsString()}\n\n", 'internal_error' );
			} catch (Exception $e2) {
				echo $e->__toString();
			}
		} else {
			echo $e->__toString();
		}

		// Final cleanup, similar to wfErrorExit()
		if ( $wgFullyInitialised ) {
			try {
				wfLogProfilingData(); // uses $wgRequest, hence the $wgFullyInitialised condition
			} catch ( Exception $e ) {}
		}

		// Exit value should be nonzero for the benefit of shell jobs
		exit( 1 );
	}

	/**
	* The core function - executes meta generators, populates basic page info, and then fills in the required additional data for all pages
	*/
	function execute()
	{
		$this->recordProfiling( 'total', 'startup', $this->startTime );
		// Process metadata generators
		$this->callGenerators( true );
		// Process 'titles' and 'pageids' parameters, and any other pages assembled by meta generators
		$this->genPageInfo();
		// Process page-related generators
		$this->callGenerators( false );

		// Report empty query - if pages and meta elements have no subelements
		if( ( !array_key_exists('pages', $this->data) || empty($this->data['pages']) ) &&
			( !array_key_exists('meta', $this->data) || empty($this->data['meta']) )) {
			$this->dieUsage( 'Nothing to do', 'emptyresult' );
		}
		// All items under 'pages' will be presented as 'page' xml elements
		if( array_key_exists('pages', $this->data) && !empty($this->data['pages']) ) {
			$this->data['pages']['_element'] = 'page';
		}
	}

	/**
	* Helper method to call generators (either meta or non-meta)
	*/
	function callGenerators( $callMetaGenerators )
	{
		foreach( $this->propGenerators as $property => &$generator ) {
			if( $generator[GN_ISMETA] === $callMetaGenerators && in_array( $property, $this->properties )) {
				$this->{$generator[GN_FUNC]}($property, $generator);
			}
		}
	}

	/**
	* Output the result to the user
	*/
	function output($isError = false)
	{
		global $wgRequest, $wgUser;

		$this->addPerfMessage( 'total', array( 'dbtime' => formatTimeInMs($this->totalDbTime) ));
		$this->recordProfiling( 'total', 'time', $this->startTime );

		$printer = $this->outputGenerators[$this->format][GN_FUNC];
		$mime = $this->outputGenerators[$this->format][GN_MIME];
		header( "Content-Type: $mime; charset=utf-8;" );
		header( "Cache-Control: private, s-maxage=0, max-age=0" );
		if( !$isError ) {
			if( !$this->enableProfiling && array_key_exists( 'perf', $this->data )) {
				$perf =& $this->data['perf'];
				unset( $this->data['perf'] );
				$this->{$printer}( $this->data );
				$this->data['perf'] =& $perf;
			} else {
				$this->{$printer}( $this->data );
			}
		} else {
			$this->{$printer}( $this->data['query'] );
		}

		//
		// Log request - userid (non-identifiable), status, what is asked, request size, additional parameters
		//
		$userIdentity = md5( $wgUser->getName() ) . "\t" . ($wgUser->isAnon() ? "anon" : ($this->isBot ? "bot" : "usr"));
		$what = $wgRequest->getVal('what');
		$format = $wgRequest->getVal('format');
		$params = mergeParameters( $this->propGenerators );
		$params = array_merge( $params, mergeParameters( $this->outputGenerators ));
		$params = array_unique($params);
		$paramVals = array();
		foreach( $params as $param ) {
			$val = $wgRequest->getVal($param);
			if( $val !== null ) {
				if( strpos( $param, 'from' ) === false && strpos( $param, 'title' ) === false) {
					$paramVals[] = "$param=$val";
				} else {
					$paramVals[] = $param;	// ignore the value
				}
			}
		}

		global $proxySite, $proxyLang;
		if ($proxySite) $paramVals[] = "proxySite=$proxySite";
		if ($proxyLang) $paramVals[] = "proxyLang=$proxyLang";

		$paramStr = implode( '&', $paramVals );
		$perfVals = array();
		if( array_key_exists('perf', $this->data) ) {
			$queryElem =& $this->data['perf'];
			foreach( $queryElem as $module => $values ) {
				if( is_array( $values )) {
					if( array_key_exists( 'time', $values )) $perfVals[] = "$module={$values['time']}";
					if( array_key_exists( 'dbtime', $values )) $perfVals[] = "{$module}_db={$values['dbtime']}";
				}
			}
			$perfVals[] = "startup={$queryElem['total']['startup']}";
		}
		$perfStr = implode( '&', $perfVals );
		$msg = "$userIdentity\t$format\t$what\t{$this->requestsize}\t$paramStr\t$perfStr&grandTotal="
				. formatTimeInMs(wfTime() - $this->startTime) . '#';
		wfDebugLog( 'query', $msg );
	}


	//
	// ************************************* INPUT PARSERS *************************************
	//
	function parseFormat( $format )
	{
		if( array_key_exists($format, $this->outputGenerators) ) {
			return $format;
		} else {
			$this->dieUsage( "Unrecognised format '$format'", 'badformat' );
		}
	}

	/**
	* Return an array of values that were given in a "a|b|c" notation, after it validates them against the list allowed values.
	*/
	function parseMultiValue( $valueName, $defaultValue, $allowMultiple, $allowedValues )
	{
		global $wgRequest;

		$values = $wgRequest->getVal($valueName, $defaultValue);
		$valuesList = explode( '|', $values );
		if( !$allowMultiple && count($valuesList) != 1 )
			$this->dieUsage("Only one value is allowed: '" . implode("', '", $allowedValues) . "' for parameter '$valueName'",
							"multival_$valueName" );
		$unknownValues = array_diff( $valuesList, $allowedValues);
		if( $unknownValues ) {
			$this->dieUsage("Unrecognised value" . (count($unknownValues)>1?"s '":" '") . implode("', '", $unknownValues) . "' for parameter '$valueName'",
							"unknown_$valueName" );
		}

		return $allowMultiple ? $valuesList : $valuesList[0];
	}


	//
	// ************************************* GENERATORS *************************************
	//


	/**
	* Creates lists of pages to work on. User parameters 'titles' and 'pageids' will be added to the list, and information from page table will be provided.
	* As the result of this method, $this->redirectPageIds and existingPageIds (arrays) will be available for other generators.
	*/
	function genPageInfo()
	{
		$this->startProfiling();
		$where = array();

		// Assemble a list of titles to process. This method will modify $where and $this->requestsize
		$nonexistentPages = &$this->parseTitles( $where );

		// Assemble a list of pageids to process. This method will modify $where and $this->requestsize
		$pageids = &$this->parsePageIds( $where );

		// Have anything to do?
		if( $this->requestsize > 0 ) {
			// Validate limits
			$this->validateLimit( 'pi_botquerytoobig', $this->requestsize, 500, 20000 );

			// Query page information with the given lists of titles & pageIDs
			$this->startDbProfiling();
			$res = $this->db->select(
				'page',
				array( 'page_id', 'page_namespace', 'page_title', 'page_is_redirect', 'page_touched', 'page_latest' ),
				$this->db->makeList( $where, LIST_OR ),
				__METHOD__ );
			$this->endDbProfiling('pageInfo');

			while( $row = $this->db->fetchObject( $res ) ) {
				$this->storePageInfo( $row, $res );
				if( $nonexistentPages !== null ) {
					unset( $nonexistentPages[$row->page_namespace][$row->page_title] );	// Strike out link
				}
			}
			$this->db->freeResult( $res );

			// Create records for non-existent page IDs
			if( $pageids !== null ) {
				foreach( array_diff_key($pageids, $this->existingPageIds) as $pageid ) {
					$data = &$this->data['pages'][$this->invalidPageIdCounter--];
					$data['id'] = 0;
					$data['badId'] = $pageid;
				}
			}

			// Add entries for non-existent page titles
			if( $nonexistentPages !== null ) {
				foreach( $nonexistentPages as $namespace => &$stuff ) {
					foreach( $stuff as $dbk => &$arbitrary ) {
						$title = Title::makeTitle( $namespace, $dbk );
						// Must do this check even for non-existent pages, as some generators can give related information
						if ( !$title->userCanRead() ) {
							$this->dieUsage( "No read permission for $titleString", 'pi_nopageaccessdenied' );
						}
						$data = &$this->data['pages'][$this->invalidPageIdCounter];
						$this->pageIdByText[$title->getPrefixedText()] = $this->invalidPageIdCounter;
						$data['_obj']    = $title;
						$data['title']   = $title->getPrefixedText();
						$data['ns']      = $title->getNamespace();
						$data['id']      = 0;
						$this->invalidPageIdCounter--;
					}
				}
			}

			// When normalized title differs from what was given, append the given title(s)
			foreach( $this->normalizedTitles as $givenTitle => &$title ) {
				$data = &$this->data['pages'][$this->invalidPageIdCounter--];
				$data['title'] = $givenTitle;
				$data['normalizedTitle'] = $title->getPrefixedText();
				// stored id might be negative, indicating a missing page
				$data['refid'] = max( 0, $this->lookupPageIdByTitle( $title->getNamespace(), $title->getDBkey() ));
			}
		}
		$this->endProfiling('pageInfo');
	}


	//
	// ************************************* META GENERATORS *************************************
	//


	/**
	* Get general site information
	*/
	function genMetaSiteInfo(&$prop, &$genInfo)
	{
		global $wgSitename, $wgVersion, $wgCapitalLinks;
		$this->startProfiling();
		$meta = array();
		$mainPage = Title::newFromText( wfMsgForContent( 'mainpage' ) );

		$meta['mainpage'] = $mainPage->getText();
		$meta['base']     = $mainPage->getFullUrl();
		$meta['sitename'] = $wgSitename;
		$meta['generator']= "MediaWiki $wgVersion";
		$meta['case']     = $wgCapitalLinks ? 'first-letter' : 'case-sensitive'; // "case-insensitive" option is reserved for future

		$this->data['meta']['site'] = $meta;
		$this->endProfiling( $prop );
	}

	/**
	* Get the list of localized namespaces
	*/
	function genMetaNamespaceInfo(&$prop, &$genInfo)
	{
		global $wgContLang;
		$this->startProfiling();
		$meta = array();
		$meta['_element'] = 'ns';
		foreach( $wgContLang->getFormattedNamespaces() as $ns => $title ) {
			$meta[$ns] = array( "id" => $ns, "*" => $title );
		}
		$this->data['meta']['namespaces'] = $meta;
		$this->endProfiling( $prop );
	}

	/**
	* Get current user's status information
	*/
	function genMetaUserInfo(&$prop, &$genInfo)
	{
		global $wgUser;
		$this->startProfiling();
		$uiisblocked = $uihasmsg = $uiextended = $uioptions = null;
		extract( $this->getParams( $prop, $genInfo ));
		$meta = array();
		$meta['name'] = $wgUser->getName();
		if( $wgUser->isAnon() ) $meta['anonymous'] = '';
		if( $this->isBot ) $meta['bot'] = '';
		if( $uiisblocked && $wgUser->isBlocked() ) $meta['blocked'] = '';
		if( $uihasmsg && $wgUser->getNewtalk() ) $meta['messages'] = '';
		if( $uiextended ) {
			$meta['groups'] = $wgUser->getGroups();
			$meta['groups']['_element'] = 'g';
			$meta['rights'] = $wgUser->getRights();
			$meta['rights']['_element'] = 'r';
		}
		if( $uioptions ) {
			$uioptions = explode( '|', $uioptions );
			foreach( $uioptions as $option ) {
				$meta[$option] = $wgUser->getOption($option);
			}
		}
		$this->data['meta']['user'] = $meta;
		$this->endProfiling( $prop );
	}

	/**
	* Add pagids of the most recently modified pages to the output
	*/
	function genMetaRecentChanges(&$prop, &$genInfo)
	{
		$this->startProfiling();
		$rchide = $rclimit = $rcfrom = null; 
		extract( $this->getParams( $prop, $genInfo ));
		# It makes no sense to hide both anons and logged-in users
		if( in_array('anons', $rchide) && in_array('liu', $rchide) ) {
			$this->dieUsage( "Both 'anons' and 'liu' cannot be given for 'rchide' parameter", 'rc_badrchide' );
		}
		$this->validateLimit( 'rc_badrclimit', $rclimit, 500, 5000 );

		$conds = array();
		if ( $rcfrom != '' ) {
			$conds[] = 'rc_timestamp >= ' . $this->prepareTimestamp($rcfrom);
		}

		foreach( $rchide as &$elem ) {
			switch( $elem ) {
				case '': // nothing
					break;
				case 'minor':
					$conds[] = 'rc_minor = 0';
					break;
				case 'bots':
					$conds[] = 'rc_bot = 0';
					break;
				case 'anons':
					$conds[] = 'rc_user != 0';
					break;
				case 'liu':
					$conds[] = 'rc_user = 0';
					break;
				default:
					wfDebugDieBacktrace( "Internal error - Unknown hide param '$elem'" );
			}
		}

		$options = array( 'USE INDEX' => 'rc_timestamp', 'LIMIT' => $rclimit );
		$options['ORDER BY'] = 'rc_timestamp' . ( $rcfrom != '' ? '' : ' DESC' );

		$this->startDbProfiling();
		$res = $this->db->select(
			'recentchanges',
			'rc_cur_id',
			$conds,
			__METHOD__,
			$options
			);
		$this->endDbProfiling( $prop );
		while ( $row = $this->db->fetchObject( $res ) ) {
			if( $row->rc_cur_id != 0 ) {
				$this->addRaw( 'pageids', $row->rc_cur_id );
			}
		}
		$this->db->freeResult( $res );
		$this->endProfiling( $prop );
	}

	/**
	* Add user pages to the list of titles to output (the actual user pages might not exist)
	*/
	function genUserPages(&$prop, &$genInfo)
	{
		global $wgContLang;
		$this->startProfiling();
		$uslimit = $usfrom = null;
		extract( $this->getParams( $prop, $genInfo ));

		$this->validateLimit( 'uslimit', $uslimit, 50, 1000 );

		$this->startDbProfiling();
		$res = $this->db->select(
			'user',
			'user_name',
			"user_name >= " . $this->db->addQuotes($usfrom),
			__METHOD__,
			array( 'ORDER BY' => 'user_name', 'LIMIT' => $uslimit )
			);
		$this->endDbProfiling( $prop );

		$userNS = $wgContLang->getNsText(NS_USER);
		if( !$userNS ) $userNS = 'User';
		$userNS .= ':';

		while ( $row = $this->db->fetchObject( $res ) ) {
			$this->addRaw( 'titles', $userNS . $row->user_name );
		}
		$this->db->freeResult( $res );
		$this->endProfiling( $prop );
	}

	/**
	* Add all pages by a given namespace to the output
	*/
	function genMetaAllPages(&$prop, &$genInfo)
	{
		//
		// TODO: This is very inefficient - we can get the actual page information, instead we make two identical query.
		//
		global $wgContLang;
		$this->startProfiling();
		$aplimit = $apfrom = $apnamespace = $apfilterredir = null;
		extract( $this->getParams( $prop, $genInfo ));
		$this->validateLimit( 'aplimit', $aplimit, 500, 1000 );

		if( $wgContLang->getNsText($apnamespace) === false ) {
			$this->dieUsage( "Unknown namespace $apnamespace", 'ap_badnamespace' );
		}

		$where = array( 'page_namespace' => intval($apnamespace) );
		if( $apfrom !== '' ) $where[] = 'page_title>=' . $this->db->addQuotes(titleToKey($apfrom));

		if ($apfilterredir === 'redirects')
			$where['page_is_redirect'] = 1;
		else if ($apfilterredir === 'nonredirects')
			$where['page_is_redirect'] = 0;

		$this->startDbProfiling();
		$res = $this->db->select(
			'page',
			array( 'page_id', 'page_namespace', 'page_title', 'page_is_redirect', 'page_touched', 'page_latest' ),
			$where,
			__METHOD__,
			array( 'USE INDEX' => 'name_title', 'LIMIT' => $aplimit+1, 'ORDER BY' => 'page_namespace, page_title' ));
		$this->endDbProfiling( $prop );

		// Add found page ids to the list of requested titles - they will be auto-populated later
		$count = 0;
		while ( $row = $this->db->fetchObject( $res ) ) {
			if( ++$count > $aplimit ) {
				// We've reached the one extra which shows that there are additional pages to be had. Stop here...
				$this->addStatusMessage( $prop, array('next' => keyToTitle($row->page_title)) );
				break;
			}
			$this->storePageInfo( $row, $res );
		}
		$this->db->freeResult( $res );
		$this->endProfiling( $prop );
	}

	/**
	* Add pages by the namespace without language links to the output
	*/
	function genMetaNoLangLinksPages(&$prop, &$genInfo)
	{
		//
		// FIXME: MERGE THIS with genMetaAllPages()
		//
		global $wgContLang;
		$this->startProfiling();
		$nllimit = $nlnamespace = $nlfrom = null;
		extract( $this->getParams( $prop, $genInfo ));
		$this->validateLimit( 'nllimit', $nllimit, 50, 1000 );
		if( $wgContLang->getNsText($nlnamespace) === false ) {
			$this->dieUsage( "Unknown namespace $nlnamespace", 'nl_badnamespace' );
		}
		extract( $this->db->tableNames( 'page', 'langlinks' ) );

		//
		// Find all pages without any rows in the langlinks table
		//
		$sql = 'SELECT'
			. ' page_id, page_namespace, page_title, page_is_redirect, page_touched, page_latest'
			. " FROM $page LEFT JOIN $langlinks ON page_id = ll_from"
			. ' WHERE'
			. ' ll_from IS NULL AND page_is_redirect = 0 AND page_namespace=' . intval($nlnamespace)
			. ( $nlfrom === '' ? '' : ' AND page_title>=' . $this->db->addQuotes(titleToKey($nlfrom)) )
			. ' ORDER BY page_namespace, page_title'
			. ' LIMIT ' . intval($nllimit+1);

		$this->startDbProfiling();
		$res = $this->db->query( $sql, __METHOD__ );
		$this->endDbProfiling( $prop );

		// Add found page ids to the list of requested titles - they will be auto-populated later
		$count = 0;
		while ( $row = $this->db->fetchObject( $res ) ) {
			if( ++$count > $nllimit ) {
				// We've reached the one extra which shows that there are additional pages to be had. Stop here...
				$this->addStatusMessage( $prop, array('next' => keyToTitle($row->page_title)));
				break;
			}
			$this->storePageInfo( $row, $res );
		}
		$this->db->freeResult( $res );
		$this->endProfiling( $prop );
	}

	/**
	* Add pages in a category
	*/
	function genPagesInCategory(&$prop, &$genInfo)
	{
		global $wgContLang;
		$this->startProfiling();
		$cptitle = $cpfrom = $cpnamespace = $cpextended = $cplimit = null;
		extract( $this->getParams( $prop, $genInfo ));

		// Validate parameters
		if( $cptitle === null )
			$this->dieUsage( "Missing category title parameter cptitle", 'cp_missingcptitle' );

		$categoryObj = &Title::newFromText( $cptitle );
		if(    !$categoryObj ||
			   ($categoryObj->getNamespace() !== NS_MAIN && $categoryObj->getNamespace() !== NS_CATEGORY) ||
			   $categoryObj->isExternal() ) {
			$this->dieUsage( "bad category name $cptitle", 'cp_invalidcategory' );
		}

		$tables = array( 'categorylinks' );
		$conds = array( 'cl_to' => $categoryObj->getDBkey() );
		if ($cpfrom != '')
			$conds[] = 'cl_sortkey >= ' . $this->db->addQuotes($cpfrom);

		if( $cpnamespace !== NS_ALL_NAMESPACES )
		{
			if ($wgContLang->getNsText($cpnamespace) === false)
				$this->dieUsage( "cpnamespace is invalid", "cp_badnamespace" );
			array_unshift($tables,'page');
			$conds[] = 'cl_from = page_id';
			$conds['page_namespace'] = $cpnamespace;
		}

		if ($cpextended)
			$fields = array( 'cl_from', 'cl_sortkey', 'cl_timestamp' );
		else
			$fields = array( 'cl_from', 'cl_sortkey' );   // Need 'cl_sortkey' to continue paging

		$this->validateLimit( 'cplimit', $cplimit, 500, 5000 );

		// Query list of categories
		$this->startDbProfiling();
		$res = $this->db->select(
			$tables,
			$fields,
			$conds,
			__METHOD__,
			array( 'ORDER BY' => 'cl_sortkey', 'LIMIT' => $cplimit+1, 'USE INDEX' => 'cl_sortkey' ));
		$this->endDbProfiling( $prop );

		$count = 0;
		while ( $row = $this->db->fetchObject( $res ) ) {
			if( ++$count > $cplimit ) {
				// We've reached the one extra which shows that there are additional pages to be had. Stop here...
				$this->addStatusMessage( 'category', array('next' => $row->cl_sortkey));
				break;
			}
			$this->addRaw( 'pageids', $row->cl_from );

			if ($cpextended) {
				// Add extra fields to the tree even before the page information is added to it
				$this->addPageSubElement($row->cl_from, $prop, 'sortkey', $row->cl_sortkey, false);
				$this->addPageSubElement($row->cl_from, $prop, 'timestamp', $row->cl_timestamp, false);
			}
		}
		$this->db->freeResult( $res );
		$this->endProfiling( $prop );
	}

	//
	// ************************************* PAGE INFO GENERATORS *************************************
	//
	
	/**
	 * Simpler replacement for double-redirect resolving genRedirectInfo2()
	 */
	function genRedirectInfo(&$prop, &$genInfo)
	{
		if( empty( $this->redirectPageIds )) return;
		$this->startProfiling();

		$this->startDbProfiling();
		$res = $this->db->select(
			array('page', 'pagelinks'),
			array('pl_from', 'pl_namespace', 'pl_title', 'page_id', 'page_is_redirect'),
			array('pl_from' => $this->redirectPageIds,
				  'pl_namespace = page_namespace',
				  'pl_title = page_title'),
			__METHOD__ );
		$this->endDbProfiling( $prop );

		$multiLinkRedirPages = array();

		while ( $row = $this->db->fetchObject( $res ) ) {
			$pageId = intval($row->pl_from);
			$data = & $this->data['pages'][$pageId]['redirect'];
			if ( !isset($data['to']) ) {
			    $data['to'] = $this->getLinkInfo( $row->pl_namespace, $row->pl_title, $row->page_id, $row->page_is_redirect );
			} else {
				// More than one link exists from redirect page
				$multiLinkRedirPages[$pageId] = '';
			}
		}
		$this->db->freeResult( $res );

		if (!empty($multiLinkRedirPages)) {
			// We found some bad redirect pages. Get the content and solve.   
			$multiLinkRedirPages = array_keys($multiLinkRedirPages);
			$ids = array();
			foreach( $multiLinkRedirPages as $pageId ) {
				$ids[] = "(rev_page=$pageId AND rev_id={$this->data['pages'][$pageId]['revid']})";
			}

			$this->startDbProfiling();
			$res = $this->db->select(
				array('page', 'revision', 'text'),
				array('page_id', 'page_is_redirect', 'old_id', 'old_text', 'old_flags'),
				array('page_id' => $multiLinkRedirPages, 'page_id=rev_page', 'page_latest=rev_id', 'rev_text_id=old_id' ),
				__METHOD__
			);
			while ( $row = $this->db->fetchObject( $res ) ) {
				$title = Title :: newFromRedirect(Revision::getRevisionText( $row ));
				if ($title) {
					$article = new Article($title);
					$pageId = $article->getTitle()->getArticleId();
					$isRedirect = $pageId > 0 ? !$article->checkTouched() : false;                    
					$link = $this->getTitleInfo( $title, $pageId, $isRedirect );
					$this->data['pages'][intval($row->page_id)]['redirect']['to'] = $link;
				}
			}
			$this->db->freeResult( $res );
		}

		$this->endProfiling( $prop );
	}
	
	/**
	 * 
	 *  This method cannot be used until http://bugzilla.wikipedia.org/show_bug.cgi?id=7304 is fixed  
	 * 
	 * Populate redirect data. Redirects may be one of the following:
	 *     Redir to nonexisting, Existing page, or Existing redirect.
	 *     Existing redirect may point to yet another nonexisting or existing page( which in turn may also be a redirect)
	 */
	function genRedirectInfo2(&$prop, &$genInfo)
	{
		if( empty( $this->redirectPageIds )) return;
		$this->startProfiling();
		extract( $this->db->tableNames( 'page', 'pagelinks' ) );

		//
		// Two part query:
		//     first part finds all the redirect, who's targets are regular existing pages
		//     second part finds targets that either do not exist or are redirects themselves.
		//
		$sql = 'SELECT '
			. 'la.pl_from a_id,'
			. 'la.pl_namespace b_namespace, la.pl_title b_title, pb.page_id b_id, pb.page_is_redirect b_is_redirect, '
			. 'null c_namespace, null c_title, null c_id, null c_is_redirect '
			. "FROM $pagelinks AS la, $page AS pb "
			. ' WHERE ' . $this->db->makeList( array(
				'la.pl_from' => $this->redirectPageIds,
				'la.pl_namespace = pb.page_namespace',
				'la.pl_title = pb.page_title',
				'pb.page_is_redirect' => 0
				), LIST_AND )
		. ' UNION SELECT '
			. 'la.pl_from a_id,'
			. 'la.pl_namespace b_namespace, la.pl_title b_title, pb.page_id b_id, pb.page_is_redirect b_is_redirect,'
			. 'lb.pl_namespace c_namespace, lb.pl_title c_title, pc.page_id c_id, pc.page_is_redirect c_is_redirect '
			. 'FROM '
			. "(($pagelinks AS la LEFT JOIN $page AS pb ON la.pl_namespace = pb.page_namespace AND la.pl_title = pb.page_title) LEFT JOIN "
			. "$pagelinks AS lb ON pb.page_id = lb.pl_from) LEFT JOIN "
			. "$page AS pc ON lb.pl_namespace = pc.page_namespace AND lb.pl_title = pc.page_title "
			. ' WHERE ' . $this->db->makeList( array(
				'la.pl_from' => $this->redirectPageIds,
				"pb.page_is_redirect IS NULL OR pb.page_is_redirect = '1'"
				), LIST_AND );

		$this->startDbProfiling();
		$res = $this->db->query( $sql, __METHOD__ );
		$this->endDbProfiling( $prop );

		while ( $row = $this->db->fetchObject( $res ) ) {
			$this->addPageSubElement( $row->a_id, 'redirect', 'to', $this->getLinkInfo( $row->b_namespace, $row->b_title, $row->b_id, $row->b_is_redirect ), false);
			if( $row->b_is_redirect ) {
				$this->addPageSubElement( $row->a_id, 'redirect', 'dblredirectto', $this->getLinkInfo( $row->c_namespace, $row->c_title, $row->c_id, $row->c_is_redirect ), false);
			}
		}
		$this->db->freeResult( $res );
		$this->endProfiling( $prop );
	}

	/**
	* Checks which pages the user has the rights to edit and move.
	*/
	function genPermissionsInfo(&$prop, &$genInfo)
	{
		$this->startProfiling();
		$prcanmove = null;
		extract( $this->getParams( $prop, $genInfo ));

		$pages =& $this->data['pages'];
		$titles = array();
		foreach( $pages as $pageId => &$page ) {
			if( array_key_exists('_obj', $page) ) {
				$titles[$pageId] =& $page['_obj'];
			}
		}
		if( !empty($titles) ) {
			// populate cache
			$batch = new LinkBatch( $titles );

			$this->startDbProfiling();
			$batch->execute();
			$this->endDbProfiling( $prop );

			if( !empty( $this->existingPageIds )) {
				$this->startDbProfiling();
				$res = $this->db->select(
					'page',
					array('page_id', 'page_restrictions'),
					array('page_id' => $this->existingPageIds),
					__METHOD__ );
				$this->endDbProfiling( $prop );

				while ( $row = $this->db->fetchObject( $res )) {
					$titles[ intval($row->page_id) ]->loadRestrictions( $row->page_restrictions );
				}
				$this->db->freeResult( $res );
			}

			foreach( $titles as $key => &$title ) {
				$page =& $pages[$key];
				$page['canEdit'] = $title->userCan( 'edit' ) ? 'true' : 'false';
				if( $prcanmove ) {
					$page['canMove'] = $title->userCan( 'move' ) ? 'true' : 'false';
				}
			}
		}
		$this->endProfiling( $prop );
	}

	var $genPageLinksSettings = array(	// database column name prefix, output element name
		'links' 	=> array( 'prefix' => 'pl', 'code' => 'l',  'linktbl' => 'pagelinks' ),
		'langlinks' => array( 'prefix' => 'll', 'code' => 'll', 'linktbl' => 'langlinks' ),
		'templates' => array( 'prefix' => 'tl', 'code' => 'tl', 'linktbl' => 'templatelinks' ));

	/**
	* Generates list of links/langlinks/templates for all non-redirect pages.
	*/
	function genPageLinksHelper(&$prop, &$genInfo)
	{
		if( empty( $this->nonRedirPageIds )) return;
		$this->startProfiling();
		$linktbl = $langlinks = $prefix = $code = null;
		extract( $this->genPageLinksSettings[$prop] );
		$langlinks = $prop === 'langlinks';

		$this->startDbProfiling();
		$res = $this->db->select(
			$linktbl,
			array( 	"{$prefix}_from from_id",
					($langlinks ? 'll_lang' : "{$prefix}_namespace to_namespace"),
					"{$prefix}_title to_title" ),
			array( "{$prefix}_from" => $this->nonRedirPageIds ),
			__METHOD__ . "_{$code}" );
		$this->endDbProfiling( $prop );

		while ( $row = $this->db->fetchObject( $res ) ) {
			if( $langlinks ) {
				$values = array('lang' => $row->ll_lang, '*' => $row->to_title);
			} else {
				$values = $this->getLinkInfo( $row->to_namespace, $row->to_title );
			}
			$this->addPageSubElement( $row->from_id, $prop, $code, $values);
		}
		$this->db->freeResult( $res );
		$this->endProfiling( $prop );
	}

	/**
	* Generates list of categories for all non-redirect pages.
	*/
	function genPageCategoryLinks(&$prop, &$genInfo)
	{
		if( empty( $this->nonRedirPageIds )) return;
		$this->startProfiling();
		$clextended = null;
		extract( $this->getParams( $prop, $genInfo ));

		$fields = array( 'cl_from', 'cl_to' );
		if ($clextended) {
			$fields[] = 'cl_sortkey';
			$fields[] = 'cl_timestamp';
		}

		$this->startDbProfiling();
		$res = $this->db->select(
			'categorylinks',
			$fields,
			array( "cl_from" => $this->nonRedirPageIds ),
			__METHOD__ );
		$this->endDbProfiling( $prop );

		while ( $row = $this->db->fetchObject( $res ) ) {
			$values = $this->getLinkInfo( NS_CATEGORY, $row->cl_to );
			if ($clextended) {
				 $values['sortkey'] = $row->cl_sortkey;
				 $values['timestamp'] = $row->cl_timestamp;
			}
			$this->addPageSubElement( $row->cl_from, $prop, 'cl', $values);
		}
		$this->db->freeResult( $res );
		$this->endProfiling( $prop );
	}

	/**
	* Generates list of links/langlinks/templates for all non-redirect pages.
	*/
	function genImageInfo(&$prop, &$genInfo)
	{
		$this->startProfiling();
		$iihistory = $iishared = $iiurl = null;
		extract( $this->getParams( $prop, $genInfo ));
		// Find local image pages to process
		$imageDbKeys = array();
		foreach( $this->data['pages'] as $pageId => &$page ) {
			if (array_key_exists('_obj', $page))
			{
				$obj = &$page['_obj'];
				if ($obj->getNamespace() === NS_IMAGE )
					$imageDbKeys[$obj->getDBkey()] = $pageId;
			}
		}

		if( !empty( $imageDbKeys ))
		{
			$this->ImageInfoHelper( $prop, true, false, $imageDbKeys, $iiurl, $this->db );
			if ($iihistory)
				$this->ImageInfoHelper( $prop, false, false, $imageDbKeys, $iiurl, $this->db );

			$this->endProfiling( $prop );   // Count shared processing separatelly

			if ($iishared)
			{
				$this->startProfiling();
				global $wgCapitalLinks, $wgUseSharedUploads, $wgContLang;
				if (!$wgUseSharedUploads)
					$this->dieUsage( "This site does not have shared image repository", 'ii_noshared' );

				if (!$wgCapitalLinks)
				{
					// Current site does not automatically capitalize first letter, but commons always does.
					$tmp = array();
					foreach ($imageDbKeys as $key => &$value)
						$tmp[$wgContLang->ucfirst($key)] = $value;
					$imageDbKeys = $tmp;
				}

				$prop2 = $prop . "_shrd";
				$this->startDbProfiling();
				$dbc = Image :: getCommonsDB();
				$this->endDbProfiling( $prop2 );

				$this->ImageInfoHelper( $prop2, true, true, $imageDbKeys, $iiurl, $dbc );
				if( $iihistory )
					$this->ImageInfoHelper( $prop2, false, true, $imageDbKeys, $iiurl, $dbc );
				$this->endProfiling( $prop2 );
			}
		}
		else
			$this->endProfiling( $prop );
	}

	/**
	* Generates list of image history entries, either from image or from oldimage table
	*/
	function ImageInfoHelper($prop, $isCur, $isShared, &$imageDbKeys, $includeUrl, &$db)
	{
		$tblNamePrefix = "";
		$moduleElemName = $isCur ? 'image' : 'imghistory';
		if ($isShared)
		{
			global $wgSharedUploadDBname, $wgSharedUploadDBprefix;
			$tblNamePrefix = "`$wgSharedUploadDBname`.$wgSharedUploadDBprefix";
			$moduleElemName = 'shared' . $moduleElemName;
		}

		$table  = $tblNamePrefix . ($isCur ? 'image' : 'oldimage');
		$fld    = $isCur ? 'img'   : 'oi';
		$fields = array( "{$fld}_name name", "{$fld}_size size", "{$fld}_width width", "{$fld}_height height", "{$fld}_bits bits",
						 "{$fld}_description description", "{$fld}_user_text user_text", "{$fld}_timestamp timestamp" );
		if( $isCur ) {
			$fields[] = "img_media_type";
			$fields[] = "img_major_mime";
			$fields[] = "img_minor_mime";
		} else {
			$fields[] = 'oi_archive_name';
		}

		$this->startDbProfiling();
		$res = $db->select(
			$table,
			$fields,
			array( "{$fld}_name" => array_keys( $imageDbKeys )),
			__METHOD__ . "_{$fld}" );
		$this->endDbProfiling( $prop );

		while ( $row = $db->fetchObject( $res ) ) {
			$name = $row->name;
			$values = array(
				'size' => $row->size,
				'width' => $row->width,
				'height' => $row->height,
				'bits' => $row->bits,
				'user' => $row->user_text,
				'timestamp' => wfTimestamp( TS_ISO_8601, $row->timestamp ),
				'comment' => $row->description,
				'*' => '');	// force all to be attributes
			if( $isCur ) {
				$values['media'] = $row->img_media_type;
				$values['mime']  = "{$row->img_major_mime}/{$row->img_minor_mime}";
				if( $includeUrl ) $values['url'] = Image::imageUrl( $name, $isShared );
				$this->data['pages'][ $imageDbKeys[$name] ][$moduleElemName] = $values;
			} else {
				// FIXME: wfImageArchiveUrl does not provide URLs to the shared images
				if( $includeUrl && !$isShared ) $values['url'] = htmlspecialchars( wfImageArchiveUrl( $row->oi_archive_name ));
				$this->addPageSubElement( $imageDbKeys[$name], $moduleElemName, 'ih', $values );
			}
		}

		$db->freeResult( $res );
	}


	var $genPageBackLinksSettings = array(	// database column name prefix, output element name
		'embeddedin' => array( 'prefix' => 'tl', 'code' => 'ei', 'linktbl' => 'templatelinks' ),
		'backlinks'  => array( 'prefix' => 'pl', 'code' => 'bl', 'linktbl' => 'pagelinks' ),
		'imagelinks' => array( 'prefix' => 'il', 'code' => 'il', 'linktbl' => 'imagelinks' ));

	/**
	* Generate backlinks for either links, templates, or both
	* $type - either 'template' or 'page'
	*/
	function genPageBackLinksHelper(&$prop, &$genInfo)
	{
		global $wgContLang, $wgMiserMode;
		$this->startProfiling();
		$prefix = $linktbl = $code = null;
		extract( $this->genPageBackLinksSettings[$prop] );
		$isImage = $prop === 'imagelinks';

		//
		// Parse and validate parameters
		//
		$parameters = $this->getParams( $prop, $genInfo );
		$limit  = intval($parameters["{$code}limit"]);
		$this->validateLimit( "{$code}limit", $limit, 5000, 10000 );
		$namespace = $parameters["{$code}namespace"];
		if( $namespace !== NS_ALL_NAMESPACES && $wgContLang->getNsText($namespace) === false )
			$this->dieUsage( "{$code}namespace is invalid", "{$code}_badnamespace" );

		//
		// Parse contFrom - will be in the format    ns|db_key|page_id - determine how to continue
		//
		// Builds a table scan query -- domas
		$contFrom = $parameters["{$code}contfrom"];
		if( $contFrom && !$wgMiserMode ) {
			$contFromList = explode( '|', $contFrom );
			$contFromValid = count($contFromList) === 3;
			if( $contFromValid ) {
				$fromNs = intval($contFromList[0]);
				$fromTitle = $contFromList[1];
				$contFromValid = ( ($fromNs !== 0 || $contFromList[0] === '0') && !empty($fromTitle) );
			}
			if( $contFromValid ) {
				$fromPageId = intval($contFromList[2]);
				$contFromValid = ($fromPageId > 0);
			}
			if( !$contFromValid ) {
				$this->dieUsage( "{$code}contfrom is invalid. You should pass the original value returned by the previous query", "{$code}_badcontfrom" );
			}
		}
		//
		// Parse page type filtering
		//
		$filter = $parameters["{$code}filter"];
		$existing = $all = false;
		switch( $filter ) {
			case 'all' :
				$all = true;
				// fallthrough
			case 'existing' :
				$existing = true;
				break;
			case 'redirects' :
				$onlyredir = true;
				break;
			case 'nonredirects' :
				$onlyredir = false;
				break;
			default:
				$this->dieUsage( "{$code}filter '$filter' is not one of the allowed: 'all', 'existing' [default], and 'nonredirects'", "{$code}_badfilter" );
		}
		//
		// Make a list of pages to query
		//
		$linkBatch = new LinkBatch;
		foreach( $this->data['pages'] as $pageId => &$page ) {
			if( (
				( $pageId < 0 && $all && array_key_exists('_obj', $page) ) ||
				( $pageId > 0 && ($existing ||
					($onlyredir === array_key_exists('redirect', $page))) )
				)
			&&
				( !$isImage || $page['ns'] == NS_IMAGE )	// when doing image links search, only allow NS_IMAGE
			) {
				$title = &$page['_obj'];
				// remove any items already processed by previous queries
				if( $contFrom ) {
					if( $title->getNamespace() < $fromNs ||
						($title->getNamespace() === $fromNs && $title->getDBkey() < $fromTitle)) {
						continue;
					}
				}
				$linkBatch->addObj( $title );
			}
		}
		if( $linkBatch->isEmpty() ) {
			$this->addStatusMessage( $prop, array('error'=>'emptyrequest') );
			return; // Nothing to do
		}
		//
		// Create query parameters
		//
		$columns = array( "{$prefix}_from from_id", 'page_namespace from_namespace', 'page_title from_title' );
		$where = array( "{$prefix}_from = page_id" );
		if( $namespace != NS_ALL_NAMESPACES )
			$where['page_namespace'] = intval($namespace);

		if( $isImage ) {
			$columns[] = "{$prefix}_to to_title";
			$where["{$prefix}_to"] = array_keys($linkBatch->data[NS_IMAGE]);
			$orderBy   = "{$prefix}_to, {$prefix}_from";
			if( $contFrom ) {
				$where[] = "(({$prefix}_to > " . $this->db->addQuotes( $fromTitle ) ." ) OR "
						  ."({$prefix}_to = " . $this->db->addQuotes( $fromTitle ) ." AND {$prefix}_from >= " . intval($fromPageId) . "))";
			}
		} else {
			$columns[] = "{$prefix}_namespace to_namespace";
			$columns[] = "{$prefix}_title to_title";
			$where[]   = $linkBatch->constructSet( $prefix, $this->db );
			$orderBy   = "{$prefix}_namespace, {$prefix}_title, {$prefix}_from";
			if( $contFrom ) {
				$where[] = 	 "({$prefix}_namespace > " . intval($fromNs) ." OR "
							."({$prefix}_namespace = " . intval($fromNs) ." AND "
								."({$prefix}_title > " . $this->db->addQuotes( $fromTitle ) ." OR "
								."({$prefix}_title = " . $this->db->addQuotes( $fromTitle ) ." AND "
									."{$prefix}_from >= " . intval($fromPageId) . "))))";
			}
		}
		$options = array( 'ORDER BY' => $orderBy, 'LIMIT' => $limit+1 );
		//
		// Execute
		//
		$this->startDbProfiling();
		$res = $this->db->select(
			array( $linktbl, 'page' ),
			$columns,
			$where,
			__METHOD__ . "_{$code}",
			$options );
		$this->endDbProfiling( $prop );

		$count = 0;
		while ( $row = $this->db->fetchObject( $res ) ) {
			if( ++$count > $limit ) {
				// We've reached the one extra which shows that there are additional pages to be had. Stop here...
				$this->addStatusMessage( $prop,
					array('next' => ($isImage ? NS_IMAGE : $row->to_namespace) ."|{$row->to_title}|{$row->from_id}") );
				break;
			}
			$pageId = $this->lookupPageIdByTitle( ($isImage ? NS_IMAGE : $row->to_namespace), $row->to_title );
			$values = $this->getLinkInfo( $row->from_namespace, $row->from_title, $row->from_id );
			$this->addPageSubElement( $pageId, $prop, $code, $values );
		}
		$this->db->freeResult( $res );
		$this->endProfiling( $prop );
	}

	/**
	* Add a list of revisions to the page history
	*/
	function genPageRevisions(&$prop, &$genInfo)
	{
		if( empty( $this->existingPageIds )) return;
		$this->startProfiling();

		// Before extracting values, change the default rvlimit to 0 if revIdsArray has any elements
		if( !empty($this->revIdsArray) ) {
			$genInfo[GN_DFLT][ array_search( 'rvlimit', $genInfo[GN_PARAMS] )] = 0;
		}
		$rvrbtoken = $rvcomments = $rvcontent = $rvlimit = $rvuniqusr = $rvoffset = null;
		extract( $this->getParams( $prop, $genInfo ));

		// Validate rollback token permissions
		if ($rvrbtoken) {
			global $wgUser;
			if (!$wgUser->isAllowed( 'rollback' ))
				$this->dieUsage("Current user has no rollback permission", "rv_norollback");
		}

		// Prepare query parameters
		$queryname = __METHOD__;
		$tables = array('revision');
		$fields = array('rev_id', 'rev_text_id', 'rev_timestamp', 'rev_user', 'rev_user_text', 'rev_minor_edit');
		if( $rvcomments ) $fields[] = 'rev_comment';
		$conds = array( 'rev_deleted' => 0 );// WHERE clause for normal & aggregated query
		$conds2 = array();					 // WHERE clause for query by revids

		// When content is needed, table 'text' must be joined in.
		if( $rvcontent ) {
			$this->validateLimit( 'content: (rvlimit*pages)+revids',
								  $rvlimit * count($this->existingPageIds) + count($this->revIdsArray), 50, 200 );
			$tables[] = 'text';
			$fields[] = 'old_id';
			$fields[] = 'old_text';
			$fields[] = 'old_flags';
			$conds2[] = 'rev_text_id=old_id';
			$conds[] = 'rev_text_id=old_id';
		} else {
			$this->validateLimit( 'rvlimit * pages + revids',
								  $rvlimit * count($this->existingPageIds) + count($this->revIdsArray), 200, 2000 );
		}

		// Optimize - when rvlimit is set to 0 (automatically when user gives revids= parameter)
		if( $rvlimit > 0 ) {
			if( isset($rvstart) )  $conds[] = 'rev_timestamp >= ' . $this->prepareTimestamp($rvstart);
			if( isset($rvend) )    $conds[] = 'rev_timestamp <= ' . $this->prepareTimestamp($rvend);
			$options = array( 'LIMIT' => $rvlimit );
			if( $rvoffset !== 0 )  $options['OFFSET'] = $rvoffset;
			if( $rvuniqusr ) {
				$options['ORDER BY'] = 'MAX_rev_timestamp DESC';	// FIXME: MYSQL4 requires MAX() to be present in the fields
				$options['GROUP BY'] = 'rev_user_text';
				$queryname .= '_grp';
			} else {
				$options['ORDER BY'] = 'rev_timestamp DESC';
			}

			//
			// Execute queries for each page (not very efficient, until agregate queries with subqueries become available)
			//
			foreach( $this->existingPageIds as $pageId ) {
				$conds['rev_page'] = $pageId;
				if( $rvuniqusr ) {
					// Query just for rev_id of last modifications by unique users
					$this->startDbProfiling();
					$res = $this->db->select( 'revision', 'MAX(rev_id) rev_id_latest, MAX(rev_timestamp) MAX_rev_timestamp', $conds, $queryname, $options );
					$this->endDbProfiling( $prop );
					while ( $row = $this->db->fetchObject( $res ) ) {
						$this->revIdsArray[] = intval($row->rev_id_latest);
					}
				} else {
					// Query all revision information
					$doneRevIds = array();
					$this->startDbProfiling();
					$res = $this->db->select( $tables, $fields, $conds, $queryname, $options );
					$this->endDbProfiling( $prop );
					while ( $row = $this->db->fetchObject( $res ) ) {
						$this->addRevisionSubElement( $row, $pageId, $rvcontent, $rvrbtoken );
						$doneRevIds[] = intval($row->rev_id);
					}
					$this->revIdsArray = array_diff( $this->revIdsArray, $doneRevIds );	// remove everything already done
				}
				$this->db->freeResult( $res );
			}
		}

		// For unique user modifications, perform an additional query to populate data object
		if( !empty($this->revIdsArray) ) {
			$fields[] = 'rev_page';	// needed to find the originating page
			$conds2['rev_id'] = $this->revIdsArray;
			if( $rvlimit === 0 ) $this->startDbProfiling();	// db timer was not started yet
			$this->startDbProfiling();
			$res = $this->db->select( $tables, $fields, $conds2, $queryname . '2', array( 'ORDER BY' => 'rev_timestamp DESC' ));
			$this->endDbProfiling( $prop );
			while ( $row = $this->db->fetchObject( $res ) ) {
				$this->addRevisionSubElement( $row, $row->rev_page, $rvcontent, $rvrbtoken );
			}
		}
		$this->endProfiling( $prop );
	}

	/**
	* Revision generator helper - adds a $row from revision table to the output
	*/
	function addRevisionSubElement( $row, $pageId, $rvcontent, $rvrbtoken )
	{
		$vals = array(
			'revid' => intval($row->rev_id),
			'oldid' => intval($row->rev_text_id),
			'timestamp' => wfTimestamp( TS_ISO_8601, $row->rev_timestamp ),
			'user' => $row->rev_user_text,
			);
		if( !$row->rev_user ) {
			$vals['anon'] = '';
		}
		if( $row->rev_minor_edit ) {
			$vals['minor'] = '';
		}
		if( $rvrbtoken ) {
			global $wgUser;
			$page = $this->data['pages'][$pageId];
			if( $row->rev_id == $page['revid'] ) {
				$vals['rbtoken'] = $wgUser->editToken( array( $page['_obj']->getPrefixedText(), $row->rev_user_text ));
			}
		}
		if( isset( $row->rev_comment )) {
			$vals['comment'] = $row->rev_comment;
		}
		if( $rvcontent ) {
			$vals['xml:space'] = 'preserve';
			$vals['*'] = Revision::getRevisionText( $row );
		} else {
			$vals['*'] = '';	// Force all elements to be attributes
		}

		$this->addPageSubElement( $pageId, 'revisions', 'rv', $vals);
	}

	/**
	* Add user contributions to the user pages
	*/
	function genUserContributions(&$prop, &$genInfo)
	{
		$this->startProfiling();
		$ucrbtoken = $uccomments = $uctop = $uclimit = null;
		extract( $this->getParams( $prop, $genInfo ));

		// Validate rollback token permissions
		if ($ucrbtoken) {
			global $wgUser;
			if (!$wgUser->isAllowed( 'rollback' ))
				$this->dieUsage("Current user has no rollback permission", "uc_norollback");
		}

		// Make query parameters
		$tables = array('page', 'revision');

		$fields = array('page_namespace', 'page_title', 'page_is_new', 'rev_id', 'rev_text_id', 'rev_timestamp', 'rev_minor_edit');
		if( $uccomments ) $fields[] = 'rev_comment';
		if( $uctop == 'all' ) $fields[] = 'page_latest';	// no need to include it otherwise, as it will always be constant

		$conds = array( 'page_id=rev_page' );
		if( $uctop == 'only' )
			$conds[] = 'page_latest=rev_id';
		elseif( $uctop == 'exclude' )
			$conds[] = 'page_latest<>rev_id';

		$options = array( 'LIMIT' => $uclimit, 'ORDER BY' => 'rev_timestamp DESC', 'FORCE INDEX' => 'usertext_timestamp' );

		$count = 0;
		$maxallowed = ($this->isBot ? 2000 : 500);

		// For all valid pages in User namespace query history. Note that the page might not exist.
		foreach( $this->data['pages'] as $pageId => &$page ) {
			if( array_key_exists('_obj', $page) ) {
				$title =& $page['_obj'];
				if( $title->getNamespace() == NS_USER && !$title->isExternal() ) {
					if( (++$count * $uclimit) > $maxallowed ) {
						$this->dieUsage( "Too many user contributions requested, only $maxallowed allowed", 'uclimit * users');
					}

					if( isset($ucstart) )  $conds[] = 'rev_timestamp >= ' . $this->prepareTimestamp($ucstart);
					if( isset($ucend) )    $conds[] = 'rev_timestamp <= ' . $this->prepareTimestamp($ucend);
					$conds['rev_user_text'] = $title->getText();
					$data = &$page['contributions'];

					$this->startDbProfiling();
					$res = $this->db->select( $tables, $fields, $conds, __METHOD__, $options );
					$this->endDbProfiling( $prop );

					while ( $row = $this->db->fetchObject( $res ) ) {
						$vals = $this->getLinkInfo( $row->page_namespace, $row->page_title );
						$vals['revid'] = intval($row->rev_id);
						$vals['oldid'] = $row->rev_text_id;
						$vals['timestamp'] = wfTimestamp( TS_ISO_8601, $row->rev_timestamp );
						if( $row->rev_minor_edit ) $vals['minor'] = '';
						if( $row->page_is_new ) $vals['new'] = '';
						if( $uctop == 'only' || ($uctop == 'all' && $row->page_latest == $row->rev_id )) {
							$vals['top'] = '';
							if( $ucrbtoken ) {
								$vals['rbtoken'] = $wgUser->editToken( array( $vals['*'], $title->getText() ));
							}
						}
						if( $uccomments ) $vals['comment'] = $row->rev_comment;

						$data[] = $vals;
					}
					$this->db->freeResult( $res );
					$data['_element'] = 'uc';
				}
			}
		}
		$this->endProfiling( $prop );
	}
	
	
	/**
	* Add counts of user contributions to the user pages
	*/
	function genContributionsCounter(&$prop, &$genInfo)
	{
		$this->startProfiling();
		$users = array ();			// Users to query
		$userPageIds = array ();	// Map of user name to the page ID

		// For all valid pages in User namespace query history. Note that the page might not exist.
		foreach ($this->data['pages'] as $pageId => & $page) {
			if (array_key_exists('_obj', $page)) {
				$title = & $page['_obj'];
				if ($title->getNamespace() == NS_USER && !$title->isExternal()) {
					$users[] = $title->getText();
					$userPageIds[$title->getText()] = $pageId;
				}
			}
		}

		$this->validateLimit( 'cc_querytoobig', count($users), 10, 50 );
		$this->startDbProfiling();
		$res = $this->db->select('user', array (
			'user_name',
			'user_editcount'
		), array (
			'user_name' => $users
		), __METHOD__
		);
		$this->endDbProfiling($prop);
		while ($row = $this->db->fetchObject($res)) {
			$pageId = $userPageIds[$row->user_name];
			$this->addPageSubElement($pageId, $prop, 'count', $row->user_editcount, false);
		}
		$this->endProfiling($prop);
	}
	
	/**
	* Add the raw content of the pages
	*/
	function genPageContent(&$prop, &$genInfo)
	{
		if( empty( $this->existingPageIds )) return;
		$this->startProfiling();

		// Generate the WHERE clause for pageIds+RevisionIds
		$ids = array();
		foreach( $this->data['pages'] as $pageId => &$page ) {
			if( $pageId > 0 ) {
				$ids[] = "(rev_page=$pageId AND rev_id={$page['revid']})";
			}
		}
		$this->validateLimit( 'co_querytoobig', count($ids), 50, 200 );

		$this->startDbProfiling();
		$res = $this->db->select(
			array('revision', 'text'),
			array('rev_page', 'old_id', 'old_text', 'old_flags'),
			array('rev_text_id=old_id', implode('OR', $ids)),
			__METHOD__
			);
		while ( $row = $this->db->fetchObject( $res ) ) {
			$this->addPageSubElement( $row->rev_page, $prop, 'xml:space', 'preserve', false);
			$this->addPageSubElement( $row->rev_page, $prop, '*', Revision::getRevisionText( $row ), false);
		}
		$this->db->freeResult( $res );
		$this->endDbProfiling( $prop );	// Revision::getRevisionText is also a database call, so include it in this scope
		$this->endProfiling( $prop );
	}

	//
	// ************************************* UTILITIES *************************************
	//

	/**
	* Take $row with fields from 'page' table and create needed page entries in $this->data
	*/
	function storePageInfo( &$row, &$res )
	{
		$title = Title::makeTitle( $row->page_namespace, $row->page_title );
		if ( !$title->userCanRead() ) {
			$this->db->freeResult( $res );
			$this->dieUsage( "No read permission for $titleString", 'pi_pageidaccessdenied' );
		}
		$pageid = intval($row->page_id);
		$data = &$this->data['pages'][$pageid];
		$this->pageIdByText[$title->getPrefixedText()] = $pageid;
		$data['_obj']    = $title;
		$data['ns']      = $title->getNamespace();
		$data['title']   = $title->getPrefixedText();
		$data['id']      = $pageid;
		$data['touched'] = $row->page_touched;
		$data['revid']   = intval($row->page_latest);

		$this->existingPageIds[] = $pageid;
		if ( $row->page_is_redirect ) {
			$data['redirect'] = '';
			$this->redirectPageIds[] = $pageid;
		} else {
			$this->nonRedirPageIds[] = $pageid;
		}
	}

	/**
	* Process the list of given titles, update $where and $this->requestsize, and return the data of the LinkBatch object
	*/
	function parseTitles( &$where )
	{
		global $wgRequest;
		$titles = $this->addRaw( 'titles', $wgRequest->getVal('titles') );
		if( $titles !== null ) {
			$titles = explode( '|', $titles );
			$linkBatch = new LinkBatch;
			foreach ( $titles as &$titleString ) {
				$titleObj = &Title::newFromText( $titleString );
				if (!$titleObj) {
					$this->dieUsage( "bad title $titleString", 'pi_invalidtitle' );
				}
				if ($titleObj->getNamespace() < 0) {
					$this->dieUsage( "No support for special page $titleString has been implemented", 'pi_unsupportednamespace' );
				}
				if (!$titleObj->userCanRead()) {
					$this->dieUsage( "No read permission for $titleString", 'pi_titleaccessdenied' );
				}
				$linkBatch->addObj( $titleObj );    // <0 namespaces will be ignored

				// Make sure we remember the original title that was given to us
				// This way the caller can correlate new titles with the originally requested, i.e. namespace is localized or capitalization
				if( $titleString !== $titleObj->getPrefixedText() ) {
					$this->normalizedTitles[$titleString] = $titleObj;
				}
			}

			if (!$linkBatch->isEmpty()) {
			    // Create a list of pages to query
			    $where[] = $linkBatch->constructSet( 'page', $this->db );
			    $this->requestsize += $linkBatch->getSize();

			    // we don't need the batch any more, data can be destroyed
			    return $linkBatch->data;
			}
		}

		return null;    // No titles to get from the database
	}

	/**
	* Process the list of given titles, update $where and $this->requestsize, and return the data of the LinkBatch object
	*/
	function parsePageIds( &$where )
	{
		global $wgRequest;
		$pageids = $this->addRaw( 'pageids', $wgRequest->getVal('pageids') );
		if( $pageids !== null ) {
			$this->processIds( $pageids, 'pageids' );
		}

		$revids = $this->addRaw( 'revids', $wgRequest->getVal('revids') );
		if( $revids !== null ) {
			$this->processIds( $revids, 'revids' );
			if( $pageids === null ) $pageids = array();

			$res = $this->db->select( 'revision', 'DISTINCT rev_page',
									  array( 'rev_deleted' => 0, 'rev_id' => $revids ),
									  __METHOD__ );
			while ( $row = $this->db->fetchObject( $res ) ) {
				$pageids[] = $row->rev_page;
			}
			$this->db->freeResult( $res );
			$pageids = array_unique($pageids);
			$this->validateLimit( 'pi_botquerytoobig2', count($pageids), 500, 20000 );
			$this->revIdsArray = &$revids;
		}

		if( !empty($pageids) ) {
			$where['page_id'] = $pageids;
			$this->requestsize += count($pageids);
		} else {
			$pageids = null;
		}

		return $pageids;
	}

	function processIds( &$ids, $name )
	{
		$ids = explode( '|', $ids );
		$ids = array_map( 'intval', $ids );
		$ids = array_unique($ids);
		sort( $ids, SORT_NUMERIC );
		if( $ids[0] <= 0 ) {
			$this->dieUsage( "'$name' contains a bad id", "pi_bad{$name}" );
		}
	}

	/**
	* From two parameter arrays, makes an array of the values provided by the user.
	*/
	function getParams( &$property, &$generator )
	{
		global $wgRequest;

		$paramNames = &$generator[GN_PARAMS];
		$paramDefaults = &$generator[GN_DFLT];
		if( count($paramNames) !== count($paramDefaults) ) {
			wfDebugDieBacktrace("Internal error: '$property' param count mismatch");
		}
		$results = array();
		for( $i = 0; $i < count($paramNames); $i++ ) {
			$param = &$paramNames[$i];
			$dflt = &$paramDefaults[$i];
			switch( gettype($dflt) ) {
				case 'NULL':
				case 'string':
					$result = $wgRequest->getVal( $param, $dflt );
					break;
				case 'integer':
					$result = $wgRequest->getInt( $param, $dflt );
					break;
				case 'boolean':
					// Having a default value of 'true' is pointless
					$result = $wgRequest->getCheck( $param );
					break;
				case 'array':
					if( count($dflt) != 3 )
						wfDebugDieBacktrace('Internal error: Enum must have 3 parts - default, allowmultiple, and array of values' . gettype($dflt));
					$result = $this->parseMultiValue( $param, $dflt[GN_ENUM_DFLT], $dflt[GN_ENUM_ISMULTI], $dflt[GN_ENUM_CHOICES] );
					break;
				default:
					wfDebugDieBacktrace('Internal error: unprocessed type ' . gettype($dflt));
			}
			$results[$param] = $result;
		}
		return $results;
	}

	/**
	* Lookup of the page id by ns:title in the data array, and will die if no such title is found
	*/
	function lookupPageIdByTitle( $ns, &$dbkey  )
	{
		$prefixedText = Title::makeTitle( $ns, $dbkey )->getPrefixedText();
		if( array_key_exists( $prefixedText, $this->pageIdByText )) {
			return $this->pageIdByText[$prefixedText];
		}
		wfDebugDieBacktrace( "internal error - '$ns:$dbkey' not found" );
	}

	/**
	* Use this method to add 'titles' or 'pageids' during meta generation in addition to any supplied by the user.
	*/
	function addRaw( $type, $elements )
	{
		$val = & $this->{$type};
		if( $elements !== null && $elements !== '' ) {
			if( is_array( $elements )) {
				$elements = implode( '|', $elements );
			}
			if( $val !== null ) {
				$val .= '|';
			}
			$val .= $elements;
		}
		return $val;
	}

	/**
	* Creates an array describing the properties of a given link
	*/
	function getLinkInfo( $ns, $title, $id = -1, $isRedirect = false )
	{
		return $this->getTitleInfo( Title::makeTitle( $ns, $title ), $id, $isRedirect );
	}

	/**
	* Creates an element    <$title ns='xx' iw='xx' id='xx'>Prefixed Title</$title>
	* All attributes are optional.
	*/
	function getTitleInfo( $title, $id = -1, $isRedirect = false )
	{
		$data = array();
		if( $title->getNamespace() != NS_MAIN ) {
			$data['ns'] = $title->getNamespace();
		}
		if( $title->isExternal() ) {
			$data['iw'] = $title->getInterwiki();
		}
		if( $id === null ) {
			$id = 0;
		}
		if( $id >= 0 ) {
			$data['id'] = intval($id);
		}
		if( $isRedirect ) {
			$data['redirect'] = 'true';
		}
		$data['*'] = $title->getPrefixedText();

		return $data;
	}

	/**
	* Adds a sub element to the page by its id.
	* Example for $multiItems = true (useful when there are many subelements with the same name, like langlinks or backlinks)
	* 'pages' => array (
	*    $pageId => array (
	*      $mainElem => array (
	*        '_element' => $itemElem,
	*        0 => $params
	*        1 => $params
	*        .....
	* Example for $multiItems = false (useful when there are few elements with unique names)
	* 'pages' => array (
	*    $pageId => array (
	*      $mainElem => array (
	*        $itemElem => $params
	*        .....
	*/
	function addPageSubElement( $pageId, $mainElem, $itemElem, $params, $multiItems = true )
	{
		$data = & $this->data['pages'][intval($pageId)][$mainElem];
		if( $multiItems ) {
			$data['_element'] = $itemElem;
			$data[] = $params;
		} else {
			if( !empty($data) && (array_key_exists( $itemElem, $data ) || array_key_exists( '_element', $data ))) {
				wfDebugDieBacktrace("Internal error: multiple calls to addPageSubElement($itemElem)");
			}
			$data[$itemElem] = $params;
		}
	}

	/**
	* Validate the proper format of the timestamp string (14 digits), and add quotes to it.
	*/
	function prepareTimestamp( $value )
	{
		if ( preg_match( '/^[0-9]{14}$/', $value ) ) {
			return $this->db->addQuotes( $value );
		} else {
			$this->dieUsage( 'Incorrect timestamp format', 'badtimestamp' );
		}
	}

	/**
	* NOTE: This function must not be called after calling header()
	* Creates a human-readable usage information message
	*/
	function dieUsage( $message, $errorcode )
	{
		global $wgUser, $wgRequest;

		$this->addStatusMessage( 'error', $errorcode );
		if( $this->format === 'xmlfm' && !$wgRequest->getCheck( 'nousage' ))
		{
			$indentSize = 12;
			$indstr = str_repeat(" ", $indentSize+7);
			$formatString = "  %-{$indentSize}s - %s\n\n";

			$formats = "";
			foreach( $this->outputGenerators as $format => &$generator ) {
				$formats .= sprintf( $formatString, $format,
					mergeDescriptionStrings($generator[GN_DESC], $indstr));
			}

			$props = "\n  *These properties apply to the entire site*\n";
			foreach( $this->propGenerators as $property => &$generator ) {
				if( $generator[GN_ISMETA] ) {
					$props .= sprintf( $formatString, $property,
								mergeDescriptionStrings($generator[GN_DESC], $indstr));
				}
			}
			$props .= "\n  *These properties apply to the specified pages*\n";
			foreach( $this->propGenerators as $property => &$generator ) {
				if( !$generator[GN_ISMETA] ) {
					$props .= sprintf( $formatString, $property,
								mergeDescriptionStrings($generator[GN_DESC], $indstr));
				}
			}

			// No need to html-escape $message - it gets done as part of the xml/html generation
			$msg = array(
				"",
				"",
				"*------ Error: $message ($errorcode) ------*",
				"",
				"*Summary*",
				"  This API provides a way for your applications to query data directly from the MediaWiki servers.",
				"  One or more pieces of information about the site and/or a given list of pages can be retrieved.",
				"  Information may be returned in either a machine (xml, json, php, yaml, wddx) or a human readable format.",
				"  More than one piece of information may be requested with a single query.",
				"",
				"*Usage*",
				"  query.php ? format=... & what=...|...|... & titles=...|...|... & ...",
				"",
				"*Common parameters*",
				"    format     - How should the output be formatted. See formats section below.",
				"    what       - What information the server should return. See the list of available properties below.",
				"                 More than one property may be requested at the same time, separated by pipe '|' symbol.",
				"    titles     - A list of titles, separated by the pipe '|' symbol.",
				"    pageids    - A list of page ids, separated by the pipe '|' symbol.",
				"    revids     - List of revision ids, separated by '|' symbol. See 'revisions' property for additional information.",
				"    noprofile  - When present, each sql query execution time will be hidden.",
				"    proxysite  - Access alternative site (wikipedia/wikinews/wikiquote/...)",
				"    proxylang  - Access alternative language (en/ru/he/commons/...)",
				"                 *Note*: proxying is a security workaround for the browser-based scripts. Avoid using it if you can.",
				"                         User is treated as anonymous, and only sites/languages hosted at the same cluster are accessible.",
				"",
				"*Examples*",
				"    query.php?what=links|templates&titles=User:Yurik",
				"  This query will return a list of all links and templates used on the User:Yurik",
				"",
				"    query.php?what=revisions&titles=Main_Page&rvlimit=100&rvstart=20060401000000&rvcomments",
				"  Get a list of 100 last revisions of the main page with comments, but only if it happened after midnight April 1st 2006",
				"",
				"    query.php?what=revisions&revids=1&rvcomments",
				"  Get revision 1 with some of its properties",
				"",
				"*Notes*",
				"  Some queries marked with *slow query* are known to be database intensive. Please optimize their use.",
				"  Some properties may add status information to the <query> element.",
				"  For example, query.php?what=allpages&aplimit=3 will set an element <query>/<allpages next='B'> to the next available value.",
				"  For the next request, set '__from' to that value to continue paging: query.php?what=allpages&aplimit=3&apfrom=B",
				"  In addition, <query> element has performance time (in ms) for both database and total processing to allow request optimization.",
				"",
				"*Supported Properties*",
				$props,
				"",
				"*Supported Formats*",
				$formats,
				"",
				"*Links*",
				"  Home Page:            http://en.wikipedia.org/wiki/User:Yurik/Query_API",
				"  Suggestions:          http://en.wikipedia.org/wiki/User_talk:Yurik/Query_API",
				"  Changelog and Source: http://svn.wikimedia.org/viewvc/mediawiki/trunk/extensions/BotQuery/query%2Ephp?view=log",
				"",
				"*Credits*",
				"  This feature was written and is being maintained by Yuri Astrakhan (<Firstname><Lastname>@gmail.com)",
				"  Please leave your comments and suggestions at http://en.wikipedia.org/wiki/User_talk:Yurik",
				"",
				"  This extension came as the result of IRC discussion between Yuri Astrakhan (en:Yurik), Tim Starling (en:Tim Starling), and Daniel Kinzler(de:Duesentrieb)",
				"  The extension was first implemented by Tim to provide interlanguage links and history summary.",
				"  It was later completely rewritten by Yuri, introducing the rest of properties, meta information, and various formatting options.",
				"",
				"*User Status*",
				"  You are " . ($wgUser->isAnon() ? "an anonymous" : "a logged-in") . " " . ($this->isBot ? "bot" : "user") . " " . $wgUser->getName(),
				"",
				"*Version*",
				'  $Id: query.php 584 2008-07-29 13:59:13Z emil $',
				"",
				);

			$this->addStatusMessage( 'usage', implode("\n", $msg), true );
		}
		$this->output(true);
		die(0);
	}

	/**
	* Adds a status message into the <query> element, for a given module.
	*/
	function addStatusMessage( $module, $value, $preserveXmlSpacing = false )
	{
		$this->addTopMessage( 'query', $module, $value, $preserveXmlSpacing );
	}

	/**
	* Adds a status message into the <query> element, for a given module.
	*/
	function addPerfMessage( $module, $value, $preserveXmlSpacing = false )
	{
		$this->addTopMessage( 'perf', $module, $value, $preserveXmlSpacing );
	}

	function addTopMessage( $main, $module, $value, $preserveXmlSpacing )
	{
		if( !array_key_exists( $main, $this->data )) {
			$this->data[$main] = array();
		}
		if( !array_key_exists( $module, $this->data[$main] )) {
			$this->data[$main][$module] = array();
		}

		$element = &$this->data[$main][$module];
		if( is_array($value) ) {
			$element = array_merge( $element, $value );
			if( !array_key_exists( '*', $element )) {
				$element['*'] = '';
			}
		} else {
			if( array_key_exists( '*', $element )) {
				$element['*'] .= $value;
			} else {
				$element['*'] = $value;
			}
			if( $preserveXmlSpacing ) {
				$element['xml:space'] = 'preserve';
			}
		}
	}

	/**
	* Records the time of the call to this method
	*/
	function startProfiling()
	{
		$this->moduleStartTime = wfTime();
	}
	/**
	* Same as startProfiling, but used for DB access only
	*/
	function startDbProfiling()
	{
		$this->moduleDbStartTime = wfTime();
	}

	/**
	* Records the running time of the given module since last startDbProfiling() call.
	*/
	function endProfiling( $module )
	{
		$this->recordProfiling( $module, 'time', $this->moduleStartTime );
	}
	/**
	* Same as endProfiling, but used for DB access only
	*/
	function endDbProfiling( $module )
	{
		$this->totalDbTime += $this->recordProfiling( $module, 'dbtime', $this->moduleDbStartTime );
	}
	/**
	* Helper profiling function
	*/
	function recordProfiling( $module, $type, &$start )
	{
		$timeDelta = wfTime() - $start;

		// When making multiple calls to the same module, sum up with previous value
		$prevDelta = 0;
		if( isset($this->data['perf'][$module][$type]) )
			$prevDelta = $this->data['perf'][$module][$type] / 1000.0;

		$this->addPerfMessage( $module, array( $type => formatTimeInMs($timeDelta + $prevDelta) ));
		return $timeDelta;
	}

	function formatTimeFromStart()
	{
		return 'Total execution time: ' . formatTimeInMs(wfTime() - $this->startTime) . ' ms';
	}

	/**
	* Validate the value against the minimum and user/bot maximum limits. Prints usage info on failure.
	*/
	function validateLimit( $varname, $value, $max, $botMax = false, $min = 0 )
	{
		global $wgUser;
		if( $botMax === false ) $botMax = $max;

		if ( $value < $min ) {
			$this->dieUsage( "$value entries is less than $min", $varname );
		}
		if( $this->isBot ) {
			if ( $value > $botMax ) {
				$this->dieUsage( "Bot requested $value pages, which is over $botMax pages allowed", $varname );
			}
		} else {
			if( $value > $max ) {
				$this->dieUsage( "User requested $value pages, which is over $max pages allowed", $varname );
			}
		}
	}

	//
	// ************************************* Print Methods *************************************
	//

	/**
	* Prints data in html format. Escapes all unsafe characters. Adds a warning in the beginning.
	*/
	function printDataInHtml( &$data, $format )
	{
	?>
	<html>
	<head>
		<title>MediaWiki Query Interface</title>
	</head>
	<body>
		<br />
	<?php
		if( !array_key_exists('usage', $data) ) {
	?>
		<small>
		This page is being rendered in <?=$format?> format, which might not be suitable for your application.<br />
		See <a href="query.php">query.php</a> for more information.<br />
		</small>
	<?php
		}
	?>
	<pre><?php
		if ($format == 'XML')
		{
			recXmlPrint( 'htmlPrinter', 'yurik', $data, -2 );
		}
		else
		{
			sanitizeOutputData($data);
			switch ($format)
			{
				case 'JSON':
					require_once 'json.php';
					$json = new Services_JSON();
					htmlPrinter( $json->encode( $data, true ));
					break;
				case 'YAML':
					require_once 'spyc.php';
					htmlPrinter( Spyc::YAMLDump($data) );
					break;
				case 'TXT':
					htmlPrinter( print_r($data, true) );
					break;
				case 'DBG':
					htmlPrinter( var_export($data, true) );
					break;
				default:
					wfDebugDieBacktrace( "Unknown formatted print format '$format'" );
			}
		}

		if( $this->enableProfiling )
			htmlPrinter( "\n\n*{$this->formatTimeFromStart()}*" );

	?></pre>
	</body>
	<?php
	}

	function printFormattedXML( &$data )  { $this->printDataInHtml( $data, 'XML' );  }
	function printFormattedJSON( &$data ) { $this->printDataInHtml( $data, 'JSON' ); }
	function printFormattedYAML( &$data ) { $this->printDataInHtml( $data, 'YAML' );  }
	function printFormattedTXT( &$data )  { $this->printDataInHtml( $data, 'TXT' );  }
	function printFormattedDBG( &$data )  { $this->printDataInHtml( $data, 'DBG' );  }

	/**
	* Output data in XML format
	*/
	function printXML( &$data )
	{
		global $wgRequest;
		echo '<?xml version="1.0" encoding="utf-8"?>';
		recXmlPrint( 'echoPrinter', 'yurik', $data, $wgRequest->getCheck('xmlindent') ? -2 : null );
		if( $this->enableProfiling ) echoPrinter( "\n<!--{$this->formatTimeFromStart()}-->" );
	}

	/**
	* Sanitizes the data and serialize() it so that other php scripts can easily consume the data
	*/
	function printPHP( &$data )
	{
		sanitizeOutputData($data);
		echo serialize($data);
	}

	/**
	* Sanitizes the data and serialize it in WDDX format.
	* If PHP was compiled with WDDX support, use it (faster)
	*/
	function printWDDX( &$data )
	{
		sanitizeOutputData($data);
		if ( function_exists( 'wddx_serialize_value' ) ) {
			echo wddx_serialize_value($data);
		} else {
			echo '<?xml version="1.0" encoding="utf-8"?>';
			echo '<wddxPacket version="1.0"><header/><data>';
			slowWddxPrinter( $data );
			echo '</data></wddxPacket>';
		}
		if( $this->enableProfiling ) echo "\n<!--{$this->formatTimeFromStart()}-->";
	}

	/**
	* Sanitizes the data and serializes it in JSON format
	*/
	function printJSON( &$data )
	{
		sanitizeOutputData($data);
		if ( !function_exists( 'json_encode' ) ) {
			require_once 'json.php';
			$json = new Services_JSON();
			echo $json->encode( $data );
		} else {
			echo json_encode( $data );
		}
	}

	/**
	* Sanitizes the data and serializes it in YAML format
	*/
	function printYAML( &$data )
	{
		sanitizeOutputData($data);
		require_once 'spyc.php';
		echo Spyc::YAMLDump($data);
	}
}

/**
* Prety-print various elements in HTML format, such as xml tags and URLs. This method also replaces any "<" with &lt;
*/
function htmlPrinter( $text )
{
	// Escape everything first for full coverage
	$text = htmlspecialchars($text);
	
	// encode all comments or tags as safe blue strings
	$text = preg_replace('/\&lt;(!--.*?--|.*?)\&gt;/', '<span style="color:blue;">&lt;\1&gt;</span>', $text);
	// identify URLs
	$text = ereg_replace("[a-zA-Z]+://[^ '()<\n]+", '<a href="\\0">\\0</a>', $text);
	// identify requests to query.php
	$text = ereg_replace("query\\.php\\?[^ ()<\n]+", '<a href="\\0">\\0</a>', $text);
	// make strings inside * bold
	$text = ereg_replace("\\*[^<>\n]+\\*", '<b>\\0</b>', $text);
	echo $text;
}

/**
* Pass-through printer.
*/
function echoPrinter( $text )
{
	echo $text;
}

/**
* Recursivelly go through the object and output its data in WDDX format.
*/
function slowWddxPrinter( &$elemValue )
{
	switch( gettype($elemValue) ) {
		case 'array':
			echo '<struct>';
			foreach( $elemValue as $subElemName => &$subElemValue ) {
				echo wfOpenElement( 'var', array('name' => $subElemName) );
				slowWddxPrinter( $subElemValue );
				echo '</var>';
			}
			echo '</struct>';
			break;
		case 'integer':
		case 'double':
			echo wfElement( 'number', null, $elemValue );
			break;
		case 'string':
			echo wfElement( 'string', null, $elemValue );
			break;
		default:
			wfDebugDieBacktrace( 'Unknown type ' . gettype($elemValue) );
	}
}

/**
* Recursivelly removes any elements from the array that begin with an '_'.
* The content element '*' is the only special element that is left.
* Use this method when the entire data object gets sent to the user.
*/
function sanitizeOutputData( &$data )
{
	foreach( $data as $key => &$value ) {
		if( $key[0] === '_' ) {
			unset( $data[$key] );
		} elseif( $key === '*' && $value === '' ) {
			unset( $data[$key] );
		} elseif( is_array( $value )) {
			sanitizeOutputData( $value );
		}
	}
}

/**
* This method takes an array and converts it into an xml.
* There are several noteworthy cases:
*
*  If array contains a key "_element", then the code assumes that ALL other keys are not important and replaces them with the value['_element'].
*	Example:	name="root",  value = array( "_element"=>"page", "x", "y", "z") creates <root>  <page>x</page>  <page>y</page>  <page>z</page> </root>
*
*  If any of the array's element key is "*", then the code treats all other key->value pairs as attributes, and the value['*'] as the element's content.
*	Example:	name="root",  value = array( "*"=>"text", "lang"=>"en", "id"=>10)   creates  <root lang="en" id="10">text</root>
*
* If neither key is found, all keys become element names, and values become element content.
* The method is recursive, so the same rules apply to any sub-arrays.
*/
function recXmlPrint( $printer, $elemName, &$elemValue, $indent )
{
	$indstr = "";
	if( !is_null($indent) ) {
		$indent += 2;
		$indstr = "\n" . str_repeat(" ", $indent);
	}

	switch( gettype($elemValue) ) {
		case 'array':
			if( array_key_exists('*', $elemValue) ) {
				$subElemContent = $elemValue['*'];
				unset( $elemValue['*'] );
				if( gettype( $subElemContent ) === 'array' ) {
					$printer( $indstr . wfOpenElement( $elemName, $elemValue ));
					recXmlPrint( $printer, $elemName, $subElemContent, $indent );
					$printer( $indstr . "</$elemName>" );
				} else {
					$printer( $indstr . wfElement( $elemName, $elemValue, $subElemContent ));
				}
			} else {
				$printer( $indstr . wfOpenElement( $elemName, null ));
				if( array_key_exists('_element', $elemValue) ) {
					$subElemName = $elemValue['_element'];
					foreach( $elemValue as $subElemId => &$subElemValue ) {
						if( $subElemId !== '_element' ) {
							recXmlPrint( $printer, $subElemName, $subElemValue, $indent );
						}
					}
				} else {
					foreach( $elemValue as $subElemName => &$subElemValue ) {
						recXmlPrint( $printer, $subElemName, $subElemValue, $indent );
					}
				}
				$printer( $indstr . "</$elemName>" );
			}
			break;
		case 'object':
			// ignore
			break;
		default:
			$printer( $indstr . wfElement( $elemName, null, $elemValue ));
			break;
	}
}

/**
* Helper method that merges an array of strings and prepends each line with an indentation string
*/
function mergeDescriptionStrings( &$value, $indstr )
{
	if( is_array($value) ) {
		$value = implode( "\n", $value );
	}
	return str_replace("\n", "\n$indstr", $value);
}

/**
* Merge all known generator parameters into one array of values. Used for logging.
*/
function mergeParameters( &$generators )
{
	$params = array();
	foreach( $generators as $property => &$generator ) {
		$value = &$generator[GN_PARAMS];
		if( $value !== null ) {
			if( is_array($value) ) {
				$params = array_merge( $params, $value );
			} else {
				$params[] = $value;
			}
		}
	}
	return $params;
}

function formatTimeInMs($timeDelta)
{
	return round( $timeDelta * 1000.0, 1 );
}

function titleToKey($title)
{
	return str_replace(' ', '_', $title);
}
function keyToTitle($key)
{
	return str_replace('_', ' ', $key);
}

/**
*@desc Get a parameter from the request, and validate that it contains only '-' or lower case letters
*/
function GetCleanProxyValue($name)
{
	if (isset($_REQUEST[$name]) && !empty($_REQUEST[$name]))
	{
		$value = $_REQUEST[$name];
		if (preg_match('/^[a-z-]+$/', $value))
			return $value;
	}
	return false;
}



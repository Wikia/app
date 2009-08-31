<?php
/**********************************************************************************

Copyright (C) 2006-08 Bradley Pesicka (teknomunk@bluebottle.com)

Tested on
# MediaWiki: 1.7.1, 1.11.1
# PHP: 5.0.5-2ubuntu1.5 (apache2handler)
# MySQL: 4.0.24_Debian-10ubuntu2.3-log

Developed for use by LryicWiki.org (http://www.lyricwiki.org/)

***********************************************************************************

This extention allows formatting of xml files in MediaWiki.

Known limitations:
* Limited security on feeds fetched.
* Any html in the feed fields will rendered as though it were wikitext
* Formatting cannot be done recursively

Version 0.2.3	2008-03-03
* Add user permissions to debug switches - must be an administrator to use them - teknomunk
* add i18n file - teknomunk

Version 0.2.2	2008-03-03
* Replace parser with sandboxParser that allows ParserFunctions to work inside <item>'s

Version 0.2.1b	2008-02-05
* Added debug switches - teknomunk

Version 0.2.1	2008-02-05
* Complete rewrite of XML parser to do things correctly - teknomunk

Version 0.1.2	2007-12-11
* Security/Bugfix: limit parse time - teknomunk
* Bugfix: use greedy matching for tag contents and then clip to the first closing tag - teknomunk
* Bugfix: add some basic error reporting - teknomunk

Version 0.1.1	2006-11-13
* SecurityFix: remove possiblity of being used to DOS sites. - teknomunk
* Bugfix: don't die when given an empty feed - teknomunk
* Bugfix: rember to unencode text fields - teknomunk
* Bugfix: was generating UNIQ- tags, used a local parser instance instead - teknomunk
* Bugfix: cache feed and use that when live feed is not available - Sean Colombo
* Bugfix: server did not support file_get_contents - Sean Colombo
* Bugfix: handle decoding of <![CDATA[  ]]> tags - teknomunk
* Bugfix: Fix dencode_cdata - teknomunk

Version 0.1
* Initial coding - teknomunk

***********************************************************************************/

require_once 'cache.php'; // Cache class used to cache the results of the cURL request.
require_once 'extras.php';

$dir = dirname(__FILE__) . '/';
$wgExtensionFunctions[] = "wfXMLFormatter";
$wgExtensionMessagesFiles['XMLParser'] = $dir . 'Tag_XML.i18n.php';

if(isset($wgScriptPath))
{
$wgExtensionCredits["parserhook"][]=array(
'name' => 'XML Formatter',
'version' => '0.2.3',
'author' => '[http://www.lyricwiki.org/User:Teknomunk teknomunk]',
'description' => 'Allows expanding XML-based files into wikitext' );
}

function wfXMLFormatter()
{
	global $wgParser;

	$wgParser->setHook( "xml", "renderXML" );
}

function debugSwitch( $name )
{
	global $wgUser;

	return ( ( $wgUser->isAllowed('delete')) && isset($_GET['ds']) && (strpos($_GET['ds'],$name) !== false) );
}

require_once "xml.php";

function filter( $string )
{
	return str_replace("\n","\\n",$string);
}
function unfilter( $string )
{
	return str_replace("\\n","\n",$string);
}

function renderXML( $input, $argv, &$parser )
{
	global $wgOut;
	$localParser = new Parser();
	wfLoadExtensionMessages('XMLParser');
	
	// make sure that php-curl is installed
	if( !function_exists("curl_init") )
	{
		return wfMsg("xml-nocurl");
	}
	
	// parameters
	$feedURL = $argv["feed"];
	$escapedFeedURL = urlencode($argv["feed"]);
	$maxItems = (integer)$argv["maxitems"];
	$addLineFeed = $argv["linefeed"];
	
	// retrieve the xml source from the cache before trying to fetch it
	// limits possible stress on other people's servers, reduces chance of DOS attacks
	$cache = new Cache();
	$cachedSource = false;
	if( debugSwitch("forceload") )
	{
		$cachedSource = $cache->fetchExpire( $escapedFeedURL, strtotime("-2 hour") );
	}
	if( !$cachedSource )
	{
		// Uses cURL library since DreamHost has file_get_contents() disabled for remote URLs.
		$ch = curl_init();
		$timeout = 5; // set to zero for no timeout
		curl_setopt ($ch, CURLOPT_URL, $feedURL);
		curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt ($ch, CURLOPT_FOLLOWLOCATION,1);
		curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
		$source = curl_exec($ch);

		// NOTE: If CURLOPT_RETURNTRANSER is true (it is) and the document returned is size 0, curl_exec returns a boolean true instead of an empty string.
		if($source === true){
			$source = "";
			curl_close($ch);
			return wfMsg("xml-emptyresult");
		} else if($source === FALSE){
			return wfMsg("xml-feedfailed");
		} else {
			curl_close($ch);
		}

		// only cache newly fetched sources
		$cache->cacheValue( $escapedFeedURL, $source );
	}
	else
	{
		$source = $cachedSource;
	}
	if(debugSwitch("source"))
	{
		echo $source."\n";
	}
	
	// parse
	$feed = new XmlDocument();
	if( !$feed->parse($source) )
	{
		return wfMsg("xml-parseerror",$feed->getError());
	}

	// fill in the template with the fields from the xml file
	preg_match_all( "#<item path=\"(.*?)\">(.*?)</item>#", filter($input), $matches );
	$result = "";
	foreach( $matches[0] as $i=>$text )
	{
		$path = $matches[1][$i];
		$template = filter(trim(unfilter($matches[2][$i])));
		
		$items = $feed->getItem( $path );
		$count = min( count( $items ), $maxItems );
		
		if( !$items )
		{
			$result .= wfMsg("xml-pathnotfound",$path);
		}

		for( $i = 0; $i < $count; ++$i )
		{
			$item = $items[$i];

			// fill in the template (use standard template parameter format)
			$text = $template;
			if( preg_match_all( "/{{{([a-zA-Z:]*)}}}/", $text, $fields ) )
			{
				foreach( array_unique( $fields[1] ) as $field )
				{
					// SWC 20061113 - Broke the accessing into two lines so that it parses
					$tempArray = $item[strtoupper($field)];
					$currValue = implode("", $tempArray[0]);
					$text = str_replace( "{{{{$field}}}}", $currValue, $text );
				}
			}

			// conditially add a line feed to the end of each item
			if( $addLineFeed )
			{
				$result .= $text."\n";
			}
			else
			{
				$result .= $text;
			}
		}
	}

	return sandboxParse( $result );
}

// Function is also in the SOAP, so this prevents any possible errors.
if(!function_exists('lw_connect')){
	GLOBAL $lw_db;
	GLOBAL $lw_host;$lw_host = $wgDBserver;
	GLOBAL $lw_user;$lw_user = $wgDBuser;
	GLOBAL $lw_pass;$lw_pass = $wgDBpassword;
	GLOBAL $lw_name;$lw_name = $wgDBname;

	////
	// Connects to the wiki database using the configured settings.
	// Only connects once per page-load so it's safe to call as many times as
	// needed without additional overhead.
	////
	function lw_connect(){
		GLOBAL $lw_db;
		if(isset($lw_db)){
			$db = $lw_db;
		} else {
			GLOBAL $lw_host,$lw_user,$lw_pass,$lw_name;
			$db = mysql_connect($lw_host, $lw_user, $lw_pass);
			mysql_select_db($lw_name, $db);
			$lw_db = $db;
		}
		return $db;
	} // end lw_connect()
}
?>

<?php
/**********************************************************************************

Copyright (C) 2006-08 Bradley Pesicka (teknomunk@bluebottle.com)

Tested on
# MediaWiki: 1.7.1, 1.11.1
# PHP: 5.0.5-2ubuntu1.5 (apache2handler)
# MySQL: 4.0.24_Debian-10ubuntu2.3-log

Developed for use by LyricWiki (http://lyrics.wikia.com/)

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

require_once 'extras.php';

$dir = dirname(__FILE__) . '/';
$wgExtensionFunctions[] = "wfXMLFormatter";
$wgExtensionMessagesFiles['XMLParser'] = $dir . 'Tag_XML.i18n.php';

if(isset($wgScriptPath))
{
$wgExtensionCredits["parserhook"][]=array(
'name' => 'XML Formatter',
'version' => '0.2.3',
'author' => '[http://lyrics.wikia.com/User:Teknomunk teknomunk]',
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
	
	// parameters
	$feedURL = $argv["feed"];
	$escapedFeedURL = urlencode($argv["feed"]);
	$maxItems = (integer)$argv["maxitems"];
	$addLineFeed = $argv["linefeed"];
	
	// retrieve the xml source from the cache before trying to fetch it
	// limits possible stress on other people's servers, reduces chance of DOS attacks
	GLOBAL $wgMemc;
	$cachedSource = false;
	if( debugSwitch("forceload") )
	{
		$wgMemc->get($escapedFeedUrl);
	}
	if( !$cachedSource )
	{
		// Uses Http::get which is the prefered method to make requests from MediaWiki since it handles going through proxies, etc.
		$timeout = 5; // set to zero for no timeout
		$source = Http::get(
			$feedURL,
			$timeout, // 'default' as a string to use the default
			array(
				CURLOPT_FOLLOWLOCATION => 1,
			)
		);

		if( !$source ){
			return wfMsgExt("xml-feedfailed", array('parseinline'));
		}

		// only cache newly fetched sources
		$wgMemc->set($escapedFeedURL, $source, strtotime("+2 hour"));
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

?>

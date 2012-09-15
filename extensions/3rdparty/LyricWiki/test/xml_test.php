<?php

require_once 'xml.php';

$feedURL = "http://lyricwiki.wordpress.com/feed/";

//*
$ch = curl_init();
$timeout = 5; // set to zero for no timeout
curl_setopt ($ch, CURLOPT_URL, $feedURL);
curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
$source = curl_exec($ch);
curl_close($ch);
/*/
$source = '
<?xml version="1.0" encoding="UTF-8"?>
<rss version="2.0"
	xmlns:content="http://purl.org/rss/1.0/modules/content/"
	xmlns:wfw="http://wellformedweb.org/CommentAPI/"
	xmlns:dc="http://purl.org/dc/elements/1.1/"
	xmlns:atom="http://www.w3.org/2005/Atom"
	xmlns:media="http://search.yahoo.com/mrss"
	>

<channel>
	<title>LyricWiki.org</title>
	<atom:link href="http://lyricwiki.wordpress.com/feed/" rel="self" type="application/rss+xml" />
</channel>
</rss>
';
//*/

#echo $source;

$xml = new XmlDocument();
$xml->parse($source);

$items = $xml->getItem("/rss/channel/item[*]");

if( $items )
{
	foreach($items as $item)
	{
		echo "=================================\n";
		#var_dump($item["TITLE"]);
		echo implode($item["TITLE"][0])."\n";
	}
}
//*/


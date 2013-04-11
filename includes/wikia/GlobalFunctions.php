<?php

if ( !defined( 'MEDIAWIKI' ) ) {
	die( "This file is part of MediaWiki, it is not a valid entry point" );
}

/**
 * Global functions used everywhere for Wikia purposes.
 */

/**
 * Author: Inez Korczyński
 */
function GetLinksArrayFromMessage($messagename) { // feel free to suggest better name for this function
	global $parserMemc, $wgEnableSidebarCache;
	global $wgLang, $wgContLang;

	wfProfileIn("GetLinksArrayFromMessage");
	$key = wfMemcKey($messagename);

	$cacheSidebar = $wgEnableSidebarCache &&
		($wgLang->getCode() == $wgContLang->getCode());

	if ($cacheSidebar) {
		$cachedsidebar = $parserMemc->get( $key );
		if ($cachedsidebar!="") {
			wfProfileOut("GetLinksArrayFromMessage");
			return $cachedsidebar;
		}
	}

	$bar = array();
	$lines = explode( "\n", wfMsgForContent( $messagename ) );
	foreach ($lines as $line) {
		if (strlen($line) == 0) // ignore empty lines
			continue;
		if (strpos($line, '*') !== 0)
			continue;
		if (strpos($line, '**') !== 0) {
			$line = trim($line, '* ');
			$heading = $line;
		} else {
			if (strpos($line, '|') !== false) { // sanity check
				$line = explode( '|' , trim($line, '* '), 2 );
				$link = wfMsgForContent( $line[0] );
				if ($link == '-')
					continue;
				if (wfEmptyMsg($line[1], $text = wfMsg($line[1])))
					$text = $line[1];
				if (wfEmptyMsg($line[0], $link))
					$link = $line[0];
					if ( preg_match( '/^(?:' . wfUrlProtocols() . ')/', $link ) ) {
					$href = $link;
				} else {
					$title = Title::newFromText( $link );
					if ( $title ) {
						$title = $title->fixSpecialName();
						$href = $title->getLocalURL();
					} else {
						$href = 'INVALID-TITLE';
					}
				}

				if(isset($heading)) {
						$bar[$heading][] = array(
						'text' => $text,
						'href' => $href,
						'id' => 'n-' . strtr($line[1], ' ', '-'),
						'active' => false
					);
				}
			} else { continue; }
		}
	}
	if ($cacheSidebar)
		$parserMemc->set( $key, $bar, 86400 );
	wfProfileOut("GetLinksArrayFromMessage");
	return $bar;
}

/**
 * print_pre
 *
 * @author: Inez Korczyński
 *
 */
function print_pre($param, $return = 0)
{
	global $wgDisablePrintPre;
	if ( isset ( $wgDisablePrintPre ) && $wgDisablePrintPre == true ) {
		return '';
	}
	$retval = "<pre>".print_r( $param, 1 )."</pre>";
	if  (empty( $return )) {
		echo $retval;
	}
	else {
		return $retval;
	}
}

/**
 * wfReplaceImageServer -- replace hostname of image servers
 *
 * @author Inez Korczyński <inez@wikia-inc.com>
 *
 * @param String $url -- old url
 * @param String $timestamp -- last change timestamp
 *
 * @return String -- new url
 */
function wfReplaceImageServer( $url, $timestamp = false ) {
	global $wgImagesServers, $wgAkamaiLocalVersion,  $wgAkamaiGlobalVersion, $wgDevBoxImageServerOverride, $wgDBname;


	// Override image server location for Wikia development environment
	// This setting should be images.developerName.wikia-dev.com or perhaps "localhost"
	if (!empty($wgDevBoxImageServerOverride)) {
		$url = str_replace("devbox", $wgDBname, $url);   // this will pull images from override wiki instead of devbox
	}

	wfDebug( __METHOD__ . ": requested url $url\n" );
	if(substr(strtolower($url), -4) != '.ogg' && isset($wgImagesServers) && is_int($wgImagesServers)) {
		if(strlen($url) > 7 && substr($url,0,7) == 'http://') {
			$hash = sha1($url);
			$inthash = ord ($hash);

			$serverNo = $inthash%($wgImagesServers-1);
			$serverNo++;

			// If there is no timestamp, use the cache-busting number from wgCdnStylePath.
			if($timestamp == ""){
				global $wgCdnStylePath;
				$matches = array();
				if(0 < preg_match("/\/__cb([0-9]+)/i", $wgCdnStylePath, $matches)){
					$timestamp = $matches[1];
				} else {
					// This results in no caching of the image.  Bad bad bad, but the best way to fail.
					Wikia::log( __METHOD__, "", "BAD FOR CACHING!: There is a call to ".__METHOD__." without a timestamp and we could not parse a fallback cache-busting number out of wgCdnStylePath.  This means the '{$url}' image won't be cacheable!");
					$timestamp = rand(0, 1000);
				}
			} else if(strtotime($timestamp) > strtotime("now -10 minute")){
				// To prevent a race-condition, if the image is less than 10 minutes old, don't use cb-value.
				// This will cause Akamai to only cache for 30 seconds.
				$timestamp = "";
			}
			// Add Akamai versions, but only if there is some sort of caching number.
			if($timestamp != ""){
				$timestamp += $wgAkamaiGlobalVersion + $wgAkamaiLocalVersion;
			}

			// NOTE: This should be the only use of the cache-buster which does not use $wgCdnStylePath.
			// RT#98969 if the url already has a cb value, don't add another one...
			$cb = ($timestamp!='' && strpos($url, "__cb") === false) ? "__cb{$timestamp}/" : '';

			if (!empty($wgDevBoxImageServerOverride)) {
				// Dev boxes
				$url = str_replace('http://images.wikia.com/', sprintf("http://$wgDevBoxImageServerOverride/%s", $cb), $url);
			} else {
				// Production
				$url = str_replace('http://images.wikia.com/', sprintf("http://images%s.wikia.nocookie.net/%s",$serverNo, $cb), $url);
			}
		}
	} else if (!empty($wgDevBoxImageServerOverride)) {
		$url = str_replace('http://images.wikia.com/', "http://$wgDevBoxImageServerOverride/", $url);
	}

	return $url;
}

/**
 * Returns a link to the same asset after applying domain sharding
 *
 * @see wfReplaceImageServer
 * @author Władysław Bodzek
 * @param $url string URL to an asset
 * @return string URL after applying domain sharding
 */
function wfReplaceAssetServer( $url ) {
	global $wgImagesServers;

	$matches = array();
	if ( preg_match("#^(?<a>(https?:)?//(slot[0-9]+\\.)?images)(?<b>\\.wikia\\.nocookie\\.net/.*)\$#",$url,$matches) ) {
		$hash = sha1($url);
		$inthash = ord($hash);

		$serverNo = $inthash%($wgImagesServers-1);
		$serverNo++;

		$url = $matches['a'] . ($serverNo) . $matches['b'];

	}

	return $url;
}

/**
 * 	@author Krzysztof Zmudziński <kaz3t@wikia.com>
 *	Returns array of review reason id
 */
function wfGetReviewReason($max = 5) {
	global $wgMemc, $wgDBname;

	$key = "$wgDBname:ReviewReasons";
	$result = $wgMemc->get($key);

	if (!is_array($result)) {
		for ($i = 1; $i <= $max; $i++) {
			$msg = htmlspecialchars_decode(wfMsg("review_reason_$i"));
			if ($msg[0] != "<") {
				$result[$i] = $msg;
			}
		}
		$wgMemc->set($key, $result, 60);
	}
	return $result;
}

/**
 * Function to shorten / truncate a string of text into a specific number of
 * characters and add three dots (...) to the end. This will also round the
 * text to the nearest whole word instead of cutting off part way through a
 * word. From: http://www.totallyphp.co.uk/code/shorten_a_text_string.htm
 * Added multibyte string support
 */
function wfShortenText( $text, $chars = 25, $useContentLanguage = false ){
	if( mb_strlen( $text ) <= $chars ) {
		return $text;
	}

	static $ellipsis = array();
	$key = ( !empty( $useContentLanguage ) ) ? 'user' : 'content';

	//memoize the message to avoid overhead,
	//this might be called many times in the
	//same process/request
	if ( !array_key_exists( $key, $ellipsis ) ) {
		$msg = ( !empty( $useContentLanguage ) ) ?
			wfMsgForContent( 'ellipsis' ) :
			wfMsg( 'ellipsis' );

		$ellipsis[$key] = array(
			$msg,
			mb_strlen( $msg )
		);
	}

	if ( $ellipsis[$key][1] >= $chars ) {
		return '';
	}

	$text = mb_substr( $text, 0, $chars - $ellipsis[$key][1] );
	$spacePos = mb_strrpos( $text, ' ' );
	$backslashPos = mb_strrpos( $text, '/' );

	if ( $spacePos || $backslashPos ) {
		$text = mb_substr( $text, 0, max( $spacePos, $backslashPos ) );
	}

	//remove symbols at the end of the snippet to avoid situations like:
	//:... or ?... or ,... etc. etc.
	$text = preg_replace( '/[[:punct:]]+$/', '', $text ) . $ellipsis[$key][0];
	return $text;
}

function wfGetBreadCrumb( $cityId = 0 ) {
	global $wgMemc, $wgSitename, $wgServer, $wgCats, $wgExternalSharedDB, $wgCityId;

	$method = __METHOD__;

	if( !empty( $wgCats ) ) {
		return $wgCats;
	}
	if ( empty ($wgExternalSharedDB)) {
		return $wgCats;
	}

	wfProfileIn( $method );
	$memckey = 'cat_structure';
	if ($cityId) $memckey[] = $cityId;
	$wgCats = $wgMemc->get( wfMemcKey( $memckey ) );
	if( empty( $wgCats ) ) {
		if( $cityId == 0 ) {
			if( $wgCityId == 0 ) {
				wfProfileOut( $method );
				return array();
			} else {
				$cityId = $wgCityId;
			}
		}

		wfProfileIn( $method . "-fromdb" );
		$dbr = wfGetDB( DB_SLAVE, array(), $wgExternalSharedDB );
		$catId = $dbr->selectField(
				"city_cat_mapping",
				"cat_id",
				array( "city_id" => $cityId ) );
		$wgCats = array();
		while( !empty( $catId ) ) {
			$res = $dbr->select(
				array( "city_cat_structure", "city_cats" ),
				array( "cat_name", "cat_url", "cat_parent_id" ),
				array( "city_cat_structure.cat_id=city_cats.cat_id", "city_cat_structure.cat_id={$catId}" )
			);
			if( $row = $dbr->fetchObject( $res ) ) {
				$wgCats[] = array( "name" => $row->cat_name, "url" => $row->cat_url, "id" => intval( $catId ), "parentId" => intval( $row->cat_parent_id ) );
				$catId = $row->cat_parent_id;
			}
		}
		wfProfileOut( $method . "-fromdb" );

		$wgCats = array_reverse( $wgCats );

		$wgMemc->set( wfMemcKey( 'cat_structure' ), $wgCats, 3600 );
	}
	array_unshift( $wgCats, array('name' => 'Wikia', 'url' => 'http://www.wikia.com/wiki/Wikia', 'id' => 0, 'parentId' => 0 ) );
	$lastId = intval( $wgCats[count($wgCats)-1]['id'] );
	$wgCats[] = array( 'name' => $wgSitename, 'url' => $wgServer, 'id' => 0, 'parentId' => $lastId );

	wfProfileOut( $method );
	return $wgCats;
}

/**
 * wfGetImagesCommon
 *
 * @return string: base url for common images
 */
function wfGetImagesCommon() {
	return 'http://images.wikia.com/common/';
}

/**
 * to decode an escaped string in unicode
 * from php.net by pedantic@hotmail.co.jp
 */
function wfDecodeUnicodeUrl($str) {
	$res = '';

    $i = 0;
	$max = strlen($str) - 6;
	while ($i <= $max)
	{
		$character = $str[$i];
		if ($character == '%' && $str[$i + 1] == 'u')
		{
		    $value = hexdec(substr($str, $i + 2, 4));
			$i += 6;

			if ($value < 0x0080) // 1 byte: 0xxxxxxx
				$character = chr($value);
			else if ($value < 0x0800) // 2 bytes: 110xxxxx 10xxxxxx
				$character = chr((($value & 0x07c0) >> 6) | 0xc0)
					. chr(($value & 0x3f) | 0x80);
			else // 3 bytes: 1110xxxx 10xxxxxx 10xxxxxx
				$character = chr((($value & 0xf000) >> 12) | 0xe0)
					. chr((($value & 0x0fc0) >> 6) | 0x80)
					. chr(($value & 0x3f) | 0x80);
		}
		else
			$i++;

		$res .= $character;
	}

	return $res . substr($str, $i);
}

/**
 * Test if current page is a TalkPage
 *
 * @author Marooned (marooned@wikia.com)
 *
 * @return bool - true when: 1) user is logged in, 2) current page is a TalkPage for current user, 3) page is displayed - not edited, moved or changed in any way
 */
function wfIsTalkPageForCurrentUserDisplayed() {
	global $wgUser, $wgTitle, $wgOut, $wgRequest;
	$action = $wgRequest->getText('action');
	return (
		$wgUser->isLoggedIn() &&
		$wgTitle->GetLocalURL() == $wgUser->GetTalkPage()->GetLocalURL() &&
		$wgOut->isArticle() &&
		($action == '' || $action == 'purge')
	);
}

/**
 * Convenience function converts string values into true
 * or false (boolean) values
 *
 * @param bool $value
 * @return boolean
 */
function wfStrToBool( $value ) {
	return ( $value === 'true' ) ? true : false;
}

/**
 * wfEchoIfSet
 *
 * print/return value if variable is set. print/return empty value otherwise
 *
 * @access public
 * @author eloy@wikia
 *
 * @param mixed $variable: variable to be displayed/set
 * @param boolean $return default false: display or just return
 *
 * @return void or string: depends of $return param
 */
function wfEchoIfSet($variable, $return = false)
{
    if (empty($return)){
        echo isset($variable) ? $variable : "";
    }
    else {
        return isset($variable) ? $variable : "";
    }
}

/**
 * wfStringToArray
 *
 * explode string by using $split param, then trim parts and return as
 * array, additionally checks if number of parts is not bigger than allowed
 * number.
 *
 * @access public
 * @author eloy@wikia-inc.com
 *
 * @param string $string: string to be splitted
 * @param string $delimiter default ',': delimiter for string
 * @param integer $parts default 0: how many parts are allowed in array,
 *  0 means not limitation
 *
 * @return mixed:
 *  false: when input is badly formatted
 *  array: when everything is fine
 */
function wfStringToArray( $string, $delimiter = ",", $parts = 0 )
{
    $aParts = explode( $delimiter, $string );
    $aReturn = array();

    #--- "normalize" string
    foreach( $aParts as $count => $part ) {
        $aReturn[] = trim($part);
        if( $count > $parts ) {
            break;
        }
    }

    return $aReturn;
}

/**
 * Parse one line from MediaWiki message to array with indexes 'text' and 'href'
 *
 * @return array
 * @author Inez Korczynski <inez@wikia.com>
 */
function parseItem($line) {
	wfProfileIn(__METHOD__);

	$href = $specialCanonicalName = false;

	$line_temp = explode('|', trim($line, '* '), 3);
	$line_temp[0] = trim($line_temp[0], '[]');
	if(count($line_temp) >= 2 && $line_temp[1] != '') {
		$line = trim($line_temp[1]);
		$link = trim(wfMsgForContent($line_temp[0]));
	} else {
		$line = trim($line_temp[0]);
		$link = trim($line_temp[0]);
	}

	$descText = null;

	if(count($line_temp) > 2 && $line_temp[2] != '') {
		$desc = $line_temp[2];
		if (wfEmptyMsg($desc, $descText = wfMsg($desc))) {
			$descText = $desc;
		}
	}

	if (wfEmptyMsg($line, $text = wfMsg($line))) {
		$text = $line;
	}

	if($link != null) {
		if (wfEmptyMsg($line_temp[0], $link)) {
			$link = $line_temp[0];
		}
		if (preg_match( '/^(?:' . wfUrlProtocols() . ')/', $link )) {
			$href = $link;
		} else {
			$title = Title::newFromText( $link );
			if($title) {
				if ($title->getNamespace() == NS_SPECIAL) {
					$dbkey = $title->getDBkey();
					$specialCanonicalName = array_shift(SpecialPageFactory::resolveAlias($dbkey));
					if (!$specialCanonicalName) $specialCanonicalName = $dbkey;
				}
				$title = $title->fixSpecialName();
				$href = $title->getLocalURL();
			} else {
				$href = '#';
			}
		}
	}

	wfProfileOut(__METHOD__);
	return array(
		'text' => $text,
		'href' => $href,
		'org' => $line_temp[0],
		'desc' => $descText,
		'specialCanonicalName' => $specialCanonicalName
	);
}

/**
 * @author Inez Korczynski <inez@wikia.com>
 * @return array
 */
function getMessageForContentAsArray($messageKey) {

	$message = trim(wfMsgForContent($messageKey));
	if(!wfEmptyMsg($messageKey, $message)) {
		$lines = explode("\n", $message);
		if(count($lines) > 0) {
			return $lines;
		}
	}
	return null;
}

/**
 * @author Michał Roszka (Mix) <michal@wikia-inc.com>
 * @return array
 */
function getMessageAsArray( $messageKey ) {
	$message = trim( wfMsg( $messageKey ) );
	if( !wfEmptyMsg( $messageKey, $message ) ) {
		$lines = explode( "\n", $message );
		if( count( $lines ) > 0 ) {
			return $lines;
		}
	}
}

/**
 * @author emil@wikia.com
 * @return default external cluster
 */
function wfGetDefaultExternalCluster() {
	global $wgDefaultExternalStore;
	if( $wgDefaultExternalStore ) {
		if( is_array( $wgDefaultExternalStore ) ) {
			$store = $wgDefaultExternalStore[0];
		} else {
			$store = $wgDefaultExternalStore;
		}
		list( $proto, $cluster ) = explode( '://', $store, 2 );
		return $cluster;
	} else {
		throw new MWException( __METHOD__.'$wgDefaultExternalStore should be defined' );
	}
}

/**
 * @author MoLi <moli@wikia.com>
 * @return db's handle for external storage
 */
function wfGetDBExt($db = DB_MASTER, $cluster = null) {
	if( !$cluster ) {
		$cluster = wfGetDefaultExternalCluster();
	}
	return wfGetLBFactory()->getExternalLB( $cluster )->getConnection( $db );
}

/**
 * Sleep until the worst slave's replication lag is less than or equal to
 * $maxLag, in seconds.  Use this when updating very large numbers of rows, as
 * in maintenance scripts, to avoid causing too much lag.  Of course, this is
 * a no-op if there are no slaves.
 *
 * Every time the function has to wait for a slave, it will print a message to
 * that effect (and then sleep for a little while), so it's probably not best
 * to use this outside maintenance scripts in its present form.
 *
 * This function is copy of wfWaitForSlaves to work with external storage
 *
 * @author Maciej Błaszkowski (Marooned) <marooned at wikia.com> (changes from original)
 * @param int $maxLag
 * @return null
 */
function wfWaitForSlavesExt( $maxLag, $cluster = null ) {
	if( $maxLag ) {
		if( !$cluster ) {
			$cluster = wfGetDefaultExternalCluster();
		}
		$lb = wfGetLBFactory()->getExternalLB( $cluster );
		list( $host, $lag ) = $lb->getMaxLag();
		while( $lag > $maxLag ) {
			$name = @gethostbyaddr( $host );
			if( $name !== false ) {
				$host = $name;
			}
			print "Waiting for $host (lagged $lag seconds)...\n";
			sleep($maxLag);
			list( $host, $lag ) = $lb->getMaxLag();
		}
	}
}

/**
 * wfGetCurrentUrl
 *
 * Get full url for request, used when $wgTitle is not available yet
 * based on code from marco panichi
 *
 * @author Krzysztof Krzyżaniak <eloy@wikia-inc.com>
 * @access public
 *
 * @param boolean $s_string default false -- return url as string not array
 *
 * @return array	parts of current url
 */
function wfGetCurrentUrl( $as_string = false ) {
	$uri = $_SERVER['REQUEST_URI'];

	/**
	 * sometimes $uri contain whole url, not only last part
	 */
	if( !preg_match( '!^https?://!', $uri ) ) {
		$uri = isset( $_SERVER[ "SERVER_NAME" ] )
			? "http://" . $_SERVER[ "SERVER_NAME" ] . $uri
			: "http://localhost" . $uri;
	}
	$arr = parse_url( $uri );

	/**
	 * host
	 */
	$arr[ "host" ] = $_SERVER['SERVER_NAME'];

	/**
	 * scheme
	 */
	$server_prt = explode( '/', $_SERVER['SERVER_PROTOCOL'] );
	$arr[ "scheme" ] = strtolower( $server_prt[0] );

	/**
	 * full url
	 */
	$arr[ "url" ] = $arr[ "scheme" ] . '://' . $arr[ "host" ] . $arr[ "path" ];
	$arr[ "url" ] = isset( $arr[ "query" ] ) ? $arr[ "url" ] . "?" . $arr[ "query" ] : $arr[ "url" ];

	return ( $as_string ) ? $arr[ "url" ]: $arr ;
}

/**
 * @TODO: remove?
 */
global $wgAjaxExportList;
$wgAjaxExportList[] = 'getMenu';
function getMenu() {
	global $wgRequest, $wgMemc, $wgScript;
	$content = '';

	$id = $wgRequest->getVal('id');
	if($id) {
		$menuArray = $wgMemc->get($id);
		if(!empty($menuArray['magicWords'])) {
			$JSurl = Xml::encodeJsVar($wgScript . '?action=ajax&rs=getMenu&v=' . $wgRequest->getVal('v') .
				'&words=' . urlencode(implode(',', $menuArray['magicWords'])));

			$content .= "wsl.loadScriptAjax({$JSurl}, function() {\n";
			unset($menuArray['magicWords']);

			$usingCallback = true;
		}

		// fallback (RT #20893)
		if ($menuArray === null) {
			$menuArray = array('mainMenu' => array());
		}

		$content .= 'window.menuArray = '.json_encode($menuArray).';$("#navigation_widget").mouseover(menuInit);$(function() { menuInit(); });';
		$duration = 60 * 60 * 24 * 7; // one week

		// close JS code
		if(!empty($usingCallback)) {
			$content .= "\n});";
		}
	}

	$words = urldecode($wgRequest->getVal('words'));
	if($words) {
		$magicWords = array();
		$map = array('voted' => array('highest_ratings', 'GetTopVotedArticles'), 'popular' => array('most_popular', 'GetMostPopularArticles'), 'visited' => array('most_visited', 'GetMostVisitedArticles'), 'newlychanged' => array('newly_changed', 'GetNewlyChangedArticles'), 'topusers' => array('community', 'GetTopFiveUsers'));
		$words = explode(',', $words);
		foreach($words as $word) {
			if(isset($map[$word])) {
				$magicWords[$word] = DataProvider::$map[$word][1]();
				$magicWords[$word][] = array('className' => 'Monaco-sidebar_more', 'url' => Title::makeTitle(NS_SPECIAL, 'Top/'.$map[$word][0])->getLocalURL(), 'text' => '-more-');
				if($word == 'popular') {
					$magicWords[$word][] = array('className' => 'Monaco-sidebar_edit', 'url' => Title::makeTitle(NS_MEDIAWIKI, 'Most popular articles')->getLocalUrl(), 'text' => '-edit-');
				}
			} else if(substr($word, 0, 8) == 'category') {
				$name = substr($word, 8);
				$articles = getMenuHelper($name);
				foreach($articles as $key => $val) {
					$title = Title::newFromId($val);
					if(is_object($title)) {
						$magicWords[$word][] = array('text' => $title->getText(), 'url' => $title->getLocalUrl());
					}
				}
				$magicWords[$word][] = array('className' => 'Monaco-sidebar_more', 'url' => Title::makeTitle(NS_CATEGORY, $name)->getLocalURL(), 'text' => '-more-');
			}
		}
		$content .= 'window.magicWords = '.json_encode($magicWords).';';
		$duration = 60 * 60 * 12; // two days
	}

	if(!empty($content)) {
		header("Content-Type: text/javascript");
//		header("Content-Length: " . strlen($content) );
		header("Cache-Control: s-maxage={$duration}, must-revalidate, max-age=0");
		header("X-Pass-Cache-Control: max-age={$duration}");
		echo $content;
		exit();
	}
}

function getMenuHelper($name, $limit = 7) {
	global $wgMemc;
	wfProfileIn(__METHOD__);

	$key = wfMemcKey('popular-art');
	$data = $wgMemc->get($key);

	if(!empty($data) && isset($data[$name])) {
		wfProfileOut(__METHOD__);
		return $data[$name];
	}

	$name = str_replace(" ", "_", $name);

	$dbr =& wfGetDB( DB_SLAVE );
	$query = "SELECT cl_from FROM categorylinks USE INDEX (cl_from), page_visited USE INDEX (page_visited_cnt_inx) WHERE article_id = cl_from AND cl_to = '".addslashes($name)."' ORDER BY COUNT DESC LIMIT $limit";
	$res = $dbr->query($query);
	$result = array();
	while($row = $dbr->fetchObject($res)) {
		$result[] = $row->cl_from;
	}
	if(count($result) < $limit) {
		$query = "SELECT cl_from FROM categorylinks WHERE cl_to = '".addslashes($name)."' ".(count($result) > 0 ? " AND cl_from NOT IN (".implode(',', $result).") " : "")." LIMIT ".($limit - count($result));
		$res = $dbr->query($query);
		while($row = $dbr->fetchObject($res)) {
			$result[] = $row->cl_from;
		}
	}
	if(empty($data) || !is_array($data)) {
		$data = array($data);
	}
	$data[$name] = $result;
	$wgMemc->set($key, $data, 60 * 60 * 6);

	wfProfileOut(__METHOD__);
	return $result;
}


/**
 * @author Inez Korczynski <inez@wikia.com>
 */
function isMsgEmpty($key) {
	return wfEmptyMsg($key, trim(wfMsg($key)));
}

/**
 * Get a list of language names available for wiki request
 * (possibly filter some)
 *
 * @author nef@wikia-inc.com
 * @return array
 *
 * @see Language::getLanguageNames()
 * @see RT#11870
 */
function wfGetFixedLanguageNames() {
	$languages = Language::getLanguageNames();

	$filter_languages = explode(',', wfMsgForContent('requestwiki-filter-language'));
	foreach ($filter_languages as $key) {
		unset($languages[$key]);
	}
	return $languages;
}

/**
 * @brief: Get a shared cache key
 * @details: this function is used for creating keys for information that
 * 	should be shared among wikis. Function uses func_get_arrays
 *
 * @author Krzysztof Krzyżaniak (eloy) <eloy@wikia-inc.com>
 *
 * @param Array, parts for creating keys, func_get_args() is used internally
 *
 * @return string  created key for cache
 */
function wfSharedMemcKey( /*... */ ) {
	global $wgSharedKeyPrefix;

	$args = func_get_args();
	if( $wgSharedKeyPrefix === false ) { // non shared wiki, fallback to normal function
		$key = 	wfWikiID() . ':' . implode( ':', $args );
	}
	else {
		$key = $wgSharedKeyPrefix . ':' . implode( ':', $args );
	}
	return $key;
}

/**
 * Get provided message in plain and HTML versions using language as priority
 *
 * @author Inez, Marooned
 * @return array containing 4 items:
 *         - the plaintext message
 *         - the rich-text message
 *         - an int which is non-zero if the plaintext message fell back to the fallback language? (not sure this is the intention)
 *         - an int which is non-zero if the rich-text message fell back to the fallback language? (not sure this is the intention)
 */
function wfMsgHTMLwithLanguage($key, $lang, $options = array(), $params = array(), $wantHTML = true) {
	global $wgContLanguageCode;
	wfProfileIn(__METHOD__);

	//remove 'content' option and pick proper language
	if (isset($options['content'])) {
		$lang = $wgContLanguageCode;
		unset($options['content']);
	}
	$options = array_merge($options, array('parsemag', 'language' => $lang));

	//TODO: check if this ok or do we need to use $msgPlainRaw plus parsing
	$msgPlain = wfMsgExt($key, $options, $params);
	$msgPlainFallbacked = $msgRichFallbacked = 0;
	if ($lang == $wgContLanguageCode) {
		$fullKey = false;
		$langKey = $key;
	} else {
		$fullKey = true;
		$langKey = "$key/$lang";
	}

	$msgPlainRaw = MessageCache::singleton()->get($langKey, true, $lang, $fullKey);
	$msgPlainRawEmpty = wfEmptyMsg($langKey, $msgPlainRaw);

	$found = false;

	foreach ( Language::getFallbacksFor( $lang ) as $fallbackLang ) {
		if ($fallbackLang == $wgContLanguageCode) {
			$fullKey = false;
			$langKey2 = $key;
		} else {
			$fullKey = true;
			$langKey2 = "$key/$fallbackLang";
		}
		$msgPlainRawLang = MessageCache::singleton()->get($langKey2, true, $fallbackLang, $fullKey);
		$msgPlainRawLangEmpty = wfEmptyMsg($langKey2, $msgPlainRawLang);
		//if main message is empty and fallbacked is not, get fallbacked one
		if (wfEmptyMsg($langKey, $msgPlainRaw) && !$msgPlainRawLangEmpty) {
			//TODO: check if this ok or do we need to use $msgPlainRaw plus parsing
			$msgPlain = wfMsgExt($key, array_merge($options, array('language' => $fallbackLang)), $params);
			$msgPlainFallbacked++;
		}
		if ($msgPlainRaw != $msgPlainRawLang && !$msgPlainRawEmpty && !$msgPlainRawLangEmpty) {
			$found = true;
			break;
		}
	}

	// notify wfMsgHTMLwithLanguageAndAlternative() that we didn't get a match
	if ( !$found ) $msgPlainFallbacked++;

	if ($wantHTML) {
		$keyHTML = $key . '-HTML';
		//TODO: check if this ok or do we need to use $msgRichRaw plus parsing
		$msgRich = wfMsgExt($keyHTML, $options, $params);

		if ($lang == $wgContLanguageCode) {
			$fullKey = false;
			$langKeyHTML = $keyHTML;
		} else {
			$fullKey = true;
			$langKeyHTML = "$keyHTML/$lang";
		}

		$msgRichRaw = MessageCache::singleton()->get($langKeyHTML, true, $lang, $fullKey);
		$msgRichRawEmpty = wfEmptyMsg($langKeyHTML, $msgRichRaw);

		$found = false;

		foreach ( Language::getFallbacksFor( $lang ) as $fallbackLang ) {
			if ($fallbackLang == $wgContLanguageCode) {
				$fullKey = false;
				$langKeyHTML2 = $key;
			} else {
				$fullKey = true;
				$langKeyHTML2 = "$keyHTML/$fallbackLang";
			}
			$msgRichRawLang = MessageCache::singleton()->get($langKeyHTML2, true, $fallbackLang, true);
			$msgRichRawLangEmpty = wfEmptyMsg($langKeyHTML2, $msgRichRawLang);
			if (wfEmptyMsg($langKeyHTML, $msgRich) && !$msgRichRawLangEmpty) {
				//TODO: check if this ok or do we need to use $msgRichRaw plus parsing
				$msgRich = wfMsgExt($keyHTML, array_merge($options, array('language' => $fallbackLang)), $params);
				$msgRichFallbacked++;
			}
			if ($msgRichRaw != $msgRichRawLang && !$msgRichRawEmpty && !wfEmptyMsg($keyHTML, $msgRichRawLang)) {
				$found = true;
				break;
			}
		}

		// notify wfMsgHTMLwithLanguageAndAlternative() that we didn't get a match
		if ( !$found ) $msgRichFallbacked++;

		if($msgRichFallbacked > $msgPlainFallbacked || wfEmptyMsg($keyHTML, $msgRich)) {
			$msgRich = null;
		}
	} else {
		$msgRich = null;
	}

	wfProfileOut(__METHOD__);
	return array($msgPlain, $msgRich, $msgPlainFallbacked, $msgRichFallbacked);
}

/**
 * Get more accurate message in plain and HTML versions using language as priority
 *
 * @author Marooned
 * @return array
 */
function wfMsgHTMLwithLanguageAndAlternative($key, $keyAlternative, $lang, $options = array(), $params = array(), $wantHTML = true) {
	// inserted here for external i18n add-on, adjust params if needed
	wfRunHooks( 'MsgHTMLwithLanguageAndAlternativeBefore' );

	list ($msgPlainMain, $msgRichMain, $msgPlainMainFallback, $msgRichMainFallback) = wfMsgHTMLwithLanguage($key, $lang, $options, $params, $wantHTML);
	list ($msgPlainAlter, $msgRichAlter, $msgPlainAlterFallback, $msgRichAlterFallback) = wfMsgHTMLwithLanguage($keyAlternative, $lang, $options, $params, $wantHTML);

	$msgPlain = $msgPlainMainFallback > $msgPlainAlterFallback || wfEmptyMsg($key, $msgPlainMain) ? $msgPlainAlter : $msgPlainMain;
	$msgRich = $msgRichMainFallback > $msgRichAlterFallback || wfEmptyMsg($key . '-HTML', $msgRichMain) ? $msgRichAlter : $msgRichMain;
	return array($msgPlain, $msgRich);
}

/**
 * Build returnto parameter with new returntoquery from MW 1.16
 *
 * @param string $customReturnto
 * @param string $extraReturntoquery a string which will be urlencoded and appended to the returntoquery. eg: "action=edit".
 *
 * @author Marooned
 * @return string
 */
function wfGetReturntoParam($customReturnto = null, $extraReturntoquery=null) {
	global $wgTitle, $wgRequest;

	if ($customReturnto) {
		$returnto = "returnto=$customReturnto";
	} else if ($wgTitle instanceof Title) {
		$thisurl = $wgTitle->getPrefixedURL();
		$returnto = "returnto=$thisurl";
	} else {
		$returnto = "";
	}

	if (!$wgRequest->wasPosted()) {
		$query = $wgRequest->getValues();
		unset($query['title']);
		unset($query['returnto']);
		unset($query['returntoquery']);
		$thisquery = wfUrlencode(wfArrayToCGI($query));
		if($extraReturntoquery){
			$thisquery .= ($thisquery == "" ? "" : "&amp;") . urlencode( $extraReturntoquery );
		}
		if($thisquery != ''){
			$returnto .= "&returntoquery=$thisquery";
		}
	}
	return $returnto;
}

/**
 * Fixed urlencode url
 * @author moli
 * @return string
 */
function wfUrlencodeExt($s_url) {
	if ( !empty($s_url) ) {
		if ( strpos( $s_url, '/index.php' ) === false ) {
			$Url = @parse_url($s_url);
			$s_url = str_replace(
				$Url['path'], #search
				implode("/", array_map("rawurlencode", explode("/", @$Url['path']))), #replace
				$s_url #what
			);
		}
	}
	return $s_url;
}

/**
 * Given a timestamp, converts it to the "x minutes/hours/days ago" format.
 *
 * @author Maciej Brencz <macbre@wikia-inc.com>, Sean Colombo
 */
function wfTimeFormatAgo($stamp){
	wfProfileIn(__METHOD__);
	global $wgLang;

	$currenttime = time();
	$stamptime = strtotime($stamp);
	$ago = $currenttime - $stamptime + 1;
	$sameyear = date('Y',$currenttime) == date('Y',$stamptime);

	$res = '';

	if ($ago > 365 * 86400 || !$sameyear) {
		// Over 365 days
		// or different year than current:
		// format is date, with a year (July 26, 2008)
		$res = $wgLang->date(wfTimestamp(TS_MW, $stamp));
	} elseif ($ago < 60) {
		// Under 1 min: to the second (ex: 30 seconds ago)
		$res = wfMsgExt('wikia-seconds-ago', array('parsemag'), $ago);
	}
	else if ($ago < 3600) {
		// Under 1 hr: to the minute (3 minutes ago)
		$res = wfMsgExt('wikia-minutes-ago', array('parsemag'), floor($ago / 60));
	}
	else if ($ago < 86400) {
		// Under 24 hrs: to the hour (4 hours ago)
		$res = wfMsgExt('wikia-hours-ago', array('parsemag'), floor($ago / 3600));
	}
	else if ($ago < 30 * 86400) {
		// Under 30 days: to the day (5 days ago)
		$res = wfMsgExt('wikia-days-ago', array('parsemag'), floor($ago / 86400));
	}
	else if ($ago < 365 * 86400) {
		// Under 365 days: date, with no year (July 26)
		//remove year from user's date format
		$format = trim($wgLang->getDateFormatString('date', 'default'), ' ,yY');
		$res = $wgLang->sprintfDate($format, wfTimestamp(TS_MW, $stamp));
	}

	wfProfileOut(__METHOD__);
	return $res;
} // end wfTimeFormatAgo()

/**
 * Returns the text from wfTimeFormatAgo only if the text is recent.
 * This can be used in places that we don't want to show glaringly stale timestamps.
 *
 * @author Maciej Brencz <macbre@wikia-inc.com>, Sean Colombo
  */
function wfTimeFormatAgoOnlyRecent($stamp){
	wfProfileIn(__METHOD__);

	$ago = time() - strtotime($stamp) + 1;

	if ($ago < 7 * 86400 ) {
		$res = wfTimeFormatAgo($stamp);
	}
	else {
		$res = '';
	}

	wfProfileOut(__METHOD__);
	return $res;
} // end wfTimeFormatAgoOnlyRecent()


/**
 * This is an ugly hack. DO NOT use unless absolutely necessary
 */
function wfMsgWithFallback( $key ) {
	$msg = wfMsgForContent( $key );

	if ( wfEmptyMsg( $key, $msg ) ) {
		$msg = wfMsgExt( $key, array( 'language' => 'en' ) );
	}

	return $msg;
}

/**
 * @deprecated
 *
 * TODO: remove this
 *
 * @param $name module name
 * @param string $action method name
 * @param null $params
 * @return string rendered module's response
 */
function wfRenderModule($name, $action = 'Index', $params = null) {
	return F::app()->renderView( $name, $action, $params);
}

/**
 * Given the email id (from 'mail' table in 'wikia_mailer' db), and the email address
 * of the recipient, generate a token that will be given to SendGrid to send back to
 * us with any bounce/spam/open/etc. reports.
 */
function wfGetEmailPostbackToken($emailId, $emailAddr){
	global $wgEmailPostbackTokenKey;
	return sha1("$emailId|$emailAddr|$wgEmailPostbackTokenKey");
} // end wfGetEmailPostbackToken()

/**
 * wfAutomaticReadOnly
 *
 * @author tor
 *
 * @return boolean
 */
function wfAutomaticReadOnly() {
	global $wgReadOnly;

	/**
	 * @see includes/db/LoadBalancer.php getReaderIndex
	 */
	$automaticLagMessage = 'The database has been automatically locked ' .
		'while the slave database servers catch up to the master';


	return (bool) $automaticLagMessage == $wgReadOnly;
}

/**
 * Convenience-function to make it easier to get the wgBlankImgUrl from inside
 * of template-code (ie: no ugly global $wgBlankImgUrl;print $wgBlankImgUrl;).
 */
function wfBlankImgUrl(){
	global $wgBlankImgUrl;
	return $wgBlankImgUrl;
} // end wfBlankImgUrl()

/**
 * Load a namespace internationalization file for the specified extension,
 * the full file path has to be defined in $wgExtensionNamespacesFiles[ $extensionName ]
 *
 * @author Federico "Lox" Lucignano <federico@wikia-inc.com>
 *
 * @param string $extensionName Name of extension to load namespace internationalization from\for
 * @param array $nsList List of namespaces definition constants to process
 */
function wfLoadExtensionNamespaces( $extensionName, $nsList ) {
	wfProfileIn(__METHOD__);

	global $wgExtensionNamespacesFiles, $wgLanguageCode, $wgNamespaceAliases, $wgExtraNamespaces;

	if(
		!empty( $extensionName ) &&
		is_string( $extensionName ) &&
		!empty( $wgExtensionNamespacesFiles[ $extensionName ] ) &&
		!empty( $nsList ) &&
		is_array( $nsList )
	) {
		//load the i18n file for the extension's namespaces
		$namespaces = false;
		require_once( $wgExtensionNamespacesFiles[ $extensionName ] );

		//english is the required default, skip processing if not defined
		if( !empty( $namespaces[ 'en' ] ) && is_array( $namespaces[ 'en' ] ) ) {
			foreach ( $nsList as $ns ) {
				if( !empty( $namespaces[ 'en' ][ $ns ] ) ) {
					$langCode = ( !empty( $namespaces[ $wgLanguageCode ][ $ns ] ) ) ? $wgLanguageCode : 'en';

					//define the namespace name for the current language
					$wgExtraNamespaces[ $ns ] = $namespaces[ $langCode ][ $ns ];

					if( $langCode != 'en' ) {
						//make en ns alias point to localized ones for current language
						$wgNamespaceAliases[ $namespaces[ 'en' ][ $ns ] ] = $ns;
					}
				}
			}
		}
	}

	wfProfileOut(__METHOD__);
}

/**
 * wfGenerateUnsubToken
 * @author uberfuzzy
 * @return string
 */
function wfGenerateUnsubToken( $email, $timestamp ) {
	global $wgUnsubscribeSalt;
	$token = sha1($timestamp . $email . $wgUnsubscribeSalt);
	return $token;
}

/**
 * Get the cache object used by the solid cache, it should be "more solid" cache
 * than memcache (for example riak)
 *
 * @param mixed $bucket -- if solid storage is riak define bucket there
 */
function &wfGetSolidCacheStorage( $bucket = false ) {
	global $wgSolidCacheType;
	$cache = wfGetCache( $wgSolidCacheType );
	if( $bucket && method_exists( $cache, "setBucket" ) ) {
		$cache->setBucket( $bucket );
	}
	return $cache;
}


/**
 * Set value of wikia article prop list of type is define in
 */
function wfSetWikiaPageProp($type, $pageID, $value, $dbname = '') {
	if(empty($dbname)) {
		$db = wfGetDB(DB_MASTER, array());
	} else {
		$db = wfGetDB(DB_MASTER, array(), $dbname);
	}

	$db->replace('page_wikia_props','',
		array(
			'page_id' =>  $pageID,
			'propname' => $type,
			'props' => serialize($value)
		),
		__METHOD__
	);
}


/**
 * Get value of wikia article prop list of type is define in
 */
function wfGetWikiaPageProp($type, $pageID, $db = DB_SLAVE, $dbname = '') {
	if(empty($dbname)) {
		$db = wfGetDB($db, array());
	} else {
		$db = wfGetDB($db, array(), $dbname);
	}

	$res = $db->select('page_wikia_props',
		array('props'),
		array(
			'page_id' =>  $pageID,
			'propname' => $type,
		),
		__METHOD__
	);

	if($out = $db->fetchRow($res)) {
		return wfUnserializeProp($out['props']);
	}

	return null;
}

/**
 * this function can be use when we are doing joins with props table
 * and we want to unserialize multiple rows of result
 */


function wfUnserializeProp($data) {
	return unserialize($data);
}


/**
 * Delete value of wikia article prop
 */
function wfDeleteWikiaPageProp($type, $pageID, $dbname = '') {
	if(empty($dbname)) {
		$db = wfGetDB(DB_MASTER, array());
	} else {
		$db = wfGetDB(DB_MASTER, array(), $dbname);
	}

	$db->delete('page_wikia_props',
		array(
			'page_id' =>  $pageID,
			'propname' => $type,
		),
		__METHOD__
	);
}

if (!function_exists('http_build_url')) {
	define('HTTP_URL_REPLACE', 1);				// Replace every part of the first URL when there's one of the second URL
	define('HTTP_URL_JOIN_PATH', 2);			// Join relative paths
	define('HTTP_URL_JOIN_QUERY', 4);			// Join query strings
	define('HTTP_URL_STRIP_USER', 8);			// Strip any user authentication information
	define('HTTP_URL_STRIP_PASS', 16);			// Strip any password authentication information
	define('HTTP_URL_STRIP_AUTH', 32);			// Strip any authentication information
	define('HTTP_URL_STRIP_PORT', 64);			// Strip explicit port numbers
	define('HTTP_URL_STRIP_PATH', 128);			// Strip complete path
	define('HTTP_URL_STRIP_QUERY', 256);		// Strip query string
	define('HTTP_URL_STRIP_FRAGMENT', 512);		// Strip any fragments (#identifier)
	define('HTTP_URL_STRIP_ALL', 1024);			// Strip anything but scheme and host

	// Build an URL
	// The parts of the second URL will be merged into the first according to the flags argument.
	//
	// @param	mixed			(Part(s) of) an URL in form of a string or associative array like parse_url() returns
	// @param	mixed			Same as the first argument
	// @param	int				A bitmask of binary or'ed HTTP_URL constants (Optional)HTTP_URL_REPLACE is the default
	// @param	array			If set, it will be filled with the parts of the composed url like parse_url() would return
	function http_build_url($url, $parts=array(), $flags=HTTP_URL_REPLACE, &$new_url=false) {
		$keys = array('user','pass','port','path','query','fragment');

		// HTTP_URL_STRIP_ALL becomes all the HTTP_URL_STRIP_Xs
		if ($flags & HTTP_URL_STRIP_ALL) {
				$flags |= HTTP_URL_STRIP_USER;
				$flags |= HTTP_URL_STRIP_PASS;
				$flags |= HTTP_URL_STRIP_PORT;
				$flags |= HTTP_URL_STRIP_PATH;
				$flags |= HTTP_URL_STRIP_QUERY;
				$flags |= HTTP_URL_STRIP_FRAGMENT;
		}
		// HTTP_URL_STRIP_AUTH becomes HTTP_URL_STRIP_USER and HTTP_URL_STRIP_PASS
		else if ($flags & HTTP_URL_STRIP_AUTH) {
			$flags |= HTTP_URL_STRIP_USER;
			$flags |= HTTP_URL_STRIP_PASS;
		}

		// Parse the original URL
		$parse_url = parse_url($url);

		// Scheme and Host are always replaced
		if (isset($parts['scheme']))
			$parse_url['scheme'] = $parts['scheme'];
		if (isset($parts['host']))
			$parse_url['host'] = $parts['host'];

		// (If applicable) Replace the original URL with it's new parts
		if ($flags & HTTP_URL_REPLACE) {
			foreach ($keys as $key) {
				if (isset($parts[$key]))
					$parse_url[$key] = $parts[$key];
			}
		}
		else {
			// Join the original URL path with the new path
			if ( isset($parts['path']) && ($flags & HTTP_URL_JOIN_PATH) ) {
				if (isset($parse_url['path']))
					$parse_url['path'] = rtrim(str_replace(basename($parse_url['path']), '', $parse_url['path']), '/') . '/' . ltrim($parts['path'], '/');
				else
					$parse_url['path'] = $parts['path'];
			}

			// Join the original query string with the new query string
			if (isset($parts['query']) && ($flags & HTTP_URL_JOIN_QUERY)) {
				if (isset($parse_url['query']))
					$parse_url['query'] .= '&' . $parts['query'];
				else
					$parse_url['query'] = $parts['query'];
			}
		}

		// Strips all the applicable sections of the URL
		// Note: Scheme and Host are never stripped
		foreach ($keys as $key) {
			if ($flags & (int)constant('HTTP_URL_STRIP_' . strtoupper($key)))
				unset($parse_url[$key]);
		}


		$new_url = $parse_url;

		return
			 ((isset($parse_url['scheme'])) ? $parse_url['scheme'] . '://' : '')
			.((isset($parse_url['user'])) ? $parse_url['user'] . ((isset($parse_url['pass'])) ? ':' . $parse_url['pass'] : '') .'@' : '')
			.((isset($parse_url['host'])) ? $parse_url['host'] : '')
			.((isset($parse_url['port'])) ? ':' . $parse_url['port'] : '')
			.((isset($parse_url['path'])) ? $parse_url['path'] : '')
			.((isset($parse_url['query'])) ? '?' . $parse_url['query'] : '')
			.((isset($parse_url['fragment'])) ? '#' . $parse_url['fragment'] : '')
			;
	}
}

/**
 * Sleep until wgDBLightMode is enable. This variable is used to disable (sleep) all
 * maintanance scripts while something is wrong with performance
 *
 * @author Piotr Molski (moli) <moli at wikia-inc.com>
 * @param int $maxSleep
 * @return null
 */
function wfDBLightMode( $maxSleep ) {
	global $wgExternalSharedDB;

	if ( !$maxSleep ) return false;

	while ( WikiFactory::getVarValueByName( 'wgDBLightMode', WikiFactory::DBToId( $wgExternalSharedDB ) ) ) {
		Wikia::log( __METHOD__, "info", "All crons works in DBLightMode ( sleep $maxSleep ) ..." );
		sleep($maxSleep);
	}

	return true;
}

function wfIsDBLightMode() {
	global $wgExternalSharedDB;

	$dbLightMode = WikiFactory::getVarValueByName( 'wgDBLightMode', WikiFactory::DBToId( $wgExternalSharedDB ) );
	return (bool) $dbLightMode;
}

/**
 * return status code if the last failure was due to the database being read-only.
 *
 * @author Piotr Molski (moli) <moli at wikia-inc.com>
 */
function wfDBReadOnlyFailed( ) {
	global $wgOut, $wgDBReadOnlyStatusCode;
	$wgOut->setPageTitle( 'DB Error' );
	$wgOut->setRobotPolicy( "noindex,nofollow" );
	$wgOut->setStatusCode( $wgDBReadOnlyStatusCode );
	$wgOut->clearHTML();
	exit;
}

function startsWith($haystack, $needle, $case = true) {
	if($case){
		return (strcmp(substr($haystack, 0, strlen($needle)),$needle)===0);
	}
	return (strcasecmp(substr($haystack, 0, strlen($needle)),$needle)===0);
}

function endsWith($haystack, $needle, $case = true) {
	if($case){
		return (strcmp(substr($haystack, strlen($haystack) - strlen($needle)),$needle)===0);
	}
	return (strcasecmp(substr($haystack, strlen($haystack) - strlen($needle)),$needle)===0);
}

function json_encode_jsfunc($input=array(), $funcs=array(), $level=0)
 {
  foreach($input as $key=>$value)
         {
          if (is_array($value))
             {
              $ret = json_encode_jsfunc($value, $funcs, 1);
              $input[$key]=$ret[0];
              $funcs=$ret[1];
             }
          else
             {
              if (substr($value,0,10)=='function()')
                 {
                  $func_key="#".uniqid()."#";
                  $funcs[$func_key]=$value;
                  $input[$key]=$func_key;
                 }
             }
         }
  if ($level==1)
     {
      return array($input, $funcs);
     }
  else
     {
      $input_json = json_encode($input);
      foreach($funcs as $key=>$value)
             {
              $input_json = str_replace('"'.$key.'"', $value, $input_json);
             }
      return $input_json;
     }
 }

/**
 * generate correct version of session key
 *
 * @author Piotr Molski (moli) <moli at wikia-inc.com>
 *
 * @return String $key
 */
function wfGetSessionKey( $id ) {
	global $wgSharedDB, $wgDBname, $wgExternalUserEnabled, $wgExternalSharedDB;

	if ( !empty( $wgExternalUserEnabled ) ) {
		$key = "{$wgExternalSharedDB}:session:{$id}";
	} elseif ( !empty( $wgSharedDB ) ) {
		$key = "{$wgSharedDB}:session:{$id}";
	} else {
		$key = "{$wgDBname}:session:{$id}";
	}

	return $key;
}

/**
 * @brief Handles pagination for arrays
 *
 * @author Federico "Lox" Lucignano
 *
 * @param Array $data the array to paginate
 * @param integer $limit the maximum number of items per page
 * @param integer $batch [OPTIONAL] the batch to retrieve
 *
 * @return array an hash with the following keys:
 * * items array the items for the requested batch
 * * next integer the number of items in the next batch
 * * batches integer the total number of batches
 * * currentBatch integer the current batch (first is 1)
 * */
function wfPaginateArray( $data, $limit, $batch = 1 ){
	wfProfileIn( __METHOD__ );

	$data = (array) $data;
	$limit = (int) $limit;
	$batch = (int) $batch;
	$total = count( $data );
	$ret = Array();
	$next = 0;
	$batches = 1;

	if ( $batch < 1 ) {
		$batch = 1;
	}

	if ( $limit < 1 ) {
		$limit = null;
	}

	if ( !empty( $limit ) && $total ) {
		$batches = ceil($total / $limit);

		if ( $batch > $batches ) {
			$batch = $batches;
		}

		$offset = $limit * ( $batch - 1 );

		if ( $offset >= $total ) {
			$offset = $total - 1;
		}

		$partial = $offset + $limit;
		$ret['items'] = array_slice( $data, $offset, $limit );

		if ( $partial < $total ) {
			$leftOver = $total - $partial;

			$next = ( $leftOver > $limit ) ? $limit : $leftOver;
		}
	} else {
		$batch = 1;
		$ret['items'] = $data;
	}

	$ret['next'] = $next;
	$ret['total'] = $total;
	$ret['batches'] = $batches;
	$ret['currentBatch'] = $batch;

	wfProfileOut( __METHOD__ );

	return $ret;
}

/**
 * @brief Helper function for displaying arrays as pairs key => value
 *
 * @author Krzysztof Krzyżaniak (eloy) <eloy@wikia-inc.com>
 *
 * @param Array $array typical array with key => value
 *
 * @return string string for debugging purposes
 */
function wfArrayToString( $array ) {
	$retval = "";
	if( is_array( $array ) ) {
		foreach( $array as $key => $value )
			$retval = "{$key} => {$value} ";
	}

	return trim( $retval );
}

/**
 * @brief Function for getting beacon_id from cookie
 *
 * @author Piotr Molski (moli) <moli@wikia-inc.com>
 *
 * @param none
 *
 * @return string string with beacon ID
 */
function wfGetBeaconId() {
	return ( isset( $_COOKIE['wikia_beacon_id'] ) )
	? $_COOKIE['wikia_beacon_id']
	: '';
}

/**
 * @brief Function that calculates content hash including dependencies for SASS files
 *
 * @author Piotr Bablok <piotr.bablok@gmail.com>
 */
function wfAssetManagerGetSASShash( $file ) {
	$processedFiles = array();
	$hash = '';
	wfAssetManagerGetSASShashCB( $file, $processedFiles, $hash );
	//error_log("done $file = $hash");
	return md5( $hash ); // shorten it
}

/**
 * @brief Generates the absolute file path to a Sass file
 *
 * @author Piotr Bablok <piotr.bablok@gmail.com>
 * @author Kyle Florence <kflorence@wikia-inc.com>
 */
function wfAssetManagerGetSASSFilePath( $file, $relativeToPath = false ) {
	global $IP;

	if ( empty( $file ) ) {
		return null;
	}

	$fileExists = file_exists( $file );

	if ( !$fileExists ) {
		$parts = explode( '/', $file );
		$filename = array_pop( $parts );
		$directory = implode( '/', $parts ) . '/';

		if ( !startsWith( $directory, '/' ) ) {
			$directory = '/' . $directory;
		}

		// Directories to search in.
		// These should be arranged in order of likeliness.
		$directories = array();

		if ( $relativeToPath ) {
			$directories[] = rtrim( $relativeToPath, '/' ) . $directory;
		}

		$directories[] = $IP . $directory;
		$directories[] = $directory;

		// Filenames to check.
		// These should be arranged in order of likeliness.
		$filenames = array();
		$filenames[] = $filename;
		$filenames[] = $filename . '.scss';
		$filenames[] = '_' . $filename . '.scss';
		$filenames[] = $filename . '.sass';
		$filenames[] = '_' . $filename . '.sass';

		foreach( $directories as $d ) {
			if ( file_exists( $d ) ) {
				foreach( $filenames as $f ) {
					$fullPath = $d . $f;
					$fileExists = file_exists( $fullPath );
					if ( $fileExists ) {
						$file = $fullPath;
						break 2;
					}
				}
			}
		}

		if ( !$fileExists ) {
			error_log( 'wfAssetManagerGetSASSFilePath: file not found: ' . $file );
			return null;
		}
	}

	return realpath( $file );
}

function wfAssetManagerGetSASShashCB( $file, &$processedFiles, &$hash ) {
	$file = wfAssetManagerGetSASSFilePath( $file );

	// File not found or already processed
	if ( !$file || isset( $processedFiles[ $file ] ) ) {
		return;
	}

	$processedFiles[ $file ] = true;
	$contents = file_get_contents( $file );
	$hash .= md5( $contents );

	// Look for imported files within this one so we can include those too
	preg_replace_callback( '/\\@import(\\s)*[\\"\']([^\\"\']*)[\\"\']/', function( $match ) use ( $file, &$processedFiles, &$hash ) {
		wfAssetManagerGetSASShashCB( wfAssetManagerGetSASSFilePath( $match[ 2 ], dirname( $file ) ), $processedFiles, $hash );
	}, $contents);
}

/**
 * Allow to find what staging machine we are on
 *
 * @author Tomasz Odrobny <tomek@wikia-inc.com>
 */
function getHostPrefix(){
	global $wgStagingList, $wgServer;
	static $cache;
	if(!empty($cache)) {
		return $cache;
	}
	$hosts = $wgStagingList;
	foreach($hosts as $host) {
		$prefix = 'http://'.$host.'.';
		if(strpos($wgServer, $prefix)  !== false ) {
			$cache = $host;
			return  $host;
		}
	}
	return null;
}

/**
 * Defines error handler to log backtrace for PHP (catchable) fatal errors
 *
 * @author Maciej Brencz <macbre@wikia-inc.com>
 */
function wfWikiaErrorHandler($errno, $errstr, $errfile, $errline) {
	switch($errno) {
		case E_RECOVERABLE_ERROR:
			Wikia::logBacktrace("PHP fatal error caught ({$errstr})");
			break;
	}

	// error was not really handled
	return false;
}

set_error_handler('wfWikiaErrorHandler');

/**
 * get namespaces
 * @global $wgContLang
 * @return array $namespaces
 */
function wfGetNamespaces() {
	global $wgContLang;

	$namespaces = $wgContLang->getFormattedNamespaces();
	wfRunHooks( 'XmlNamespaceSelectorAfterGetFormattedNamespaces', array(&$namespaces) );

	return $namespaces;
}

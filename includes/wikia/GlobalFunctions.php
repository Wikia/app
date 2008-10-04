<?php

if ( !defined( 'MEDIAWIKI' ) ) {
	die( "This file is part of MediaWiki, it is not a valid entry point" );
}

/**
 * Global functions used everywhere for Wikia purposes.
 */

require( "$IP/extensions/wikia/AdServer.php" );
require_once( "$IP/extensions/wikia/AdEngine/AdEngine.php" );
require_once( "$IP/extensions/wikia/MergeFiles/MergeFiles.php" );

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
		return;
	}
	$retval = "<pre>".print_r( $param, 1 )."</pre>";
	if  (empty( $return )) {
		echo $retval;
	}
	else {
		return $retval;
	}
}

function wfReplaceImageServer($url) {
	global $wgImagesServers;

	if(isset($wgImagesServers) && is_int($wgImagesServers)) {
		if(strlen($url) > 7 && substr($url,0,7) == 'http://') {
			$hash = sha1($url);
			$inthash = ord ($hash);

			$serverNo = $inthash%($wgImagesServers-1);
			$serverNo++;

			return str_replace('http://images.wikia.com/',sprintf('http://images%s.wikia.nocookie.net/',$serverNo),$url);
		}
	}
	return $url;
}

/**
 * create table name for shared database
 *
 * @access public
 * @author eloy@wikia
 *
 * @param $table string: table name
 *
 * @return string: table name with additional shared database
 */

function wfSharedTable( $table, $useExternal = true )
{
    global $wgSharedDB, $wgExternalSharedDB;

	if ($useExternal && !empty( $wgExternalSharedDB )) {
		return "`$wgExternalSharedDB`.`$table`";
	} elseif (!empty( $wgSharedDB )) {
		return "`$wgSharedDB`.`$table`";
	} else
		return "`$table`";

}

/*
 * 	@author Krzysztof Zmudziński <kaz3t@wikia.com>
 *	Returns array of review reason id
 */
function wfGetReviewReason($max = 5) {
	global $wgMessageCache, $wgMemc, $wgDBname;

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
 */
function shortenText( $text, $chars=25 ) {
	if( strlen( $text ) <= $chars )
		return $text;

	$text = $text . " ";
	$text = substr( $text, 0, $chars );
	// gerard@wikia.com - fix for long strings without spaces and slashes
	if( strrpos( $text, ' ') || strrpos( $text, '/' ) )
	{
	    $text = substr( $text, 0, max( strrpos( $text, ' '), strrpos( $text, '/' ) ) );
	}
	//
	$text = $text . "...";

	return $text;
}

function wfGetBreadCrumb( $cityId = 0 ) {
	global $wgMemc, $wgSitename, $wgServer, $wgCats;

	$method = __METHOD__;

	if( !empty( $wgCats ) ) {
		return $wgCats;
	}

	wfProfileIn( $method );
	$memckey = 'cat_structure';
	if ($cityId) $memckey[] = $cityId;
	$wgCats = $wgMemc->get( wfMemcKey( $memckey ) );
	if( empty( $wgCats ) ) {
		global $wgCityId, $wgSharedDB;
		if( $cityId == 0 ) {
			if( $wgCityId == 0 ) {
				wfProfileOut( $method );
				return array();
			} else {
				$cityId = $wgCityId;
			}
		}

		wfProfileIn( $method . "-fromdb" );
		$dbr = wfGetDB( DB_SLAVE );
		$catId = $dbr->selectField(
				wfSharedTable("city_cat_mapping"),
				"cat_id",
				array( "city_id" => $cityId ) );
		$wgCats = array();
		while( !empty( $catId ) ) {
			$res = $dbr->select(
				array( wfSharedTable("city_cat_structure"), wfSharedTable("city_cats") ),
				array( "cat_name", "cat_url", "cat_parent_id" ),
				array( wfSharedTable("city_cat_structure").".cat_id=".wfSharedTable("city_cats").".cat_id", wfSharedTable("city_cat_structure").".cat_id=$catId" ) );
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
 * @access global
 * @author eloy@wikia
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

	$href = false;

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
				$title = $title->fixSpecialName();
				$href = $title->getLocalURL();
			} else {
				$href = 'INVALID-TITLE';
			}
		}
	}

	return array('text' => $text, 'href' => $href, 'org' => $line_temp[0], 'desc' => $descText);
}

/**
 * @author Inez Korczynski <inez@wikia.com>
 * @return array
 */
function getMessageAsArray($messageKey) {
	$message = trim(wfMsg($messageKey));
	if(!wfEmptyMsg($messageKey, $message)) {
		$lines = explode("\n", $message);
		if(count($lines) > 0) {
			return $lines;
		}
	}
	return null;
}

/**
 * @author MoLi <moli@wikia.com>
 * @return db's handle
 */
if (!function_exists('wfGetDBStats')) {
	function &wfGetDBStats()
	{
		global $wgDBuser, $wgDBpassword, $wgDBStatsServer, $wgDBStats;
		wfProfileIn( __METHOD__ );
		if ( (!isset($wgDBStatsServer)) || (!isset($wgDBStats)) ) {
			return null;
		}
		$db = new Database( $wgDBStatsServer, $wgDBuser, $wgDBpassword, $wgDBStats);
		wfProfileOut( __METHOD__ );
		return $db;
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
 * @return array	parts of current url
 */
function wfGetCurrentUrl() {
	$arr = array();
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

	return $arr;
}
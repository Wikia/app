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
require_once( "$IP/includes/wikia/ajax/AjaxFunctions.php" );

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
	global $wgImagesServers, $wgDevelEnvironment;

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
				if(0 < preg_match("/\/__cb([0-9]+)\//i", $wgCdnStylePath, $matches)){
					$timestamp = $matches[1];
				} else {
					// This results in no caching of the image.  Bad bad bad, but the best way to fail.
					Wikia::log( __METHOD__, "", "BAD FOR CACHING!: There is a call to ".__METHOD__." without a timestamp and we could not parse a fallback cache-busting number out of wgCdnStylePath.  This means the image won't be cacheable!");
					$timestamp = rand(0, 1000);
				}
			}

			// macbre: don't add CB value on dev machines
			// NOTE: This should be the only use of the cache-buster which does not use $wgCdnStylePath.
			$cb = empty($wgDevelEnvironment) ? "__cb{$timestamp}/" : '';

			return str_replace('http://images.wikia.com/', sprintf("http://images%s.wikia.nocookie.net/%s",$serverNo, $cb), $url);
		}
	}
	return $url;
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
	global $wgMemc, $wgSitename, $wgServer, $wgCats, $wgExternalSharedDB, $wgCityId;

	$method = __METHOD__;

	if( !empty( $wgCats ) ) {
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
					$specialCanonicalName = SpecialPage::resolveAlias($dbkey);
					if (!$specialCanonicalName) $specialCanonicalName = $dbkey;
				}
				$title = $title->fixSpecialName();
				$href = $title->getLocalURL();
			} else {
				$href = '#';
			}
		}
	}

	return array('text' => $text, 'href' => $href, 'org' => $line_temp[0], 'desc' => $descText, 'specialCanonicalName' => $specialCanonicalName);
}

/**
 * @author Inez Korczynski <inez@wikia.com>
 * @return array
 */
function getMessageAsArray($messageKey) {
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

global $wgAjaxExportList;
$wgAjaxExportList[] = 'getMenu';
function getMenu() {
	global $wgRequest, $wgMemc, $wgCityId, $wgScript;
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

		$content .= 'window.menuArray = '.Wikia::json_encode($menuArray).';$("#navigation_widget").mouseover(menuInit);$(function() { menuInit(); });';
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
		$content .= 'window.magicWords = '.Wikia::json_encode($magicWords).';';
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
	$key = wfMemcKey('popular-art');
	$data = $wgMemc->get($key);

	if(!empty($data) && isset($data[$name])) {
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
	return $result;
}


/**
 * @author Inez Korczynski <inez@wikia.com>
 */
function isMsgEmpty($key) {
	return wfEmptyMsg($key, trim(wfMsg($key)));
}

/*
 * get a list of language names available for wiki request
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
 * Get a shared cache key
 */
function wfSharedMemcKey( /*... */ ) {
	global $wgSharedDB, $wgWikiaCentralAuthDatabase;

	$args = func_get_args();
	$prefix = empty( $wgWikiaCentralAuthDatabase ) ? $wgSharedDB : $wgWikiaCentralAuthDatabase;
	$key = $prefix . ':' . implode( ':', $args );
	return $key;
}

/*
 * Get provided message in plain and HTML versions using language as priority
 *
 * @author Inez, Marooned
 * @return array
 */
function wfMsgHTMLwithLanguage($key, $lang, $options = array(), $params = array(), $wantHTML = true) {
	global $wgContLanguageCode, $wgMessageCache;

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

	$msgPlainRaw = $wgMessageCache->get($langKey, true, $lang, $fullKey);
	$msgPlainRawEmpty = wfEmptyMsg($langKey, $msgPlainRaw);
	$fallbackLang = $lang;
	while ($fallbackLang = Language::getFallbackFor($fallbackLang)) {
		if ($fallbackLang == $wgContLanguageCode) {
			$fullKey = false;
			$langKey2 = $key;
		} else {
			$fullKey = true;
			$langKey2 = "$key/$fallbackLang";
		}
		$msgPlainRawLang = $wgMessageCache->get($langKey2, true, $fallbackLang, $fullKey);
		$msgPlainRawLangEmpty = wfEmptyMsg($langKey2, $msgPlainRawLang);
		//if main message is empty and fallbacked is not, get fallbacked one
		if (!$msgPlainRawLangEmpty && wfEmptyMsg($langKey, $msgPlainRaw)) {
			//TODO: check if this ok or do we need to use $msgPlainRaw plus parsing
			$msgPlain = wfMsgExt($key, array_merge($options, array('language' => $fallbackLang)), $params);
		}
		if ($msgPlainRaw != $msgPlainRawLang && !$msgPlainRawEmpty && !$msgPlainRawLangEmpty) {
			break;
		}
		$msgPlainFallbacked++;
	}
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

		$msgRichRaw = $wgMessageCache->get($langKeyHTML, true, $lang, $fullKey);
		$msgRichRawEmpty = wfEmptyMsg($langKeyHTML, $msgRichRaw);
		$fallbackLang = $lang;
		while ($fallbackLang = Language::getFallbackFor($fallbackLang)) {
			if ($fallbackLang == $wgContLanguageCode) {
				$fullKey = false;
				$langKeyHTML2 = $key;
			} else {
				$fullKey = true;
				$langKeyHTML2 = "$keyHTML/$fallbackLang";
			}
			$msgRichRawLang = $wgMessageCache->get($langKeyHTML2, true, $fallbackLang, true);
			$msgRichRawLangEmpty = wfEmptyMsg($langKeyHTML2, $msgRichRawLang);
			if (!$msgRichRawLangEmpty && wfEmptyMsg($langKeyHTML, $msgRich)) {
				//TODO: check if this ok or do we need to use $msgRichRaw plus parsing
				$msgRich = wfMsgExt($keyHTML, array_merge($options, array('language' => $fallbackLang)), $params);
			}
			if ($msgRichRaw != $msgRichRawLang && !$msgRichRawEmpty && !wfEmptyMsg($keyHTML, $msgRichRawLang)) {
				break;
			}
			$msgRichFallbacked++;
		}
		if($msgRichFallbacked > $msgPlainFallbacked || wfEmptyMsg($keyHTML, $msgRich)) {
			$msgRich = null;
		}
	} else {
		$msgRich = null;
	}

	return array($msgPlain, $msgRich, $msgPlainFallbacked, $msgRichFallbacked);
}

/*
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

/*
 * Build returnto parameter with new returntoquery from MW 1.16
 *
 * @author Marooned
 * @return string
 */
function wfGetReturntoParam($customReturnto = null) {
	global $wgTitle, $wgRequest;

	if ($customReturnto) {
		$returnto = "returnto=$customReturnto";
	} else {
		$thisurl = $wgTitle->getPrefixedURL();
		$returnto = "returnto=$thisurl";
	}

	if (!$wgRequest->wasPosted()) {
		$query = $wgRequest->getValues();
		unset($query['title']);
		unset($query['returnto']);
		unset($query['returntoquery']);
		$thisquery = wfUrlencode(wfArrayToCGI($query));
		if($thisquery != '')
			$returnto .= "&returntoquery=$thisquery";
	}
	return $returnto;
}

/*
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

/*
 * Given a timestamp, converts it to the "x minutes/hours/days ago" format.
 *
 * @author Maciej Brencz <macbre@wikia-inc.com>, Sean Colombo
 */
function wfTimeFormatAgo($stamp){
	wfProfileIn(__METHOD__);
	global $wgLang;

	$ago = time() - strtotime($stamp) + 1;

	if ($ago < 60) {
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
		$pref = $wgLang->dateFormat(true);
		if($pref == 'default' || !isset($wgLang->dateFormats["$pref date"])) {
			$pref = $wgLang->defaultDateFormat;
		}
		//remove year from user's date format
		$format = trim($wgLang->dateFormats["$pref date"], ' ,yY');
		$res = $wgLang->sprintfDate($format, wfTimestamp(TS_MW, $stamp));
	}
	else {
		// Over 365 days: date, with a year (July 26, 2008)
		$res = $wgLang->date(wfTimestamp(TS_MW, $stamp));
	}

	wfProfileOut(__METHOD__);
	return $res;
} // end wfTimeFormatAgo()

/*
 * Returns the text from wfTimeFormatAgo only if the text is recent.
 * This can be used in places that we don't want to show glaringly stale timestamps.
 *
 * @author Maciej Brencz <macbre@wikia-inc.com>, Sean Colombo
  */
function wfTimeFormatAgoOnlyRecent($stamp){
	wfProfileIn(__METHOD__);
	global $wgContLang;

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

/** Get the main TT cache object */
function wfGetMainTTCache() {
	global $wgCaches, $wgCachedTTServers;
	$cache = false;

	if ( class_exists('TokyoTyrantCache')  && !empty($wgCachedTTServers) ) {
		if ( !array_key_exists( CACHE_TT, $wgCaches ) ) {
			$wgCaches[CACHE_TT] = new TokyoTyrantCache();
			$wgCaches[CACHE_TT]->set_servers( $wgCachedTTServers );
		}
		$cache = $wgCaches[CACHE_TT];
	} else {
		reset( $wgCaches );
		$type = key( $wgCaches );
		$cache = $wgCaches[$type];
	}

	return $cache;
}

/* this is an ugly hack. DO NOT use unless absolutely necessary */
function wfMsgWithFallback( $key ) {
	$msg = wfMsgForContent( $key );

	if ( wfEmptyMsg( $key, $msg ) ) {
		$msg = wfMsgExt( $key, array( 'language' => 'en' ) );
	}

	return $msg;
}


/**
 * return default riak client instance, so far only initialized class
 * @author Krzysztof Krzyżaniak (eloy)
 */
function wfGetRiakClient() {
	global $wgRiakNodeHost, $wgRiakNodePort, $wgRiakNodePrefix;

	return new RiakClient( $wgRiakNodeHost, $wgRiakNodePort, $wgRiakNodePrefix );
}

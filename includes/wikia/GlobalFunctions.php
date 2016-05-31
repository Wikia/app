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
function GetLinksArrayFromMessage( $messagename ) { // feel free to suggest better name for this function
	global $parserMemc, $wgEnableSidebarCache;
	global $wgLang, $wgContLang;

	wfProfileIn( "GetLinksArrayFromMessage" );
	$key = wfMemcKey( $messagename );

	$cacheSidebar = $wgEnableSidebarCache &&
		( $wgLang->getCode() == $wgContLang->getCode() );

	if ( $cacheSidebar ) {
		$cachedsidebar = $parserMemc->get( $key );
		if ( $cachedsidebar != "" ) {
			wfProfileOut( "GetLinksArrayFromMessage" );
			return $cachedsidebar;
		}
	}

	$bar = array();
	$lines = explode( "\n", wfMsgForContent( $messagename ) );
	foreach ( $lines as $line ) {
		if ( strlen( $line ) == 0 ) // ignore empty lines
			continue;
		if ( strpos( $line, '*' ) !== 0 )
			continue;
		if ( strpos( $line, '**' ) !== 0 ) {
			$line = trim( $line, '* ' );
			$heading = $line;
		} else {
			if ( strpos( $line, '|' ) !== false ) { // sanity check
				$line = explode( '|' , trim( $line, '* ' ), 2 );
				$link = wfMsgForContent( $line[0] );
				if ( $link == '-' )
					continue;
				if ( wfEmptyMsg( $line[1], $text = wfMsg( $line[1] ) ) )
					$text = $line[1];
				if ( wfEmptyMsg( $line[0], $link ) )
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

				if ( isset( $heading ) ) {
						$bar[$heading][] = array(
						'text' => $text,
						'href' => $href,
						'id' => 'n-' . strtr( $line[1], ' ', '-' ),
						'active' => false
					);
				}
			} else { continue; }
		}
	}
	if ( $cacheSidebar )
		$parserMemc->set( $key, $bar, 86400 );
	wfProfileOut( "GetLinksArrayFromMessage" );
	return $bar;
}

/**
 * print_pre
 *
 * @author: Inez Korczyński
 *
 */
function print_pre( $param, $return = 0 )
{
	global $wgDisablePrintPre;
	if ( isset ( $wgDisablePrintPre ) && $wgDisablePrintPre == true ) {
		return '';
	}
	$retval = "<pre>" . print_r( $param, 1 ) . "</pre>";
	if  ( empty( $return ) ) {
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
	$wg = F::app()->wg;

	// Override image server location for Wikia development environment
	// This setting should be images.developerName.wikia-dev.com or perhaps "localhost"
	// FIXME: This needs to be removed. It should be encapsulated in the URL generation.
	$overrideServer = !empty( $wg->DevBoxImageServerOverride ) && !$wg->EnableVignette;
	if ( $overrideServer ) {
		$url = preg_replace( "/\\/\\/(.*?)wikia-dev\\.com\\/(.*)/", "//{$wg->DevBoxImageServerOverride}/$2", $url );
	}

	wfDebug( __METHOD__ . ": requested url $url\n" );
	if ( substr( strtolower( $url ), -4 ) != '.ogg' && isset( $wg->ImagesServers ) && is_int( $wg->ImagesServers ) ) {
		if ( strlen( $url ) > 7 && substr( $url, 0, 7 ) == 'http://' ) {
			$hash = sha1( $url );
			$inthash = ord ( $hash );

			$serverNo = $inthash % ( $wg->ImagesServers -1 );
			$serverNo++;

			// If there is no timestamp, use the cache-busting number from wgCdnStylePath.
			if ( $timestamp == "" ) {
				$matches = array();
				// @TODO: consider using wgStyleVersion
				if ( 0 < preg_match( "/\/__cb([0-9]+)/i", $wg->CdnStylePath, $matches ) ) {
					$timestamp = $matches[1];
				} else {
					// This results in no caching of the image.  Bad bad bad, but the best way to fail.
					Wikia::log( __METHOD__, "", "BAD FOR CACHING!: There is a call to " . __METHOD__ . " without a timestamp and we could not parse a fallback cache-busting number out of wgCdnStylePath.  This means the '{$url}' image won't be cacheable!" );
					$timestamp = rand( 0, 1000 );
				}
			}

			// NOTE: This should be the only use of the cache-buster which does not use $wg->CdnStylePath.
			// RT#98969 if the url already has a cb value, don't add another one...
			$cb = ( $timestamp != '' && strpos( $url, "__cb" ) === false ) ? "__cb{$timestamp}/" : '';

			if ( $overrideServer ) {
				// Dev boxes
				// TODO: support domains sharding on devboxes
				$url = str_replace( 'http://images.wikia.com/', sprintf( "http://{$wg->DevBoxImageServerOverride}/%s", $cb ), $url );
			} else {
				// Production
				$url = str_replace( 'http://images.wikia.com/', sprintf( "http://{$wg->ImagesDomainSharding}/%s", $serverNo, $cb ), $url );
			}
		}
	} else if ( $overrideServer ) {
		$url = str_replace( 'http://images.wikia.com/', "http://{$wg->DevBoxImageServerOverride}/", $url );
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
	global $wgImagesServers, $wgDevelEnvironment;

	$matches = array();

	if ( preg_match( "#^(?<a>(https?:)?//(slot[0-9]+\\.)?images)(?<b>\\.wikia\\.nocookie\\.net/.*)\$#", $url, $matches ) ) {
		$hash = sha1( $url );
		$inthash = ord( $hash );

		$serverNo = $inthash % ( $wgImagesServers -1 );
		$serverNo++;

		$url = $matches['a'] . ( $serverNo ) . $matches['b'];
	} elseif ( !empty( $wgDevelEnvironment ) && preg_match( '/^((https?:)?\/\/)(([a-z0-9]+)\.wikia-dev\.com\/(.*))$/', $url, $matches ) ) {
		$hash = sha1( $url );
		$inthash = ord( $hash );

		$serverNo = $inthash % ( $wgImagesServers -1 );
		$serverNo++;

		$url = "{$matches[1]}i{$serverNo}.{$matches[3]}";
	}

	return $url;
}

/**
 * 	@author Krzysztof Zmudziński <kaz3t@wikia.com>
 *	Returns array of review reason id
 */
function wfGetReviewReason( $max = 5 ) {
	global $wgMemc, $wgDBname;

	$key = "$wgDBname:ReviewReasons";
	$result = $wgMemc->get( $key );

	if ( !is_array( $result ) ) {
		for ( $i = 1; $i <= $max; $i++ ) {
			$msg = htmlspecialchars_decode( wfMsg( "review_reason_$i" ) );
			if ( $msg[0] != "<" ) {
				$result[$i] = $msg;
			}
		}
		$wgMemc->set( $key, $result, 60 );
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
function wfShortenText( $text, $chars = 25, $useContentLanguage = false ) {
	if ( mb_strlen( $text ) <= $chars ) {
		return $text;
	}

	static $ellipsis = array();
	$key = ( !empty( $useContentLanguage ) ) ? 'user' : 'content';

	// memoize the message to avoid overhead,
	// this might be called many times in the
	// same process/request
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

	// remove symbols at the end of the snippet to avoid situations like:
	// :... or ?... or ,... etc. etc.
	$text = preg_replace( '/[[:punct:]]+$/', '', $text ) . $ellipsis[$key][0];
	return $text;
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
function wfDecodeUnicodeUrl( $str ) {
	$res = '';

    $i = 0;
	$max = strlen( $str ) - 6;
	while ( $i <= $max )
	{
		$character = $str[$i];
		if ( $character == '%' && $str[$i + 1] == 'u' )
		{
		    $value = hexdec( substr( $str, $i + 2, 4 ) );
			$i += 6;

			if ( $value < 0x0080 ) // 1 byte: 0xxxxxxx
				$character = chr( $value );
			else if ( $value < 0x0800 ) // 2 bytes: 110xxxxx 10xxxxxx
				$character = chr( ( ( $value & 0x07c0 ) >> 6 ) | 0xc0 )
					. chr( ( $value & 0x3f ) | 0x80 );
			else // 3 bytes: 1110xxxx 10xxxxxx 10xxxxxx
				$character = chr( ( ( $value & 0xf000 ) >> 12 ) | 0xe0 )
					. chr( ( ( $value & 0x0fc0 ) >> 6 ) | 0x80 )
					. chr( ( $value & 0x3f ) | 0x80 );
		}
		else
			$i++;

		$res .= $character;
	}

	return $res . substr( $str, $i );
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
	$action = $wgRequest->getText( 'action' );
	return (
		$wgUser->isLoggedIn() &&
		$wgTitle->GetLocalURL() == $wgUser->GetTalkPage()->GetLocalURL() &&
		$wgOut->isArticle() &&
		( $action == '' || $action == 'purge' )
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
 * @return void|string: depends of $return param
 */
function wfEchoIfSet( $variable, $return = false )
{
    if ( empty( $return ) ) {
        echo isset( $variable ) ? $variable : "";
		return null;
    }
    else {
        return isset( $variable ) ? $variable : "";
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

    # --- "normalize" string
    foreach ( $aParts as $count => $part ) {
        $aReturn[] = trim( $part );
        if ( $count > $parts ) {
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
function parseItem( $line ) {
	wfProfileIn( __METHOD__ );

	$href = $specialCanonicalName = false;

	$line_temp = explode( '|', trim( $line, '* ' ), 3 );
	$line_temp[0] = trim( $line_temp[0], '[]' );
	if ( count( $line_temp ) >= 2 && $line_temp[1] != '' ) {
		$line = trim( $line_temp[1] );
		$link = trim( wfMsgForContent( $line_temp[0] ) );
	} else {
		$line = trim( $line_temp[0] );
		$link = trim( $line_temp[0] );
	}

	$descText = null;

	if ( count( $line_temp ) > 2 && $line_temp[2] != '' ) {
		$desc = $line_temp[2];
		if ( wfEmptyMsg( $desc, $descText = wfMsg( $desc ) ) ) {
			$descText = $desc;
		}
	}

	if ( wfEmptyMsg( $line, $text = wfMsg( $line ) ) ) {
		$text = $line;
	}

	if ( $link != null ) {
		if ( wfEmptyMsg( $line_temp[0], $link ) ) {
			$link = $line_temp[0];
		}
		if ( preg_match( '/^(?:' . wfUrlProtocols() . ')/', $link ) ) {
			$href = $link;
		} else {
			$title = Title::newFromText( $link );
			if ( $title ) {
				if ( $title->getNamespace() == NS_SPECIAL ) {
					$dbkey = $title->getDBkey();
					$pageData = SpecialPageFactory::resolveAlias( $dbkey );
					$specialCanonicalName = array_shift( $pageData );
					if ( !$specialCanonicalName ) $specialCanonicalName = $dbkey;
				}
				$title = $title->fixSpecialName();
				$href = $title->getLocalURL();
			} else {
				$href = '#';
			}
		}
	}

	wfProfileOut( __METHOD__ );
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
 * @author Adam Karmiński <adamk@wikia-inc.com>
 * @param string $messageKey
 * @return array|null
 */
function getMessageForContentAsArray( $messageKey ) {
	$message = wfMessage( $messageKey )->inContentLanguage();
	if ( !$message->isBlank() ) {
		$lines = explode( "\n", trim( $message->plain() ) );
		if ( count( $lines ) > 0 ) {
			return $lines;
		}
	}
	return null;
}

/**
 * @author Michał Roszka (Mix) <michal@wikia-inc.com>
 * @return array
 */
function getMessageAsArray( $messageKey, $params = [] ) {
	$message = wfMessage( $messageKey )->params( $params );
	if ( !$message->isBlank() ) {
		$lines = explode( "\n", trim( $message->plain() ) );
		if ( count( $lines ) > 0 ) {
			return $lines;
		}
	}
	return null;
}

/**
 * @author emil@wikia.com
 * @return string default external cluster
 */
function wfGetDefaultExternalCluster() {
	global $wgDefaultExternalStore;
	if ( $wgDefaultExternalStore ) {
		if ( is_array( $wgDefaultExternalStore ) ) {
			$store = $wgDefaultExternalStore[0];
		} else {
			$store = $wgDefaultExternalStore;
		}
		list( $proto, $cluster ) = explode( '://', $store, 2 );
		return $cluster;
	} else {
		throw new MWException( __METHOD__ . '$wgDefaultExternalStore should be defined' );
	}
}

/**
 * @author MoLi <moli@wikia.com>
 * @return DatabaseBase db's handle for external storage
 */
function wfGetDBExt( $db = DB_MASTER, $cluster = null ) {
	if ( !$cluster ) {
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
	if ( $maxLag ) {
		if ( !$cluster ) {
			$cluster = wfGetDefaultExternalCluster();
		}
		$lb = wfGetLBFactory()->getExternalLB( $cluster );
		list( $host, $lag ) = $lb->getMaxLag();
		while ( $lag > $maxLag ) {
			$name = @gethostbyaddr( $host );
			if ( $name !== false ) {
				$host = $name;
			}
			print "Waiting for $host (lagged $lag seconds)...\n";
			sleep( $maxLag );
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
	if ( !preg_match( '!^https?://!', $uri ) ) {
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


function getMenuHelper( $name, $limit = 7 ) {
	global $wgMemc;
	wfProfileIn( __METHOD__ );

	$key = wfMemcKey( 'popular-art' );
	$data = $wgMemc->get( $key );

	if ( !empty( $data ) && isset( $data[$name] ) ) {
		wfProfileOut( __METHOD__ );
		return $data[$name];
	}

	$name = str_replace( " ", "_", $name );
	$limit = intval( $limit );

	$dbr = wfGetDB( DB_SLAVE );
	$query = "SELECT cl_from FROM categorylinks USE INDEX (cl_from), page_visited USE INDEX (page_visited_cnt_inx) WHERE article_id = cl_from AND cl_to = " . $dbr->addQuotes( $name ) . " ORDER BY COUNT DESC LIMIT $limit";
	$res = $dbr->query( $query, __METHOD__ );
	$result = array();
	while ( $row = $dbr->fetchObject( $res ) ) {
		$result[] = $row->cl_from;
	}
	if ( count( $result ) < $limit ) {
		$resultEscaped = $dbr->makeList( $result ); # PLATFORM-1579 - e.g. 'a', 'b', 'c'
		$query = "SELECT cl_from FROM categorylinks WHERE cl_to = " . $dbr->addQuotes( $name ) . " " . ( count( $result ) > 0 ? " AND cl_from NOT IN (" . $resultEscaped . ") " : "" ) . " LIMIT " . ( $limit - count( $result ) );
		$res = $dbr->query( $query, __METHOD__ );
		while ( $row = $dbr->fetchObject( $res ) ) {
			$result[] = $row->cl_from;
		}
	}
	if ( empty( $data ) || !is_array( $data ) ) {
		$data = array( $data );
	}
	$data[$name] = $result;
	$wgMemc->set( $key, $data, 60 * 60 * 6 );

	wfProfileOut( __METHOD__ );
	return $result;
}


/**
 * @author Inez Korczynski <inez@wikia.com>
 */
function isMsgEmpty( $key ) {
	return wfEmptyMsg( $key, trim( wfMsg( $key ) ) );
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

	$filter_languages = explode( ',', wfMsgForContent( 'requestwiki-filter-language' ) );
	foreach ( $filter_languages as $key ) {
		unset( $languages[$key] );
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
	if ( $wgSharedKeyPrefix === false ) { // non shared wiki, fallback to normal function
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
function wfMsgHTMLwithLanguage( $key, $lang, $options = array(), $params = array(), $wantHTML = true ) {
	global $wgContLanguageCode;
	wfProfileIn( __METHOD__ );

	// remove 'content' option and pick proper language
	if ( isset( $options['content'] ) ) {
		$lang = $wgContLanguageCode;
		unset( $options['content'] );
	}
	$options = array_merge( $options, array( 'parsemag', 'language' => $lang ) );

	// TODO: check if this ok or do we need to use $msgPlainRaw plus parsing
	$msgPlain = wfMsgExt( $key, $options, $params );
	$msgPlainFallbacked = $msgRichFallbacked = 0;
	if ( $lang == $wgContLanguageCode ) {
		$fullKey = false;
		$langKey = $key;
	} else {
		$fullKey = true;
		$langKey = "$key/$lang";
	}

	$msgPlainRaw = MessageCache::singleton()->get( $langKey, true, $lang, $fullKey );
	$msgPlainRawEmpty = wfEmptyMsg( $langKey, $msgPlainRaw );

	$found = false;

	foreach ( Language::getFallbacksFor( $lang ) as $fallbackLang ) {
		if ( $fallbackLang == $wgContLanguageCode ) {
			$fullKey = false;
			$langKey2 = $key;
		} else {
			$fullKey = true;
			$langKey2 = "$key/$fallbackLang";
		}
		$msgPlainRawLang = MessageCache::singleton()->get( $langKey2, true, $fallbackLang, $fullKey );
		$msgPlainRawLangEmpty = wfEmptyMsg( $langKey2, $msgPlainRawLang );
		// if main message is empty and fallbacked is not, get fallbacked one
		if ( wfEmptyMsg( $langKey, $msgPlainRaw ) && !$msgPlainRawLangEmpty ) {
			// TODO: check if this ok or do we need to use $msgPlainRaw plus parsing
			$msgPlain = wfMsgExt( $key, array_merge( $options, array( 'language' => $fallbackLang ) ), $params );
			$msgPlainFallbacked++;
		}
		if ( $msgPlainRaw != $msgPlainRawLang && !$msgPlainRawEmpty && !$msgPlainRawLangEmpty ) {
			$found = true;
			break;
		}
	}

	// notify wfMsgHTMLwithLanguageAndAlternative() that we didn't get a match
	if ( !$found ) $msgPlainFallbacked++;

	if ( $wantHTML ) {
		$keyHTML = $key . '-HTML';
		// TODO: check if this ok or do we need to use $msgRichRaw plus parsing
		$msgRich = wfMsgExt( $keyHTML, $options, $params );

		if ( $lang == $wgContLanguageCode ) {
			$fullKey = false;
			$langKeyHTML = $keyHTML;
		} else {
			$fullKey = true;
			$langKeyHTML = "$keyHTML/$lang";
		}

		$msgRichRaw = MessageCache::singleton()->get( $langKeyHTML, true, $lang, $fullKey );
		$msgRichRawEmpty = wfEmptyMsg( $langKeyHTML, $msgRichRaw );

		$found = false;

		foreach ( Language::getFallbacksFor( $lang ) as $fallbackLang ) {
			if ( $fallbackLang == $wgContLanguageCode ) {
				$fullKey = false;
				$langKeyHTML2 = $key;
			} else {
				$fullKey = true;
				$langKeyHTML2 = "$keyHTML/$fallbackLang";
			}
			$msgRichRawLang = MessageCache::singleton()->get( $langKeyHTML2, true, $fallbackLang, true );
			$msgRichRawLangEmpty = wfEmptyMsg( $langKeyHTML2, $msgRichRawLang );
			if ( wfEmptyMsg( $langKeyHTML, $msgRich ) && !$msgRichRawLangEmpty ) {
				// TODO: check if this ok or do we need to use $msgRichRaw plus parsing
				$msgRich = wfMsgExt( $keyHTML, array_merge( $options, array( 'language' => $fallbackLang ) ), $params );
				$msgRichFallbacked++;
			}
			if ( $msgRichRaw != $msgRichRawLang && !$msgRichRawEmpty && !wfEmptyMsg( $keyHTML, $msgRichRawLang ) ) {
				$found = true;
				break;
			}
		}

		// notify wfMsgHTMLwithLanguageAndAlternative() that we didn't get a match
		if ( !$found ) $msgRichFallbacked++;

		if ( $msgRichFallbacked > $msgPlainFallbacked || wfEmptyMsg( $keyHTML, $msgRich ) ) {
			$msgRich = null;
		}
	} else {
		$msgRich = null;
	}

	wfProfileOut( __METHOD__ );
	return array( $msgPlain, $msgRich, $msgPlainFallbacked, $msgRichFallbacked );
}

/**
 * Get more accurate message in plain and HTML versions using language as priority
 *
 * @author Marooned
 * @return array
 */
function wfMsgHTMLwithLanguageAndAlternative( $key, $keyAlternative, $lang, $options = array(), $params = array(), $wantHTML = true ) {
	// inserted here for external i18n add-on, adjust params if needed
	wfRunHooks( 'MsgHTMLwithLanguageAndAlternativeBefore' );

	list ( $msgPlainMain, $msgRichMain, $msgPlainMainFallback, $msgRichMainFallback ) = wfMsgHTMLwithLanguage( $key, $lang, $options, $params, $wantHTML );
	list ( $msgPlainAlter, $msgRichAlter, $msgPlainAlterFallback, $msgRichAlterFallback ) = wfMsgHTMLwithLanguage( $keyAlternative, $lang, $options, $params, $wantHTML );

	$msgPlain = $msgPlainMainFallback > $msgPlainAlterFallback || wfEmptyMsg( $key, $msgPlainMain ) ? $msgPlainAlter : $msgPlainMain;
	$msgRich = $msgRichMainFallback > $msgRichAlterFallback || wfEmptyMsg( $key . '-HTML', $msgRichMain ) ? $msgRichAlter : $msgRichMain;
	return array( $msgPlain, $msgRich );
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
function wfGetReturntoParam( $customReturnto = null, $extraReturntoquery = null ) {
	global $wgTitle, $wgRequest;

	if ( $customReturnto ) {
		$returnto = "returnto=$customReturnto";
	} else if ( $wgTitle instanceof Title ) {
		$thisurl = $wgTitle->getPrefixedURL();
		$returnto = "returnto=$thisurl";
	} else {
		$returnto = "";
	}

	if ( !$wgRequest->wasPosted() ) {
		$query = $wgRequest->getValues();
		unset( $query['title'] );
		unset( $query['returnto'] );
		unset( $query['returntoquery'] );
		$thisquery = wfUrlencode( wfArrayToCGI( $query ) );
		if ( $extraReturntoquery ) {
			$thisquery .= ( $thisquery == "" ? "" : "&amp;" ) . urlencode( $extraReturntoquery );
		}
		if ( $thisquery != '' ) {
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
function wfUrlencodeExt( $s_url ) {
	if ( !empty( $s_url ) ) {
		if ( strpos( $s_url, '/index.php' ) === false ) {
			$Url = @parse_url( $s_url );
			$s_url = str_replace(
				$Url['path'], # search
				implode( "/", array_map( "rawurlencode", explode( "/", @$Url['path'] ) ) ), # replace
				$s_url # what
			);
		}
	}
	return $s_url;
}

/**
 * Given a timestamp, converts it to the "x minutes/hours/days ago" format.
 *
 * @author Maciej Brencz <macbre@wikia-inc.com>, Sean Colombo
 *
 * @param string $stamp
 * @param boolean $hideCurrentYear
 * @return string
 */
function wfTimeFormatAgo( $stamp, $hideCurrentYear = true ) {
	wfProfileIn( __METHOD__ );
	global $wgLang;

	$currenttime = time();
	$stamptime = strtotime( $stamp );
	$ago = $currenttime - $stamptime + 1;
	$sameyear = date( 'Y', $currenttime ) == date( 'Y', $stamptime );

	$res = '';

	if ( $ago > 365 * 86400 || !$sameyear ) {
		// Over 365 days
		// or different year than current:
		// format is date, with a year (July 26, 2008)
		$res = $wgLang->date( wfTimestamp( TS_MW, $stamp ) );
	} elseif ( $ago < 60 ) {
		// Under 1 min: to the second (ex: 30 seconds ago)
		$res = wfMsgExt( 'wikia-seconds-ago', array( 'parsemag' ), $ago );
	}
	else if ( $ago < 3600 ) {
		// Under 1 hr: to the minute (3 minutes ago)
		$res = wfMsgExt( 'wikia-minutes-ago', array( 'parsemag' ), floor( $ago / 60 ) );
	}
	else if ( $ago < 86400 ) {
		// Under 24 hrs: to the hour (4 hours ago)
		$res = wfMsgExt( 'wikia-hours-ago', array( 'parsemag' ), floor( $ago / 3600 ) );
	}
	else if ( $ago < 30 * 86400 ) {
		// Under 30 days: to the day (5 days ago)
		$res = wfMsgExt( 'wikia-days-ago', array( 'parsemag' ), floor( $ago / 86400 ) );
	}
	else if ( $ago < 365 * 86400 ) {
		// Under 365 days: date, with no year (July 26)
		// remove year from user's date format
		$format = $wgLang->getDateFormatString( 'date', 'default' );
		if ( $hideCurrentYear ) {
			$format = trim( $format, ' ,yY' );
		}
		$res = $wgLang->sprintfDate( $format, wfTimestamp( TS_MW, $stamp ) );
	}

	wfProfileOut( __METHOD__ );
	return $res;
} // end wfTimeFormatAgo()

/**
 * Returns the text from wfTimeFormatAgo only if the text is recent.
 * This can be used in places that we don't want to show glaringly stale timestamps.
 *
 * @author Maciej Brencz <macbre@wikia-inc.com>, Sean Colombo
  */
function wfTimeFormatAgoOnlyRecent( $stamp ) {
	wfProfileIn( __METHOD__ );

	$ago = time() - strtotime( $stamp ) + 1;

	if ( $ago < 7 * 86400 ) {
		$res = wfTimeFormatAgo( $stamp );
	}
	else {
		$res = '';
	}

	wfProfileOut( __METHOD__ );
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
function wfBlankImgUrl() {
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
	wfProfileIn( __METHOD__ );

	global $wgExtensionNamespacesFiles, $wgLanguageCode, $wgNamespaceAliases, $wgExtraNamespaces;

	if (
		!empty( $extensionName ) &&
		is_string( $extensionName ) &&
		!empty( $wgExtensionNamespacesFiles[ $extensionName ] ) &&
		!empty( $nsList ) &&
		is_array( $nsList )
	) {
		// load the i18n file for the extension's namespaces
		$namespaces = false;
		require_once( $wgExtensionNamespacesFiles[ $extensionName ] );

		// english is the required default, skip processing if not defined
		if ( !empty( $namespaces[ 'en' ] ) && is_array( $namespaces[ 'en' ] ) ) {
			foreach ( $nsList as $ns ) {
				if ( !empty( $namespaces[ 'en' ][ $ns ] ) ) {
					$langCode = ( !empty( $namespaces[ $wgLanguageCode ][ $ns ] ) ) ? $wgLanguageCode : 'en';

					// define the namespace name for the current language
					$wgExtraNamespaces[ $ns ] = $namespaces[ $langCode ][ $ns ];

					if ( $langCode != 'en' ) {
						// make en ns alias point to localized ones for current language
						$wgNamespaceAliases[ $namespaces[ 'en' ][ $ns ] ] = $ns;
					}
				}
			}
		}
	}

	wfProfileOut( __METHOD__ );
}

/**
 * wfGenerateUnsubToken
 * @author uberfuzzy
 * @return string
 */
function wfGenerateUnsubToken( $email, $timestamp ) {
	global $wgUnsubscribeSalt;
	$token = sha1( $timestamp . $email . $wgUnsubscribeSalt );
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
	if ( $bucket && method_exists( $cache, "setBucket" ) ) {
		$cache->setBucket( $bucket );
	}
	return $cache;
}


/**
 * Set value of wikia article prop list of type is define in
 *
 * Note: The query below used to be done using a REPLACE, however
 * the primary key was removed from the page_wikia_props due to
 * performance issues (see PLATFORM-1658). Without a primary key
 * or unique index, a REPLACE becomes just an INSERT so this method
 * was adding duplicate rows to the table.
 *
 * Because of this, we're implementing a manual REPLACE by explicitly
 * issuing a DELETE query followed by an INSERT.
 */
function wfSetWikiaPageProp( $type, $pageID, $value, $dbname = '' ) {
	if ( empty( $dbname ) ) {
		$db = wfGetDB( DB_MASTER );
	} else {
		$db = wfGetDB( DB_MASTER, array(), $dbname );
	}

	$db->delete(
		'page_wikia_props',
		[
			'page_id' => $pageID,
			'propname' => $type
		],
		__METHOD__
	);

	$db->insert(
		'page_wikia_props',
		[
			'page_id'  => $pageID,
			'propname' => $type,
			'props'    => wfSerializeProp( $type, $value )
		],
		__METHOD__
	);

	$db->commit( __METHOD__ );
}


/**
 * Get value of wikia article prop list of type is define in
 */
function wfGetWikiaPageProp( $type, $pageID, $db = DB_SLAVE, $dbname = '' ) {
	if ( empty( $dbname ) ) {
		$db = wfGetDB( $db, array() );
	} else {
		$db = wfGetDB( $db, array(), $dbname );
	}

	$res = $db->select( 'page_wikia_props',
		array( 'props' ),
		array(
			'page_id'  =>  $pageID,
			'propname' => $type,
		),
		__METHOD__
	);

	if ( $out = $db->fetchRow( $res ) ) {
		return wfUnserializeProp( $type, $out['props'] );
	}

	return null;
}

/**
 * Only serialize the page property types that require it
 * @param $type - The property type
 * @param $data - The data to operate upon
 * @return string - Returns the database ready version of whatever was passed in
 */
function wfSerializeProp( $type, $data ) {
	global $wgWPPNotSerialized;

	// Serialize the value unless we're told not to
	if ( ! in_array( $type, $wgWPPNotSerialized ) ) {
		$data = serialize( $data );
	}

	return $data;
}

/**
 * Only unserialize the page property types that require it
 * @param $type - The property type
 * @param $data - The data to operate upon
 * @return mixed - Returns the unserialized version of whatever was passed in
 */
function wfUnserializeProp( $type, $data ) {
	global $wgWPPNotSerialized;

	// Unserialize the value unless we're told not to
	if ( ! in_array( $type, $wgWPPNotSerialized ) ) {
		$data = unserialize( $data );
	}
	return $data;
}


/**
 * Delete value of wikia article prop
 */
function wfDeleteWikiaPageProp( $type, $pageID, $dbname = '' ) {
	if ( empty( $dbname ) ) {
		$db = wfGetDB( DB_MASTER );
	} else {
		$db = wfGetDB( DB_MASTER, array(), $dbname );
	}

	$db->delete(
		'page_wikia_props',
		array(
			'page_id' =>  $pageID,
			'propname' => $type,
		),
		__METHOD__
	);

	$db->commit( __METHOD__ );
}

if ( !function_exists( 'http_build_url' ) ) {
	define( 'HTTP_URL_REPLACE', 1 );				// Replace every part of the first URL when there's one of the second URL
	define( 'HTTP_URL_JOIN_PATH', 2 );			// Join relative paths
	define( 'HTTP_URL_JOIN_QUERY', 4 );			// Join query strings
	define( 'HTTP_URL_STRIP_USER', 8 );			// Strip any user authentication information
	define( 'HTTP_URL_STRIP_PASS', 16 );			// Strip any password authentication information
	define( 'HTTP_URL_STRIP_AUTH', 32 );			// Strip any authentication information
	define( 'HTTP_URL_STRIP_PORT', 64 );			// Strip explicit port numbers
	define( 'HTTP_URL_STRIP_PATH', 128 );			// Strip complete path
	define( 'HTTP_URL_STRIP_QUERY', 256 );		// Strip query string
	define( 'HTTP_URL_STRIP_FRAGMENT', 512 );		// Strip any fragments (#identifier)
	define( 'HTTP_URL_STRIP_ALL', 1024 );			// Strip anything but scheme and host

	// Build an URL
	// The parts of the second URL will be merged into the first according to the flags argument.
	//
	// @param	mixed			(Part(s) of) an URL in form of a string or associative array like parse_url() returns
	// @param	mixed			Same as the first argument
	// @param	int				A bitmask of binary or'ed HTTP_URL constants (Optional)HTTP_URL_REPLACE is the default
	// @param	array			If set, it will be filled with the parts of the composed url like parse_url() would return
	function http_build_url( $url, $parts = array(), $flags = HTTP_URL_REPLACE, &$new_url = false ) {
		$keys = array( 'user', 'pass', 'port', 'path', 'query', 'fragment' );

		// HTTP_URL_STRIP_ALL becomes all the HTTP_URL_STRIP_Xs
		if ( $flags & HTTP_URL_STRIP_ALL ) {
				$flags |= HTTP_URL_STRIP_USER;
				$flags |= HTTP_URL_STRIP_PASS;
				$flags |= HTTP_URL_STRIP_PORT;
				$flags |= HTTP_URL_STRIP_PATH;
				$flags |= HTTP_URL_STRIP_QUERY;
				$flags |= HTTP_URL_STRIP_FRAGMENT;
		}
		// HTTP_URL_STRIP_AUTH becomes HTTP_URL_STRIP_USER and HTTP_URL_STRIP_PASS
		else if ( $flags & HTTP_URL_STRIP_AUTH ) {
			$flags |= HTTP_URL_STRIP_USER;
			$flags |= HTTP_URL_STRIP_PASS;
		}

		// Parse the original URL
		$parse_url = parse_url( $url );

		// Scheme and Host are always replaced
		if ( isset( $parts['scheme'] ) )
			$parse_url['scheme'] = $parts['scheme'];
		if ( isset( $parts['host'] ) )
			$parse_url['host'] = $parts['host'];

		// (If applicable) Replace the original URL with it's new parts
		if ( $flags & HTTP_URL_REPLACE ) {
			foreach ( $keys as $key ) {
				if ( isset( $parts[$key] ) )
					$parse_url[$key] = $parts[$key];
			}
		}
		else {
			// Join the original URL path with the new path
			if ( isset( $parts['path'] ) && ( $flags & HTTP_URL_JOIN_PATH ) ) {
				if ( isset( $parse_url['path'] ) )
					$parse_url['path'] = rtrim( str_replace( basename( $parse_url['path'] ), '', $parse_url['path'] ), '/' ) . '/' . ltrim( $parts['path'], '/' );
				else
					$parse_url['path'] = $parts['path'];
			}

			// Join the original query string with the new query string
			if ( isset( $parts['query'] ) && ( $flags & HTTP_URL_JOIN_QUERY ) ) {
				if ( isset( $parse_url['query'] ) )
					$parse_url['query'] .= '&' . $parts['query'];
				else
					$parse_url['query'] = $parts['query'];
			}
		}

		// Strips all the applicable sections of the URL
		// Note: Scheme and Host are never stripped
		foreach ( $keys as $key ) {
			if ( $flags & (int)constant( 'HTTP_URL_STRIP_' . strtoupper( $key ) ) )
				unset( $parse_url[$key] );
		}


		$new_url = $parse_url;

		return
			 ( ( isset( $parse_url['scheme'] ) ) ? $parse_url['scheme'] . '://' : '' )
			. ( ( isset( $parse_url['user'] ) ) ? $parse_url['user'] . ( ( isset( $parse_url['pass'] ) ) ? ':' . $parse_url['pass'] : '' ) . '@' : '' )
			. ( ( isset( $parse_url['host'] ) ) ? $parse_url['host'] : '' )
			. ( ( isset( $parse_url['port'] ) ) ? ':' . $parse_url['port'] : '' )
			. ( ( isset( $parse_url['path'] ) ) ? $parse_url['path'] : '' )
			. ( ( isset( $parse_url['query'] ) ) ? '?' . $parse_url['query'] : '' )
			. ( ( isset( $parse_url['fragment'] ) ) ? '#' . $parse_url['fragment'] : '' )
			;
	}
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

function startsWith( $haystack, $needle, $case = true ) {
	if ( $case ) {
		return ( strcmp( substr( $haystack, 0, strlen( $needle ) ), $needle ) === 0 );
	}
	return ( strcasecmp( substr( $haystack, 0, strlen( $needle ) ), $needle ) === 0 );
}

function endsWith( $haystack, $needle, $case = true ) {
	if ( $case ) {
		return ( strcmp( substr( $haystack, strlen( $haystack ) - strlen( $needle ) ), $needle ) === 0 );
	}
	return ( strcasecmp( substr( $haystack, strlen( $haystack ) - strlen( $needle ) ), $needle ) === 0 );
}

/**
 * @brief Handles pagination for arrays
 *
 * @author Federico "Lox" Lucignano
 *
 * @param array $data the array to paginate
 * @param integer $limit the maximum number of items per page
 * @param integer $batch [OPTIONAL] the batch to retrieve
 *
 * @return array an hash with the following keys:
 * * items array the items for the requested batch
 * * next integer the number of items in the next batch
 * * batches integer the total number of batches
 * * currentBatch integer the current batch (first is 1)
 * */
function wfPaginateArray( $data, $limit, $batch = 1 ) {
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
		$batches = ceil( $total / $limit );

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
 * @param array $array typical array with key => value
 *
 * @return string string for debugging purposes
 */
function wfArrayToString( $array ) {
	$retval = "";
	if ( is_array( $array ) ) {
		foreach ( $array as $key => $value )
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
 * Allow to find what staging machine we are on
 *
 * @author Tomasz Odrobny <tomek@wikia-inc.com>
 */
function getHostPrefix() {
	global $wgStagingList, $wgServer;
	static $cache;
	if ( !empty( $cache ) ) {
		return $cache;
	}
	$hosts = $wgStagingList;
	foreach ( $hosts as $host ) {
		$prefix = 'http://' . $host . '.';
		if ( strpos( $wgServer, $prefix )  !== false ) {
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
function wfWikiaErrorHandler( $errno, $errstr, $errfile, $errline ) {
	switch( $errno ) {
		case E_RECOVERABLE_ERROR:
			Wikia::logBacktrace( "PHP fatal error caught ({$errstr})" );
			break;
	}

	// error was not really handled
	return false;
}

/**
 * get namespaces
 * @global $wgContLang
 * @return array $namespaces
 */
function wfGetNamespaces() {
	global $wgContLang;

	$namespaces = $wgContLang->getFormattedNamespaces();
	wfRunHooks( 'XmlNamespaceSelectorAfterGetFormattedNamespaces', array( &$namespaces ) );

	return $namespaces;
}

/**
 * Repair malformed HTML without making semantic changes (ie, changing tags to more closely follow the HTML spec.)
 * Refs DAR-985, VID-1011, SUS-327
 *
 * @param string $html - HTML to repair
 * @return string - repaired HTML
 */
function wfFixMalformedHTML( $html ) {
	$domDocument = new DOMDocument();

	// Silence errors when loading html into DOMDocument (it complains when receiving malformed html - which is
	// what we're using it to fix) see: http://www.php.net/manual/en/domdocument.loadhtml.php#95463
	libxml_use_internal_errors( true );

	// CONN-130 - Added <!DOCTYPE html> to allow HTML5 tags in the article comment
	$htmlHeader = '<!DOCTYPE html><html>';

	// Make sure loadHTML knows that text is utf-8 (it assumes ISO-88591)
	$htmlHeader .= '<head><meta http-equiv="content-type" content="text/html; charset=utf-8"></head>';

	// SUS-237 - Wrap in <body> tag to prevent wrapping simple text with <p> tags and stripping HTML comments and script tags
	// This also simplifies the return value extraction
	$htmlHeader .= '<body>';

	$domDocument->loadHTML( $htmlHeader . $html );

	// Strip doctype declaration, <html>, <body> tags created by saveHTML, as well as <meta> tag added to
	// to html above to declare the charset as UTF-8
	$html = preg_replace(
		array(
			'/^.*<body>/s',
			'/<\/body>\s*<\/html>$/s',
		),
		'',
		$domDocument->saveHTML()
	);

	return $html;
}

/**
 * Go through the backtrace and return the first method that is not in the ingored class
 * @param $ignoreClasses mixed array of ignored class names or a single class name
 * @return string method name
 */
function wfGetCallerClassMethod( $ignoreClasses ) {
	// analyze the backtrace to log the source of purge requests
	$backtrace = wfDebugBacktrace();
	$method = '';

	if ( is_string( $ignoreClasses ) ) {
		$ignoreClasses = [ $ignoreClasses ];
	}

	while ( $entry = array_shift( $backtrace ) ) {

		if ( empty( $entry['class'] ) || in_array( $entry['class'], $ignoreClasses ) ) {
			continue;
		}

		// skip closures
		// e.g. "FilePageController:{closure}"
		if ( $entry['function'] === '{closure}' ) {
			continue;
		}

		$method = $entry['class'] . ':' . $entry['function'];
		break;
	}

	return $method;
}

/**
 * Make an array whether you've got a string or array
 * @param string|array $value
 * @return array
 */
function wfReturnArray( $value ) {
	if ( !is_array( $value ) ) {
		$value = [ $value ];
	}
	return $value;
}

/**
 * Get unique array (case insensitive). This works because array_unique preserves
 * the numeric array indices and then array_intersect_key compares these indices
 * and not the values themselves. Implemention could probably be improved.
 * @param array $arr
 * @return array $unique
 */
function wfGetUniqueArrayCI( array $arr ) {
	$lower = array_map( 'strtolower', $arr );
	$unique = array_intersect_key( $arr, array_unique( $lower ) );
	return array_filter( $unique );
}

/**
 * Like pathinfo but with support for multibyte - copied from http://php.net/manual/en/function.pathinfo.php#107461
 */
function mb_pathinfo( $filepath ) {
	preg_match( '%^(.*?)[\\\\/]*(([^/\\\\]*?)(\.([^\.\\\\/]+?)|))[\\\\/\.]*$%im', $filepath, $m );
	$ret = [];
	if ( $m[1] ) {
		$ret['dirname'] = $m[1];
	}
	if ( $m[2] ) {
		$ret['basename'] = $m[2];
	}
	if ( $m[5] ) {
		$ret['extension'] = $m[5];
	}
	if ( $m[3] ) {
		$ret['filename'] = $m[3];
	}
	return $ret;
}

// Selectively allow cross-site AJAX

/**
 * Helper function to convert wildcard string into a regex
 * '*' => '.*?'
 * '?' => '.'
 *
 * @param $search string
 * @return string
 */
function convertWildcard( $search ) {
	$search = preg_quote( $search, '/' );
	$search = str_replace(
		array( '\*', '\?' ),
		array( '.*?', '.' ),
		$search
	);
	return "/$search/";
}

/**
 * Moved core code from api.php to be available in wikia.php
 *
 * @see PLATFORM-1790
 * @author macbre
 */
function wfHandleCrossSiteAJAXdomain() {
	global $wgCrossSiteAJAXdomains, $wgCrossSiteAJAXdomainExceptions;

	if ( $wgCrossSiteAJAXdomains && isset( $_SERVER['HTTP_ORIGIN'] ) ) {
		$exceptions = array_map( 'convertWildcard', $wgCrossSiteAJAXdomainExceptions );
		$regexes = array_map( 'convertWildcard', $wgCrossSiteAJAXdomains );
		foreach ( $regexes as $regex ) {
			if ( preg_match( $regex, $_SERVER['HTTP_ORIGIN'] ) ) {
				foreach ( $exceptions as $exc ) { // Check against exceptions
					if ( preg_match( $exc, $_SERVER['HTTP_ORIGIN'] ) ) {
						break 2;
					}
				}
				header( "Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}" );
				header( 'Access-Control-Allow-Credentials: true' );
				break;
			}
		}
	}
}

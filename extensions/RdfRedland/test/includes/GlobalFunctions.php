<?php
if (!defined('MEDIAWIKI')) die();

require_once( 'includes/ContLang.php' );
require_once( 'includes/MockDatabase.php' );

/**
 * Converts an Accept-* header into an array mapping string values to quality
 * factors
 */
function wfAcceptToPrefs( $accept, $def = '*/*' ) {
	# No arg means accept anything (per HTTP spec)
	if( !$accept ) {
		return array( $def => 1 );
	}

	$prefs = array();

	$parts = explode( ',', $accept );

	foreach( $parts as $part ) {
		$part = trim( $part );
		# FIXME: doesn't deal with params like 'text/html; level=1'
		@list( $value, $qpart ) = explode( ';', $part );
		if( !isset( $qpart ) ) {
			$prefs[$value] = 1;
		} elseif( preg_match( '/q\s*=\s*(\d*\.\d+)/', $qpart, $match ) ) {
			$prefs[$value] = $match[1];
		}
	}

	return $prefs;
}

/**
 * This function takes two arrays as input, and returns a CGI-style string, e.g.
 * "days=7&limit=100". Options in the first array override options in the second.
 * Options set to "" will not be output.
 */
function wfArrayToCGI( $array1, $array2 = NULL )
{
	if ( !is_null( $array2 ) ) {
		$array1 = $array1 + $array2;
	}

	$cgi = '';
	foreach ( $array1 as $key => $value ) {
		if ( '' !== $value ) {
			if ( '' != $cgi ) {
				$cgi .= '&';
			}
			$cgi .= urlencode( $key ) . '=' . urlencode( $value );
		}
	}
	return $cgi;
}

/**
 * Get a message from anywhere, for the current user language.
 *
 * Use wfMsgForContent() instead if the message should NOT
 * change depending on the user preferences.
 *
 * Note that the message may contain HTML, and is therefore
 * not safe for insertion anywhere. Some functions such as
 * addWikiText will do the escaping for you. Use wfMsgHtml()
 * if you need an escaped message.
 *
 * @param $key String: lookup key for the message, usually
 *    defined in languages/Language.php
 */
function wfMsg( $key ) {
	$args = func_get_args();
	array_shift( $args );
	return wfMsgReal( $key, $args, true );
}

/**
 * @todo document
 */
function wfShowingResults( $offset, $limit ) {
	global $wgLang;
	return wfMsg( 'showingresults', $wgLang->formatNum( $limit ), $wgLang->formatNum( $offset+1 ) );
}

/**
 * @param mixed $outputtype A timestamp in one of the supported formats, the
 *                          function will autodetect which format is supplied
 *                          and act accordingly.
 * @return string Time in the format specified in $outputtype
 */
function wfTimestamp($outputtype=TS_UNIX,$ts=0) {
	$uts = 0;
	$da = array();
	if ($ts==0) {
		$uts=time();
	} elseif (preg_match("/^(\d{4})\-(\d\d)\-(\d\d) (\d\d):(\d\d):(\d\d)$/D",$ts,$da)) {
		# TS_DB
		$uts=gmmktime((int)$da[4],(int)$da[5],(int)$da[6],
			    (int)$da[2],(int)$da[3],(int)$da[1]);
	} elseif (preg_match("/^(\d{4}):(\d\d):(\d\d) (\d\d):(\d\d):(\d\d)$/D",$ts,$da)) {
		# TS_EXIF
		$uts=gmmktime((int)$da[4],(int)$da[5],(int)$da[6],
			(int)$da[2],(int)$da[3],(int)$da[1]);
	} elseif (preg_match("/^(\d{4})(\d\d)(\d\d)(\d\d)(\d\d)(\d\d)$/D",$ts,$da)) {
		# TS_MW
		$uts=gmmktime((int)$da[4],(int)$da[5],(int)$da[6],
			    (int)$da[2],(int)$da[3],(int)$da[1]);
	} elseif (preg_match("/^(\d{1,13})$/D",$ts,$datearray)) {
		# TS_UNIX
		$uts = $ts;
	} elseif (preg_match('/^(\d{1,2})-(...)-(\d\d(\d\d)?) (\d\d)\.(\d\d)\.(\d\d)/', $ts, $da)) {
		# TS_ORACLE
		$uts = strtotime(preg_replace('/(\d\d)\.(\d\d)\.(\d\d)(\.(\d+))?/', "$1:$2:$3",
				str_replace("+00:00", "UTC", $ts)));
	} elseif (preg_match('/^(\d{4})-(\d{2})-(\d{2})T(\d{2}):(\d{2}):(\d{2})Z$/', $ts, $da)) {
		# TS_ISO_8601
		$uts=gmmktime((int)$da[4],(int)$da[5],(int)$da[6],
			(int)$da[2],(int)$da[3],(int)$da[1]);
	} elseif (preg_match("/^(\d{4})\-(\d\d)\-(\d\d) (\d\d):(\d\d):(\d\d)[\+\- ](\d\d)$/",$ts,$da)) {
		# TS_POSTGRES
		$uts=gmmktime((int)$da[4],(int)$da[5],(int)$da[6],
		(int)$da[2],(int)$da[3],(int)$da[1]);
	} else {
		# Bogus value; fall back to the epoch...
		wfDebug("wfTimestamp() fed bogus time value: $outputtype; $ts\n");
		$uts = 0;
	}

	switch($outputtype) {
		case TS_UNIX:
			return $uts;
		case TS_MW:
			return gmdate( 'YmdHis', $uts );
		case TS_DB:
			return gmdate( 'Y-m-d H:i:s', $uts );
		case TS_ISO_8601:
			return gmdate( 'Y-m-d\TH:i:s\Z', $uts );
		// This shouldn't ever be used, but is included for completeness
		case TS_EXIF:
			return gmdate(  'Y:m:d H:i:s', $uts );
		case TS_RFC2822:
			return gmdate( 'D, d M Y H:i:s', $uts ) . ' GMT';
		case TS_ORACLE:
			return gmdate( 'd-M-y h.i.s A', $uts) . ' +00:00';
		case TS_POSTGRES:
			return gmdate( 'Y-m-d H:i:s', $uts) . ' GMT';
		default:
			throw new MWException( 'wfTimestamp() called with illegal output type.');
	}
}

/**
 * @todo document
 */
function wfViewPrevNext( $offset, $limit, $link, $query = '', $atend = false ) {
	global $wgLang;
	$fmtLimit = $wgLang->formatNum( $limit );
	$prev = wfMsg( 'prevn', $fmtLimit );
	$next = wfMsg( 'nextn', $fmtLimit );

	if( is_object( $link ) ) {
		$title =& $link;
	} else {
		$title = Title::newFromText( $link );
		if( is_null( $title ) ) {
			return false;
		}
	}

	if ( 0 != $offset ) {
		$po = $offset - $limit;
		if ( $po < 0 ) { $po = 0; }
		$q = "limit={$limit}&offset={$po}";
		if ( '' != $query ) { $q .= '&'.$query; }
		$plink = '<a href="' . $title->escapeLocalUrl( $q ) . "\">{$prev}</a>";
	} else { $plink = $prev; }

	$no = $offset + $limit;
	$q = 'limit='.$limit.'&offset='.$no;
	if ( '' != $query ) { $q .= '&'.$query; }

	if ( $atend ) {
		$nlink = $next;
	} else {
		$nlink = '<a href="' . $title->escapeLocalUrl( $q ) . "\">{$next}</a>";
	}
	$nums = wfNumLink( $offset, 20, $title, $query ) . ' | ' .
		wfNumLink( $offset, 50, $title, $query ) . ' | ' .
		wfNumLink( $offset, 100, $title, $query ) . ' | ' .
		wfNumLink( $offset, 250, $title, $query ) . ' | ' .
		wfNumLink( $offset, 500, $title, $query );

	return wfMsg( 'viewprevnext', $plink, $nlink, $nums );
}

/**
 * Returns the 'best' match between a client's requested internet media types
 * and the server's list of available types. Each list should be an associative
 * array of type to preference (preference is a float between 0.0 and 1.0).
 * Wildcards in the types are acceptable.
 *
 * @param array $cprefs Client's acceptable type list
 * @param array $sprefs Server's offered types
 * @return string
 *
 * @todo FIXME: doesn't handle params like 'text/plain; charset=UTF-8'
 * XXX: generalize to negotiate other stuff
 */
function wfNegotiateType( $cprefs, $sprefs ) {
	$combine = array();

	foreach( array_keys($sprefs) as $type ) {
		$parts = explode( '/', $type );
		if( $parts[1] != '*' ) {
			$ckey = mimeTypeMatch( $type, $cprefs );
			if( $ckey ) {
				$combine[$type] = $sprefs[$type] * $cprefs[$ckey];
			}
		}
	}

	foreach( array_keys( $cprefs ) as $type ) {
		$parts = explode( '/', $type );
		if( $parts[1] != '*' && !array_key_exists( $type, $sprefs ) ) {
			$skey = mimeTypeMatch( $type, $sprefs );
			if( $skey ) {
				$combine[$type] = $sprefs[$skey] * $cprefs[$type];
			}
		}
	}

	$bestq = 0;
	$besttype = NULL;

	foreach( array_keys( $combine ) as $type ) {
		if( $combine[$type] > $bestq ) {
			$besttype = $type;
			$bestq = $combine[$type];
		}
	}

	return $besttype;
}

/**
 * Checks if a given MIME type matches any of the keys in the given
 * array. Basic wildcards are accepted in the array keys.
 *
 * Returns the matching MIME type (or wildcard) if a match, otherwise
 * NULL if no match.
 *
 * @param string $type
 * @param array $avail
 * @return string
 * @private
 */
function mimeTypeMatch( $type, $avail ) {
	if( array_key_exists($type, $avail) ) {
		return $type;
	} else {
		$parts = explode( '/', $type );
		if( array_key_exists( $parts[0] . '/*', $avail ) ) {
			return $parts[0] . '/*';
		} elseif( array_key_exists( '*/*', $avail ) ) {
			return '*/*';
		} else {
			return NULL;
		}
	}
}

/**
 * Provide a simple HTTP error.
 */
function wfHttpError( $code, $label, $desc ) {
    throw new Exception( "$code: $label, $desc" );
}

/**
 * Really get a message
 * @return $key String: key to get.
 * @return $args
 * @return $useDB Boolean
 * @return String: the requested message.
 */
function wfMsgReal( $key, $args, $useDB = true, $forContent=false, $transform = true ) {
	$fname = 'wfMsgReal';

	$message = wfMsgGetKey( $key, $useDB, $forContent, $transform );
	$message = wfMsgReplaceArgs( $message, $args );
	return $message;
}

/**
 * Fetch a message string value, but don't replace any keys yet.
 * @param string $key
 * @param bool $useDB
 * @param bool $forContent
 * @return string
 * @private
 */
function wfMsgGetKey( $key, $useDB, $forContent = false, $transform = true ) {
	global $wgParser, $wgContLang, $wgMessageCache, $wgLang;

	if ( is_object( $wgMessageCache ) )
		$transstat = $wgMessageCache->getTransform();

	if( is_object( $wgMessageCache ) ) {
		if ( ! $transform )
			$wgMessageCache->disableTransform();
		$message = $wgMessageCache->get( $key, $useDB, $forContent );
	} else {
		if( $forContent ) {
			$lang = &$wgContLang;
		} else {
			$lang = &$wgLang;
		}

		wfSuppressWarnings();

		if( is_object( $lang ) ) {
			$message = $lang->getMessage( $key );
		} else {
			$message = false;
		}
		wfRestoreWarnings();
		if($message === false)
			$message = Language::getMessage($key);
		if ( $transform && strstr( $message, '{{' ) !== false ) {
			$message = $wgParser->transformMsg($message, $wgMessageCache->getParserOptions() );
		}
	}

	if ( is_object( $wgMessageCache ) && ! $transform )
		$wgMessageCache->setTransform( $transstat );

	return $message;
}

/**
 * Reference-counted warning suppression
 */
function wfSuppressWarnings( $end = false ) {
	static $suppressCount = 0;
	static $originalLevel = false;

	if ( $end ) {
		if ( $suppressCount ) {
			--$suppressCount;
			if ( !$suppressCount ) {
				error_reporting( $originalLevel );
			}
		}
	} else {
		if ( !$suppressCount ) {
			$originalLevel = error_reporting( E_ALL & ~( E_WARNING | E_NOTICE ) );
		}
		++$suppressCount;
	}
}

/**
 * Restore error level to previous value
 */
function wfRestoreWarnings() {
	wfSuppressWarnings( true );
}

/**
 * Replace message parameter keys on the given formatted output.
 *
 * @param string $message
 * @param array $args
 * @return string
 * @private
 */
function wfMsgReplaceArgs( $message, $args ) {
	# Fix windows line-endings
	# Some messages are split with explode("\n", $msg)
	$message = str_replace( "\r", '', $message );

	// Replace arguments
	if ( count( $args ) ) {
		if ( is_array( $args[0] ) ) {
			foreach ( $args[0] as $key => $val ) {
				$message = str_replace( '$' . $key, $val, $message );
			}
		} else {
			foreach( $args as $n => $param ) {
				$replacementKeys['$' . ($n + 1)] = $param;
			}
			$message = strtr( $message, $replacementKeys );
		}
	}

	return $message;
}

function wfGetDB ( $type ) {
	return new TotallyFakeDatabase();
}

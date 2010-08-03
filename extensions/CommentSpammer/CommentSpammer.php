<?php

/**
 * Experimental DNS blacklist extension for rejecting edits
 * from suspected comment spammers.
 *
 * @author Nick Jenkins <nickpj At-The-Host-Called gmail.com>, http://nickj.org/
 * @license GPL v2
 * @addtogroup Extensions
 */

if ( ! defined( 'MEDIAWIKI' ) ) {
	die( 'This is only valid as a MediaWiki extension' );
}

$wgExtensionFunctions[] = 'efCommentSpammer';
$wgExtensionCredits['other'][] = array(
	'name' => 'CommentSpammer',
	'svn-date' => '$LastChangedDate: 2009-01-25 13:24:02 +0100 (ndz, 25 sty 2009) $',
	'svn-revision' => '$LastChangedRevision: 46195 $',
	'author' => 'Nick Jenkins',
	'url' => 'http://www.mediawiki.org/wiki/Extension:CommentSpammer',
	'description' => 'Rejects edits from suspected comment spammers on a DNS blacklist.',
	'descriptionmsg' => 'commentspammer-desc',
);

$dir = dirname(__FILE__) . '/';
$wgExtensionMessagesFiles['CommentSpammer'] = $dir . 'CommentSpammer.i18n.php';

function efCommentSpammer() {
	wfLoadExtensionMessages( 'CommentSpammer' );
}

/**
 * Add the hook on which we trigger.
 */
$wgHooks['EditFilter'][]      = 'HoneyPotCommentSpammer::commentSpammerHook';

/**
 * Another log type, 'cSpammer', is added, if logging has been enabled, and appropriate
 * message arrays are updated so that the UI works as expected.
 */
if( isset( $wgCommentSpammerLog )
   && ( isset( $wgCommentSpammerLog['allowed'] ) && $wgCommentSpammerLog['allowed'] ) ||
      ( isset( $wgCommentSpammerLog['denied']  ) && $wgCommentSpammerLog['denied']  ) ) {
	$wgLogTypes[] = 'cSpammer';
	$wgLogHeaders['cSpammer'] = 'cspammerlogpagetext';
	$wgLogNames['cSpammer'] = 'cspammer-log-page';
	$wgHooks['LogLine'][] = 'HoneyPotCommentSpammer::showLogLine';
}

/**
 * The reason I selected honeypot rather than another black list for this is that for the last 20 spam
 * comments that got through on my wiki, they were all listed as "comments spammers" on honeypot in
 * the first 10 Google hits for those IP addresses.
 */
class HoneyPotCommentSpammer {

	/**
	 * Class constants that relate to: http://www.projecthoneypot.org/httpbl_api.php
	 */
	const HONEY_POT_DNSBL      = 'dnsbl.httpbl.org';
	const HONEY_POT_NO_ERROR   = 127; // The "everything is a-okay" response code that we want to see.
	const MAX_STALENESS        = 14;  // Number of days since this IP last spammed before we forgive.
	const MIN_THREAT_LEVEL     = 5;   // How naughty have they been? 0 = not naughty, 255 = Satan incarnate.
	const COMMENT_SPAMMER_CODE = 4;   // The code for a comment spammer.

	/**
	 * Determines whether the specified IP address corresponds to a known active comment spammer.
	 * @param string $ip_addr A IP address string like '87.101.244.10'
	 * @return boolean True for spammer, false for non-spammer or if get unexpected results.
	 */
	public static function isCommentSpammer( $ip_addr = null ) {
		// logged in users are assumed to not be comment spammers.
		global $wgUser;
		if( ! $wgUser->isAnon() ) {
			//wfDebug( __METHOD__ . ": Assuming not spammer as logged in.\n" );
			return false;
		}

		// check whether this is a known comment spammer.
		if( empty( $ip_addr ) ) $ip_addr = wfGetIp();

		$results = self::getDnsResults( $ip_addr );

		$params = array( $ip_addr );
		$is_spammer = self::resultsSaySpammer( $results, $params );
		wfDebug( __METHOD__ . ": DNS says $ip_addr is " . ($is_spammer ? '' : 'NOT ' ) . "a spammer.\n" );

		// We record a diagnostic log in here, that will appear in Special:Log
		// For high-volume or mid-volume sites, this should be commented out.
		self::addLogEntry( $is_spammer, $params );

		return $is_spammer;
	}

	/**
	 * Add a record of the DNSBL results to the Wiki's log. Only suitable for small sites that want debugging info.
	 * @todo Ideally there might a way to add a hook so that an extension could specify how to display its own log
	 * line (e.g. using the 'log_params' field) in SpecialLog::logLine, but as a close-enough substitute we
	 * can just put everything into the log_comment field.
	 * @param boolean $is_spammer
	 * @param array $params
	 */
	private static function addLogEntry( $is_spammer, $params ) {
		global $wgTitle, $wgCommentSpammerLog;

		$log_action = $is_spammer ? 'denied' : 'allowed';

		// don't log unless we were explicitly asked to.
		if( !isset( $wgCommentSpammerLog[$log_action] ) || !$wgCommentSpammerLog[$log_action] ) return;

		$dbw = wfGetDB( DB_MASTER );
		$data = array(
	                'log_type'      => 'cSpammer' ,
	                'log_action'    => $log_action,
	                'log_timestamp' => $dbw->timestamp( wfTimestampNow() ),
	                'log_user'      => User::idFromName( 'MediaWiki default' ),  // recording log as coming from 'MediaWiki default', not sure if this makes sense or not.
	                'log_namespace' => $wgTitle->getNamespace(),
	                'log_title'     => $wgTitle->getDBkey(),
	                'log_params'    => implode( ', ', $params )
                );
		$dbw->insert( 'logging', $data, __METHOD__ );
	}

	/**
	 * Helps displays a single CommentSpammer formatted line in Special:Log
	 * @param string $type
	 * @param string $action (param not used)
	 * @param Title $title
	 * @param array $paramArray
	 * @param string $comment
	 */
	public static function showLogLine( $type, $action, $title, $paramArray, &$comment ) {
		if( $type != 'cSpammer' ) return true;
		if( !is_array( $paramArray ) ) return false;
		if( !isset( $paramArray[0] ) ) return false;
		$params = explode(", ", $paramArray[0] );

		$page = $title->getPrefixedText();

		if( count( $params ) >= 4 ) {
			list( $ip_addr, $last_spam, $threat_level, $offence_code) = $params;
			$comment = wfMsgExt( 'commentspammer-log-msg'     , array( 'parseinline' ), $ip_addr, $page )
				. wfMsg( 'word_separator' )
				. wfMsgExt( 'commentspammer-log-msg-info', array( 'parseinline' ), $last_spam, $threat_level, $offence_code, $ip_addr );
		} elseif( count( $params ) == 1 ) {
			$ip_addr = $params[0];
			$comment = wfMsgExt( 'commentspammer-log-msg',      array( 'parseinline' ), $ip_addr, $page );
		} else {
			return false;
		}

		return true;
	}

	/**
	 * Determines whether the specified IP address corresponds to a known active comment spammer, and if
	 * so denies the edit and outputs a message to this effect.
	 * // @param EditPage $editPage EditPage object for page modification.
	 * // @param string $textbox The text the user submitted. (param not used)
	 * // @param string $section The section the user modified. (param not used)
	 * // @param string $hookError Return value for error about why the edit was rejected, if applicable. (param not used)
	 * @return boolean True for allowing the edit, false for denying the edit.
	 */
	public static function commentSpammerHook( /* $editPage = null, $textbox = '', $section = '', & $hookError = '' */ ) {
		$spammer = self::isCommentSpammer( );
		if( $spammer ) {
			global $wgOut;
			$wgOut->addWikiText( wfMsg( 'commentspammer-save-blocked' ) );
		}
		return ! $spammer;  // need to invert, as true hook retval means "no problem", whereas if $spammer == true, then we have a problem.
	}

	/**
	 * Gets the blacklist DNS response for the specified IP address.
	 * @param string $ip_addr A IP address string like '87.101.244.10'
	 * @return array DNS data as an array.
	 */
	private static function getDnsResults( $ip_addr ) {
		global $wgHoneyPotKey;

		// reverse the IP address
		$reverse_array = explode( '.', $ip_addr );
		krsort( $reverse_array );
		$reverse_ip_addr = implode( '.', $reverse_array );

		// honey_pot_record = key + '.' + reversed ip address + '.' + honey pot dnsbl
		$honey_pot_record = $wgHoneyPotKey . '.' . $reverse_ip_addr . '.' . self::HONEY_POT_DNSBL;

		//wfDebug( __METHOD__ . ": honey_pot_record: $honey_pot_record\n" );
		$result = dns_get_record( $honey_pot_record, DNS_A );
		return $result;
	}

	/**
	 * Determines whether the DNS results indicate a spammer or not.
	 * @param array $result DNS data as an array.
	 * @param array $params Return array built with the response values from the DNS result.
	 * @return boolean  True for spammer, false for non-spammer, or if get unexpected results.
	 */
	private static function resultsSaySpammer( $result, & $params ) {
		//wfDebug( __METHOD__ . ": Entering\n" );
		// if there was anything wrong with the data we got, assume they're
		// not a spammer.
		if( ! is_array( $result ) ) return false;
		//wfDebug( __METHOD__ . ": Data was array\n" );

		// if not properly formed, assume they're not a spammer.
		if( ! isset( $result[0]       ) ) return false;
		if( ! isset( $result[0]['ip'] ) ) return false;

		//wfDebug( __METHOD__ . ": Data looks well-formed\n" );
		// the result code is in the ip address we got back.
		$honey_pot_code = $result[0]['ip'];
		$parts = explode( '.', $honey_pot_code );

		// if not properly formed IPv4 address, assume they're not a spammer.
		if( count( $parts ) != 4 ) return false;
		//wfDebug( __METHOD__ . ": Looks like an IPv4 address.\n" );
		list( $first, $second, $third, $fourth ) = $parts;
		$params[] = $second;
		$params[] = $third;
		$params[] = $fourth;

		// if we got an error response, assume they're not a spammer.
		if( $first != self::HONEY_POT_NO_ERROR ) return false;
		//wfDebug( __METHOD__ . ": Did not get an error response: $first\n" );

		// if they have mended or abstained from their wicked spammy ways, then forgive.
		if( $second >= self::MAX_STALENESS ) return false;
		//wfDebug( __METHOD__ . ": Have not abstained from their spammy ways: $second\n" );

		// if they are not really a threat, then forgive.
		if( $third <= self::MIN_THREAT_LEVEL ) return false;
		//wfDebug( __METHOD__ . ": Looks like a threat: $third. Offence code: $fourth\n" );
		// if they are not a comment spammer, then forgive.
		return $fourth & self::COMMENT_SPAMMER_CODE;

		// Q: If they are a spammer, should we sleep here for 10 seconds, to slow them down,
		// like a tar pit? ... Or maybe we should just drop the connection, without notifying
		// them ... must be something *legal* that we can do here that wastes their time and
		// slows them down and generally increases their costs, like when a telemarketer calls,
		// and you say "be right with you!" and then put them on indefinite hold and every few
		// minutes say "nearly there", **long pause** "almost done", **long pause** "don't go away",
		// **long pause** "I really want to hear this" **long pause**, etc ...
	}
}

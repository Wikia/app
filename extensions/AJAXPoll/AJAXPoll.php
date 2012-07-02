<?php
/**
 * AJAX Poll extension for MediaWiki
 * Created by Dariusz Siedlecki, based on the work by Eric David.
 * Licensed under the GFDL.
 *
 * <poll>
 * [Option]
 * Question
 * Answer 1
 * Answer 2
 * ...
 * Answer n
 * </poll>
 *
 * @file
 * @ingroup Extensions
 * @author Dariusz Siedlecki <datrio@gmail.com>
 * @author Jack Phoenix <jack@countervandalism.net>
 * @version 1.4.1
 * @link http://www.mediawiki.org/wiki/Extension:AJAX_Poll Documentation
 */

if( !defined( 'MEDIAWIKI' ) ) {
	die( "This is not a valid entry point.\n" );
}

// Extension credits that will show up on Special:Version
$wgExtensionCredits['parserhook'][] = array(
	'name' => 'AJAX Poll',
	'version' => '1.4.1',
	'author' => array( 'Dariusz Siedlecki', 'Jack Phoenix' ),
	'description' => 'Allows AJAX-based polls with <tt>&lt;poll&gt;</tt> tag',
	'url' => 'https://www.mediawiki.org/wiki/Extension:AJAX_Poll'
);

// Internationalization + AJAX function
$dir = dirname( __FILE__ ) . '/';
$wgExtensionMessagesFiles['AJAXPoll'] = $dir . 'AJAXPoll.i18n.php';
$wgAjaxExportList[] = 'submitVote';

$wgHooks['ParserFirstCallInit'][] = 'wfPoll';

/**
 * Register <poll> tag with the parser
 *
 * @param $parser Object: instance of Parser (not necessarily $wgParser)
 * @return Boolean: true
 */
function wfPoll( &$parser ) {
	$parser->setHook( 'poll', 'renderPoll' );
	return true;
}

# The callback function for converting the input text to HTML output
function renderPoll( $input ) {
	global $wgParser, $wgUser, $wgOut, $wgTitle, $wgScriptPath;

	$wgParser->disableCache();

	if ( $wgUser->getName() == '' ) {
		$user = wfGetIP();
	} else {
		$user = $wgUser->getName();
	}

	// ID of the poll
	$ID = strtoupper( md5( $input ) );

	$par = new Parser();
	$input = $par->parse( $input, $wgTitle, $wgOut->parserOptions() );
	$input = trim( strip_tags( $input->getText() ) );
	$lines = explode( "\n", trim( $input ) );

	// Deprecating AJAX
	/*if ( isset( $_POST['p_id'] ) && isset( $_POST['p_answer'] ) && $_POST['p_id'] == $ID ) {
		submitVote( $_POST['p_id'], intval( $_POST['p_answer'] ) );
	}*/

	$dbw = wfGetDB( DB_MASTER );
	$dbw->begin();
	/**
	 * Register poll in the database
	 */
	$row = $dbw->selectRow(
		array( 'poll_info' ),
		array( 'COUNT(poll_id) AS count' ),
		array( 'poll_id' => $ID ),
		__METHOD__
	);

	if( empty( $row->count ) ) {
		$dbw->insert(
			'poll_info',
			array(
				'poll_id' => $ID,
				'poll_txt' => $input,
				'poll_date' => wfTimestampNow(),
				'poll_title' => $wgParser->mTitle->getText()
			),
			__METHOD__
		);
	}
	$dbw->commit();

	// Add CSS
	$wgOut->addExtensionStyle( $wgScriptPath . '/extensions/AJAXPoll/AJAXPoll.css' );
	switch( $lines[0] ) {
		case 'STATS':
			$retVal = buildStats( $ID, $user );
			break;
		default:
			$retVal = '<div id="pollContainer' . $ID . '">' .
				buildHTML( $ID, $user, $lines ) .
				'</div>';
			break;
	}
	return $retVal;
}

function buildStats( $ID, $user ) {
	$dbw = wfGetDB( DB_MASTER );

	$res = $dbw->select(
		'poll_vote',
		array(
			'COUNT(*)',
			'COUNT(DISTINCT poll_id)',
			'COUNT(DISTINCT poll_user)',
			'TIMEDIFF(NOW(), MAX(poll_date))'
		),
		array(),
		__METHOD__
	);
	$tab = $dbw->fetchRow( $res );

	$clock = explode( ':', $tab[3] );

	if ( $clock[0] == '00' && $clock[1] == '00' ) {
		$x = $clock[2];
		$y = 'second';
	} elseif( $clock[0] == '00' ) {
		$x = $clock[1];
		$y = 'minute';
	} else {
		if ( $clock[0] < 24 ) {
			$x = $clock[0];
			$y = 'hour';
		} else {
			$x = floor( $hr / 24 );
			$y = 'day';
		}
	}

	$clockago = $x . ' ' . $y . ( $x > 1 ? 's' : '' );

	$res = $dbw->select(
		'poll_vote',
		'COUNT(*)',
		array( 'DATE_SUB(CURDATE(), INTERVAL 2 DAY) <= poll_date' ),
		__METHOD__
	);
	$tab2 = $dbw->fetchRow( $res );

	return "There are $tab[1] polls and $tab[0] votes given by $tab[2] different people.<br />The last vote has been given $clockago ago.<br/>During the last 48 hours, $tab2[0] votes have been given.";
}

function submitVote( $ID, $answer ) {
	global $wgUser;

	$dbw = wfGetDB( DB_MASTER );

	if ( $wgUser->getName() == '' ) {
		$user = wfGetIP();
	} else {
		$user = $wgUser->getName();
	}

	if ( $wgUser->isAllowed( 'bot' ) ) {
		return buildHTML( $ID, $user );
	}

	$answer = $dbw->strencode( ++$answer );

	$q = $dbw->select(
		'poll_vote',
		'COUNT(*) AS c',
		array(
			'poll_id' => $ID,
			'poll_user' => $dbw->addQuotes( $user )
		),
		__METHOD__
	);
	$r = $dbw->fetchRow( $q );

	if ( $r['c'] > 0 ) {
		$updateQuery = $dbw->update(
			'poll_vote',
			array(
				"poll_answer='{$answer}'",
				'poll_date' => wfTimestampNow()
			),
			array(
				'poll_id' => $ID,
				'poll_user' => $dbw->addQuotes( $user )
			),
			__METHOD__
		);
		$dbw->commit();
		if ( $updateQuery ) {
			return buildHTML( $ID, $user, '', 'poll-vote-update' );
		} else {
			return buildHTML( $ID, $user, '', 'poll-vote-error' );
		}
	} else {
		$insertQuery = $dbw->insert(
			'poll_vote',
			array(
				'poll_id' => $ID,
				'poll_user' => $dbw->addQuotes( $user ),
				'poll_ip' => wfGetIP(),
				'poll_answer' => $answer,
				'poll_date' => wfTimestampNow()
			),
			__METHOD__
		);
		$dbw->commit();
		if ( $insertQuery ) {
			return buildHTML( $ID, $user, '', 'poll-vote-add' );
		} else {
			return buildHTML( $ID, $user, '', 'poll-vote-error' );
		}
	}
}

function buildHTML( $ID, $user, $lines = '', $extra_from_ajax = '' ) {
	global $wgTitle, $wgLang, $wgUseAjax;

	$dbw = wfGetDB( DB_SLAVE );

	$q = $dbw->select(
		'poll_info',
		array( 'poll_txt', 'poll_date' ),
		array( 'poll_id' => $ID ),
		__METHOD__
	);
	$r = $dbw->fetchRow( $q );

	if ( empty( $lines ) ) {
		$lines = explode( "\n", trim( $r['poll_txt'] ) );
	}

	$start_date = $r['poll_date'];

	$q = $dbw->select(
		'poll_vote',
		array( 'poll_answer', 'COUNT(*)' ),
		array( 'poll_id' => $ID ),
		__METHOD__,
		array( 'GROUP BY' => 'poll_answer' )
	);

	$poll_result = array();

	while ( $r = $q->fetchRow() ) {
		$poll_result[$r[0]] = $r[1];
	}

	$amountOfVotes = array_sum( $poll_result );

	// Did we vote?
	$q = $dbw->select(
		'poll_vote',
		array( 'poll_answer', 'poll_date' ),
		array(
			'poll_id' => $ID,
			'poll_user' => $dbw->addQuotes( $user )
		),
		__METHOD__
	);

	if ( $r = $dbw->fetchRow( $q ) ) {
		$tmp_date = wfMsg(
			'poll-your-vote',
			$lines[$r[0] - 1],
			$wgLang->timeanddate( wfTimestamp( TS_MW, $r[1] ), true /* adjust? */ )
		);
	}

	if ( is_object( $wgTitle ) ) {
		if( !empty( $extra_from_ajax ) ) {
			$additionalAttributes = ' style="display: block;"';
			$message = wfMsg( $extra_from_ajax );
		} else {
			$additionalAttributes = '';
			$message = '';
		}
		// HTML output has to be on one line thanks to a MediaWiki bug
		// @see https://bugzilla.wikimedia.org/show_bug.cgi?id=1319
		$ret = '<div id="pollId' . $ID . '" class="poll"><div class="pollAjax" id="pollAjax' . $ID . '"' .
			$additionalAttributes . '>' . $message .
			'</div><div class="pollQuestion">' . strip_tags( $lines[0] ) . '</div>';

		// Different message depending on if the user has already voted or not.
		if ( isset( $r[0] ) ) {
			$ret .= '<div class="pollMisc">' . $tmp_date . '</div>';
		} else {
			$ret .= '<div class="pollMisc">' . wfMsg( 'poll-no-vote' ) . '</div>';
		}

		$ret .= '<form method="post" action="' . $wgTitle->getLocalURL() .
			'" id="pollIdAnswer' . $ID . '"><input type="hidden" name="p_id" value="' . $ID . '" />';

		for ( $i = 1; $i < count( $lines ); $i++ ) {
			$ans_no = $i - 1;

			if ( $amountOfVotes == 0 ) {
				$percent = 0;
			} else {
				$percent = $wgLang->formatNum( round( ( isset( $poll_result[$i + 1] ) ? $poll_result[$i + 1] : 0 ) * 100 / $amountOfVotes, 2 ) );
			}

			if ( isset( $r[0] ) && $r[0] == $i ) {
				$our = true;
			} else {
				$our = false;
			}

			// If AJAX is enabled, as it is by default in modern MWs, we can
			// just use sajax library function here for that AJAX-y feel.
			// If not, we'll have to submit the form old-school way...
			if ( $wgUseAjax ) {
				$submitJS = "sajax_do_call(\"submitVote\", [\"" . $ID . "\", \"" . $i . "\"], document.getElementById(\"pollContainer" . $ID . "\"));";
			} else {
				$submitJS = "document.getElementById(\"pollIdAnswer" . $ID . "\").submit();";
			}

			// HTML output has to be on one line thanks to a MediaWiki bug
			// @see https://bugzilla.wikimedia.org/show_bug.cgi?id=1319
			$ret .= "<div class='pollAnswer' id='pollAnswer" . $ans_no .
				"'><div class='pollAnswerName'><label for='pollAnswerRadio" .
				$ans_no . "' onclick='document.getElementById(\"pollAjax" .
				$ID . "\").innerHTML=\"" . wfMsg( 'poll-submitting' ) .
				"\"; document.getElementById(\"pollAjax" . $ID .
				"\").style.display=\"block\"; this.getElementsByTagName(\"input\")[0].checked = true; " .
				$submitJS . "'><input type='radio' id='p_answer" . $ans_no .
				"' name='p_answer' value='" . $i . "' />" .
				strip_tags( $lines[$i] ) .
				"</label></div> <div class='pollAnswerVotes" . ( $our ? ' ourVote' : '' ) .
				"' onmouseover='span=this.getElementsByTagName(\"span\")[0];tmpPollVar=span.innerHTML;span.innerHTML=span.title;span.title=\"\";' onmouseout='span=this.getElementsByTagName(\"span\")[0];span.title=span.innerHTML;span.innerHTML=tmpPollVar;'><span title='" .
				wfMsg( 'poll-percent-votes', sprintf( $percent ) ) . "'>" .
				( ( isset( $poll_result ) && !empty( $poll_result[$i + 1] ) ) ? $poll_result[$i + 1] : 0 ) .
				"</span><div style='width: " . $percent . "%;" . ( $percent == 0 ? ' border:0;' : '' ) . "'></div></div></div>";
		}

		$ret .= '</form>';

		// Display information about the poll (creation date, amount of votes)
		$tmp_date = wfMsgExt(
			'poll-info',
			'parsemag', // parse PLURAL
			$amountOfVotes, // amount of votes
			$wgLang->timeanddate( wfTimestamp( TS_MW, $start_date ), true /* adjust? */ )
		);

		$ret .= '<div id="pollInfo">' . $tmp_date . '</div>';

		$ret .= '</div>';
	} else {
		$ret = '';
	}

	return $ret;
}
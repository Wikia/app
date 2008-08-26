<?php

/*
	fetch phrases to block, and fill $wgSpamRegex with them, rather than scribble that into the variable at startup
*/

global $wgHooks;
/* initialize hook, FilterEdit is too far in code */
$wgHooks['AlternateEdit'][] = 'wfGetSpamRegex';
$wgHooks['EditFilter'][] = 'wfGetSummarySpamRegex';

function wfGetSpamRegex () {
	global $wgSpamRegex;
	if (!wfSimplifiedRegexCheckSharedDB())
		return true;

	/* get here only the phrases for blocking in textbox */
	$phrases = wfFetchSpamRegexData (SPAMREGEX_TEXTBOX);
	("" != $phrases) ? $wgSpamRegex =  "/".$phrases."/i" : $wgSpamRegex = false;
	return true;
}

function wfGetSummarySpamRegex ($editpage) {
	global $wgOut;
	if (!wfSimplifiedRegexCheckSharedDB())
		return true;

	$matches = array();
	/* here we get only the phrases for blocking in summaries... */
	$phrases = wfFetchSpamRegexData (SPAMREGEX_SUMMARY);
	("" != $phrases) ? $m_phrases =  "/".$phrases."/i" : $m_phrases = false;
	if ( $m_phrases && ($editpage->summary != '') && preg_match( $m_phrases, $editpage->summary, $matches ) ) {
		/*	...so let's rock with our custom spamPage to indicate that
			(since some phrases can be safely in the text and not in a summary
			and we do not want to confuse the good users, right?)
		*/
		$wgOut->setPageTitle( wfMsg( 'spamprotectiontitle' ) );
		$wgOut->setRobotPolicy( 'noindex,nofollow' );
		$wgOut->setArticleRelated( false );

		$wgOut->addWikiText( wfMsg( 'spamprotectiontext' ) );
		if ( $matches[0] ) {
			$wgOut->addWikiText( wfMsg( 'spamprotectionmatch', "<nowiki>{$matches[0]}</nowiki>" ) );
		}
		$wgOut->addWikiText ( wfMsg ('spamregex_summary') );

		$wgOut->returnToMain( false );

		return false;
	}
	return true;
}

function wfFetchSpamRegexData ($mode) {
	global $wgMemc, $wgUser, $wgSpamRegex, $wgSharedDB;

	$phrases = "" ;
	$first = true ;

	/* first, check if regex string is already stored in memcache */
	( $mode == SPAMREGEX_SUMMARY ) ? $key_clause = ":Summary" : $key_clause = ":Textbox";
	$key = "$wgSharedDB:spamRegexCore:spamRegex" . $key_clause;
	$cached = $wgMemc->get($key);
	if ( !$cached ) {
		/* fetch data from db, concatenate into one string, then fill cache */
		( $mode == SPAMREGEX_SUMMARY ) ? $clause = " WHERE spam_summary = 1" : $clause = " WHERE spam_textbox = 1";
		$dbr =& wfGetDB( DB_SLAVE );
		$query = "SELECT spam_text FROM " . wfSpamRegexGetTable() . $clause;
		$res = $dbr->query($query);
		while ( $row = $dbr->fetchObject( $res ) ) {
			$concat = $row->spam_text;
			if (!$first) {
				$phrases .= "|".$concat;
			} else {
				$phrases .= $concat;
				$first = false;
			}
		}
		$wgMemc->set($key, $phrases, 0);
		$dbr->freeResult($res);
	} else {
		/* take from cache */
		$phrases = $cached;
	}
	return $phrases;
}
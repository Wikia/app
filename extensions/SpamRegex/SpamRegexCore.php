<?php

/* 
	fetch phrases to block, and fill $wgSpamRegex with them, rather than scribble that into the variable at startup
*/

global $wgHooks;
/* initialize hook, FilterEdit is too far in code */
$wgHooks['EditFilter'][] = 'wfGetSummarySpamRegex' ;
$wgHooks['SpecialMovepageBeforeMove'][] = 'wfGetMoveSpamRegex' ;

function wfGetSummarySpamRegex ($editpage) {
	wfProfileIn( __METHOD__ );
	wfLoadExtensionMessages ('SpamRegex') ;
	global $wgOut, $wgTitle ;

	// here we get only the phrases for blocking in summaries...	
	$s_phrases = array () ;
	$s_phrases = wfFetchSpamRegexData (SPAMREGEX_SUMMARY) ;
	if ( $s_phrases && ($editpage->summary != '')) {
		//	...so let's rock with our custom spamPage to indicate that
		//	(since some phrases can be safely in the text and not in a summary
		//	and we do not want to confuse the good users, right?)
		
		foreach ($s_phrases as $s_phrase) {
			if (preg_match ($s_phrase, $editpage->summary, $s_matches)) {
				$wgOut->setPageTitle( wfMsg( 'spamprotectiontitle' ) );
				$wgOut->setRobotPolicy( 'noindex,nofollow' );
				$wgOut->setArticleRelated( false );

				$wgOut->addWikiText( wfMsg( 'spamprotectiontext' ) );
				$wgOut->addWikiText( wfMsg( 'spamprotectionmatch', "<nowiki>{$s_matches[0]}</nowiki>" ) );
				$wgOut->addWikiText ( wfMsg ('spamregex_summary') ) ; 

				$wgOut->returnToMain( false, $wgTitle );
				wfProfileOut( __METHOD__ );
				return false ;
			}
		}
	}

	$t_phrases = array () ;
	// and here we check for phrases within the text itself
	$t_phrases = wfFetchSpamRegexData (SPAMREGEX_TEXTBOX) ;
	if ($t_phrases && is_array($t_phrases)) {
		foreach ($t_phrases as $t_phrase) {
			if (preg_match ($t_phrase, $editpage->textbox1, $t_matches)) {
				$editpage->spamPage ($t_matches[0]) ;
				wfProfileOut( __METHOD__ );
				return false ;
			}
		}
	}	
	wfProfileOut( __METHOD__ );
	return true ;
}


// this is for page move
function wfGetMoveSpamRegex ($movepage) {
	wfProfileIn( __METHOD__ );
	wfLoadExtensionMessages ('SpamRegex') ;

	// here we get only the phrases for blocking in summaries...	
	$s_phrases = array () ;
	$s_phrases = wfFetchSpamRegexData (SPAMREGEX_SUMMARY) ;
	if ( $s_phrases && ($movepage->reason != '')) {		
		foreach ($s_phrases as $s_phrase) {
			if (preg_match ($s_phrase, $movepage->reason, $s_matches)) {				
				$spammessage = wfMsg ('spamregex-move') ;
				$spammessage .= wfMsg ('spamprotectionmatch', "<nowiki>{$s_matches[0]}</nowiki>") ;
				$movepage->showForm ('hookaborted', $spammessage) ;

				wfProfileOut( __METHOD__ );
				return false ;
			}
		}
	}
	wfProfileOut( __METHOD__ );
	return true ;
}


function wfFetchSpamRegexData ($mode) {
	wfProfileIn( __METHOD__ );
	global $wgMemc, $wgUser, $wgSpamRegex, $wgSharedDB ;

	$phrases = array () ;
	$first = true ;

	/* first, check if regex string is already stored in memcache */
	( $mode == SPAMREGEX_SUMMARY ) ? $key_clause = ":Summary" : $key_clause = ":Textbox" ;
	$key = wfSpamRegexGetMemcDB () . ":spamRegexCore:spamRegex" . $key_clause ;	
	$cached = $wgMemc->get ($key) ;
	if ( !$cached ) {
		/* fetch data from db, concatenate into one string, then fill cache */
		( $mode == SPAMREGEX_SUMMARY ) ? $clause = " WHERE spam_summary = 1" : $clause = " WHERE spam_textbox = 1" ;
		$dbr =& wfGetDB( DB_SLAVE ) ;
		$query = "SELECT spam_text FROM " . wfSpamRegexGetTable() . $clause ;
		$res = $dbr->query ($query) ;
		while ( $row = $dbr->fetchObject( $res ) ) {
			$concat = $row->spam_text ;
			$phrases [] = "/" . $concat . "/i" ;
		}
	
		$wgMemc->set ($key, $phrases, 0) ; 
		$dbr->freeResult ($res) ;
	} else {
		/* take from cache */
		$phrases = $cached ;
	}	
	wfProfileOut( __METHOD__ );
	return $phrases ;
}


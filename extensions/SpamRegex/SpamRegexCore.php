<?php

/**
 * Fetch phrases to block, and fill $wgSpamRegex with them, rather than scribble that into the variable at startup
 */
class SpamRegexHooks {

	public static function onEditFilter( $editpage ) {
		global $wgOut, $wgTitle;
		wfProfileIn( __METHOD__ );

		// here we get only the phrases for blocking in summaries...
		$s_phrases = array();
		$s_phrases = self::fetchRegexData( SPAMREGEX_SUMMARY );
		if ( $s_phrases && ( $editpage->summary != '' ) ) {
			//	...so let's rock with our custom spamPage to indicate that
			//	(since some phrases can be safely in the text and not in a summary
			//	and we do not want to confuse the good users, right?)

			foreach( $s_phrases as $s_phrase ) {
				if ( preg_match( $s_phrase, $editpage->summary, $s_matches ) ) {
					wfLoadExtensionMessages( 'SpamRegex' );
					$wgOut->setPageTitle( wfMsg( 'spamprotectiontitle' ) );
					$wgOut->setRobotPolicy( 'noindex,nofollow' );
					$wgOut->setArticleRelated( false );

					$wgOut->addWikiMsg( 'spamprotectiontext' );
					$wgOut->addWikiMsg( 'spamprotectionmatch', "<nowiki>{$s_matches[0]}</nowiki>" );
					$wgOut->addWikiMsg( 'spamregex-summary' );

					$wgOut->returnToMain( false, $wgTitle );
					wfProfileOut( __METHOD__ );
					return false;
				}
			}
		}

		$t_phrases = array();
		// and here we check for phrases within the text itself
		$t_phrases = self::fetchRegexData( SPAMREGEX_TEXTBOX );
		if ( $t_phrases && is_array( $t_phrases ) ) {
			foreach( $t_phrases as $t_phrase ) {
				if ( preg_match( $t_phrase, $editpage->textbox1, $t_matches ) ) {
					$editpage->spamPage( $t_matches[0] );
					wfProfileOut( __METHOD__ );
					return false;
				}
			}
		}
		wfProfileOut( __METHOD__ );
		return true;
	}

	// this is for page move
	public static function onAbortMove( $oldtitle, $newtitle, $user, &$error ) {
		global $wgRequest;
		wfProfileIn( __METHOD__ );

		// here we get only the phrases for blocking in summaries...
		$s_phrases = self::fetchRegexData( SPAMREGEX_SUMMARY );
		$reason = $wgRequest->getText( 'wpReason' );

		if ( $s_phrases && $reason ) {
			foreach( $s_phrases as $s_phrase ) {
				if ( preg_match( $s_phrase, $reason, $s_matches ) ) {
					wfLoadExtensionMessages( 'SpamRegex' );
					$error .= wfMsgExt( 'spamregex-move', array( 'parseinline' ) ) . ' ';
					$error .= wfMsgExt( 'spamprotectionmatch', array( 'parseinline' ), "<nowiki>{$s_matches[0]}</nowiki>" );
					wfProfileOut( __METHOD__ );
					return false;
				}
			}
		}
		wfProfileOut( __METHOD__ );
		return true;
	}

	protected static function fetchRegexData( $mode ) {
		global $wgMemc;
		wfProfileIn( __METHOD__ );

		$phrases = array();
		/* first, check if regex string is already stored in memcache */
		$key_clause = $mode == SPAMREGEX_SUMMARY ?  'Summary' : 'Textbox';
		$key = wfSpamRegexCacheKey( 'spamRegexCore', 'spamRegex', $key_clause );
		$cached = $wgMemc->get( $key );
		if ( !$cached ) {
			/* fetch data from db, concatenate into one string, then fill cache */
			$field = $mode == SPAMREGEX_SUMMARY ? 'spam_summary' : 'spam_textbox';
			$dbr = wfGetDB( DB_SLAVE );
			$res = $dbr->select( 'spam_regex', 'spam_text', array( $field => 1 ), __METHOD__ );
			while ( $row = $res->fetchObject() ) {
				$concat = $row->spam_text;
				$phrases [] = "/" . $concat . "/i" ;
			}
			$wgMemc->set( $key, $phrases, 0 );
			$res->free();
		} else {
			/* take from cache */
			$phrases = $cached;
		}
		wfProfileOut( __METHOD__ );
		return $phrases;
	}
}
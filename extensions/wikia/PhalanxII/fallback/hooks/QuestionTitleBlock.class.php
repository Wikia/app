<?php

/**
 * This filter blocks a question (page) from being created,
 * if its title matches any of the blacklisted phrases.
 *
 * Note: only works on Answers-type wikis
 */

class QuestionTitleBlock {
	static public function badWordsTest( $title, &$block ) {
		global $wgLanguageCode;
		wfProfileIn( __METHOD__ );

		$text = preg_replace( '/[^\PP]+/', '', $title->getText() );
		$text = preg_replace( '/\s+/', ' ', $text );

		$blocksData = PhalanxFallback::getFromFilter( PhalanxFallback::TYPE_ANSWERS_QUESTION_TITLE, $wgLanguageCode );

		$blockData = null;
		$result = PhalanxFallback::findBlocked( $text, $blocksData, true, $blockData );
		if ( $result['blocked'] ) {
			$block = ( object ) $result;
			Wikia::log( __METHOD__, __LINE__, "Block '{$result['msg']}' blocked '$text'." );
			wfProfileOut( __METHOD__ );
			return false;
		}

		wfProfileOut( __METHOD__ );
		return true;
	}
}

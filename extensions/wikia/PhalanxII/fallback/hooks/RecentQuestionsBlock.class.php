<?php

/**
 * RecentQuestionsBlock
 *
 * This filter blocks questions (articles) from being displayed
 * in a number of outputs (widgets, lists, tag-generated listings).
 *
 * It does not block those articles from being created.
 *
 * Note: works only on Answers-type wikis
 */

class RecentQuestionsBlock {
	public static function filterWordsTest( $question ) {
		wfProfileIn( __METHOD__ );

		$text = preg_replace('/\pP+/', '', $question);
		$text = preg_replace('/\s+/', ' ', $text);

		$blocksData = PhalanxFallback::getFromFilter( PhalanxFallback::TYPE_ANSWERS_RECENT_QUESTIONS );
		if ( !empty($blocksData) && !empty($text) ) {
			$blockData = null;
			$result = PhalanxFallback::findBlocked( $text, $blocksData, true, $blockData );
			if ( $result['blocked'] ) {
				Wikia::log(__METHOD__, __LINE__, "Block '{$result['msg']}' blocked '$text'.");
				wfProfileOut( __METHOD__ );
				return false;
			}
		}

		wfProfileOut( __METHOD__ );
		return true;
	}
}

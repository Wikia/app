<?php

/**
 * This filter blocks a question (page) from being created,
 * if its title matches any of the blacklisted phrases.
 *
 * Note: only works on Answers-type wikis
 */

class BadWordsBlock {
	static public function badWordsTest( $title ) {
		global $wgLanguageCode;
		wfProfileIn(__METHOD__);

		$text = preg_replace('/[^\PP]+/', '', $title->getText());
		$text = preg_replace('/\s+/', ' ', $text);

		$blocksData = Phalanx::getFromFilter( Phalanx::TYPE_ANSWERS_QUESTION, $wgLanguageCode );

		foreach ( $blocksData as $blockData ) {
			$result = Phalanx::isBlocked( $text, $blockData );
			if ( $result['blocked'] ) {
				Wikia::log(__METHOD__, __LINE__, "Block '{$result['msg']}' blocked '$text'.");
				wfProfileOut(__METHOD__);
				return false;
			}
		}

		wfProfileOut(__METHOD__);
		return true;
	}
}

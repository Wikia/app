<?php

/**
 * This filter blocks a wiki from being created,
 * if it's name contains unwanted phrases.
 *
 * @see extensions/wikia/AutoCreateWiki/
 */

class WikiCreationBlock {
	public static function isAllowedText($text, $where, $split) {
		wfProfileIn( __METHOD__ );

		$text = trim($text);
		$blocksData = Phalanx::getFromFilter( Phalanx::TYPE_WIKI_CREATION );

		if ( !empty($blocksData) && !empty($text) ) {
			foreach ($blocksData as $blockData) {
				$result = Phalanx::isBlocked( $text, $blockData );
				if ( $result['blocked'] ) {
					wfProfileOut( __METHOD__ );
					Wikia::log(__METHOD__, __LINE__, "Block '{$result['msg']}' blocked '$text'.");
					return false;
				}
			}
		}

		wfProfileOut( __METHOD__ );
		return true;
	}
}

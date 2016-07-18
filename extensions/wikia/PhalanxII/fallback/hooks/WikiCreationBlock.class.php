<?php

/**
 * This filter blocks a wiki from being created,
 * if it's name contains unwanted phrases.
 *
 * @see extensions/wikia/CreateWikiChecks/
 */

class WikiCreationBlock {
	public static function isAllowedText($text, &$block) {
		wfProfileIn( __METHOD__ );

		$text = trim($text);
		$blocksData = PhalanxFallback::getFromFilter( PhalanxFallback::TYPE_WIKI_CREATION );

		if ( !empty($blocksData) && !empty($text) ) {
			$blockData = null;
			$result = PhalanxFallback::findBlocked( $text, $blocksData, true, $blockData );
			if ( $result['blocked'] ) {
				$block = (object) $blockData;
				wfProfileOut( __METHOD__ );
				return false;
			}
		}

		wfProfileOut( __METHOD__ );
		return true;
	}
}

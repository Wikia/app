<?php

/**
 * TitleBlock
 *
 * This filter prevents a page from being created,
 * if its title matches any of the blacklisted phrases.
 *
 * It does not prevent a pre-existing page from being edited.
 *
 * @date 2010-06-09
 */

class TitleBlock {
	static private $blocksData = null;

	static public function beforeMove( &$move, &$block ) {
		wfProfileIn( __METHOD__ );

		$retVal = true;
		$title = Title::newFromURL( $move->newTitle );

		if ( !( $title instanceof Title ) ) {
			wfProfileOut( __METHOD__ );
			return $retVal;
		}
		$retVal = self::checkTitle( $title, $block );

		wfProfileOut( __METHOD__ );
		return $retVal;
	}

	static public function listCallback( $title, &$block ) {
		wfProfileIn( __METHOD__ );

		$retVal = true;

		if ( !( $title instanceof Title ) ) {
			wfProfileOut( __METHOD__ );
			return $retVal;
		}

		// Hook is called for both page creations and edits. We should only check
		// if the page is created = page does not exist (RT#61104)
		if ( $title->exists() ) {
			wfProfileOut( __METHOD__ );
			return $retVal;
		}

		$retVal = self::checkTitle( $title, $block );

		wfProfileOut( __METHOD__ );
		return $retVal;
	}

	static public function newWikiBuilder( $titleObj, &$block ) {
		wfProfileIn( __METHOD__ );

		$retVal = true;

		// titleObj is already verified as object earlier in NWB
		$retVal = self::checkTitle( $titleObj, $block );

		wfProfileOut( __METHOD__ );
		return $retVal;
	}

	// used in Answer's CreateDefaultQuestionPage
	static public function genericTitleCheck( $titleObj, &$block ) {
		wfProfileIn( __METHOD__ );

		$retVal = true;

		// titleObj is already verified as object earlier in CDQP
		if ( $titleObj instanceof Title ) {
			$retVal = self::checkTitle( $titleObj, $block );
		}

		wfProfileOut( __METHOD__ );
		return $retVal;
	}


	/**
	 * @param Title $title
	 * @param object $block
	 *
	 * @return bool — true if $title is considered safe, false if $title is blocked
	 */
	static public function checkTitle( Title $title, &$block ) {
		wfProfileIn( __METHOD__ );

		if ( is_null( self::$blocksData ) ) {
			self::$blocksData = PhalanxFallback::getFromFilter( PhalanxFallback::TYPE_TITLE );
		}
		$fullText = $title->getFullText();
		$result = array( 'blocked' => false );

		if ( !empty( self::$blocksData ) ) {
			$blockData = null;
			$result = PhalanxFallback::findBlocked( $fullText, self::$blocksData, true, $blockData );
			if ( $result['blocked'] ) {
				$block = ( object ) $blockData;
				# self::spamPage( $result['msg'], $title );
				Wikia::log( __METHOD__, __LINE__, "Block '{$result['msg']}' blocked '$fullText'." );
			}
		}

		wfProfileOut( __METHOD__ );
		return !$result['blocked'];
	}

	// moved from SpamRegexBatch.php
	// TODO: use Phalanx messages
	static function spamPage( $match = false, $title = null ) {
		global $wgOut;

		$wgOut->setPageTitle( wfMsg( 'spamprotectiontitle' ) );
		$wgOut->setRobotPolicy( 'noindex,nofollow' );
		$wgOut->setArticleRelated( false );

		$wgOut->addWikiMsg( 'spamprotectiontext' );
		$wgOut->addHTML( '<p>( Call #9 )</p>' );
		if ( $match )
			$wgOut->addWikiMsg( 'spamprotectionmatch', "<nowiki>{$match}</nowiki>" );

		$wgOut->returnToMain( false, $title );
	}
}

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

	static public function beforeMove( &$move ) {
		wfProfileIn( __METHOD__ );

		$retVal = true;
		$title = Title::newFromURL( $move->newTitle );

		if (!($title instanceof Title)) {
			wfProfileOut( __METHOD__ );
			return $retVal;
		}
		$retVal = self::checkTitle($title);

		wfProfileOut( __METHOD__ );
		return $retVal;
	}

	static public function listCallback( $editPage, $text, $section, &$hookError ) {
		wfProfileIn( __METHOD__ );

		$retVal = true;
		$title = $editPage->mTitle;

		if (!($title instanceof Title)) {
			wfProfileOut( __METHOD__ );
			return $retVal;
		}
		
		// Hook is called for both page creations and edits. We should only check
		// if the page is created = page does not exist (RT#61104)
		if ($title->exists()) {
			wfProfileOut(__METHOD__);
			return $retVal;
		}

		$retVal = self::checkTitle($title);

		wfProfileOut( __METHOD__ );
		return $retVal;
	}

	static public function newWikiBuilder( &$api, $titleObj, $category, $text ) {
		wfProfileIn( __METHOD__ );

		$retVal = true;

		// titleObj is already verified as object earlier in NWB
		$retVal = self::checkTitle($titleObj);

		wfProfileOut( __METHOD__ );
		return $retVal;
	}

	//used in Answer's CreateDefaultQuestionPage
	static public function genericTitleCheck( $titleObj ) {
		wfProfileIn( __METHOD__ );

		$retVal = true;

		// titleObj is already verified as object earlier in CDQP
		if ($titleObj instanceof Title) {
			$retVal = self::checkTitle($titleObj);
		}

		wfProfileOut( __METHOD__ );
		return $retVal;
	}


	static public function checkTitle($title) {
		wfProfileIn( __METHOD__ );

		if (is_null(self::$blocksData)) {
			self::$blocksData = Phalanx::getFromFilter( Phalanx::TYPE_TITLE );
		}
		$fullText = $title->getFullText();
		$result = array('blocked' => false);

		if ( !empty(self::$blocksData) ) {
			foreach ( self::$blocksData as $blockData ) {
				$result = Phalanx::isBlocked( $fullText, $blockData );
				if ( $result['blocked'] ) {
					self::spamPage( $result['msg'], $title );
					Wikia::log(__METHOD__, __LINE__, "Block '{$result['msg']}' blocked '$fullText'.");
					break;
				}
			}
		}

		wfProfileOut( __METHOD__ );
		return !$result['blocked'];
	}

	//moved from SpamRegexBatch.php
	//TODO: use Phalanx messages
	static function spamPage( $match = false, $title = null ) {
		global $wgOut;

		$wgOut->setPageTitle( wfMsg( 'spamprotectiontitle' ) );
		$wgOut->setRobotPolicy( 'noindex,nofollow' );
		$wgOut->setArticleRelated( false );

		$wgOut->addWikiMsg( 'spamprotectiontext' );
		if ( $match )
			$wgOut->addWikiMsg( 'spamprotectionmatch', "<nowiki>{$match}</nowiki>" );

		$wgOut->returnToMain( false, $title );
	}
}

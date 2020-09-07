<?php

/**
 * ContentBlock
 *
 * This filter blocks an edit from being saved, if its content or the summary given
 * matches any of the blacklisted phrases.
 */

class PhalanxContentBlock extends WikiaObject {
	/**
	 * @static
	 *
	 * hook
	 *
	 * @param EditPage $editPage
	 * @param $text
	 * @param $section
	 * @param $hookError
	 * @param $summary
	 * @return bool
	 */
	static public function editFilter( EditPage $editPage, $text, $section, &$hookError, $summary ) {
		wfProfileIn( __METHOD__ );
		list( $contentIsBlocked, $errorMessage ) = self::checkContentFromEditPage( $editPage );

		if ( $contentIsBlocked ) {
			// we found block
			$editPage->spamPageWithContent( $errorMessage );
			$hookError = $errorMessage; // SUS-1189

			Wikia\Logger\WikiaLogger::instance()->warning( __METHOD__ . ' - block applied SUS-1188', [ 'title' => $editPage->getTitle()->getPrefixedDBkey(), 'error_message' => $errorMessage ] );
		}

		wfProfileOut( __METHOD__ );
		return !$contentIsBlocked;
	}

	/**
	 * Hook function for APIEditBeforeSave. This hook is run before the "EditFilter" hook, when applicable.
	 *
	 * @param $editPage EditPage
	 * @param $text string
	 * @param $resultArr array
	 * @return bool
	 */
	static function filterAPIEditBeforeSave( $editPage, $text, &$resultArr ) {
		wfProfileIn( __METHOD__ );
		list( $contentIsBlocked, $errorMessage ) = self::checkContentFromEditPage( $editPage, 'getBlockMessage' );

		if ( $contentIsBlocked ) {
			// Something was blocked
			$resultArr['spamblacklist'] = $errorMessage;
		}

		wfProfileOut( __METHOD__ );
		return !$contentIsBlocked;
	}

	/**
	 * Check for blocked content in an EditPage object
	 *
	 * @param $editPage EditPage
	 * @param $errorFunctionName string
	 * @return array Whether the content was NOT blocked, and the error message if content is blocked
	 */
	static private function checkContentFromEditPage( $editPage, $errorFunctionName = null ) {
		wfProfileIn( __METHOD__ );
		static $contentWasChecked = false;
		static $contentIsBlocked = false;
		static $errorMessage = '';

		if ( $contentWasChecked ) {
			return [ $contentIsBlocked, $errorMessage ];
		}

		if ( self::isContentBlockingDisabled() ) {
			wfProfileOut( __METHOD__ );
			wfDebug( __METHOD__ . ": content blocking disabled by \$wgPhalanxDisableContent\n" );
			return [ $contentIsBlocked, $errorMessage ];
		}

		// SUS-1219: fallback to editpage title if wgTitle is null
		$title = $editPage->getContextTitle() ?? $editPage->getTitle();

		$phalanxModel = new PhalanxContentModel( $title );

		$summary = $editPage->summary;
		$textbox = $editPage->textbox1;

		$contentIsBlocked = !$phalanxModel->match_summary( $summary );
		if ( $contentIsBlocked === false ) {
			/* check content */
			$contentIsBlocked = !self::editContent( $textbox, $errorMessage, $phalanxModel, $errorFunctionName );
		} else {
			if ( $errorFunctionName !== null ) {
				$errorMessage = call_user_func( array( $phalanxModel, $errorFunctionName ) );
			}
			else {
				$errorMessage = $phalanxModel->contentBlock();
			}
		}

		$contentWasChecked = true;
		wfProfileOut( __METHOD__ );
		return [ $contentIsBlocked, $errorMessage ];
	}


	/**
	 * Hook: SpecialMovepageBeforeMove
	 *
	 * Handles page moves via Special:MovePage - aborts if the summary given matches any blacklisted phrase,
	 * or if the destination title matches any title filter.
	 *
	 * @param MovePageForm $move Special:MovePage class instance
	 * @return bool False if a match was found to stop hook processing, true otherwise
	 */
	static public function beforeMove( MovePageForm $move ): bool {
		wfProfileIn( __METHOD__ );

		$phalanxModel = new PhalanxContentModel( $move->newTitle );
		$isOk = $phalanxModel->match_title();

		// no need to check edit summary if title is blocked
		if ( $isOk !== false ) {
			$isOk = $phalanxModel->match_summary( $move->reason );
		}

		if ( $isOk === false ) {
			$phalanxModel->displayBlock();
		}

		wfProfileOut( __METHOD__ );
		return $isOk;
	}

	/**
	 * Hook: AbortMove
	 * @see https://www.mediawiki.org/wiki/Manual:Hooks/AbortMove
	 *
	 * Handles page moves via API - aborts if the summary given matches any blacklisted phrase,
	 * or if the destination title matches any title filter.
	 * For page moves via Special:MovePage, beforeMove hook handler above has already aborted the move in case of a match
	 *
	 * @param Title $oldTitle
	 * @param Title $newTitle Destination title - will be checked against Phalanx service
	 * @param User $user
	 * @param null|string $error
	 * @param string $reason User-provided move reason - will be checked against Phalanx service
	 * @return bool False if a match was found to stop hook processing, true otherwise
	 */
	static public function abortMove( Title $oldTitle, Title $newTitle, User $user, &$error, string $reason ): bool {
		wfProfileIn( __METHOD__ );

		$phalanxModel = new PhalanxContentModel( $newTitle );
		$isOk = $phalanxModel->match_title();

		// no need to check edit summary if title is blocked
		if ( $isOk !== false ) {
			$isOk = $phalanxModel->match_summary( $reason );
		}

		if ( $isOk === false ) {
			// SUS-1090: $error must be a MediaWiki message key
			$error = 'spamprotectionmatch';
		}

		wfProfileOut( __METHOD__ );

		// SUS-1090: We need to return false if we found a match - otherwise move won't be aborted
		return $isOk;
	}

	/**
	 * @static
	 *
	 * hook
	 * @param $textbox string
	 * @param $error_msg string
	 * @param $phalanxModel PhalanxModel
	 * @param $errorFunctionName string
	 */
	static public function editContent( $textbox, &$error_msg, $phalanxModel = null, $errorFunctionName = null ) {
		wfProfileIn( __METHOD__ );

		$title = RequestContext::getMain()->getTitle();

		if ( is_null( $phalanxModel ) ) {
			$phalanxModel = new PhalanxContentModel( $title );
		}

		/* check in Phalanx service */
		$ret = $phalanxModel->match_content( $textbox );

		if ( $ret === false ) {
			if ( $errorFunctionName !== null ) {
				$error_msg = call_user_func( array( $phalanxModel, $errorFunctionName ) );
			}
			else {
				$error_msg = $phalanxModel->contentBlock();
			}
		}

		wfProfileOut( __METHOD__ );
		return $ret;
	}

	/**
	 * @static
	 *
	 * hook
	 */
	static public function checkContent( $textbox, &$msg, $displayBlock = false ) {
		wfProfileIn( __METHOD__ );

		$title = RequestContext::getMain()->getTitle();

		$phalanxModel = new PhalanxContentModel( $title );

		$ret = PhalanxContentBlock::editContent( $textbox, $msg, $phalanxModel );

		if ( $ret === false && $displayBlock ) {
			$phalanxModel->displayBlock();
		}

		wfProfileOut( __METHOD__ );
		return $ret;
	}

	/**
	 * BAC-675: handle $wgPhalanxDisableContent
	 *
	 * Don't check content related blocks on SOAP wiki
	 *
	 * @return bool
	 */
	static private function isContentBlockingDisabled() {
		return !empty( F::app()->wg->PhalanxDisableContent );
	}
}

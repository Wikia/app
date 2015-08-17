<?php

/**
 * ContentBlock
 *
 * This filter blocks an edit from being saved, if its content or the summary given
 * matches any of the blacklisted phrases.
 */

class PhalanxContentBlock extends WikiaObject {
	private static $whitelist = null;

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
	static public function editFilter( $editPage, $text, $section, &$hookError, $summary ) {
		wfProfileIn( __METHOD__ );
		list( $contentIsBlocked, $errorMessage ) = self::checkContentFromEditPage( $editPage );

		if ( $contentIsBlocked ) {
			// we found block
			$editPage->spamPageWithContent( $errorMessage );
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

		if (self::isContentBlockingDisabled()) {
			wfProfileOut( __METHOD__ );
			wfDebug(__METHOD__ . ": content blocking disabled by \$wgPhalanxDisableContent\n");
			return true;
		}

		$title = RequestContext::getMain()->getTitle();

		$phalanxModel = new PhalanxContentModel( $title );

		$summary = $editPage->summary;
		$textbox = $editPage->textbox1;
		
		/* compare summary with spam-whitelist */
		if ( !empty( $summary ) && !empty( $textbox ) && is_null( self::$whitelist ) ) {
			self::$whitelist = $phalanxModel->buildWhiteList();
		}

		/* check summary */
		if ( !empty( self::$whitelist ) ) {
			$summary = preg_replace( self::$whitelist, '', $summary );
		}

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

	/*
	 * abortMove
	 *
	 * Aborts a page move if the summary given matches
	 * any blacklisted phrase.
	 */
	static public function abortMove( $oldTitle, $newTitle, $user, &$error, $reason ) {
		wfProfileIn( __METHOD__ );

		if (self::isContentBlockingDisabled()) {
			wfProfileOut( __METHOD__ );
			wfDebug(__METHOD__ . ": content blocking disabled by \$wgPhalanxDisableContent\n");
			return true;
		}

		$phalanxModel = new PhalanxContentModel( $newTitle );
		$ret = $phalanxModel->match_title();
		if ( $ret !== false ) {
			/* compare reason with spam-whitelist - WTF? */
			if ( !empty( $reason ) && is_null( self::$whitelist ) ) {
				self::$whitelist = $phalanxModel->buildWhiteList();
			}
			
			/* check reason - WHY? */
			if ( !empty( self::$whitelist ) ) {
				$reason = preg_replace( self::$whitelist, '', $reason );
			}

			$ret = $phalanxModel->match_summary( $reason );
		} 
		
		if ( $ret === false ) {
			$error .= $phalanxModel->reasonBlock();
		}
		
		wfProfileOut( __METHOD__ );
		return true;
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
		
		/* compare summary with spam-whitelist */
		if ( !empty( $textbox ) && is_null(self::$whitelist) ) {
			self::$whitelist = $phalanxModel->buildWhiteList();
		}

		/* check content */
		if ( !empty( self::$whitelist ) ) {
			$textbox = preg_replace( self::$whitelist, '', $textbox );
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
	static public function checkContent( $textbox, &$msg ) {
		wfProfileIn( __METHOD__ );

		$title = RequestContext::getMain()->getTitle();

		$phalanxModel = new PhalanxContentModel( $title );
		
		/**
		 * @todo $this in static method
		 */
		$ret = PhalanxContentBlock::editContent( $textbox, $msg, $phalanxModel );
		
		if ( $ret === false ) {
			$msg = $phalanxModel->textBlock();
		}
		
		wfProfileOut( __METHOD__ );
		return $ret;
	}

	/**
	 * BAC-675: handle $wgPhalanxDisableContent
	 *
	 * Don't check content related blocks on VSTF wiki
	 *
	 * @return bool
	 */
	static private function isContentBlockingDisabled() {
		return !empty( F::app()->wg->PhalanxDisableContent );
	}
}

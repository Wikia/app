<?php

/**
 * ContentBlock
 *
 * This filter blocks an edit from being saved, if its content or the summary given
 * matches any of the blacklisted phrases.
 */

class PhalanxContentBlock extends WikiaObject {
	private static $whitelist = null;

	function __construct() {
		parent::__construct();
		F::setInstance( __CLASS__, $this );
	}

	public function editFilter( $editPage, $text, $section, &$hookError, $summary ) {
		$this->wf->profileIn( __METHOD__ );

		$phalanxModel = F::build('PhalanxContentModel', array( $this->wg->Title ) );
		
		$summary = $editPage->summary;
		$textbox = $editPage->textbox1;
		
		/* compare summary with spam-whitelist */
		if ( !empty( $summary ) && !empty( $textbox ) && is_null(self::$whitelist) ) {
			self::$whitelist = $phalanxModel->buildWhiteList();
		}
		
		/* check summary */
		if ( !empty( self::$whitelist ) ) {
			$summary = preg_replace( self::$whitelist, '', $summary );
		}

		$ret = $phalanxModel->match_summary( $summary );
		if ( $ret !== false ) {
			/* check content */
			if ( !empty( self::$whitelist ) ) {
				$textbox = preg_replace( self::$whitelist, '', $textbox );
			}
			$ret = $phalanxModel->match_content( $textbox );	
		}
		
		if ( $ret === false ) {
			// we found block
			$editPage->spamPageWithContent( $phalanxModel->contentBlock() );
		}
		
		$this->wf->profileOut( __METHOD__ );
		return $ret;
	}

	/*
	 * abortMove
	 *
	 * Aborts a page move if the summary given matches
	 * any blacklisted phrase.
	 */
	public function abortMove( $oldTitle, $newTitle, $user, &$error, $reason ) {
		$this->wf->profileIn( __METHOD__ );

		$phalanxModel = F::build('PhalanxContentModel', array( $newTitle ) );
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
		
		$this->wf->profileOut( __METHOD__ );
		return true;
	}
}

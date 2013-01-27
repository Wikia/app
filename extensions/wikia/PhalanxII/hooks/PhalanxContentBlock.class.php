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

	public function editFilter( $editpage ) {
		$this->wf->profileIn( __METHOD__ );

		$phalanxModel = F::build('PhalanxContentModel', array( $this->wg->Title ) );

		if ( $phalanxModel->isOk() ) {
			$this->wf->profileOut( __METHOD__ );
			return true;
		}
		
		/* summary */
		$summary = $editpage->summary;
		
		/* content */
		$textbox = $editpage->textbox1;
		
		/* compare summary with spam-whitelist */
		if ( !empty( $summary ) && !empty( $textbox ) && empty(self::$whitelist) ) {
			self::$whitelist = $phalanxModel->buildWhiteList();
		}
		
		/* check summary */
		if ( !empty( self::$whitelist ) ) {
			$summary = preg_replace( self::$whitelist, '', $summary );
		}

		$phalanxModel->setText( $summary );
		$result = $phalanxModel->match( "summary" );
		if ( $result !== false ) {
			if ( is_numeric( $result ) && $result > 0 ) {
				/* user is blocked - we have block ID */
				$phalanxModel->setBlockId( $result );
				// set output with block info
				$phalanxModel->displayBlock();
				$ret = false;
			} else {
				/* check content */
				if ( !empty( self::$whitelist ) ) {
					$textbox = preg_replace( self::$whitelist, '', $textbox );
				}
				$phalanxModel->setText( $textbox );
				$result = $phalanxModel->match( "content" );
				if ( $result !== false ) {
					if ( is_numeric( $result ) ) {
						/* user is blocked - we have block ID */
						$phalanxModel->setBlockId( $result );
						// set output with block info
						$editpage->spamPageWithContent( $phalanxModel->contentBlock() );
						$ret = false;
					} else {
						$ret = true;
					}
				}
			}
		} 
		
		/* if some problems with Phalanx service - use old version of extension */
		if ( $result === false ) {
			// TO DO
			/* problem with Phalanx service? */
			// include_once( dirname(__FILE__) . '/../prev_hooks/ContentBlock.class.php';
			// $ret = ContentBlock::onEditFilter( $editpage );		
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
	public function abortMove( $oldtitle, $newtitle, $user, &$error ) {
		$this->wf->profileIn( __METHOD__ );
		
		$phalanxModel = F::build('PhalanxContentModel', array( $newtitle ) );

		/* allow blocked words to be added to whitelist */
		if ( $phalanxModel->isOk() ) {
			$this->wf->profileOut( __METHOD__ );
			return true;
		}
		
		/* content to check */
		$reason = $this->wg->request->getText( 'wpReason' );
		
		/* compare summary with spam-whitelist */
		if ( !empty( $reason ) && empty(self::$whitelist) ) {
			self::$whitelist = $phalanxModel->buildWhiteList();
		}
		
		/* check summary */
		if ( !empty( self::$whitelist ) ) {
			$summary = preg_replace( self::$whitelist, '', $reason );
		}

		$phalanxModel->setText( $reason );
		$result = $phalanxModel->match( "summary" );
		if ( $result !== false ) {
			if ( is_numeric( $result ) && $result > 0 ) {
				/* user is blocked - we have block ID */
				$phalanxModel->setBlockId( $result );
				// set output with block info
				$error .= $phalanxModel->reasonBlock();
				$ret = false;
			} else {
				$ret = true;
			}
		} else {
			// TO DO
			/* problem with Phalanx service? */
			// include_once( dirname(__FILE__) . '/../prev_hooks/ContentBlock.class.php';
			// $ret = ContentBlock::onAbortMove( $oldtitle, $newtitle, $user, $error );		
		}

		$this->wf->profileOut( __METHOD__ );
		return true;
	}
}

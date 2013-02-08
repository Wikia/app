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

		$ret = true;
		$phalanxModel = F::build('PhalanxContentModel', array( $this->wg->Title ) );

		if ( $phalanxModel->isOk() ) {
			$this->wf->profileOut( __METHOD__ );
			return true;
		}
		
		/* summary */
		$summary = $editPage->summary;
		
		/* content */
		$textbox = $editPage->textbox1;
		
		/* compare summary with spam-whitelist */
		if ( !empty( $summary ) && !empty( $textbox ) && is_null(self::$whitelist) ) {
			self::$whitelist = $phalanxModel->buildWhiteList();
		}
		
		/* check summary */
		if ( !empty( self::$whitelist ) ) {
			$summary = preg_replace( self::$whitelist, '', $summary );
		}

error_log ( "summary = $summary \n", 3, "/tmp/moli.log" );
error_log ( "textbox = $textbox \n", 3, "/tmp/moli.log" );

		$result = $phalanxModel->setText( $summary )->match( "summary" );
error_log ( "result ( $summary ) = " . print_r( $result, true ) . "\n", 3, "/tmp/moli.log" );
		if ( $result !== false ) {
			if ( 
				is_object( $result ) && 
				isset( $result->id ) &&
				$result->id > 0 
			) {
				/* user is blocked - we have block ID */
				$phalanxModel->setBlockId( $result->id )->displayBlock();
				$ret = false;
			} else {
				/* check content */
				if ( !empty( self::$whitelist ) ) {
					$textbox = preg_replace( self::$whitelist, '', $textbox );
				}
				$result = $phalanxModel->setText( $textbox )->match( "content" );
error_log ( "result ( $textbox ) = " . print_r( $result, true ) . "\n", 3, "/tmp/moli.log" );
				if ( $result !== false ) {
					if ( 
						is_object( $result ) &&
						isset( $result->id ) &&
						$result->id > 0
					) {
						$editPage->spamPageWithContent( $phalanxModel->setBlockId( $result->id )->contentBlock() );
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
			// $ret = ContentBlock::onEditFilter( $editPage );		
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

		$ret = true;
		$phalanxModel = F::build('PhalanxContentModel', array( $newtitle ) );

		/* allow blocked words to be added to whitelist */
		if ( $phalanxModel->isOk() ) {
			$this->wf->profileOut( __METHOD__ );
			return $ret;
		}
		
		/* content to check */
		$reason = $this->wg->request->getText( 'wpReason' );
		
		/* compare summary with spam-whitelist */
		if ( !empty( $reason ) && is_null(self::$whitelist) ) {
			self::$whitelist = $phalanxModel->buildWhiteList();
		}
		
		/* check summary */
		if ( !empty( self::$whitelist ) ) {
			$summary = preg_replace( self::$whitelist, '', $reason );
		}

		$result = $phalanxModel->setText( $reason )->match( "summary" );
		if ( $result !== false ) {
			if ( 
				is_object( $result ) && 
				isset( $result->id ) &&
				$result->id > 0 
			) {
				$error .= $phalanxModel->setBlockId( $result->id )->reasonBlock();
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

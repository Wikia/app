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

		$result = $phalanxModel->setText( $summary )->match( "summary" );
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
	public function abortMove( $oldtitle, $newtitle, $user, &$error, $reason ) {
		$this->wf->profileIn( __METHOD__ );

		$ret = true;
		$phalanxModel = F::build('PhalanxContentModel', array( $newTitle ) );

		if ( $phalanxModel->isOk() ) {
			$this->wf->profileOut( __METHOD__ );
			return true;
		}

		/* check title name */
		$text = $title->getFullText();

		$result = $phalanxModel->setText( $text )->match( "title" );
		if ( $result !== false ) {
			if ( 
				is_object( $result ) && 
				isset( $result->id ) && 
				$result->id > 0 
			) {
				/* user is blocked - we have block ID */
				$phalanxModel->setBlockId( $result->id )->reasonBlock();
				$ret = false;
			} else {		
				/* compare reason with spam-whitelist - WTF? */
				if ( !empty( $reason ) && is_null(self::$whitelist) ) {
					self::$whitelist = $phalanxModel->buildWhiteList();
				}
				
				/* check reason - WHY? */
				if ( !empty( self::$whitelist ) ) {
					$reason = preg_replace( self::$whitelist, '', $reason );
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
				}
			}
		} 
		
		if ( $result === false ) {
			// TO DO
			/* problem with Phalanx service? */
			// include_once( dirname(__FILE__) . '/../prev_hooks/TitleBlock.class.php';
			// $ret = TitleBlock::genericTitleCheck( $title );		
		}
		
		$this->wf->profileOut( __METHOD__ );
		return true;
	}
}

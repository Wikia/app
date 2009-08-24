<?php

class CodeRevisionCommitter extends CodeRevisionView {

	function __construct( $repoName, $rev ) {
		// Parent should set $this->mRepo, $this->mRev, $this->mReplyTarget
		parent::__construct( $repoName, $rev );
	}

	function execute() {
		global $wgRequest, $wgOut, $wgUser;

		if ( !$wgUser->matchEditToken( $wgRequest->getVal( 'wpEditToken' ) ) ) {
			$wgOut->addHTML( '<strong>' . wfMsg( 'sessionfailure' ) . '</strong>' );
			parent::execute();
			return;
		}
		if ( !$this->mRev ) {
			parent::execute();
			return;
		}

		$redirTarget = null;
		$dbw = wfGetDB( DB_MASTER );

		$dbw->begin();
		// Change the status if allowed
		if ( $this->validPost( 'codereview-set-status' ) && $this->mRev->isValidStatus( $this->mStatus ) ) {
			$this->mRev->setStatus( $this->mStatus, $wgUser );
		}
		$addTags = $removeTags = array();
		if ( $this->validPost( 'codereview-add-tag' ) && count( $this->mAddTags ) ) {
			$addTags = $this->mAddTags;
		}
		if ( $this->validPost( 'codereview-remove-tag' ) && count( $this->mRemoveTags ) ) {
			$removeTags = $this->mRemoveTags;
		}
		// If allowed to change any tags, then do so
		if ( count( $addTags ) || count( $removeTags ) ) {
			$this->mRev->changeTags( $addTags, $removeTags, $wgUser );
		}
		// Add any comments
		if ( $this->validPost( 'codereview-post-comment' ) && strlen( $this->text ) ) {
			$parent = $wgRequest->getIntOrNull( 'wpParent' );
			$review = $wgRequest->getInt( 'wpReview' );
			$isPreview = $wgRequest->getCheck( 'wpPreview' );
			$id = $this->mRev->saveComment( $this->text, $review, $parent );
			// For comments, take us back to the rev page focused on the new comment
			if ( !$this->jumpToNext ) {
				$redirTarget = $this->commentLink( $id );
			}
		}
		$dbw->commit();

		// Return to rev page
		if ( !$redirTitle ) {
			if ( $this->jumpToNext ) {
				if ( $next = $this->mRev->getNextUnresolved() ) {
					$redirTitle = SpecialPage::getTitleFor( 'Code', $this->mRepo->getName() . '/' . $next );
				} else {
					$redirTitle = SpecialPage::getTitleFor( 'Code', $this->mRepo->getName() );
				}
			} else {
				# $redirTarget already set for comments
				$redirTitle = $redirTarget ? $redirTarget : $this->revLink();
			}
		}
		$wgOut->redirect( $redirTitle->getFullUrl() );
	}

	public function validPost( $permission ) {
		global $wgUser, $wgRequest;
		return parent::validPost( $permission ) && $wgRequest->wasPosted()
			&& $wgUser->matchEditToken( $wgRequest->getVal( 'wpEditToken' ) );
	}
}

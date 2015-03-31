<?php

namespace Email\Controller;

use Email\EmailController;

class WatchedPageController extends EmailController {

	const AVATAR_SIZE = 50;

	/* @var \Title */
	private $title;

	private $summary;

	private $minorEdit;

	private $oldID;

	private $timeStamp;

	public function getSubject() {
		return wfMessage( 'emailext-watchedpage-subject', $this->title->getPrefixedText() );
	}

	// TODO setup error handling here if minorEdit not passed in
	public function initEmail() {
		$this->title = $this->request->getVal( 'title' );
		$this->summary = $this->request->getVal( 'summary' );
		$this->minorEdit = $this->request->getVal( 'minorEdit' );
		$this->oldID = $this->request->getVal( 'oldID' );
		$this->timeStamp = $this->request->getVal( 'timeStamp' );
	}

	public function assertCanEmail() {
		parent::assertCanEmail();
		$this->assertUserWantsNotification();
		$this->assertEditNotTooMinor();
	}

	private function assertUserWantsNotification() {
		if ( !$this->targetUser->getOption( 'enotifwatchlistpages' ) ) {
			throw new \Email\Check( 'User does not want notifications' );
		}
	}

	private function assertEditNotTooMinor() {
		if ( $this->minorEdit && !$this->targetUser->getOption( 'enotifminoredits' ) ) {
			throw new \Email\Check( 'Notification too minor' );
		}
	}

	protected function getFooterMessages() {
		$footerMessages = [
			wfMessage( 'emailext-watchedpage-unfollow-text',
				$this->title->getFullURL( 'action=unwatch' ),
				$this->title->getPrefixedText() )->parse()
		];
		return array_merge( $footerMessages, parent::getFooterMessages() );
	}

//	protected function getReplyToAddress() {
//		global $wgPasswordSender, $wgPasswordSenderName, $wgEnotifRevealEditorAddress;
//		global $wgEnotifFromEditor, $wgNoReplyAddress;
//		# Reveal the page editor's address as REPLY-TO address only if
//		# the user has not opted-out and the option is enabled at the
//		# global configuration level.
//		$adminAddress = new MailAddress( $wgPasswordSender, $wgPasswordSenderName );
//		if ( $wgEnotifRevealEditorAddress
//			&& ( $this->editor->getEmail() != '' )
//			&& $this->editor->getOption( 'enotifrevealaddr' ) )
//		{
//			$editorAddress = new MailAddress( $this->editor );
//			if ( $wgEnotifFromEditor ) {
//				$this->from    = $editorAddress;
//			} else {
//				$this->from    = $adminAddress;
//				$this->replyto = $editorAddress;
//			}
//		} else {
//			$this->from    = $adminAddress;
//			$this->replyto = new MailAddress( $wgNoReplyAddress );
//		}
//	}

	/**
	 * @template watchedPage
	 */
	public function body() {
		$this->response->setData( [
			'salutation' => $this->getSalutation(),
			'articleEditedMessage' => $this->getArticleEditedMessage(),
			'editorProfilePage' => $this->getEditorProfilePage(),
			'editorUserName' => $this->getEditorUserName(),
			'editorAvatarURL' => $this->getEditorAvatarUR(),
			'summary' => $this->getSummary(),
			'compareChangesLabel' => $this->getCompareChangesLabel(),
			'compareChangesLink' => $this->getCompareChangesLink(),
			'headOver' => $this->getHeadOver(),
			'allChanges' => $this->getAllChanges(),
			'timeStamp' => $this->getTimeStamp()
		] );
	}

	private function getSalutation() {
		return wfMessage( 'emailext-watchedpage-salutation',
			$this->targetUser->getName() )->inLanguage( $this->getTargetLang() )->text();
	}

	private function getArticleEditedMessage() {
		return wfMessage( 'emailext-watchedpage-article-edited',
			$this->title->getFullURL(),
			$this->title->getPrefixedText() )->inLanguage( $this->getTargetLang() )->parse();
	}

	private function getEditorProfilePage() {
		if ( $this->currentUser->isLoggedIn() ) {
			return $this->currentUser->getUserPage()->getFullURL();
		}
		return "";
	}

	private function getEditorUserName() {
		if ( $this->currentUser->isLoggedIn() )	 {
			return $this->currentUser->getName();
		}
		return wfMessage( "emailext-watchedpage-anonymous-editor" )->inLanguage( $this->getTargetLang() )->text();
	}

	// TODO Make sure we want an anon avatar
	private function getEditorAvatarUR() {
		return \AvatarService::getAvatarUrl( $this->currentUser, self::AVATAR_SIZE );
	}

	private function getSummary() {
		if ( !empty( $this->summary ) ) {
			return $this->summary;
		}
		return wfMessage( 'enotif_no_summary' )->inLanguage( $this->getTargetLang() )->text();
	}

	private function getCompareChangesLabel() {
		return wfMessage( 'emailext-watchedpage-diff-button-text' )->inLanguage( $this->getTargetLang() )->text();
	}

	// TODO Make sure current revision is always one more than the old id
	private function getCompareChangesLink() {
		return $this->title->getFullUrl( 'diff=' . ( $this->oldID + 1 ) . '&oldid=' . $this->oldID );
	}

	private function getHeadOver() {
		return wfMessage( 'emailext-watchedpage-article-link-text',
			$this->title->getFullURL(),
			$this->title->getPrefixedText() )->inLanguage( $this->getTargetLang() )->parse();
	}

	private function getAllChanges() {
		return wfMessage( 'emailext-watchedpage-view-all-changes',
			$this->title->getFullURL( 'action=history' ),
			$this->title->getPrefixedText() )->inLanguage( $this->getTargetLang() )->parse();
	}

	private function getTimeStamp() {
		return \F::app()->wg->ContLang->userDate( $this->timestamp, $this->targetUser );
	}
}

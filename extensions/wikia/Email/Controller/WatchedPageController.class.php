<?php

namespace Email\Controller;

use Email\Check;
use Email\EmailController;

class WatchedPageController extends EmailController {

	const AVATAR_SIZE = 50;

	/* @var \Title */
	private $title;
	private $summary;
	private $currentRevId;
	private $previousRevId;
	private $replyToAddress;
	private $fromAddress;

	public function getSubject() {
		return wfMessage( 'emailext-watchedpage-subject',
			$this->title->getPrefixedText(),
			$this->getEditorUserName() )->inLanguage( $this->targetLang )->text();
	}

	public function initEmail() {
		$nameSpace = $this->request->getInt( 'nameSpace', NS_MAIN );
		$this->title = \Title::newFromText( $this->request->getVal( 'title' ), $nameSpace );
		$this->summary = $this->request->getVal( 'summary' );
		$this->currentRevId = $this->request->getVal( 'currentRevId' );
		$this->previousRevId = $this->request->getVal( 'previousRevId' );
		$this->replyToAddress = $this->request->getVal( 'replyToAddress' );
		$this->fromAddress = new \MailAddress( $this->request->getVal( 'fromAddress', '' ), $this->getVal( 'fromName', '' ) );

		$this->assertValidParams();
	}

	/**
	 * Validate the params passed in by the client
	 */
	private function assertValidParams() {
		$this->assertValidTitle();
		$this->assertValidRevIds();
		$this->assertValiFromAddress();
	}

	/**
	 * @throws \Email\Check
	 */
	private function assertValidTitle() {
		if ( !$this->title instanceof \Title ) {
			throw new Check( "Invalid value passed for title (param: title)" );
		}

		if ( !$this->title->exists() ) {
			throw new Check( "Title doesn't exist." );
		}
	}

	private function assertValidRevIds() {
		if ( empty( $this->currentRevId ) ) {
			throw new Check( "Empty value for current Revision ID (param: currentRevId)" );
		}

		if ( empty( $this->previousRevId ) ) {
			throw new Check( "Empty value for previous Revision ID (param: previousRevId)" );
		}
	}

	private function assertValiFromAddress() {
		if ( $this->fromAddress->toString() == "" ) {
			throw new Check( "Empty from address (param: fromAddress)" );
		}
	}

	protected function getFromAddress() {
		return $this->fromAddress;
	}

	protected function getReplyToAddress() {
		return $this->replyToAddress;
	}

	protected function getFooterMessages() {
		$footerMessages = [
			wfMessage( 'emailext-watchedpage-unfollow-text',
				$this->title->getCanonicalUrl( 'action=unwatch' ),
				$this->title->getPrefixedText() )->inLanguage( $this->targetLang )->parse()
		];
		return array_merge( $footerMessages, parent::getFooterMessages() );
	}

	/**
	 * @template avatarLayout
	 */
	public function body() {
		$this->response->setData( [
			'salutation' => $this->getSalutation(),
			'articleEditedText' => $this->getArticleEditedText(),
			'editorProfilePage' => $this->getEditorProfilePage(),
			'editorUserName' => $this->getEditorUserName(),
			'editorAvatarURL' => $this->getEditorAvatarURL(),
			'summary' => $this->getSummary(),
			'buttonText' => $this->getCompareChangesLabel(),
			'buttonLink' => $this->getCompareChangesLink(),
			'contentFooterMessages' => [
				$this->getArticleLinkText(),
				$this->getAllChangesText(),
			],
		] );
	}

	/**
	 * @return String
	 */
	private function getSalutation() {
		return wfMessage( 'emailext-watchedpage-salutation',
			$this->targetUser->getName() )->inLanguage( $this->targetLang )->text();
	}

	/**
	 * @return String
	 */
	private function getArticleEditedText() {
		return wfMessage( 'emailext-watchedpage-article-edited',
			$this->title->getFullURL(),
			$this->title->getPrefixedText() )->inLanguage( $this->targetLang )->parse();
	}

	/**
	 * @return String
	 */
	private function getEditorProfilePage() {
		if ( $this->currentUser->isLoggedIn() ) {
			return $this->currentUser->getUserPage()->getFullURL();
		}
		return "";
	}

	/**
	 * @return String
	 */
	private function getEditorUserName() {
		if ( $this->currentUser->isLoggedIn() )	 {
			return $this->currentUser->getName();
		}
		return wfMessage( "emailext-watchedpage-anonymous-editor" )->inLanguage( $this->targetLang )->text();
	}

	/**
	 * @return String
	 */
	private function getEditorAvatarURL() {
		return \AvatarService::getAvatarUrl( $this->currentUser, self::AVATAR_SIZE );
	}

	/**
	 * @return String
	 */
	private function getSummary() {
		if ( !empty( $this->summary ) ) {
			return $this->summary;
		}
		return wfMessage( 'emailext-watchedpage-no-summary' )->inLanguage( $this->targetLang )->text();
	}

	/**
	 * @return String
	 */
	private function getCompareChangesLabel() {
		return wfMessage( 'emailext-watchedpage-diff-button-text' )->inLanguage( $this->targetLang )->text();
	}

	/**
	 * @return String
	 */
	private function getCompareChangesLink() {
		return $this->title->getFullUrl( [
			'diff' => $this->currentRevId,
			'oldid' => $this->previousRevId
		] );
	}

	/**
	 * @return String
	 */
	private function getArticleLinkText() {
		return wfMessage( 'emailext-watchedpage-article-link-text',
			$this->title->getFullURL( [
				'diff' => 0,
				'oldid' => $this->previousRevId
			] ),
			$this->title->getPrefixedText() )->inLanguage( $this->targetLang )->parse();
	}

	/**
	 * @return String
	 */
	private function getAllChangesText() {
		return wfMessage( 'emailext-watchedpage-view-all-changes',
			$this->title->getFullURL( 'action=history' ),
			$this->title->getPrefixedText() )->inLanguage( $this->targetLang )->parse();
	}
}

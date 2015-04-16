<?php

namespace Email\Controller;

use Email\Check;
use Email\EmailController;

class WatchedPageController extends EmailController {

	/* @var \Title */
	private $title;
	private $summary;
	private $currentRevId;
	private $previousRevId;

	public function getSubject() {
		return wfMessage( 'emailext-watchedpage-subject',
			$this->title->getPrefixedText(),
			$this->getCurrentUserName()
		)->inLanguage( $this->targetLang )->text();
	}

	public function initEmail() {
		$titleText = $this->request->getVal( 'title' );
		$titleNamespace = $this->request->getVal( 'namespace', NS_MAIN );

		$this->title = \Title::newFromText( $titleText, $titleNamespace );
		$this->summary = $this->getVal( 'summary' );
		$this->currentRevId = $this->getVal( 'currentRevId' );
		$this->previousRevId = $this->getVal( 'previousRevId' );

		$this->assertValidParams();
	}

	/**
	 * Validate the params passed in by the client
	 */
	private function assertValidParams() {
		$this->assertValidTitle();
		$this->assertValidRevIds();
	}

	/**
	 * @throws \Email\Check
	 */
	private function assertValidTitle() {
		if ( !$this->title instanceof \Title ) {
			throw new Check( "Invalid value passed for title" );
		}

		if ( !$this->title->exists() ) {
			throw new Check( "Title doesn't exist." );
		}
	}

	private function assertValidRevIds() {
		if ( empty( $this->currentRevId ) ) {
			throw new Check( "Empty current Revision Id" );
		}

		if ( empty( $this->previousRevId ) ) {
			throw new Check( "Empty previous Revision Id" );
		}
	}

	protected function getFooterMessages() {
		$footerMessages = [
			wfMessage( 'emailext-unfollow-text',
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
			'summary' => $this->getSummary(),
			'editorProfilePage' => $this->getCurrentProfilePage(),
			'editorUserName' => $this->getCurrentUserName(),
			'editorAvatarURL' => $this->getCurrentAvatarURL(),
			'details' => $this->getDetails(),
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
	private function getSummary() {
		return wfMessage( 'emailext-watchedpage-article-edited',
			$this->title->getFullURL(),
			$this->title->getPrefixedText() )->inLanguage( $this->targetLang )->parse();
	}

	/**
	 * @return String
	 */
	private function getDetails() {
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
			$this->title->getFullURL(),
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

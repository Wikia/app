<?php

namespace Email\Controller;

use Email\Check;
use Email\EmailController;

abstract class WatchedPageController extends EmailController {

	/* @var \Title */
	protected $title;
	protected $summary;
	protected $currentRevId;

	/**
	 * @return String
	 */
	protected abstract function getSubjectMessageKey();

	protected abstract function getSummaryMessageKey();

	public function getSubject() {
		return wfMessage( $this->getSubjectMessageKey(),
			$this->title->getPrefixedText(),
			$this->getCurrentUserName()
		)->inLanguage( $this->targetLang )->text();
	}

	public function initEmail() {
		$titleText = $this->request->getVal( 'title' );
		$titleNamespace = $this->request->getVal( 'namespace', NS_MAIN );

		$this->title = \Title::newFromText( $titleText, $titleNamespace );
		$this->summary = $this->getVal( 'summary' );

		if ($this->title instanceof \Title) {
			$this->currentRevId = $this->title->getLatestRevID( \Title::GAID_FOR_UPDATE );
		}

		$this->assertValidParams();
	}

	/**
	 * Validate the params passed in by the client
	 */
	protected function assertValidParams() {
		$this->assertValidTitle();
	}

	/**
	 * @throws \Email\Check
	 */
	protected function assertValidTitle() {
		if ( !$this->title instanceof \Title ) {
			throw new Check( "Invalid value passed for title (param: title)" );
		}

		if ( !$this->title->exists() && !$this->title->isDeletedQuick() ) {
			throw new Check( "Title doesn't exist." );
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
			'buttonText' => $this->getButtonText(),
			'buttonLink' => $this->getButtonLink(),
			'contentFooterMessages' => $this->getContentFooterMessages(),
			'contentFooterMessagesCount' => (bool) count($this->getContentFooterMessages()),
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
		return wfMessage( $this->getSummaryMessageKey(),
			$this->title->getFullURL(),
			$this->title->getPrefixedText()
		)->inLanguage( $this->targetLang )->parse();
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
	protected function getButtonText() {
		return wfMessage( 'emailext-watchedpage-diff-button-text' )->inLanguage( $this->targetLang )->text();
	}

	/**
	 * @return String
	 */
	protected function getButtonLink() {
		return $this->title->getFullUrl( [
			'diff' => $this->currentRevId
		] );
	}

	/**
	 * @return String
	 */
	protected function getArticleLinkText() {
		return wfMessage( 'emailext-watchedpage-article-link-text',
			$this->title->getFullURL( [
				'diff' => 0,
				'oldid' => $this->currentRevId
			] ),
			$this->title->getPrefixedText()
		)->inLanguage( $this->targetLang )->parse();
	}

	/**
	 * @return String
	 */
	protected function getAllChangesText() {
		return wfMessage( 'emailext-watchedpage-view-all-changes',
			$this->title->getFullURL( [
				'action' => 'history'
			] ),
			$this->title->getPrefixedText()
		)->inLanguage( $this->targetLang )->parse();
	}

	/**
	 * @return Array
	 */
	protected function getContentFooterMessages() {
		return [
			$this->getArticleLinkText(),
			$this->getAllChangesText(),
		];
	}
}

class WatchedPageEditedController extends WatchedPageController {
	protected $previousRevId;

	public function initEmail() {
		$this->previousRevId = $this->getVal( 'previousRevId' );

		parent::initEmail();
	}

	/**
	 * Validate the params passed in by the client
	 */
	protected function assertValidParams() {
		parent::assertValidParams();
		$this->assertValidRevIds();
	}

	protected function assertValidRevIds() {
		if ( empty( $this->previousRevId ) ) {
			throw new Check( "Empty value for previous Revision ID (param: previousRevId)" );
		}
	}

	/**
	 * @return String
	 */
	protected function getArticleLinkText() {
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
	protected function getSubjectMessageKey() {
		return 'emailext-watchedpage-article-edited-subject';
	}

	/**
	 * @return String
	 */
	protected function getSummaryMessageKey() {
		return 'emailext-watchedpage-article-edited';
	}
}

class WatchedPageProtectedController extends WatchedPageController {
	/**
	 * @return String
	 */
	protected function getSubjectMessageKey() {
		return 'emailext-watchedpage-article-protected-subject';
	}

	/**
	 * @return String
	 */
	protected function getSummaryMessageKey() {
		return 'emailext-watchedpage-article-protected';
	}
}

class WatchedPageUnprotectedController extends WatchedPageController {
	/**
	 * @return String
	 */
	protected function getSubjectMessageKey() {
		return 'emailext-watchedpage-article-unprotected-subject';
	}

	/**
	 * @return String
	 */
	protected function getSummaryMessageKey() {
		return 'emailext-watchedpage-article-unprotected';
	}
}

class WatchedPageDeletedController extends WatchedPageController {
	/**
	 * @return String
	 */
	protected function getSubjectMessageKey() {
		return 'emailext-watchedpage-article-deleted-subject';
	}

	/**
	 * @return String
	 */
	protected function getSummaryMessageKey() {
		return 'emailext-watchedpage-article-deleted';
	}

	/**
	 * @return String
	 */
	protected function getButtonText() {
		return wfMessage( 'emailext-watchedpage-deleted-button-text' )->inLanguage( $this->targetLang )->text();
	}

	/**
	 * @return String
	 */
	protected function getButtonLink() {
		return $this->title->getFullUrl();
	}

	/**
	 * @return Array
	 */
	protected function getContentFooterMessages() {
		return [];
	}
}

class WatchedPageRenamedController extends WatchedPageController {
	protected $newTitle;

	public function initEmail() {
		parent::initEmail();

		$this->newTitle = \WikiPage::factory( $this->title )->getRedirectTarget();
	}

	/**
	 * @return String
	 */
	protected function getSubjectMessageKey() {
		return 'emailext-watchedpage-article-renamed-subject';
	}

	/**
	 * @return String
	 */
	protected function getSummaryMessageKey() {
		return 'emailext-watchedpage-article-renamed';
	}

	/**
	 * @return String
	 */
	protected function getArticleLinkText() {
		return wfMessage( 'emailext-watchedpage-article-link-text',
			$this->newTitle->getFullURL(),
			$this->newTitle->getPrefixedText() )->inLanguage( $this->targetLang )->parse();
	}

	/**
	 * @return String
	 */
	protected function getAllChangesText() {
		return wfMessage( 'emailext-watchedpage-view-all-changes',
			$this->newTitle->getFullURL( 'action=history' ),
			$this->newTitle->getPrefixedText() )->inLanguage( $this->targetLang )->parse();
	}
}

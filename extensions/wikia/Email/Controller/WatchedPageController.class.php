<?php

namespace Email\Controller;

use Email\EmailController;

class WatchedPageController extends EmailController {

	const AVATAR_SIZE = 50;

	/* @var \Title */
	private $title;
	private $summary;
	private $currentRevId;
	private $previousRevId;
	private $timeStamp;
	private $replyToAddress;
	private $fromAddress;

	public function getSubject() {
		return wfMessage( 'emailext-watchedpage-subject', $this->title->getPrefixedText() );
	}

	public function initEmail() {
		$this->title = $this->request->getVal( 'title' );
		$this->summary = $this->request->getVal( 'summary' );
		$this->currentRevId = $this->request->getVal( 'currentRevId' );
		$this->previousRevId = $this->request->getVal( 'previousRevId' );
		$this->timeStamp = $this->request->getVal( 'timeStamp' );
		$this->replyToAddress = $this->request->getVal( 'replyToAddress' );
		$this->fromAddress = $this->request->getVal( 'fromAddress' );
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
				$this->title->getPrefixedText() )->inLanguage( $this->getTargetLang() )->parse()
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
			'editorAvatarURL' => $this->getEditorAvatarUR(),
			'summary' => $this->getSummary(),
			'buttonText' => $this->getCompareChangesLabel(),
			'buttonLink' => $this->getCompareChangesLink(),
			'contentFooterMessages' => [
				$this->getArticleLinkText(),
				$this->getAllChangesText(),
			],
			'timeStamp' => $this->getTimeStamp()
		] );
	}

	/**
	 * @return String
	 * Get rendered html for content unique to this email
	 * @todo We may want to make this available more generically for other emails to use the avatar layout.
	 */
	protected function getContent() {
		$css = file_get_contents( __DIR__ . '/../styles/avatarLayout.css' );
		$html = $this->app->renderView(
			get_class( $this ),
			'body',
			$this->request->getParams()
		);

		$html = $this->inlineStyles( $html, $css );

		return $html;
	}

	/**
	 * @return String
	 */
	private function getSalutation() {
		return wfMessage( 'emailext-watchedpage-salutation',
			$this->targetUser->getName() )->inLanguage( $this->getTargetLang() )->text();
	}

	/**
	 * @return String
	 */
	private function getArticleEditedText() {
		return wfMessage( 'emailext-watchedpage-article-edited',
			$this->title->getFullURL(),
			$this->title->getPrefixedText() )->inLanguage( $this->getTargetLang() )->parse();
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
		return wfMessage( "emailext-watchedpage-anonymous-editor" )->inLanguage( $this->getTargetLang() )->text();
	}

	/**
	 * @return String
	 */
	private function getEditorAvatarUR() {
		return \AvatarService::getAvatarUrl( $this->currentUser, self::AVATAR_SIZE );
	}

	/**
	 * @return String
	 */
	private function getSummary() {
		if ( !empty( $this->summary ) ) {
			return $this->summary;
		}
		return wfMessage( 'enotif_no_summary' )->inLanguage( $this->getTargetLang() )->text();
	}

	/**
	 * @return String
	 */
	private function getCompareChangesLabel() {
		return wfMessage( 'emailext-watchedpage-diff-button-text' )->inLanguage( $this->getTargetLang() )->text();
	}

	/**
	 * @return String
	 */
	private function getCompareChangesLink() {
		return $this->title->getFullUrl( 'diff=' . $this->currentRevId . '&oldid=' . $this->previousRevId );
	}

	/**
	 * @return String
	 */
	private function getArticleLinkText() {
		return wfMessage( 'emailext-watchedpage-article-link-text',
			$this->title->getFullURL(),
			$this->title->getPrefixedText() )->inLanguage( $this->getTargetLang() )->parse();
	}

	/**
	 * @return String
	 */
	private function getAllChangesText() {
		return wfMessage( 'emailext-watchedpage-view-all-changes',
			$this->title->getFullURL( 'action=history' ),
			$this->title->getPrefixedText() )->inLanguage( $this->getTargetLang() )->parse();
	}

	/**
	 * @return String
	 */
	private function getTimeStamp() {
		return \F::app()->wg->ContLang->userDate( $this->timestamp, $this->targetUser );
	}
}

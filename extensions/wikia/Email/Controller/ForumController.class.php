<?php

namespace Email\Controller;

use Email\Check;
use Email\EmailController;
use Email\Fatal;

class ForumController extends EmailController {

	protected $titleText;
	protected $titleUrl;
	protected $details;
	/* @var \Title */
	protected $board;

	public function initEmail() {
		$this->titleText = $this->request->getVal( 'titleText' );
		$this->titleUrl = $this->request->getVal( 'titleUrl' );
		$this->board = \Title::newFromText(
			$this->request->getVal( 'boardTitle' ),
			$this->request->getVal( 'boardNamespace' )
		);
		$this->details = $this->getVal( 'details' );

		$this->assertValidParams();
	}

	protected function assertValidParams() {
		if ( !$this->board instanceof \Title ) {
			throw new Check( "Invalid value passed for board" );
		}

		if ( !$this->board->exists() ) {
			throw new Check( "Board doesn't exist." );
		}
	}

	/**
	 * @template avatarLayout
	 */
	public function body() {
		$this->response->setData( [
			'salutation' => $this->getSalutation(),
			'editorProfilePage' => $this->getCurrentProfilePage(),
			'editorUserName' => $this->getCurrentUserName(),
			'editorAvatarURL' => $this->getCurrentAvatarURL(),
			'summary' => $this->getSummary(),
			'details' => $this->getDetails(),
			'detailsHeader' => $this->getDetailsHeader(),
			'buttonText' => $this->getButtonText(),
			'buttonLink' => $this->getButtonLink(),
		] );
	}

	public function getSubject() {
		return wfMessage( $this->getSubjectKey(), $this->boardText )
			->inLanguage( $this->targetLang )
			->text();
	}

	protected function getSubjectKey() {
		return 'emailext-forum-subject';
	}

	protected function getSalutation() {
		return wfMessage(
			'emailext-forum-salutation',
			$this->targetUser->getName()
		)->inLanguage( $this->targetLang )->text();
	}

	protected function getSummary() {
		return wfMessage( 'emailext-forum-summary', $this->board->getFullURL(), $this->board->getText() )
			->inLanguage( $this->targetLang )
			->parse();
	}

	protected function getDetails() {
		return $this->details;
	}

	protected function getButtonText() {
		return wfMessage( 'emailext-forum-button-label' )
			->inLanguage( $this->targetLang )
			->parse();
	}

	protected function getButtonLink() {
		return $this->titleUrl;
	}

	protected function getDetailsHeader() {
		return $this->titleText;
	}

	protected function getFooterMessages() {
		$boardUrl = $this->board->getFullURL( [
			'action' => 'unwatch'
		] );

		$footerMessages = [
			wfMessage( 'emailext-unfollow-text', $boardUrl, $this->board->getText() )
				->inLanguage( $this->targetLang )
				->parse()
		];

		return array_merge( $footerMessages, parent::getFooterMessages() );
	}
}

class ForumReplyController extends ForumController {
	protected function getButtonLink() {
		return $this->titleUrl;
	}

	protected function getViewAllLink() {
		return $this->titleUrl;
	}

	protected function getButtonLabelKey () {
		return 'emailext-forum-reply-link-label';
	}

	protected function getSummary() {
		return wfMessage( $this->getSummaryKey(), $this->titleText, $this->titleUrl )
			->inLanguage( $this->targetLang )
			->parse();
	}

	protected function getSubjectKey() {
		return 'emailext-forum-reply-subject';
	}

	protected function getSummaryKey() {
		return 'emailext-forum-reply-summary';
	}

	protected function getViewAllKey(){
		return 'emailext-forum-reply-view-all';
	}

	protected function getFooterMessages() {
		$unfollowUrl = $this->board->getFullURL( [
			'action' => 'unwatch'
		] );

		$footerMessages = [
			wfMessage( 'emailext-forum-reply-unfollow-text', $unfollowUrl, $this->titleText )
				->inLanguage( $this->targetLang )
				->parse()
		];
		return array_merge( $footerMessages, EmailController::getFooterMessages() );
	}
}

<?php

namespace Email\Controller;

use Email\Check;
use Email\EmailController;
use Email\Fatal;

class ForumController extends EmailController {

	/** @var \Title */
	protected $title;

	public function initEmail() {
		$titleText = $this->request->getVal( 'title' );
		$titleNamespace = $this->request->getVal( 'namespace' );

		$this->title = \Title::newFromText( $titleText, $titleNamespace );

		$this->assertValidParams();
	}

	/**
	 * Validate the params passed in by the client
	 */
	private function assertValidParams() {
		$this->assertValidTitle();
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
		$articleTitle = $this->title->getText();
		return wfMessage( $this->getSubjectKey(), $articleTitle )
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

	// TODO get board name
	protected function getSummary() {
		$articleTitle = $this->title->getText();

		return wfMessage( 'emailext-forum-summary', $articleTitle )
			->inLanguage( $this->targetLang )
			->text();
	}

	protected function getDetails() {
		global $wgParser;
		$article = new \Article($this->title);

		return strip_tags($wgParser->parse($article->getContent(), $this->title, $article->getParserOptions())->getText(), '<p><br>');
	}

	protected function getButtonText() {
		return wfMessage( 'emailext-forum-button-label')
			->inLanguage( $this->targetLang )
			->parse();
	}

	protected function getButtonLink() {
		return $this->title->getFullURL();
	}

	protected function getDetailsHeader() {
		return $this->title->getText();
	}

	// TODO footer message
	/*
	protected function getFooterMessages() {
		$parentUrl = $this->title->getCanonicalURL( 'action=unwatch' );
		$parentTitleText = $this->title->getPrefixedText();

		$footerMessages = [
			wfMessage( 'emailext-unfollow-text', $parentUrl, $parentTitleText )
				->inLanguage( $this->targetLang )
				->parse()
		];
		return array_merge( $footerMessages, parent::getFooterMessages() );
	}
	*/
}

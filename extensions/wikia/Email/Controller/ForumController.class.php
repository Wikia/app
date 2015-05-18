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

	protected static function getEmailSpecificFormFields() {
		$formFields =  [
			"inputs" => [
				[
					'type' => 'text',
					'name' => 'titleText',
					'label' => 'Title Text',
					'tooltip' => 'The title of the forum thread, eg "Changing the Font Size of Headings" from Title URL listed above'
				],
				[
					'type' => 'text',
					'name' => 'titleUrl',
					'label' => 'Title URL',
					'tooltip' => 'URL of the specific forum thread, eg http://community.wikia.com/wiki/Thread:841030'
				],
				[
					'type' => 'text',
					'name' => 'boardTitle',
					'label' => 'Board Title',
					'tooltip' => 'Name of the board, eg <wikiName>.wikia.com/wiki/Board:<wallUserName>'
				],
				[
					'type' => 'hidden',
					'name' => 'boardNamespace',
					'value' => NS_WIKIA_FORUM_BOARD
				],
				[
					'type' => 'text',
					'name' => 'details',
					'label' => 'Details',
					'tooltip' => 'The first posting in the board'
				],
			]
		];

		return $formFields;
	}
}

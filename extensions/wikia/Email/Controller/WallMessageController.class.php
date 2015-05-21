<?php

namespace Email\Controller;

use Email\Check;
use Email\EmailController;

abstract class WallMessageController extends EmailController {

	protected $titleUrl;
	protected $titleText;
	protected $details;

	protected $wallUserName;
	/** @var \Title */
	protected $wallTitle;
	protected $authorUserName;

	/**
	 * Get the summary text immediately following the salutation in the email
	 *
	 * @return string
	 */
	abstract protected function getSummary();

	public function initEmail() {
		$this->wallUserName = $this->request->getVal( 'wallUserName' );
		$this->authorUserName = $this->request->getVal( 'authorUserName' );

		$this->wallTitle = \Title::newFromText( $this->wallUserName, NS_USER_WALL );

		$this->assertUserRolesSet();

		$this->titleUrl = $this->request->getVal( 'titleUrl' );
		$this->titleText = $this->request->getVal( 'titleText' );
		$this->details = $this->request->getVal( 'details' );

		$this->assertMessageDetails();
	}

	protected function assertUserRolesSet() {
		if ( empty( $this->authorUserName ) ) {
			throw new Check( "Could not determine message author" );
		}

		if ( empty( $this->wallUserName ) ) {
			throw new Check( "Could not determine message owner" );
		}

		if ( !$this->wallTitle->exists() ) {
			throw new Check( "Given Message Wall doesn't exist" );
		}
	}

	protected function assertMessageDetails() {
		if ( empty( $this->titleUrl ) ) {
			throw new Check( "Message URL parameter (titleUrl) is required" );
		}

		if ( empty( $this->titleText ) ) {
			throw new Check( "Title text parameter (titleText) is required" );
		}

		if ( empty( $this->details ) ) {
			throw new Check( "Details parameter (details) is required" );
		}
	}

	/**
	 * @template avatarLayout
	 */
	public function body() {
		$this->response->setData( [
			'salutation' => $this->getSalutation(),
			'summary' => $this->getSummary(),
			'editorProfilePage' => $this->getCurrentProfilePage(),
			'editorUserName' => $this->authorUserName,
			'editorAvatarURL' => $this->getCurrentAvatarURL(),
			'detailsHeader' => $this->titleText,
			'details' => $this->details,
			'buttonText' => $this->getButtonText(),
			'buttonLink' => $this->titleUrl,
			'contentFooterMessages' => [
				$this->getRecentMessagesText()
			],
		] );
	}

	/**
	 * Get the localized text describing the full message thread link
	 *
	 * @return string
	 */
	protected function getButtonText() {
		return wfMessage( 'emailext-wallmessage-full-conversation' )
			->inLanguage( $this->targetLang )
			->text();
	}

	/**
	 * Get the localized text describing the recent messages link
	 *
	 * @return string
	 */
	protected function getRecentMessagesText() {
		return wfMessage(
			'emailext-wallmessage-recent-messages',
			$this->wallTitle->getFullURL(),
			$this->wallTitle->getPrefixedText() )
		->inLanguage( $this->targetLang )->parse();
	}

	protected static function getEmailSpecificFormFields() {
		$formFields =  [
			"inputs" => [
				[
					'type' => 'text',
					'name' => 'wallUserName',
					'label' => 'Wall Username',
					'tooltip' => 'Name of the board, eg <wikiName>.wikia.com/wiki/Board:<wallUserName>'
				],
				[
					'type' => 'text',
					'name' => 'authorUserName',
					'label' => 'Author Username',
					'tooltip' => 'Username of the user who posted a reply'
				],
				[
					'type' => 'text',
					'name' => 'titleUrl',
					'label' => 'Title URL',
					'tooltip' => 'URL of the specific forum thread, eg http://community.wikia.com/wiki/Thread:841030#2'
				],
				[
					'type' => 'text',
					'name' => 'titleText',
					'label' => 'Title Text',
					'tooltip' => 'The title of the forum thread, eg "Changing the Font Size of Headings" from Title URL listed above'
				],
				[
					'type' => 'text',
					'name' => 'details',
					'label' => 'Details',
					'tooltip' => 'The text of post'
				],
			]
		];

		return $formFields;
	}
}

class OwnWallMessageController extends WallMessageController {

	/**
	 * Get the summary text immediately following the salutation in the email
	 *
	 * @return string
	 */
	protected function getSummary() {
		return wfMessage( 'emailext-wallmessage-owned-summary',
			$this-> getCurrentProfilePage(), $this->authorUserName
		)->inLanguage( $this->targetLang )->parse();
	}

	/**
	 * Get the email subject line
	 *
	 * @return string
	 */
	protected function getSubject() {
		return wfMessage( 'emailext-wallmessage-owned-subject',
			$this->authorUserName
		)->inLanguage( $this->targetLang )->text();
	}
}

class ReplyWallMessageController extends OwnWallMessageController {
	/** @var \Title */
	protected $title;

	public function initEmail() {
		parent::initEmail();

		$this->title = \Title::newFromText( $this->getVal( 'threadId' ), NS_USER_WALL_MESSAGE );
	}

	protected function getFooterMessages() {
		$unwatchUrl = $this->title->getFullURL( [
			'action' => 'unwatch'
		] );

		$footerMessages = [
			wfMessage( 'emailext-unfollow-text', $unwatchUrl, $this->title->getPrefixedText() )
				->inLanguage( $this->targetLang )->parse()
		];
		return array_merge( $footerMessages, parent::getFooterMessages() );
	}
}

class FollowedWallMessageController extends WallMessageController {

	/**
	 * Get the summary text immediately following the salutation in the email
	 *
	 * @return string
	 */
	protected function getSummary() {
		return wfMessage( 'emailext-wallmessage-following-summary',
			$this-> getCurrentProfilePage(),
			$this->authorUserName,
			$this->wallUserName
		)->inLanguage( $this->targetLang )->parse();
	}

	/**
	 * Get the email subject line
	 *
	 * @return string
	 */
	protected function getSubject() {
		return wfMessage( 'emailext-wallmessage-following-subject',
			$this->authorUserName,
			$this->wallUserName
		)->inLanguage( $this->targetLang )->text();
	}

	protected function getFooterMessages() {
		$unwatchUrl = $this->wallTitle->getFullURL( [
			'action' => 'unwatch'
		] );

		$footerMessages = [
			wfMessage( 'emailext-unfollow-text', $unwatchUrl, $this->wallTitle->getPrefixedText() )
				->inLanguage( $this->targetLang )->parse()
		];
		return array_merge( $footerMessages, parent::getFooterMessages() );
	}
}

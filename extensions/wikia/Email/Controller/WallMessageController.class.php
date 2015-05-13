<?php

namespace Email\Controller;

use Email\Check;
use Email\EmailController;

// TODO fix replies on MY message wall to fire an email
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

		$this->assertUserRolesSet();

		$this->titleUrl = $this->request->getVal( 'titleUrl' );
		$this->titleText = $this->request->getVal( 'titleText' );
		$this->details = $this->request->getVal( 'details' );

		$this->wallTitle = \Title::newFromText( $this->wallUserName, NS_USER_WALL );

		$this->assertMessageDetails();
	}

	protected function assertUserRolesSet() {
		if ( empty( $this->authorUserName ) ) {
			throw new Check( "Could not determine message author" );
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
			'detailsSubject' => $this->titleText,
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

	protected function getFooterMessages() {
		$unfollowURL = $this->wallTitle->getFullURL( [
			'action' => 'unwatch'
		] );

		$footerMessages = [
			wfMessage( 'emailext-unfollow-text', $unfollowURL, $this->wallTitle->getPrefixedText() )
				->inLanguage( $this->targetLang )->parse()
		];
		return array_merge( $footerMessages, parent::getFooterMessages() );
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
			$this->authorUserName
		)->inLanguage( $this->targetLang )->parse();
	}

	protected function getFooterMessages() {
		return EmailController::getFooterMessages();
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

class FollowedWallMessageController extends WallMessageController {

	/**
	 * Get the summary text immediately following the salutation in the email
	 *
	 * @return string
	 */
	protected function getSummary() {
		return wfMessage( 'emailext-wallmessage-following-summary',
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
}

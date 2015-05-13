<?php

namespace Email\Controller;

use Email\Check;
use Email\EmailController;

// TODO fix replies on MY message wall to fire an email
class WallMessageController extends EmailController {

	private $messageUrl;
	private $messageTitle;
	private $messageBody;

	private $wallUserName;
	private $senderUserName;
	private $receiverUserName;

	public function initEmail() {
		$this->wallUserName = $this->request->getVal( 'wallUserName' );
		$threadUserName = $this->request->getVal( 'threadUserName' );
		$replyUserName = $this->request->getVal( 'replyUserName' );
		$isThread = $this->request->getVal( 'isThread' );

		if ( $isThread ) {
			$this->senderUserName = $threadUserName;
			$this->receiverUserName = $this->wallUserName;
		} else {
			$this->senderUserName = $replyUserName;
			$this->receiverUserName = $threadUserName;
		}

		$this->assertUserRolesSet();

		$this->messageUrl = $this->request->getVal( 'messageUrl' );
		$this->messageTitle = $this->request->getVal( 'messageTitle' );
		$this->messageBody = $this->request->getVal( 'messageBody' );

		$this->assertMessageDetails();
	}

	private function assertUserRolesSet() {
		if ( empty( $this->senderUserName ) ) {
			throw new Check( "Could not determine message sender" );
		}

		if ( empty( $this->receiverUserName ) ) {
			throw new Check( "Could not determine message recipient" );
		}
	}

	private function assertMessageDetails() {
		if ( empty( $this->messageUrl ) ) {
			throw new Check( "Message URL parameter (messageUrl) is required" );
		}

		if ( empty( $this->messageTitle ) ) {
			throw new Check( "Message title parameter (messageTitle) is required" );
		}

		if ( empty( $this->messageBody ) ) {
			throw new Check( "Message body parameter (messageBody) is required" );
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
			'editorUserName' => $this->senderUserName,
			'editorAvatarURL' => $this->getCurrentAvatarURL(),
			'detailsSubject' => $this->messageTitle,
			'details' => $this->messageBody,
			'buttonText' => $this->getButtonText(),
			'buttonLink' => $this->messageUrl,
			'contentFooterMessages' => [
				$this->getRecentMessagesText()
			],
		] );
	}

	/**
	 * Whether this thread topic or thread reply is meant for the user getting this email
	 *
	 * @return boolean
	 */
	protected function isForTargetUser() {
		$targetName = $this->targetUser->getName();
		return $targetName == $this->receiverUserName;
	}

	/**
	 * Get the email subject line
	 *
	 * @return string
	 */
	public function getSubject() {
		if ( $this->isForTargetUser() ) {
			return wfMessage( 'emailext-wallmessage-owned-subject',
				$this->senderUserName
			)->inLanguage( $this->targetLang )->text();
		} else {
			return wfMessage( 'emailext-wallmessage-following-subject',
				$this->senderUserName,
				$this->receiverUserName
			)->inLanguage( $this->targetLang )->text();
		}
	}

	/**
	 * Get the summary text immediately following the salutation in the email
	 *
	 * @return string
	 */
	protected function getSummary() {
		if ( $this->isForTargetUser() ) {
			return wfMessage( 'emailext-wallmessage-owned-summary',
				$this->senderUserName
			)->inLanguage( $this->targetLang )->parse();
		} else {
			return wfMessage( 'emailext-wallmessage-following-summary',
				$this->senderUserName,
				$this->receiverUserName
			)->inLanguage( $this->targetLang )->parse();
		}
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
		$ownerWall = \Title::newFromText( $this->wallUserName, NS_USER_WALL );
		$wallUrl = $ownerWall->getFullURL();

		return wfMessage( 'emailext-wallmessage-recent-messages', $wallUrl )
			->inLanguage( $this->targetLang )->parse();
	}

	protected function getFooterMessages() {
		// TODO remove this link on MY message wall

		$footerMessages = [
			wfMessage( 'emailext-unfollow-text' )->inLanguage( $this->targetLang )->parse()
		];
		return array_merge( $footerMessages, parent::getFooterMessages() );
	}
}

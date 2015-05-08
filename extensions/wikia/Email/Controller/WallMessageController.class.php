<?php

namespace Email\Controller;

use Email\EmailController;

class WallMessageController extends EmailController {

	/**
	 * @template wallMessage
	 */
	public function body() {
		$this->response->setData( [
			'salutation' => $this->getSalutation(),
			'summary' => $this->getSummary(),
			'editorProfilePage' => $this->getCurrentProfilePage(),
			'editorUserName' => $this->request->getVal( 'fromName' ),
			'editorAvatarURL' => $this->getCurrentAvatarURL(),
			'wallMessageTitle' => $this->request->getVal( 'messageTitle' ),
			'wallMessageBody' => $this->request->getVal( 'messageBody' ),
			'buttonText' => $this->getFullConversationText(),
			'buttonLink' => $this->getFullConversationUrl(),
			'contentFooterMessages' => [
				$this->getRecentMessagesText()
			],
		] );
	}

	/**
	 * Whether this email is for a user following a thread on someone else's wall
	 *
	 * @return boolean
	 */
	protected function isForFollowedThread() {
		return (bool) $this->request->getVal( 'targetUser' ) !== $this->request->getVal( 'wallUserName' );
	}

	/**
	 * Get the email subject line
	 *
	 * @return string
	 */
	public function getSubject() {
		if ( $this->isForFollowedThread() ) {
			return wfMessage( 'emailext-wallmessage-following-subject',
				$this->request->getVal( 'fromName' ),
				$this->request->getVal( 'wallUserName' )
			)->inLanguage( $this->targetLang )->text();
		} else {
			return wfMessage( 'emailext-wallmessage-owned-subject',
				$this->request->getVal( 'fromName' )
			)->inLanguage( $this->targetLang )->text();
		}
	}

	/**
	 * Get the summary text immediately following the salutation in the email
	 *
	 * @return string
	 */
	protected function getSummary() {
		if ( $this->isForFollowedThread() ) {
			return wfMessage( 'emailext-wallmessage-following-summary',
				$this->request->getVal( 'fromName' ),
				$this->request->getVal( 'wallUserName' )
			)->inLanguage( $this->targetLang )->parse();
		} else {
			return wfMessage( 'emailext-wallmessage-owned-summary',
				$this->request->getVal( 'fromName' )
			)->inLanguage( $this->targetLang )->parse();
		}
	}

	/**
	 * Get the localized text describing the full message thread link
	 *
	 * @return string
	 */
	protected function getFullConversationText() {
		return wfMessage( 'emailext-wallmessage-full-conversation' )->inLanguage( $this->targetLang )->text();
	}

	/**
	 * Get the URL to the full message thread
	 *
	 * @return string
	 */
	protected function getFullConversationUrl() {
		return $this->request->getVal( 'url' );
	}

	/**
	 * Get the localized text describing the recent messages link
	 *
	 * @return string
	 */
	protected function getRecentMessagesText() {
		$wallTitleText = $this->isForFollowedThread() ? $this->request->getVal( 'wallUserName' ) :
			$this->request->getVal( 'targetuser' );
		return wfMessage( 'emailext-wallmessage-recent-messages',
			\Wall::newFromTitle( \Title::newFromText( $wallTitleText ) )->getUrl()
		)->inLanguage( $this->targetLang )->parse();
	}

	protected function getFooterMessages() {
		$footerMessages = [
			wfMessage( 'emailext-unfollow-text' )->inLanguage( $this->targetLang )->parse()
		];
		return array_merge( $footerMessages, parent::getFooterMessages() );
	}
}

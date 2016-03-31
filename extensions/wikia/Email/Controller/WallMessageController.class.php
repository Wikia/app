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
	/** @var \Title */
	protected $wallMessageTitle;

	/**
	 * Get the summary text immediately following the salutation in the email
	 *
	 * @return string
	 */
	abstract protected function getSummary();

	public function initEmail() {
		$this->wallUserName = $this->request->getVal( 'wallUserName' );

		// Anon's have IPs for usernames so choose something more appropriate in that case
		if ( $this->currentUser->isAnon() ) {
			$this->authorUserName = $this->getMessage( 'emailext-anonymous-editor' )->text();
		} else {
			$this->authorUserName = $this->currentUser->getName();
		}

		$this->wallTitle = \Title::newFromText( $this->wallUserName, NS_USER_WALL );

		$this->assertUserRolesSet();

		$this->titleUrl = $this->request->getVal( 'titleUrl' );
		$this->titleText = $this->request->getVal( 'titleText' );
		$this->details = $this->request->getVal( 'details' );
		$this->wallMessageTitle = \Title::newFromText( $this->getVal( 'threadId' ), NS_USER_WALL_MESSAGE );

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
			'hasContentFooterMessages' => true,
		] );
	}

	/**
	 * Get the localized text describing the full message thread link
	 *
	 * @return string
	 */
	protected function getButtonText() {
		return $this->getMessage( 'emailext-wallmessage-full-conversation' )->text();
	}

	/**
	 * Get the localized text describing the recent messages link
	 *
	 * @return string
	 */
	protected function getRecentMessagesText() {
		return $this->getMessage(
			'emailext-wallmessage-recent-messages',
			$this->wallTitle->getFullURL(),
			$this->wallTitle->getPrefixedText()
		)->parse();
	}

	protected static function getEmailSpecificFormFields() {
		$formFields =  [
			"inputs" => [
				[
					'type' => 'text',
					'name' => 'wallUserName',
					'label' => 'Wall Username',
					'tooltip' => 'Name of the board, eg <wikiName>.wikia.com/wiki/Message_Wall:<wallUserName>'
				],
				[
					'type' => 'text',
					'name' => 'titleUrl',
					'label' => 'Title URL',
					'tooltip' => 'URL of the specific wall thread, eg http://community.wikia.com/wiki/Thread:8410302'
				],
				[
					'type' => 'text',
					'name' => 'titleText',
					'label' => 'Title Text',
					'tooltip' => 'The title of the wall thread, eg "Changing the Font Size of Headings" from Title URL listed above'
				],
				[
					'type' => 'text',
					'name' => 'details',
					'label' => 'Details',
					'tooltip' => 'The text of post'
				],
				[
					'type' => 'text',
					'name' => 'threadId',
					'label' => 'Thread ID',
					'tooltip' => 'Message thread ID, eg. http://community.wikia.com/wiki/Thread:<threadId>'
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
		return $this->getMessage( 'emailext-wallmessage-owned-summary',
			$this->wallMessageTitle->getFullURL(),
			$this->titleText
		)->parse();
	}

	/**
	 * Get the email subject line
	 *
	 * @return string
	 */
	protected function getSubject() {
		return $this->getMessage( 'emailext-wallmessage-owned-subject', $this->titleText )->text();
	}
}

class ReplyWallMessageController extends WallMessageController {

	/** @var \Title */
	protected $containingThread;

	public function initEmail() {
		parent::initEmail();
		$this->containingThread = \Title::newFromText( $this->getVal( 'parentId' ), NS_USER_WALL_MESSAGE );
	}

	/**
	 * Get the summary text immediately following the salutation in the email
	 *
	 * @return string
	 */
	protected function getSummary() {
		return $this->getMessage( 'emailext-wallmessage-reply-summary',
			$this->containingThread->getFullURL(),
			$this->titleText
		)->parse();
	}

	/**
	 * Get the email subject line
	 *
	 * @return string
	 */
	protected function getSubject() {
		return $this->getMessage( 'emailext-wallmessage-reply-subject', $this->titleText )->parse();
	}

	protected function getFooterMessages() {
		$unwatchUrl = $this->containingThread->getFullURL( [
			'action' => 'unwatch'
		] );

		$footerMessages = [
			$this->getMessage( 'emailext-unfollow-text', $unwatchUrl, $this->containingThread->getPrefixedText() )
				->parse()
		];
		return array_merge( $footerMessages, parent::getFooterMessages() );
	}

	protected static function getEmailSpecificFormFields() {
		$formFields = [
			"inputs" => [
				[
					'type'  => 'text',
					'name' => 'parentId',
					'label' => 'parentID',
					'tooltip' => 'Message thread ID, eg. http://community.wikia.com/wiki/Thread:<threadId>. ' .
						'Use the same value as you did for threadId.'
				]
			]
		];

		return array_merge_recursive( parent::getEmailSpecificFormFields(), $formFields );
	}
}

class FollowedWallMessageController extends WallMessageController {

	/**
	 * Get the summary text immediately following the salutation in the email
	 *
	 * @return string
	 */
	protected function getSummary() {
		return $this->getMessage( 'emailext-wallmessage-following-summary',
			$this->wallUserName,
			$this->wallMessageTitle->getFullURL(),
			$this->titleText
		)->parse();
	}

	/**
	 * Get the email subject line
	 *
	 * @return string
	 */
	protected function getSubject() {
		return $this->getMessage( 'emailext-wallmessage-following-subject',
			$this->wallUserName,
			$this->titleText
		)->text();
	}

	protected function getFooterMessages() {
		$unwatchUrl = $this->wallTitle->getFullURL( [
			'action' => 'unwatch'
		] );

		$footerMessages = [
			$this->getMessage( 'emailext-unfollow-text', $unwatchUrl, $this->wallTitle->getPrefixedText() )
				->parse()
		];
		return array_merge( $footerMessages, parent::getFooterMessages() );
	}
}

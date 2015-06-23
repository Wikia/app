<?php

namespace Email\Controller;

use Email\Check;
use Email\EmailController;
use Email\Tracking\TrackingCategories;

abstract class WallMessageController extends EmailController {

	const TRACKING_CATEGORY = TrackingCategories::WALL_NOTIFICATION;

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
					'tooltip' => 'Name of the board, eg <wikiName>.wikia.com/wiki/Board:<wallUserName>'
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
				[
					'type' => 'text',
					'name' => 'threadId',
					'label' => 'Thread ID',
					'tooltip' => 'Message thread ID'
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
			\Title::newFromText( $this->getVal( 'threadId' ), NS_USER_WALL_MESSAGE )->getFullURL(),
			$this->titleText
		)->parse();
	}

	/**
	 * Get the email subject line
	 *
	 * @return string
	 */
	protected function getSubject() {
		return $this->getMessage( 'emailext-wallmessage-owned-subject', $this->titleText )->parse();
	}
}

class ReplyWallMessageController extends OwnWallMessageController {
	/** @var \Title */
	protected $title;

	public function initEmail() {
		parent::initEmail();

		$this->title = \Title::newFromText( $this->getVal( 'threadId' ), NS_USER_WALL_MESSAGE );
	}

	/**
	 * Get the summary text immediately following the salutation in the email
	 *
	 * @return string
	 */
	protected function getSummary() {
		return $this->getMessage( 'emailext-wallmessage-reply-summary',
			\Title::newFromText( $this->getVal( 'threadId' ), NS_USER_WALL_MESSAGE )->getFullURL(),
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
		$unwatchUrl = $this->title->getFullURL( [
			'action' => 'unwatch'
		] );

		$footerMessages = [
			$this->getMessage( 'emailext-unfollow-text', $unwatchUrl, $this->title->getPrefixedText() )
				->parse()
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
		return $this->getMessage( 'emailext-wallmessage-following-summary',
			$this->wallUserName,
			\Title::newFromText( $this->getVal( 'threadId' ), NS_USER_WALL_MESSAGE )->getFullURL(),
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

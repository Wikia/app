<?php

namespace Email\Controller;

use Email\Check;
use Email\EmailController;

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
			'details' => $this->details,
			'detailsHeader' => $this->titleText,
			'buttonText' => $this->getButtonText(),
			'buttonLink' => $this->titleUrl,
			'contentFooterMessages' => $this->getContentFooterMessages(),
			'hasContentFooterMessages' => true,
		] );
	}

	public function getSubject() {
		return $this->getMessage( $this->getSubjectKey(), $this->board->getText() )->text();
	}

	protected function getSubjectKey() {
		return 'emailext-forum-subject';
	}

	protected function getSummary() {
		return $this->getMessage( 'emailext-forum-summary', $this->board->getFullURL(), $this->board->getText() )->parse();
	}

	protected function getButtonText() {
		return $this->getMessage( $this->getButtonTextKey() )->parse();
	}
	protected function getButtonTextKey() {
		return 'emailext-forum-button-label';
	}

	protected function getContentFooterMessages() {
		return [];
	}

	protected function getFooterMessages() {
		$boardUrl = $this->board->getFullURL( [
			'action' => 'unwatch'
		] );

		$footerMessages = [
			$this->getMessage( 'emailext-unfollow-text', $boardUrl, $this->board->getText() )->parse()
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
					'tooltip' => 'The title of the forum thread, eg "Changing the Font Size of Headings" from Title URL given'
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
					'tooltip' => 'Name of the board, eg "Support Requests - Getting Started board"'
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
					'tooltip' => 'Content of the post/reply'
				],
			]
		];

		return $formFields;
	}
}

class ReplyForumController extends ForumController {

	/** @var \Title */
	protected $parent;

	public function initEmail() {
		parent::initEmail();

		// This is a bit confusing; discussion URLs use the ID as their user facing title text, so the Title
		// object is constructed as if the ID is the title text and with NS_USER_WALL_MESSAGE as the namespace.
		// This is completely bogus since the dbKey is actually something much different and for this
		// reason, a call to $parent->exists() will fail.
		$id = $this->request->getVal( 'parentId' );
		$this->parent = \Title::newFromText( $id, NS_USER_WALL_MESSAGE );

		$this->assertValidReplyParams();
	}

	protected function assertValidReplyParams() {
		if ( !$this->parent instanceof \Title ) {
			throw new Check( "Could not find parent for parentId given" );
		}
	}

	public function getSubject() {
		return $this->getMessage( $this->getSubjectKey(), $this->titleText )->text();
	}

	protected function getSummary() {
		return $this->getMessage(
			$this->getSummaryKey(),
			$this->titleText,
			$this->parent->getFullURL()
		)->parse();
	}

	protected function getContentFooterMessages() {
		return array_merge( parent::getContentFooterMessages(), [ $this->getViewAll() ] );
	}

	protected function getViewAll() {
		return $this->getMessage( 'emailext-forum-reply-view-all', $this->parent->getFullURL() )->parse();
	}

	protected function getFooterMessages() {
		$unfollowUrl =  $this->parent->getFullURL( [
			'action' => 'unwatch'
		] );

		$footerMessages = [
			$this->getMessage(
				'emailext-forumreply-unfollow-text',
				$unfollowUrl,
				$this->parent->getFullURL()
			)->parse()
		];

		return array_merge( $footerMessages, EmailController::getFooterMessages() );
	}

	protected function getButtonTextKey() {
		return 'emailext-forum-reply-link-label';
	}

	protected function getSubjectKey() {
		return 'emailext-forum-reply-subject';
	}

	protected function getSummaryKey() {
		return 'emailext-forum-reply-summary';
	}

	protected static function getEmailSpecificFormFields() {
		$formFields = parent::getEmailSpecificFormFields();

		$formFields['inputs'][] = [
			'type' => 'text',
			'name' => 'parentId',
			'label' => 'Parent ID',
			'tooltip' => 'The id of the forum thread, eg "841030" from URL like:  http://community.wikia.com/wiki/Thread:841030'
		];

		return $formFields;
	}
}

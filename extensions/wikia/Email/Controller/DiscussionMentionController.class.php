<?php

namespace Email\Controller;

use Email\Check;
use Email\EmailController;

class DiscussionMentionController extends EmailController {

	protected $siteId;
	protected $threadId;
	protected $postId;

	protected $wikiInfo;
	protected $discussionPermalink;

	/**
	 * Get the summary text immediately following the salutation in the email
	 *
	 * @return string
	 */
	protected function getSummary() {
		return $this->getMessage(
			'emailext-discussionmention-summary',
			$this->getCurrentProfilePage(),
			$this->getCurrentUserName(),
			$this->wikiInfo->city_title,
			$this->discussionPermalink
		)->parse();
	}

	protected function getSubject() {
		return $this->getMessage(
			'emailext-discussionmention-subject',
			$this->wikiInfo->city_title
		)->text();
	}

	public function initEmail() {
		$this->siteId = $this->request->getVal( 'siteId' );
		$this->threadId = $this->request->getVal( 'threadId' );
		$this->postId = $this->request->getVal( 'postId' );

		$this->assertContext();

		$this->wikiInfo = \WikiFactory::getWikiByID($this->siteId);
		$this->discussionPermalink = $this->generatePermalink();
	}

	protected function assertContext() {
		if ( empty( $this->siteId ) ) {
			throw new Check("Discussion siteId missing");
		}

		if ( empty( $this->threadId ) ) {
			throw new Check("The threadId parameter is required");
		}
	}

	protected function getBaseDiscussionUrl() {
		$url = \WikiFactory::getLocalEnvURL($this->wikiInfo->city_url);
		$url  .= '/d';

		return $url;
	}

	protected function generatePermalink() {
		$url = $this->getBaseDiscussionUrl();

		$url  .= '/p/' . $this->threadId;

		if ( !empty( $this->postId ) ) {
			$url .= '/r/' . $this->postId;
		}

		return $url;
	}

	/**
	 * @template avatarLayout
	 */
	public function body() {
		$this->response->setData( [
			'salutation' => $this->getSalutation(),
			'summary' => $this->getSummary(),
			'editorProfilePage' => $this->getCurrentProfilePage(),
			'editorUserName' => $this->getCurrentUserName(),
			'editorAvatarURL' => $this->getCurrentAvatarURL(),
			'detailsHeader' => '',
			'details' => '',
			'buttonText' => $this->getButtonText(),
			'buttonLink' => $this->getBaseDiscussionUrl(),
		] );
	}

	/**
	 * Get the localized text describing the full message thread link
	 *
	 * @return string
	 */
	protected function getButtonText() {
		return $this->getMessage( 'emailext-discussionmention-conversation' )->text();
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
					'name' => 'siteId',
					'label' => 'Wiki site ID',
					'tooltip' => 'The ID for the wiki the discussion is on'
				],
				[
					'type' => 'text',
					'name' => 'threadId',
					'label' => 'Thread/Post ID',
					'tooltip' => 'The ID for the post (thread on the backend) with the mention'
				],
				[
					'type' => 'text',
					'name' => 'postId',
					'label' => 'Post/Reply ID',
					'tooltip' => 'The ID for the reply (post on the backend) with the mention (optional)'
				],
			]
		];

		return $formFields;
	}
}

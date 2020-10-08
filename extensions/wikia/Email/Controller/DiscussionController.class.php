<?php

namespace Email\Controller;

use Email\Check;
use Email\EmailController;
use Wikia\Logger\WikiaLogger;

abstract class DiscussionController extends EmailController {

	protected $postContent;
	protected $postUrl;
	protected $wiki;

	public function initEmail() {
		$this->postContent = $this->request->getVal( 'postContent' );
		$this->postUrl = $this->request->getVal( 'postUrl' );
		$this->setWikiFromWikiID();
		$this->assertValidParams();
	}

	private function setWikiFromWikiID() {
		$siteId = $this->request->getVal( 'siteId' );
		if ( empty( $siteId ) ) {
			throw new Check( 'Empty value passed for required param siteId' );
		}

		$this->wiki = \WikiFactory::getWikiByID( $siteId );
		if ( !$this->wiki ) {
			throw new Check( "Unable to find wiki information for siteId $siteId" );
		}

		WikiaLogger::instance()->info(
			'Wiki instance created',
			[
				'issue' => 'IW-3264',
				'city_id' => $this->wiki->city_id,
				'city_url' => $this->wiki->city_url
			]
		);
	}

	protected function assertValidParams() {
		if ( empty( $this->postUrl ) ) {
			throw new Check( 'Empty value passed for required param postUrl' );
		}
	}

	/**
	 * @template avatarLayout
	 */
	public function body() {
		$this->response->setData(
			[
				'salutation' => $this->getSalutation(),
				'summary' => $this->getSummary(),
				'editorProfilePage' => $this->getCurrentProfilePage(),
				'editorUserName' => $this->getCurrentUserName(),
				'editorAvatarURL' => $this->getCurrentAvatarURL(),
				'details' => $this->getDetails(),
				'buttonText' => $this->getButtonText(),
				'buttonLink' => $this->postUrl,
				'contentFooterMessages' => $this->getContentFooterMessages(),
				'hasContentFooterMessages' => true,
			]
		);
	}

	protected abstract function getSummary();

	protected function getDetails() {
		return $this->postContent;
	}

	private function getButtonText() {
		return $this->getMessage( 'emailext-discussion-button-text' )->text();
	}

	protected function getContentFooterMessages() {
		return [
			$this->getMessage(
				'emailext-discussion-all-discussions',
				$this->getDiscussionsLink(),
				$this->wiki->city_title
			)
		];
	}

	protected function getDiscussionsLink() {
		return $this->wiki->city_url . 'f';
	}

	/**
	 * Wrap the provided text in <nowiki> tags. This escapes the text preventing
	 * it from being parsed as wikitext.
	 * @param $text
	 * @return string
	 */
	protected function wrapTextInNoWikiTags( $text ) {
		return '<nowiki>' . $text . '</nowiki>';
	}

	protected static function getEmailSpecificFormFields() {
		return [
			'inputs' => [
				[
					'type' => 'text',
					'name' => 'siteId',
					'label' => 'Site ID',
				],
				[
					'type' => 'text',
					'name' => 'postContent',
					'label' => 'Content of the post',
				],
				[
					'type' => 'text',
					'name' => 'currentUserId',
					'label' => 'ID of user to send email as',
				],
				[
					'type' => 'text',
					'name' => 'postUrl',
					'label' => 'URL of the post',
				]
			]
		];
	}
}

class DiscussionReplyController extends DiscussionController {

	private $threadTitle;

	public function initEmail() {
		$this->threadTitle = $this->request->getVal( "threadTitle" );
		parent::initEmail();
	}

	public function getSubject() {
		return strip_tags( $this->getSummary() );
	}

	public function getSummary() {
		if ( !empty( $this->threadTitle ) ) {
			return $this->getMessage(
				'emailext-discussion-reply-with-title-subject',
				$this->postUrl,
				$this->wrapTextInNoWikiTags( $this->threadTitle ),
				$this->wiki->city_url,
				$this->wiki->city_title
			)->parse();
		}

		return $this->getMessage(
			'emailext-discussion-reply-subject',
			$this->wiki->city_url,
			$this->wiki->city_title
		)->parse();
	}

	protected static function getEmailSpecificFormFields() {
		$formFields = [
			'inputs' => [
				[
					'type' => 'text',
					'name' => 'threadTitle',
					'label' => 'Title of thread being responded to (Optional)',
				]
			]
		];

		return array_merge_recursive( parent::getEmailSpecificFormFields(), $formFields );
	}

	/**
	 * Asserts that target user is subscribed to Discussions Follow emails.
	 *
	 * @throws \Email\Check
	 */
	public function assertCanEmail() {
		parent::assertCanEmail();

		$wantsDiscussionEmails = ( bool ) $this->targetUser->getGlobalPreference( 'enotifdiscussionsfollows' );

		if ( !$wantsDiscussionEmails ) {
			throw new Check( 'User is not subscribed to Discussions Follow emails.' );
		}
	}

}

class DiscussionUpvoteController extends DiscussionController {

	private $postTitle;
	private $upVotes;

	CONST MESSAGE_KEYS = [
		5 => [
			'subject-with-title' => 'emailext-discussion-5-upvote-subject-with-title',
			'subject' => 'emailext-discussion-5-upvote-subject',
			'summary-with-title' => 'emailext-discussion-5-upvote-summary-with-title',
			'summary' => 'emailext-discussion-5-upvote-summary',
		],
		25 => [
			'subject-with-title' => 'emailext-discussion-25-upvote-subject-with-title',
			'subject' => 'emailext-discussion-25-upvote-subject',
			'summary-with-title' => 'emailext-discussion-25-upvote-summary-with-title',
			'summary' => 'emailext-discussion-25-upvote-summary',
		],
		100 => [
			'subject-with-title' => 'emailext-discussion-100-upvote-subject-with-title',
			'subject' => 'emailext-discussion-100-upvote-subject',
			'summary-with-title' => 'emailext-discussion-100-upvote-summary-with-title',
			'summary' => 'emailext-discussion-100-upvote-summary',
		]
	];

	public function initEmail() {
		$this->postTitle = $this->request->getVal( 'postTitle' );
		$this->upVotes = $this->request->getVal( 'upVotes' );
		parent::initEmail();
	}

	protected function assertValidParams() {
		parent::assertValidParams();

		if ( empty( $this->upVotes ) ) {
			throw new Check( 'Empty value passed for required param upVotes' );
		}

		if ( !array_key_exists( $this->upVotes, self::MESSAGE_KEYS ) ) {
			throw new Check( 'Invalid value for param upvoteCount. Must be 5, 25, 100' );
		}
	}

	public function getSubject() {
		if ( !empty( $this->postTitle ) ) {
			return $this->getMessage(
				self::MESSAGE_KEYS[$this->upVotes]['subject-with-title'],
				$this->postTitle,
				$this->wiki->city_title
			);
		}

		return $this->getMessage(
			self::MESSAGE_KEYS[$this->upVotes]['subject'],
			$this->wiki->city_title
		);
	}

	public function getSummary() {
		if ( !empty( $this->postTitle ) ) {
			return $this->getMessage(
				self::MESSAGE_KEYS[$this->upVotes]['summary-with-title'],
				$this->postUrl,
				$this->wrapTextInNoWikiTags( $this->postTitle ),
				$this->wiki->city_url,
				$this->wiki->city_title
			);
		}

		return $this->getMessage(
			self::MESSAGE_KEYS[$this->upVotes]['summary'],
			$this->wiki->city_url,
			$this->wiki->city_title
		);
	}

	protected static function getEmailSpecificFormFields() {
		$formFields = [
			'inputs' => [
				[
					'type' => 'text',
					'name' => 'postTitle',
					'label' => 'Title of Post (Optional)',
				],
				[
					'type' => 'text',
					'name' => 'upVotes',
					'label' => 'Upvote Count',
				],
			],
		];

		return array_merge_recursive( parent::getEmailSpecificFormFields(), $formFields );
	}

	/**
	 * Asserts that target user is subscribed to Discussions Upvote emails.
	 *
	 * @throws \Email\Check
	 */
	public function assertCanEmail() {
		parent::assertCanEmail();

		$wantsDiscussionEmails = ( bool ) $this->targetUser->getGlobalPreference( 'enotifdiscussionsvotes' );

		if ( !$wantsDiscussionEmails ) {
			throw new Check( 'User is not subscribed to Discussions Upvote emails.' );
		}
	}
}

class DiscussionAtMentionController extends DiscussionController {

    private $contentType;
    private $threadTitle;

    const THREAD_AT_MENTION = 'thread-at-mention';
    const POST_AT_MENTION = 'post-at-mention';

    const TYPE_TO_I18N_KEY = [
        self::THREAD_AT_MENTION => 'emailext-discussion-thread-at-mention',
        self::POST_AT_MENTION => 'emailext-discussion-post-at-mention',
    ];

    public function initEmail() {
        $this->contentType = $this->request->getVal( 'contentType' );
        $this->threadTitle = $this->request->getVal( 'threadTitle' );

        parent::initEmail();
    }

    protected function assertValidParams() {
        parent::assertValidParams();

        if ( !array_key_exists( $this->contentType, self::TYPE_TO_I18N_KEY ) ) {
            throw new Check( 'Invalid value passed for required param content, must be "thread-at-mention" or "post-at-mention"' );
        }

        if ( empty( $this->threadTitle ) ) {
            throw new Check( 'Empty value passed for required param threadTitle' );
        }
    }

    public function getSubject() {
        return $this->getSummary();
    }

    public function getSummary() {
        return $this->getMessage(
            self::TYPE_TO_I18N_KEY[$this->contentType],
            $this->getCurrentUserName(),
            $this->threadTitle,
            $this->wiki->city_title
        );
    }

    protected static function getEmailSpecificFormFields() {
        $formFields = [
            'inputs' => [
                [
                    'type' => 'text',
                    'name' => 'contentType',
                    'label' => 'contentType of at-mention. One of: ' . self::POST_AT_MENTION . ' ' . self::THREAD_AT_MENTION
                ],
                [
                    'type' => 'text',
                    'name' => 'threadTitle',
                    'label' => 'Title of the thread containing the at-mention',
                ],
            ],
        ];

        return array_merge_recursive( parent::getEmailSpecificFormFields(), $formFields );
    }
}

class DiscussionArticleCommentController extends DiscussionController {

	private $contentType;
	private $articleTitle;

	const ARTICLE_COMMENT_REPLY = 'article-comment-reply';
	const ARTICLE_COMMENT_AT_MENTION = 'article-comment-at-mention';
	const ARTICLE_COMMENT_REPLY_AT_MENTION = 'article-comment-reply-at-mention';

    public function initEmail() {
    	// For AC related notifications, threadTitle means article title (comments don't have titles)
		$this->articleTitle = $this->request->getVal( 'threadTitle' );
		$this->contentType = $this->request->getVal( 'contentType' );

		parent::initEmail();
	}

	protected function getSummary() {
		return $this->getMessage(
			$this->getTranslationKey(),
			$this->getCurrentUserName(),
			$this->getArticleTitleLink(),
			$this->getWikiNameLink()
		);
	}

	protected function getSubject() {
		return $this->getSummary();
	}

	private function getArticleTitleLink() {
    	$articleUrl = \Title::newFromText( $this->articleTitle )->getFullURL();
    	$link = '[' . $articleUrl . ' ' . $this->articleTitle . ']';

    	WikiaLogger::instance()->info('getArticleTitleLink', [
    		'issue' => 'IW-3264',
			'link' => $link,
		]);

    	return $link;
	}

	private function getWikiNameLink() {
    	$link = '[' . $this->wiki->city_url . ' ' . $this->wiki->city_title . ']';

		WikiaLogger::instance()->info('getWikiNameLink', [
    		'issue' => 'IW-3264',
			'link' => $link,
		]);

		return $link;
	}

	private function getTranslationKey() {
    	// TODO: Follower email - update following (or discussion) pandora service to send out notifications for followers
    	switch ( $this->contentType ) {
			case self::ARTICLE_COMMENT_AT_MENTION:
				return 'emailext-article-comment-at-mention';
			case self::ARTICLE_COMMENT_REPLY_AT_MENTION:
				return 'emailext-article-comment-reply-at-mention';
			case self::ARTICLE_COMMENT_REPLY:
				return 'emailext-article-comment-reply';
			default:
				throw new Check( 'Incorrect contentType "' . $this->contentType . '"' );
		}
	}

	protected function getDiscussionsLink() {
		return $this->wiki->city_url;
	}
}

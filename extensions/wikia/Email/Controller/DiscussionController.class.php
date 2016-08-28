<?php

namespace Email\Controller;

use Email\Check;
use Email\EmailController;

abstract class DiscussionController extends EmailController {

    protected $postContent;
    protected $postUrl;
    protected $wiki;

    public function initEmail() {
        $this->postContent = $this->request->getVal( 'postContent' );
        $this->postUrl = $this->request->getVal( 'postUrl' );
        $this->setWikiFromWikiID();
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
    }

    protected function assertValidParams() {
        if ( empty( $this->postUrl ) ) {
            throw new Check( 'Empty value passed for required param postUrl' );
        }

        if ( empty( $this->postContent ) ) {
            throw new Check( 'Empty value passed for required param postContent' );
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
            'editorUserName' => $this->getCurrentUserName(),
            'editorAvatarURL' => $this->getCurrentAvatarURL(),
            'details' => $this->getDetails(),
            'buttonText' => $this->getButtonText(),
            'buttonLink' => $this->postUrl,
            'contentFooterMessages' => $this->getContentFooterMessages(),
            'hasContentFooterMessages' => true,
        ] );
    }

    public function assertCanEmail() {
        parent::assertCanEmail();
        $this->assertSubscribedToDiscussionsEmail();
    }

    /**
     * Asserts that target user is subscribed to Discussions emails.
     *
     * @throws \Email\Check
     */
    protected function assertSubscribedToDiscussionsEmail() {
	    $wantsDiscussionEmails = ( bool ) $this->targetUser->getGlobalPreference( 'enotifdiscussions' );

        if ( !$wantsDiscussionEmails ) {
            throw new Check( 'User is not subscribed to Discussions emails.' );
        }
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
            $this->getMessage( 'emailext-discussion-all-discussions',
                $this->getDiscussionsLink(),
                $this->wiki->city_title
            )
        ];
    }

    private function getDiscussionsLink() {
        return $this->wiki->city_url . 'd';
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
        parent::initEmail();
        $this->threadTitle = $this->request->getVal( "threadTitle" );
    }

    public function getSubject() {
        return strip_tags( $this->getSummary() );
    }

    public function getSummary() {
        if ( !empty( $this->threadTitle ) ) {
            return $this->getMessage( 'emailext-discussion-reply-with-title-subject',
                $this->postUrl,
                $this->threadTitle,
                $this->wiki->city_url,
                $this->wiki->city_title
            )->parse();
        }

        return $this->getMessage( 'emailext-discussion-reply-subject',
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
        parent::initEmail();
        $this->postTitle = $this->request->getVal( 'postTitle' );
        $this->upVotes = $this->request->getVal( 'upVotes' );
        $this->assertValidParams();
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
                $this->postTitle,
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
}

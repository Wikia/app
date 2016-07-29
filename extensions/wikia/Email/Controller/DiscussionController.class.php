<?php

namespace Email\Controller;

use Email\Check;
use Email\EmailController;

abstract class DiscussionController extends EmailController {

    protected $postTitle;
    protected $postUrl;
    protected $wiki;

    public function initEmail() {
        $this->postTitle = $this->request->getVal( 'postTitle' );
        $this->postUrl = $this->request->getVal( 'postUrl' );
        $this->setWikiFromWikiID();
    }

    private function setWikiFromWikiID() {
        $siteId = $this->request->getVal( 'siteId' );
        if ( empty( $siteId ) ) {
            throw new Check( 'Empty value passed for required param siteId' );
        }

        $this->wiki = \WikiFactory::getWikiByID( $siteId );
        if ( !$this->wiki == false ) {
            throw new Check( "Unable to find wiki information for siteId $siteId" );
        }
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
        $this->response->setData( [
            'salutation' => $this->getSalutation(),
            'summary' => $this->getSummary(),
            'editorProfilePage' => $this->getCurrentProfilePage(),
            'editorUserName' => $this->getCurrentUserName(),
            'editorAvatarURL' => $this->getCurrentAvatarURL(),
            'details' => $this->getDetails(),
            'buttonText' => $this->getButtonText(),
            'buttonLink' => $this->postUrl,
            'contentFooterMessages' => $this->getFooterMessages(),
            'hasContentFooterMessages' => true,
        ] );
    }

    protected abstract function getSummary();

    protected abstract function getDetails();

    private function getButtonText() {
        return $this->getMessage( 'emailext-discussion-button-text' )->text();
    }

    protected function getFooterMessages() {
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
                    'name' => 'postTitle',
                    'label' => 'Title of Post (Optional)',
                ],
                [
                    'type' => 'text',
                    'name' => 'currentUser',
                    'label' => 'ID of user to send email as',
                ],
                [
                    'type' => 'text',
                    'name' => 'targetUser',
                    'label' => 'ID of user to send email to',
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

    private $replyContent;

    public function initEmail() {
        parent::initEmail();
        $this->replyContent = $this->request->getVal( 'replyContent' );
        $this->assertValidParams();
    }

    protected function assertValidParams() {
        parent::assertValidParams();
        if ( empty( $this->replyContent ) ) {
            throw new Check( 'Empty value passed for required param replyContent' );
        }
    }

    public function getSubject() {
        return strip_tags( $this->getSummary() );
    }

    public function getSummary() {
        if ( !empty( $this->postTitle ) ) {
            return $this->getMessage( 'emailext-discussion-reply-with-title-subject',
                $this->postUrl,
                $this->postTitle,
                $this->wiki->city_url,
                $this->wiki->city_title
            )->parse();
        }

        return $this->getMessage( 'emailext-discussion-reply-subject',
            $this->wiki->city_url,
            $this->wiki->city_title
        )->parse();
    }

    protected function getDetails() {
        return $this->replyContent;
    }

    protected static function getEmailSpecificFormFields() {
        $formFields = [
            'inputs' => [
                [
                    'type' => 'text',
                    'name' => 'replyContent',
                    'label' => 'Reply Content',
                ]
            ]
        ];

        return array_merge_recursive( parent::getEmailSpecificFormFields(), $formFields );
    }
}

class DiscussionUpvoteController extends DiscussionController {

    private $firstPostContent;
    private $upvoteCount;

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
        $this->firstPostContent = $this->request->getVal( 'firstPostContent' );
        $this->upvoteCount = $this->request->getVal( 'upvoteCount' );
        $this->assertValidParams();
    }

    protected function assertValidParams() {
        parent::assertValidParams();
        if ( empty( $this->firstPostContent ) ) {
            throw new Check( 'Empty value passed for required param firstPostContent' );
        }

        if ( empty( $this->upvoteCount ) ) {
            throw new Check( 'Empty value passed for required param upvoteCount' );
        }

        if ( !array_key_exists( $this->upvoteCount, self::MESSAGE_KEYS ) ) {
            throw new Check( 'Invalid value for param upvoteCount. Must be 5, 25, 100' );
        }
    }

    public function getSubject() {
        if ( !empty( $this->postTitle ) ) {
            return $this->getMessage(
                self::MESSAGE_KEYS[$this->upvoteCount]['subject-with-title'],
                $this->postTitle,
                $this->wiki->city_title
            );
        }

        return $this->getMessage(
            self::MESSAGE_KEYS[$this->upvoteCount]['subject'],
            $this->wiki->city_title
        );
    }

    public function getSummary() {
        if ( !empty( $this->postTitle ) ) {
            return $this->getMessage(
                self::MESSAGE_KEYS[$this->upvoteCount]['summary-with-title'],
                $this->postUrl,
                $this->postTitle,
                $this->wiki->city_url,
                $this->wiki->city_title
            );
        }

        return $this->getMessage(
            self::MESSAGE_KEYS[$this->upvoteCount]['summary'],
            $this->wiki->city_url,
            $this->wiki->city_title
        );
    }

    protected function getDetails() {
        return $this->firstPostContent;
    }

    protected static function getEmailSpecificFormFields() {
        $formFields = [
            'inputs' => [
                [
                    'type' => 'text',
                    'name' => 'firstPostContent',
                    'label' => 'First Post Content',
                ],
                [
                    'type' => 'text',
                    'name' => 'upvoteCount',
                    'label' => 'Upvote Count',
                ],
            ],
        ];

        return array_merge_recursive( parent::getEmailSpecificFormFields(), $formFields );
    }
}

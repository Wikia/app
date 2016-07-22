<?php

namespace Email\Controller;

use Email\Check;
use Email\EmailController;

class DiscussionReplyController extends EmailController {

    private $postTitle;
    private $postUrl;
    private $replyContent;
    private $wiki;

    public function initEmail() {
        $this->postTitle = $this->request->getVal( 'postTitle' );
        $this->postUrl = $this->request->getVal( 'postUrl' );
        $this->replyContent = $this->request->getVal( 'replyContent' );
        $this->setWikiFromWikiID();
        $this->assertValidParams();
    }

    private function setWikiFromWikiID() {
        $siteId = $this->request->getVal( 'siteId' );
        if ( empty( $siteId ) ) {
            throw new Check( "Empty value passed for required param siteId" );
        }

        $wiki = \WikiFactory::getWikiByID( $siteId );
        if ( $wiki == false ) {
            throw new Check( "Unable to find wiki information for siteId $siteId" );
        }

        $this->wiki = $wiki;
    }

    private function assertValidParams() {
        if ( empty( $this->postTitle ) ) {
            throw new Check( "Empty value passed for required param siteId" );
        }

        if ( empty( $this->postUrl ) ) {
            throw new Check( "Empty value passed for required param postUrl" );
        }

        if ( empty( $this->replyContent ) ) {
            throw new Check( "Empty value passed for required param replyContent" );
        }
    }

    /**
     * @template avatarLayout
     */
    public function body() {
        $this->response->setData( [
            'salutation' => "Hi James",
            'summary' => $this->getSummary(),
            'editorProfilePage' => $this->getCurrentProfilePage(),
            'editorUserName' => $this->getCurrentUserName(),
            'editorAvatarURL' => $this->getCurrentAvatarURL(),
            'details' => $this->replyContent,
            'buttonText' => $this->getButtonText(),
            'buttonLink' => $this->getDiscussionsLink(),
            'contentFooterMessages' => $this->getFooterMessages(),
            'hasContentFooterMessages' => true
        ] );
    }

    public function getSummary() {
        if ( !empty( $this->postTitle ) ) {
            return $this->getMessage('emailext-discussion-reply-with-title-subject',
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

    public function getSubject() {
        return strip_tags( $this->getSummary() );
    }

    private function getDiscussionsLink() {
        return $this->wiki->city_url . "d";

    }
    
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

    protected static function getEmailSpecificFormFields() {
        $form = [
            'inputs' => [
                [
                    'type' => 'text',
                    'name' => 'replyContent',
                    'label' => "Reply Content",
                ],
                [
                    'type' => 'text',
                    'name' => 'siteId',
                    'label' => "Site ID",
                ],
                [
                    'type' => 'text',
                    'name' => 'postTitle',
                    'label' => "Title of Post",
               ],
                [
                    'type' => 'text',
                    'name' => 'currentUser',
                    'label' => "ID of user to send email as",
                ],
                [
                    'type' => 'text',
                    'name' => 'targetUser',
                    'label' => "ID of user to send email to",
                ]
            ]
        ];

        return $form;
    }
}

<?php

class ArchiveWikiForumController extends WallBaseController {

    // Constants which map to method names. Useful for renderView calls
    // F:app()->renderView( 'className', 'methodName' );
    const ARCHIVED_FORUM_NOTIFICATION = "archivedForumNotification";

    /**
     * Render HTML for notification to user that old style wiki forums
     * have been archived on this wiki.
     */
    public function archivedForumNotification() {
        $this->response->addAsset( 'extensions/wikia/ArchiveWikiForum/css/archivedForumNotification.scss' );

        $forumTitle = SpecialPage::getTitleFor( 'Forum' );
        $this->response->setVal( 'forumUrl',  $forumTitle->getLocalURL() );
    }
}

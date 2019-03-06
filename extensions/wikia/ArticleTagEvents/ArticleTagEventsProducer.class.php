<?php

use Wikia\Rabbit\ConnectionBase;

class ArticleTagEventsProducer {

    const RENAMED_ROUTING_KEY= 'article-tags.renamed';

    private static $rabbitPublisher;

    public static function onTitleMoveComplete( Title $oldTitle, Title $newTitle, User $user, $pageId, $redirectId ) {
        global $wgCityId;
        $message = [
            'wikiId' => $wgCityId,
            'articleId' => $newTitle->getArticleID(),
            'articleTitle' => $newTitle->getPrefixedText(),
            'relativeUrl' => $newTitle->getLocalURL(),
        ];

        self::getPublisher()->publish( self::RENAMED_ROUTING_KEY, $message );
    }

    /** @return \Wikia\Rabbit\ConnectionBase */
    protected static function getPublisher() {
        global $wgArticleTagExchangeConfig;

        if ( !isset( self::$rabbitPublisher ) ) {
            self::$rabbitPublisher = new ConnectionBase( $wgArticleTagExchangeConfig );
        }

        return self::$rabbitPublisher;
    }
}
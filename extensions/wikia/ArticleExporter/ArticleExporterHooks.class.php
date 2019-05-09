<?php

use Wikia\Rabbit\ConnectionBase;

/**
 * @author Lore team
 *
 * Send plaintext versions of articles to RabbitMQ as they are edited on Fandom
 */

class ArticleExporterHooks {
    protected static $rabbitConnection;

    public static function onArticleSaveComplete( WikiPage $page ) {
        global $wgCityId;
        global $wgArticleExporterExchange;

        $message = [
            'wikiId' => $wgCityId,
            'pageIds' => [ strval($page->getId()) ],
        ];

        self::getRabbitConnection()->publish( $wgArticleExporterExchange['routing'], $message );

        return true;
    }

    protected static function getRabbitConnection() {
        global $wgArticleExporterExchange;

        if ( !isset( self::$rabbitConnection ) ) {
            self::$rabbitConnection = new ConnectionBase( $wgArticleExporterExchange );
        }

        return self::$rabbitConnection;
    }
}
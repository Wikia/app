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

        $title = $page->getTitle();
        $namespace = $title->getNamespace();
        $mainPage = $title->isMainPage();

        if ( $namespace == NS_MAIN || $mainPage ) {
            $message = [
                'wikiId' => $wgCityId,
                'pages' => [
                    [
                        'pageId' => strval( $page->getId() ),
                        'namespace' => $namespace
                    ]
                ],
            ];

            self::getRabbitConnection()->publish( $wgArticleExporterExchange['routing'], $message );
        }

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
<?php

use Wikia\Logger\WikiaLogger;
use Wikia\Rabbit\ConnectionBase;

/**
 * @author Lore team
 *
 * Something
 */

class TaxonomyArticleHooks {
    const ROUTING_KEY = "taxonomy-jamie-mw-test";

    protected static $rabbitConnection;

	static public function onArticleEditUpdates(\WikiPage $page, $editInfo, bool $changed) {
        global $wgCityId;

        $message = [
            'wikiId' => $wgCityId,
            'articleId' => $page->getId(),
            'articleTitle' => $page->getTitle()->getText(),
            // 'articleWikitext' => $article->getText(),
            'articlePlaintext' => html_entity_decode( strip_tags( $editInfo->output->getText()), ENT_COMPAT, 'UTF-8' )
        ];

        self::getRabbitConnection()->publish( self::ROUTING_KEY, $message );

        return true;
	}

    protected static function getRabbitConnection() {
        global $wgTaxonomyArticleExchange;

        if ( !isset( self::$rabbitConnection ) ) {
            self::$rabbitConnection = new ConnectionBase( $wgTaxonomyArticleExchange );
        }

        return self::$rabbitConnection;
    }
}

<?php
/**
 * Get articles as plaintext saved to Rabbit
 *
 * This job is created by \TaxonomyArticleHooks::onArticleSaveComplete
 */

namespace Wikia\Tasks\Tasks;

use ParserOptions;
use Wikia\Logger\WikiaLogger;
use Wikia\Rabbit\ConnectionBase;

class GenerateArticlePlaintextTask extends BaseTask {
    const ROUTING_KEY = "taxonomy-jamie-mw-test";

    protected static $rabbitConnection;

    // wiki id, article id, article wikitext
    public function generateArticlePlaintext($wikiId, $article) {

        WikiaLogger::instance()->error("generate article plaintext");

        global $wgParser;

        // get the plaintext
        $title = $article->getTitle()->getText();
        // $plaintext = $wgParser->parse($article->getText(), $title, new ParserOptions())->getText();
        $plaintext = "test one two three";

        // put it into rabbit
        $message = [
            'wikiId' => $wikiId,
            'article' => $article,
            'articleId' => $article->getId(),
            'articleTitle' => $title,
            // 'articleWikitext' => $article->getText(),
            'articlePlaintext' => $plaintext
        ];

        self::getRabbitConnection()->publish( self::ROUTING_KEY, $message );
    }

    protected static function getRabbitConnection() {
        global $wgTaxonomyArticleExchange;

        if ( !isset( self::$rabbitConnection ) ) {
            self::$rabbitConnection = new ConnectionBase( $wgTaxonomyArticleExchange );
        }

        return self::$rabbitConnection;
    }

}

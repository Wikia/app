<?php

use Wikia\Rabbit\ConnectionBase;

/**
 * @author Lore team
 *
 * Send plaintext versions of articles to RabbitMQ as they are edited on Fandom
 */

class TaxonomyArticleHooks {
	const ROUTING_KEY = "taxonomy.article-edits";

	protected static $rabbitConnection;

	static public function onArticleEditUpdates( \WikiPage $page, $editInfo ) {
		global $wgCityId;

		// We currently do not need wikitext for the classifier, but it may be useful
		//  to have in the future. Uncomment this line to include wikitext in the message
		$message = [
			'wikiId' => $wgCityId,
			'articleId' => $page->getId(),
			'articleTitle' => $page->getTitle()->getText(),
			// 'articleWikitext' => $page->getText(),
			'articlePlaintext' => html_entity_decode( strip_tags( $editInfo->output->getText() ), ENT_COMPAT, 'UTF-8' )
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

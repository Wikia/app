<?php

/**
 * A ParserOptions-agnostic ParserCache implementation for use by RTE.
 */
class RTEParserCache extends ParserCache {
	const TTL = 86400 * 3; // 3 days

	public function __construct( BagOStuff $memCached ) {
		parent::__construct( $memCached );
	}

	protected function getParserOutputKey( $article, $hash ) {
		$articleId = $article->getID();

		return wfMemcKey( 'rte-parser-cache', $articleId );
	}

	protected function getOptionsKey( $article ) {
		$articleId = $article->getID();

		return wfMemcKey( 'rte-parser-cache-pointer', $articleId );
	}
}

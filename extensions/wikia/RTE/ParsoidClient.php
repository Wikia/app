<?php

use Wikia\Service\Gateway\UrlProvider;

class ParsoidClient {
	/** @var UrlProvider $urlProvider */
	private $urlProvider;

	public function __construct( UrlProvider $urlProvider ) {
		$this->urlProvider = $urlProvider;
	}

	public function wt2html( string $pageTitle, int $revisionId ) {
		$baseUrl = $this->urlProvider->getUrl( 'parsoid-redux' );
		$apiUrl = wfExpandUrl( wfScript( 'api' ) );

		$fullUrl = "$baseUrl/$apiUrl/v3/page/html/$pageTitle/$revisionId";

		return Http::get( $fullUrl );
	}

	public function html2wt( string $html, string $pageTitle, int $revisionId ) {
		$baseUrl = $this->urlProvider->getUrl( 'parsoid-redux' );
		$apiUrl = wfExpandUrl( wfScript( 'api' ) );

		$fullUrl = "$baseUrl/$apiUrl/v3/transform/html/to/wikitext/$pageTitle/$revisionId";

		return Http::post( $fullUrl, [ $html => $html ] );
	}
}

<?php

use Wikia\Service\Gateway\UrlProvider;

class ParsoidClient {
	const DEFAULT_REQUEST_OPTIONS = [ 'noProxy' => true ];

	/** @var UrlProvider $urlProvider */
	private $urlProvider;

	public function __construct( UrlProvider $urlProvider ) {
		$this->urlProvider = $urlProvider;
	}

	public function getPageHtml( string $pageTitle, int $revisionId ) {
		$baseUrl = $this->getParsoidUrl();

		$fullUrl = "$baseUrl/v3/page/html/$pageTitle/$revisionId";

		$ret =  Http::get( $fullUrl, 'default', static::DEFAULT_REQUEST_OPTIONS );

		return $ret;
	}

	public function html2wt( string $html, string $pageTitle, int $revisionId ) {
		$baseUrl = $this->getParsoidUrl();

		$fullUrl = "$baseUrl/v3/transform/html/to/wikitext/$pageTitle/$revisionId";

		return Http::post( $fullUrl, [ 'html' => $html ] );
	}

	public function wt2html( string $wikitext) {
		$baseUrl = $this->getParsoidUrl();

		$fullUrl = "$baseUrl/v3/transform/wikitext/to/html";

		$requestOptions = [
			'postData' => [
				'wikitext' => $wikitext,
				'body_only' => true
			]
		];

		return Http::post( $fullUrl, array_merge( static::DEFAULT_REQUEST_OPTIONS, $requestOptions ) );
	}

	private function getParsoidUrl(): string {
		$baseUrl = $this->urlProvider->getUrl( 'parsoid-redux' );
		$apiUrl = urlencode( wfExpandUrl( wfScript( 'api' ) ) );

		return "http://$baseUrl/$apiUrl";
	}
}

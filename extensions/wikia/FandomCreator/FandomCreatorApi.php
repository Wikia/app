<?php

namespace FandomCreator;

use Http;
use MWHttpRequest;

class FandomCreatorApi {

	/** @var string */
	private $baseUrl;

	/**
	 * FandomCreatorApi constructor.
	 * @param string $baseUrl
	 */
	public function __construct( string $baseUrl ) {
		$this->baseUrl = $baseUrl;
	}

	public function getCommunity($communityId) {
		$response = $this->doApiRequest( "{$this->baseUrl}/communities/{$communityId}" );
	}

	public function getSitemap($communityId) {
		$response = $this->doApiRequest( "{$this->baseUrl}/communities/{$communityId}/sitemap" );
		if ( !$response->status->isOK() ) {
			return null;
		}

		return json_decode( $response->getContent() );
	}

	private function doApiRequest( string $url ): MWHttpRequest {
		return Http::request( 'GET', $url, [
				'userAgent' => $_SERVER['HTTP_USER_AGENT'],
				'noProxy' => true,
				'returnInstance' => true,
				'followRedirects' => true,
		] );
	}
}

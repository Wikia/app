<?php

namespace FandomCreator;

use Http;
use MWHttpRequest;

class FandomCreatorApi {

	/** @var string */
	private $baseUrl;

	/** @var string */
	private $communityId;

	/**
	 * FandomCreatorApi constructor.
	 * @param string $baseUrl
	 * @param string $communityId
	 */
	public function __construct( string $baseUrl, string $communityId ) {
		$this->baseUrl = $baseUrl;
		$this->communityId = $communityId;
	}

	public function getCommunity() {
		$response = $this->doApiRequest( "{$this->baseUrl}/communities/{$this->communityId}" );
	}

	public function getSitemap() {
		$response = $this->doApiRequest( "{$this->baseUrl}/communities/{$this->communityId}/sitemap" );
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

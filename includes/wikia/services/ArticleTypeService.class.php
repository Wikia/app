<?php

class ArticleTypeService {
	/**
	 * endpoint for holmes
	 */
	const HOLMES_ENDPOINT = 'http://dev-arturd:8080/holmes/classifications/';

	const TIMEOUT = 1;

	public function execute() {
	}

	/**
	 * Returns article type for given pageId
	 * @param int $pageId
	 * @return string|null
	 */
	public function getArticleType( $pageId ) {

		$art = Article::newFromID( $pageId );

		if ( !$art ) {
			return null;
		}
		$params = [
			'title' => $art->getTitle()->getText(),
			'wikiText' => $art->getPage()->getRawText()
		];

		$json = json_encode( $params, JSON_FORCE_OBJECT );

		$ch = curl_init();
		curl_setopt( $ch, CURLOPT_URL, self::HOLMES_ENDPOINT );
		curl_setopt( $ch, CURLOPT_CONNECTTIMEOUT, self::TIMEOUT );
		curl_setopt( $ch, CURLOPT_TIMEOUT, self::TIMEOUT );
		curl_setopt( $ch, CURLOPT_POST, 1 );
		curl_setopt( $ch, CURLOPT_POSTFIELDS, $json );
		curl_setopt( $ch, CURLOPT_HTTPHEADER, [ 'Content-Type: application/json' ] );
		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );

		$result = curl_exec( $ch );
		curl_close( $ch );
		$response = json_decode( $result, true );

		if ( !empty( $response ) && isset( $response[ 'class' ] ) ) {
			return $response[ 'class' ];
		} else {
			$wikiId = F::app()->wg->cityId;
			throw new Exception( 'ArticleType error for: ' . $wikiId . '_' . $pageId );
		}
	}
}

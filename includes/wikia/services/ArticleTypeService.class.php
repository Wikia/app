<?php

class ArticleTypeService {
	/**
	 * endpoint for holmes
	 */
	const HOLMES_ENDPOINT = 'http://dev-arturd:8080/holmes/classifications/';

	const TIMEOUT = 10;

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
			'wikiText' => /*$art->getPage()->getRawText()*/ 'asdf'
		];

		$json = json_encode( $params, JSON_FORCE_OBJECT );
		$response = Http::post(self::HOLMES_ENDPOINT,
			[
				'postData' => $json,
				'timeout'=> self::TIMEOUT,
				'headers' => [ 'Content-Type'=>'application/json'],
				'noProxy' => true //only for testing with dev-arturd
			]
		);

		$response = json_decode( $response, true );

		if ( !empty( $response ) && isset( $response[ 'class' ] ) ) {
			return $response[ 'class' ];
		} else {
			$wikiId = F::app()->wg->cityId;
			throw new Exception( 'ArticleType error for: ' . $wikiId . '_' . $pageId );
		}
	}
}

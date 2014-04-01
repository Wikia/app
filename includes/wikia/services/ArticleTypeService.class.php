<?php

class ArticleTypeService {
	/**
	 * endpoint for holmes
	 */
	const HOLMES_ENDPOINT = 'http://dev-holmes:8080/holmes/classifications/';

	const TIMEOUT = 10;

	/**
	 * Returns article type for given pageId
	 * @param int $pageId
	 * @throws ServiceUnavailableException
	 * @return string|null
	 */
	public function getArticleType( $pageId ) {
		$articleData = $this->getArticleDataByArticleId($pageId);

		if(is_null($articleData)) {
			return null;
		}

		$json = json_encode( $articleData, JSON_FORCE_OBJECT );
		$response = Http::post(self::HOLMES_ENDPOINT,
			[
				'postData' => $json,
				'timeout'=> self::TIMEOUT,
				'headers' => [ 'Content-Type'=>'application/json'],
				'noProxy' => true //only for testing with dev-arturd
			]
		);

		$response = json_decode( $response, true );

		if ( empty( $response ) ) {
			$wikiId = F::app()->wg->cityId;
			\Wikia\Logger\WikiaLogger::instance()->error("ArticleTypeService error. Possibly holmes unavailable.", ["wikiId" => $wikiId, "pageId" => $pageId]);
			throw new ServiceUnavailableException('ArticleTypeService error for: ' . $wikiId . '_' . $pageId);
		}

		return $response[ 'class' ];
	}

	/**
	 * @param $pageId
	 * @return array|null
	 */
	private function getArticleDataByArticleId($pageId) {
		$art = Article::newFromID($pageId);

		if (!$art) {
			return null;
		} else {
			return [
				'title' => $art->getTitle()->getText(),
				'wikiText' => $art->getPage()->getRawText()
			];
		}
	}
}

class ServiceUnavailableException extends Exception {
}

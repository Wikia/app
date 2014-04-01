<?php

class ArticleTypeService {
	/**
	 * Request timeout in seconds.
	 */
	const TIMEOUT = 2;

	/**
	 * @var string
	 */
	private $holmesEndpoint;

	/**
	 * @param string|null $holmesEndpoint root for holmes endpoint
	 */
	function __construct( $holmesEndpoint = null ) {
		if ( is_null( $holmesEndpoint ) ) {
			// use wgHolmesEndpoint by default
			$holmesEndpoint = F::app()->wg->HolmesEndpoint;
		}
		$this->holmesEndpoint = $holmesEndpoint;
	}

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
		$response = Http::post($this->getHolmesClassificationsEndpoint(),
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
			\Wikia\Logger\WikiaLogger::instance()->error("ArticleTypeService error. Possibly holmes service unavailable.", ["wikiId" => $wikiId, "pageId" => $pageId]);
			throw new ServiceUnavailableException('ArticleTypeService error for: ' . $wikiId . '_' . $pageId);
		}

		return $response[ 'class' ];
	}

	private function getHolmesClassificationsEndpoint() {
		return $this->holmesEndpoint . "/classifications";
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

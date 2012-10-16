<?php
/**
 * Controller to fetch informations about wikis
 *
 * @author Federico "Lox" Lucignano <federico@wikia-inc.com>
 */

class WikisApiController extends WikiaApiController {
	const ITEMS_PER_BATCH = 25;

	private $model = null;

	public function init() {
		$this->model = new WikisModel();
	}

	/**
	 * Get the top wikis by pageviews optionally filtering by vertical (hub) and/or language
	 *
	 * @requestParam string $hub [OPTIONAL] The name of the vertical (e.g. Gaming, Entertainment,
	 * Lifestyle, etc.) to use as a filter
	 * @requestParam string $lang [OPTIONAL] The language code (e.g. en, de, fr, es, it, etc.) to use as a filter
	 * @requestParam integer $limit [OPTIONAL] The maximum number of results to fetch, defaults to 25
	 *
	 * @responseParam array $items The list of top wikis by pageviews matching the optional filtering
	 * @responseParam integer $total The total number of results
	 * @responseParam integer $currentBatch The index of the current batch/page
	 * @responseParam integer $batches The total number of batches/pages
	 * @responseParam integer $next The amount of items in the next batch/page
	 */
	public function getList() {
		$hub = trim( $this->request->getVal( 'hub', null ) );
		$lang = trim( $this->getVal( 'lang', null ) );
		$limit = $this->request->getInt( 'limit', self::ITEMS_PER_BATCH );
		$batch = $this->request->getInt( 'batch', 1 );
		$results = $this->model->getTopWikis ( $lang, $hub );
		$batches = $this->wf->PaginateArray( $results, $limit, $batch );

		foreach ( $batches as $name => $value ) {
			$this->response->setVal( $name, $value );
		}

		$this->response->setCacheValidity(
			604800 /* 1 week */,
			604800 /* 1 week */,
			array(
				WikiaResponse::CACHE_TARGET_BROWSER,
				WikiaResponse::CACHE_TARGET_VARNISH
			)
		);
	}

	/**
	 * Finds wikis which name or topic match a keyword optionally filtering by vertical (hub) and/or language,
	 * the total amount of results is limited to 250 items
	 *
	 * @requestParam string $keyword search term
	 * @requestParam string $hub [OPTIONAL] The name of the vertical (e.g. Gaming, Entertainment,
	 * Lifestyle, etc.) to use as a filter
	 * @requestParam string $lang [OPTIONAL] The language code (e.g. en, de, fr, es, it, etc.) to use as a filter
	 * @requestParam integer $limit [OPTIONAL] The number of items per each batch/page, defaults to 25
	 * @requestParam integer $batch [OPTIONAL] The batch/page index to retrieve, defaults to 1
	 *
	 * @responseParam array $items The list of wikis matching the keyword and the optional filtering
	 * @responseParam integer $total The total number of results
	 * @responseParam integer $currentBatch The index of the current batch/page
	 * @responseParam integer $batches The total number of batches/pages
	 * @responseParam integer $next The amount of items in the next batch/page
	 */
	public function getByString() {
		$this->wf->profileIn( __METHOD__ );

		$keyword = trim( $this->request->getVal( 'string', '' ) );
		$hub = trim( $this->request->getVal( 'hub', null ) );
		$lang = trim( $this->getVal( 'lang', null ) );
		$limit = $this->request->getInt( 'limit', self::ITEMS_PER_BATCH );
		$batch = $this->request->getInt( 'batch', 1 );
		$results = $this->model->getWikisByKeyword($keyword, $lang, $hub );
		$batches = $this->wf->PaginateArray( $results, $limit, $batch );

		foreach ( $batches as $name => $value ) {
			$this->response->setVal( $name, $value );
		}

		//store only for 24h to allow new wikis
		//to appear in a reasonable amount of time in the search
		//results
		$this->response->setCacheValidity(
			86400 /* 24h */,
			85400 /* 24h */,
			array(
				WikiaResponse::CACHE_TARGET_BROWSER,
				WikiaResponse::CACHE_TARGET_VARNISH
			)
		);

		$this->wf->profileOut( __METHOD__ );
	}

	public function getDetails() {
		$this->wf->profileIn( __METHOD__ );

		$ids = $this->request->getVal( 'ids', null);
		$hub = trim( $this->request->getVal( 'hub', null ) );
		$lang = trim( $this->request->getVal( 'lang', null ) );

		if ( !empty( $ids ) ) {
			$ids = explode( ',', $ids );
		}

		$results = $this->model->getPromotionData( $ids, $lang, $hub );

		$this->setVal( 'items', $results );

		//store only for 24h to allow new wikis
		//to appear in a reasonable amount of time in the search
		//results
		//$this->response->setCacheValidity(
		//	86400 /* 24h */,
		//	86400 /* 24h */,
		//	array(
		//		WikiaResponse::CACHE_TARGET_BROWSER,
		//		WikiaResponse::CACHE_TARGET_VARNISH
		//	)
		//);

		$this->wf->profileOut( __METHOD__ );
	}
}
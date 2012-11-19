<?php
/**
 * Controller to fetch informations about wikis
 *
 * Available only on the www.wikia.com main domain.
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
	 * @requestParam string $hub [OPTIONAL] The name of the vertical (e.g. Gaming, Entertainment, Lifestyle, etc.) to use as a filter
	 * @requestParam string $lang [OPTIONAL] The language code (e.g. en, de, fr, es, it, etc.) to use as a filter
	 * @requestParam integer $limit [OPTIONAL] The maximum number of results to fetch, defaults to 25
	 * @requestParam integer $batch [OPTIONAL] The batch/page index to retrieve, defaults to 1
	 *
	 * @responseParam array $items The list of top wikis by pageviews matching the optional filtering
	 * @responseParam integer $total The total number of results
	 * @responseParam integer $currentBatch The index of the current batch/page
	 * @responseParam integer $batches The total number of batches/pages
	 * @responseParam integer $next The amount of items in the next batch/page
	 *
	 * @example http://www.wikia.com/wikia.php?controller=WikisApi&method=getList&hub=Gaming&lang=en
	 */
	public function getList() {
		$hub = trim( $this->request->getVal( 'hub', null ) );
		$lang = trim( $this->getVal( 'lang', null ) );
		$limit = $this->request->getInt( 'limit', self::ITEMS_PER_BATCH );
		$batch = $this->request->getInt( 'batch', 1 );
		$results = $this->model->getTop( $lang, $hub );
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
	 * @requestParam string $hub [OPTIONAL] The name of the vertical (e.g. Gaming, Entertainment, Lifestyle, etc.) to use as a filter
	 * @requestParam string $lang [OPTIONAL] The language code (e.g. en, de, fr, es, it, etc.) to use as a filter
	 * @requestParam integer $limit [OPTIONAL] The number of items per each batch/page, defaults to 25
	 * @requestParam integer $batch [OPTIONAL] The batch/page index to retrieve, defaults to 1
	 *
	 * @responseParam array $items The list of wikis matching the keyword and the optional filtering
	 * @responseParam integer $total The total number of results
	 * @responseParam integer $currentBatch The index of the current batch/page
	 * @responseParam integer $batches The total number of batches/pages
	 * @responseParam integer $next The amount of items in the next batch/page
	 *
	 * @example http://www.wikia.com/wikia.php?controller=WikisApi&method=getByString&string=call+of+duty&hub=Gaming&lang=en
	 */
	public function getByString() {
		$this->wf->profileIn( __METHOD__ );

		$keyword = trim( $this->request->getVal( 'string', '' ) );
		$hub = trim( $this->request->getVal( 'hub', null ) );
		$lang = trim( $this->getVal( 'lang', null ) );
		$limit = $this->request->getInt( 'limit', self::ITEMS_PER_BATCH );
		$batch = $this->request->getInt( 'batch', 1 );
		$results = $this->model->getByString($keyword, $lang, $hub );
		$batches = $this->wf->PaginateArray( $results, $limit, $batch );

		foreach ( $batches as $name => $value ) {
			$this->response->setVal( $name, $value );
		}

		//store only for 24h to allow new wikis
		//to appear in a reasonable amount of time in the search
		//results
		$this->response->setCacheValidity(
			86400 /* 24h */,
			86400 /* 24h */,
			array(
				WikiaResponse::CACHE_TARGET_BROWSER,
				WikiaResponse::CACHE_TARGET_VARNISH
			)
		);

		$this->wf->profileOut( __METHOD__ );
	}

	/**
	 * Get details about one or more wikis.
	 *
	 * @requestParam string $ids A string with a comma-separated list of wiki ID's
	 *
	 * @responseParam array A list of results with the wiki ID as the index, each item has a headline, desc, image and flags property
	 *
	 * @example http://www.wikia.com/wikia.php?controller=WikisApi&method=getDetails&ids=3125,490
	 */
	public function getDetails() {
		$this->wf->profileIn( __METHOD__ );

		$ids = $this->request->getVal( 'ids', null );

		if ( !empty( $ids ) ) {
			$ids = explode( ',', $ids );
		}

		$results = $this->model->getDetails( $ids );

		foreach ( $results as &$res ) {
			//image data transformation
			$imageUrl = null;
			$img = $this->wf->findFile( $res['image'] );

			if ( !empty( $img ) ) {
				$imageUrl = $img->getFullUrl();
			}

			$res['image'] = $imageUrl;

			//flags data transformation
			$flags = array();
			//those flags are used internally,
			//they shouldn't be exposed via the API
			$blacklist = array( 'blocked', 'promoted' );

			foreach ( $res['flags'] as $name => $val ) {
				if ( $val == true && !in_array( $name, $blacklist ) ) {
					$flags[] = $name;
				}
			}

			$res['flags'] = $flags;

			//remove redundant data available via other methods
			unset( $res['hubId'] );
			unset( $res['lang'] );
			unset( $res['url'] );
			unset( $res['name'] );
		}

		$this->setVal( 'items', $results );

		//store only for 24h to allow new wikis
		//to appear in a reasonable amount of time in the search
		//results
		$this->response->setCacheValidity(
			86400 /* 24h */,
			86400 /* 24h */,
			array(
				WikiaResponse::CACHE_TARGET_BROWSER,
				WikiaResponse::CACHE_TARGET_VARNISH
			)
		);

		$this->wf->profileOut( __METHOD__ );
	}
}
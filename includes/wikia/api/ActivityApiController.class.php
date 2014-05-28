<?php


class ActivityApiController extends WikiaApiController {
	private $revisionService;

	const DEFAULT_RESULTS_NUMBER = 10;
	const DEFAULT_ARTICLE_NAMESPACE = 0;

	function __construct( $revisionService = null ) {
		if( $revisionService == null ) {
			$revisionService = new RevisionService();
		}
		$this->revisionService = $revisionService;
	}

	/**
	 * Fetches latest activity information
	 *
	 * @requestParam int  $limit [OPTIONAL] maximal result count
	 * @requestParam array $namespaces [OPTIONAL] [0] by default
	 * @requestParam bool $allowDuplicates [OPTIONAL] 1 by default
	 *
	 * @responseParam array latest revision information
	 *
	 * @example
	 * @example &allowDuplicates=1
	 * @example &allowDuplicates=0
	 * @example &namespaces=0,14&allowDuplicates=0&limit=20
	 */
	public function getLatestActivity() {
		$limit = $this->getRequest()->getInt("limit", self::DEFAULT_RESULTS_NUMBER);
		$namespaces = $this->getRequest()->getArray("namespaces", [self::DEFAULT_ARTICLE_NAMESPACE]);
		$allowDuplicates = $this->getRequest()->getBool("allowDuplicates", true);

		$items = $this->revisionService->getLatestRevisions($limit, $namespaces, $allowDuplicates);

		$this->setVal( 'items', $items );
		$this->response->setVal( 'basepath', $this->wg->Server );
	}

	/**
	 * Fetches recently changed articles
	 *
	 * @requestParam int $limit [OPTIONAL] maximal result count
	 * @requestParam array $namespaces [OPTIONAL] [0] by default
	 * @requestParam bool $allowDuplicates [OPTIONAL] 1 by default
	 *
	 * @responseParam array latest revision information
	 *
	 * @example
	 * @example &allowDuplicates=1
	 * @example &allowDuplicates=0
	 * @example &namespaces=0,14&allowDuplicates=0&limit=20
	 */
	public function getRecentlyChangedArticles() {
		$limit = $this->getRequest()->getInt("limit", self::DEFAULT_RESULTS_NUMBER);
		$namespaces = $this->getRequest()->getArray("namespaces", [self::DEFAULT_ARTICLE_NAMESPACE]);
		$allowDuplicates = $this->getRequest()->getBool("allowDuplicates", true);

		$items = $this->revisionService->getLatestRevisions($limit, $namespaces, $allowDuplicates, 'filterByArticle');

		$this->setVal( 'items', $items );
		$this->response->setVal( 'basepath', $this->wg->Server );
	}
}

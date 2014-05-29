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
		$this->executeServiceQuery();
	}

	/**
	 * Fetches recently changed articles.
	 *
	 * Works the same as getLatestActivity() except behavior when allowDuplicates=0 is passed.
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
		$this->executeServiceQuery( 'filterByArticle' );
	}

	/**
	 * Gets query parameters from the request, sends the request to service and sets results to response $items[] variable
	 *
	 * Re-used method in ActivityApiController::getLatestActivity() and ActivityApiController::getRecentlyChangedArticles()
	 *
	 * @param String|null $filteringMethod name of filtering method passed to RevisionService::getLatestRevisions()
	 */
	private function executeServiceQuery( $filteringMethod = null ) {
		$limit = $this->getRequest()->getInt( 'limit', self::DEFAULT_RESULTS_NUMBER );
		$namespaces = $this->getRequest()->getArray( 'namespaces', [ self::DEFAULT_ARTICLE_NAMESPACE ] );
		$allowDuplicates = $this->getRequest()->getBool( 'allowDuplicates', true );

		$items = $this->revisionService->getLatestRevisions(
			$limit,
			$namespaces,
			$allowDuplicates,
			$filteringMethod
		);

		$this->response->setVal( 'items', $items );
		$this->response->setVal( 'basepath', $this->wg->Server );
	}

}

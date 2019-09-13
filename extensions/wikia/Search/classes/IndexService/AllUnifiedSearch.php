<?php

namespace Wikia\Search\IndexService;

use Exception;

/**
 * Aggregates all other services into a single request -- good for populating a full index.
 *
 * This is a copy paste from All.php, which has been adjusted for Unified Search purposes.
 * This class is not meant to stay, rather than that it's meant to be a stage in the migration to use Unified Search
 * rather than Solr.
 * @package Search
 * @subpackage IndexService
 */
class AllUnifiedSearch extends AbstractService {
	/**
	 * These are the services whose outputs will be aggregated during execute.
	 *
	 * @var array
	 */
	protected $services = [
		'Wikia\Search\IndexService\FullContent' => null,
		'Wikia\Search\IndexService\MediaData' => null,
		'Wikia\Search\IndexService\Metadata' => null,
		'Wikia\Search\IndexService\ArticleQuality' => null,
	];

	/**
	 * Invokes a bunch of other services' execute functions
	 *
	 * @throws Exception
	 * @see \Wikia\Search\IndexService\AbstractService::execute()
	 * @return array
	 */
	public function execute() {
		if ( $this->currentPageId === null ) {
			throw new Exception( "This service requires a page ID to be set." );
		}
		$result = [];
		foreach ( $this->services as $serviceName => $service ) {
			if ( $service === null ) {
				$service = new $serviceName();
				$this->services[$serviceName] = $service;
			}
			$subResult = $service->setPageId( $this->currentPageId )->getResponse();
			if ( is_array( $subResult ) ) {
				$result = array_merge( $result, $subResult );
			}
		}

		return array_merge( $result, $this->getWikiGlobalSearchInclusionStats() );
	}

	/**
	 * Retrieves stats for deciding to include page in global search.
	 * Return number of articles on wiki, promoted wiki and hidden wiki flags
	 *
	 * @return array
	 */
	protected function getWikiGlobalSearchInclusionStats() {
		global $wgExcludeWikiFromSearch;
		global $wgForceWikiIncludeInSearch;

		$result = [];
		$result['hidden_wiki_b'] = !empty( $wgExcludeWikiFromSearch );
		$result['promoted_wiki_b'] = !empty( $wgForceWikiIncludeInSearch );

		$service = $this->getService();
		$wikiData = $service->getApiStatsForWiki();
		$result['wiki_articles_i'] = $wikiData['query']['statistics']['articles'];
		return $result;
	}
}

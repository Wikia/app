<?php
namespace Wikia\Search\IndexService;
/**
 * Responsible for statistics for a given wiki
 * Separated out so we can run this service wiki-wide
 *
 * @author relwell
 * @package Search
 * @subpackage IndexService
 */
class WikiStats extends AbstractWikiService {
	/**
	 * Allows us to cache the result after requesting once
	 *
	 * @var array
	 */
	protected $result = [];

	/**
	 * Access statistics for a given wiki and set it in the document
	 *
	 * @return array containing result data
	 */
	public function execute() {
		$service = $this->getService();
		if ( $this->result == [] && $service->isOnDbCluster() ) {
			$data = $service->getApiStatsForWiki();
			$statistics = $data['query']['statistics'];
			if ( is_array( $statistics ) ) {
				$this->result['wikipages'] = $statistics['pages'];
				$this->result['wikiarticles'] = $statistics['articles'];
				$this->result['activeusers'] = $statistics['activeusers'];
				$this->result['wiki_images'] = $statistics['images'];
			}
		}

		return $this->result;
	}
}

<?php
/**
 * Class definition for \Wikia\Search\IndexService\WikiPromoData;
 * @author relwell
 *
 */
namespace Wikia\Search\IndexService;
/**
 * Responsible for statistics for a given wiki
 * Separated out so we can run this service wiki-wide
 * @author relwell
 * @package Search
 * @subpackage IndexService
 */
class WikiStats extends AbstractWikiService
{
	/**
	 * Allows us to cache the result after requesting once
	 * @var array
	 */
	protected $result = array();

    /**
	 * Access statistics for a given wiki and set it in the document
	 * @return array containing result data
	 */
	public function execute() {
		wfProfileIn(__METHOD__);
		$sharedDb = $this->service->getGlobal( 'ExternalSharedDB' );
		if (! empty( $sharedDb ) ) { 
			$data = $this->service->getApiStatsForWiki();
			$statistics = $data['query']['statistics'];
			if( is_array($statistics) ) {
				$this->result['wikipages']      = $statistics['pages'];
				$this->result['wikiarticles']   = $statistics['articles'];
				$this->result['activeusers']    = $statistics['activeusers'];
				$this->result['wiki_images']    = $statistics['images'];
			}
		}
		wfProfileOut(__METHOD__);
		return $this->result;
	}
}

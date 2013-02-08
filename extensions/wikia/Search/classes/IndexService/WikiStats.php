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
 */
class WikiStats extends AbstractWikiService
{
	/**
	 * Allows us to cache the result after requesting once
	 * @var array
	 */
	protected $result = array();

    /**
	 * Access the promo text for a given wiki and set it in the document
	 * @todo these need to be updated any time one of these values change for a wiki. could get dicey. will def need atomic update.
	 * @param int $wid the wiki id
	 * @return array containing result data
	 */
	public function execute() {
		wfProfileIn(__METHOD__);
		$data = $this->interface->getApiStatsForWiki();
	    $statistics = $data['query']['statistics'];
		if( is_array($statistics) ) {
			$this->result['wikipages']      = $statistics['pages'];
			$this->result['wikiarticles']   = $statistics['articles'];
			$this->result['activeusers']    = $statistics['activeusers'];
			$this->result['wiki_images']    = $statistics['images'];
		}
		wfProfileOut(__METHOD__);
		return $this->result;
	}
}

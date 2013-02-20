<?php
/**
 * Class definition for Wikia\Search\ResultSet\GroupingSet
 */
namespace Wikia\Search\ResultSet;
use \Wikia\Search\MediaWikiInterface;
/**
 * This is a search result set that contains grouped results.
 * @author relwell
 */
class GroupingSet extends Grouping
{
	/**
	 * Constructor.
	 * @param Solarium_Result_Select $result
	 * @param WikiaSearchConfig $searchConfig
	 * @param GroupingSet $parent
	 * @param int $metaposition
	 */
	public function __construct( Solarium_Result_Select $result, WikiaSearchConfig $searchConfig ) {
		$this->searchResultObject = $result;
		$this->searchConfig       = $searchConfig;
		$this->interface          = MediaWikiInterface::getInstance();
		$this->resultsFound = $this->getHostGrouping()->getMatches();
		$this->prependWikiMatchIfExists()
		     ->setResultGroupings()
		     ->setResultsFound( $this->resultsFound );
	}
	
	/**
	 * We use this to iterate over groupings and created nested search result sets.
	 * @return GroupingSet provides fluent interface
	 */
	protected function setResultGroupings() {
		$fieldGroup = $this->getHostGrouping();
		$metaposition = 0;
		foreach ($fieldGroup->getValueGroups() as $valueGroup) {
			$resultSet = Factory::getInstance()->get( $this->searchResultObject, $this->searchConfig, $this, $metaposition++ );
			$this->results[$resultSet->getHeader('cityUrl')] = $resultSet;
		}
		return $this;
	}
	
	/**
	 * Prepends a wiki match if one is stored in the config.
	 * @return GroupingSet
	 */
	protected function prependWikiMatchIfExists() {
		if ( $this->searchConfig->hasWikiMatch() ) {
    		$this->resultsFound++;
    		return $this->addResult( $this->searchConfig->getWikiMatch()->getResult() );
		}
		return $this;
	}
	
}
<?php
/**
 * Class definition for Wikia\Search\ResultSet\Grouping
 */
namespace Wikia\Search\ResultSet;
use \Wikia\Search\MediaWikiInterface, \ArrayIterator, \Solarium_Result_Select, \Wikia\Search\Config;
/**
 * This class handles sub-groupings of results for inter-wiki search.
 * @author relwell
 */
class Grouping extends Base
{

	/**
	 * The wrapper handling this particular grouping instance
	 * @var GroupingSet
	 */
	protected $parent;
	
	/**
	 * The host for grouping.
	 * @var string
	 */
	protected $host;
	
	/**
	 * Uses DependencyContainer to pre-populate attributes, and then configures stuff.
	 * @param DependencyContainer $container
	 */
	protected function configure( DependencyContainer $container ) {
		$this->searchResultObject = $container->getResult();
		$this->searchConfig       = $container->getConfig();
		$this->interface          = $container->getInterface();
		$this->parent             = $container->getParent();
		$this->metaposition       = $container->getMetaposition();
		$this->results            = new ArrayIterator( array() );
		
		$this->setResultsFromHostGrouping()
		     ->configureHeaders();

		
	}
	
	/**
	 * Finds current grouping from result and sets documents accordingly.
	 * @return \Wikia\Search\ResultSet\Grouping
	 */
	protected function setResultsFromHostGrouping() {
		$valueGroups = $this->getHostGrouping()->getValueGroups();
		$valueGroup  = $valueGroups[$this->metaposition];
		$this->host  = $valueGroup->getValue();
		$this->resultsFound = $valueGroup->getNumFound();
		$this->setResults( $valueGroup->getDocuments() );
		return $this;
	}
	
	/**
	 * Sets a bunch of headers associated with wiki info
	 * @return Wikia\Search\ResultSet\Grouping
	 */
	protected function configureHeaders() {
		$doc = end( $this->results ); // there's only one
		if (! empty( $doc ) ) {
			$cityId = $doc['wid'];
			$statsInfo = $this->interface->getStatsInfoForWikiId( $cityId );
			foreach ( $statsInfo as $key => $val ) {
				$statsInfo[$key.'_count'] = $val;
				unset( $statsInfo[$key] );
			}
			$this->addHeaders( $doc->getFields() )
			     ->addHeaders( $this->interface->getVisualizationInfoForWikiId( $cityId ) )
			     ->addHeaders( $statsInfo )
			     ->setHeader ( 'wikititle', $this->interface->getGlobalForWiki( 'wgSitename', $cityId ) );
		}
		return $this;
	}
	
	/**
	 * Reusable method for grabbing the resultset grouped by host.
	 * @throws Exception
	 * @return Solarium_Result_Select_Grouping_FieldGroup
	 */
	protected function getHostGrouping() {
		$grouping = $this->searchResultObject->getGrouping();
		if (! $grouping ) {
		    throw new \Exception("Search config was grouped but result was not.");
		}
		$hostGrouping = $grouping->getGroup('host');
		if (! $hostGrouping ) {
		    throw new \Exception("Search results were not grouped by host field.");
		}
		return $hostGrouping;
	}

	/**
	 * Returns the parent value set during instantiation
	 * @return GroupingSet|null
	 */
	public function getParent() {
		return $this->parent;
	}

	/**
	 * Returns the host value of the grouping.
	 * @return string
	 */
	public function getId() {
		return $this->host;
	}
	
	/**
	 * Allows us to serialize some core values from an expected wiki for json requests
	 * @param array $expectedFields
	 * @return array
	 */
	public function toArray( $expectedFields = array( 'title', 'url' ) ) {
		$result = array();
		foreach ( $expectedFields as $field ) {
			switch ( $field ) {
				case 'title':
					$result['title'] = $this->getHeader( 'cityTitle' );
					break;
				case 'url':
					$result['url'] = $this->getHeader( 'cityUrl' );
					break;
			}
		}
		return $result;
	}

}
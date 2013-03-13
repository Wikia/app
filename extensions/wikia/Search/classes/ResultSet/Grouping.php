<?php
/**
 * Class definition for Wikia\Search\ResultSet\Grouping
 */
namespace Wikia\Search\ResultSet;
use \Wikia\Search\MediaWikiService, \ArrayIterator, \Solarium_Result_Select, \Wikia\Search\Config;
/**
 * This class handles sub-groupings of results for inter-wiki search.
 * @author relwell
 * @package Search
 * @subpackage ResultSet
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
			$wikiId = $doc['wid'];
			$this->addHeaders( $doc->getFields() )
			     ->addHeaders( $this->interface->getVisualizationInfoForWikiId( $wikiId ) )
			     ->addHeaders( $this->interface->getStatsInfoForWikiId( $wikiId ) )
			     ->setHeader ( 'wikititle', $this->interface->getGlobalForWiki( 'wgSitename', $wikiId ) )
			     ->setHeader ( 'hub', $this->interface->getHubForWikiId( $wikiId ) );
			
			if (! $this->getHeader( 'description' ) ) {
				$this->setHeader( 'description', $this->interface->getDescriptionTextForWikiId( $wikiId ) );
			}
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
	 * @return array
	 */
	public function toArray() {
		return $this->getHeader();
	}

}
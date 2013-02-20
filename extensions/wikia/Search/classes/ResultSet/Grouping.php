<?php
/**
 * Class definition for Wikia\Search\ResultSet\Grouping
 */
namespace Wikia\Search\ResultSet;
use \Wikia\Search\MediaWikiInterface;
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
	 * Constructor, sets parent and metaposition and configures instance.
	 * @param Solarium_Result_Select $result
	 * @param WikiaSearchConfig $searchConfig
	 * @param GroupingSet $parent
	 * @param int $metaposition
	 */
	public function __construct( Solarium_Result_Select $result, WikiaSearchConfig $searchConfig, GroupingSet $parent, $metaposition ) {
		$this->searchResultObject = $result;
		$this->searchConfig       = $searchConfig;
		$this->parent             = $parent;
		$this->metaposition       = $metaposition;
		$this->interface          = MediaWikiInterface::getInstance();
		
		$valueGroups = $this->getHostGrouping()->getValueGroups();
		$valueGroup  = $valueGroups[$this->metaposition];
		$this->host  = $valueGroup->getValue();
		$documents   = $valueGroup->getDocuments();

		$this->setResults       ( $documents )
		     ->setResultsFound  ( $valueGroup->getNumFound() );

		if ( count( $documents ) > 0 ) {
			$exampleDoc = $documents[0];
			$cityId     = $exampleDoc->getCityId();

			$this->setHeader( 'cityId', $cityId )
			     ->setHeader( 'cityTitle', $this->interface->getGlobalForWiki( 'wgSitename', $cityId ) )
			     ->setHeader( 'cityUrl', $this->interface->getGlobalForWiki( 'wgServer', $cityId ) )
			     ->setHeader( 'cityArticlesNum', $exampleDoc['wikiarticles'] );
		}
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

}
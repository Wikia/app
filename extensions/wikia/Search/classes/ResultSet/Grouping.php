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
	 * Constructor, uses DependencyContainer to pre-populate attributes.
	 * @param DependencyContainer $container
	 */
	public function __construct( DependencyContainer $container ) {
		$this->searchResultObject = $container->getResult();
		$this->searchConfig       = $container->getConfig();
		$this->interface          = $container->getInterface();
		$this->parent             = $container->getParent();
		$this->metaposition       = $container->getMetaposition();
		$this->results            = new ArrayIterator( array() );
		
		$valueGroups = $this->getHostGrouping()->getValueGroups();
		$valueGroup  = $valueGroups[$this->metaposition];
		$this->host  = $valueGroup->getValue();
		$documents   = $valueGroup->getDocuments();

		$this->setResults       ( $documents )
		     ->setResultsFound  ( $valueGroup->getNumFound() )
		     ->configureGlobals();

		
	}
	
	/**
	 * Sets a bunch of headers associated with wiki info
	 */
	protected function configureGlobals() {
		$doc = end( $this->results ); // there's only one
		if (! empty( $doc ) ) {
			$cityId     = $doc['wid'];
			$this->setHeader( 'cityId', $cityId )
			     ->setHeader( 'cityTitle', $this->interface->getGlobalForWiki( 'wgSitename', $cityId ) )
			     ->setHeader( 'cityUrl', $this->interface->getGlobalForWiki( 'wgServer', $cityId ) );
			
			foreach ( $this->interface->getVisualizationInfoForWikiId( $cityId ) as $key => $val ) {
				$this->setHeader( $key.'_count', $val );
			}
			$this->addHeaders( $this->interface->getStatsInfoForWikiId( $cityId ) );
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
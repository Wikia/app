<?php
/**
 * Class definition for Wikia\Search\QueryService\Select\InterWiki
 */
namespace Wikia\Search\QueryService\Select;
use \Solarium_Query_Select, \Wikia\Search\Utilities;
/**
 * This class is responsible for performing interwiki search queries.
 * Presently, that not only means not restricting search by a single wiki,
 * but also grouping by hostname.
 * @author relwell
 * @package Search
 * @subpackage QueryService
 */
class InterWiki extends AbstractSelect
{
	/**
	 * Used for tracking
	 * @var string
	 */
	protected $searchType = 'inter';
	
	/** 
	 * Boost functions used in interwiki search
	 * @var array
	 */
	protected $boostFunctions = array(
		'wam_i^100',
	);
	
	/**
	 * Uses the xwiki core, where a wiki is a document.
	 * @var string
	 */
	protected $core = 'xwiki';
	
	/**
	 * Default time allowed for a query.
	 * @var int
	 */
	protected $timeAllowed = 1000;
	
	/**
	 * Reuses AbstractSelect's extractWikiMatch as the primary match method
	 * @see \Wikia\Search\QueryService\Select\AbstractSelect::extractMatch()
	 * @return Wikia\Search\Match\Wiki
	 */
	public function extractMatch() {
		return $this->extractWikiMatch();
	}
	
	/**
	 * Registers grouping, query parameters, and filters.
	 * @see \Wikia\Search\QueryService\Select\AbstractSelect::registerComponents()
	 * @param Solarium_Query_Select $query
	 * @return InterWiki
	 */
	protected function registerComponents( Solarium_Query_Select $query ) {
		return $this->registerQueryParams   ( $query )
		            ->registerFilterQueries ( $query )
		            ->registerDismax        ( $query )
		;
	}
	

	/**
	 * Registers a filter query for documents matching the wiki ID of a match, if available.
	 * @see \Wikia\Search\QueryService\Select\AbstractSelect::registerFilterQueryForMatch()
	 * @return Wikia\Search\QueryService\Select\InterWiki
	 */
	protected function registerFilterQueryForMatch() {
		if ( $this->config->hasWikiMatch() ) {
			$noPtt = Utilities::valueForField( 'id', $this->config->getWikiMatch()->getId(), array( 'negate' => true ) );
			$this->config->setFilterQuery( $noPtt, 'wikiptt' );
		}
		return $this;
	}
	
	
	/**
	 * Handles initial configuration when invoking search.
	 * @return Wikia\Search\QueryService\Select\InterWiki
	 */
	protected function prepareRequest() {
		if ( $this->config->getPage() > 1 ) {
			$this->config->setStart( ( $this->config->getPage() - 1 ) * $this->config->getLength() );
		}
		// @todo config needs requested fields set dynamically
		$this->config->setRequestedFields( [ 'id', 'headline_txt', 'wam_i', 'description', 'sitename_txt', 'url', 'videos_i', 'images_i', 'image_s', 'hot_b', 'promoted_b', 'new_b', 'official_b', 'hub_s', 'lang_s' ] );
		return $this;
	}
	
	/**
	 * Builds the string used with filter queries based on search config
	 * @return string
	 */
	protected function getFilterQueryString() {
		$filterQueries = [ '-articles_i:[0 TO 50]' ];
		$hub = $this->config->getHub();
		if (! empty( $hub ) ) {
			$filterQueries[] = Utilities::valueForField( 'hub_s', $hub );
		}
		return implode( ' AND ', $filterQueries );
	}
	
	/**
	 * Builds the necessary query clauses based on values set in the searchconfig object
	 * @return string
	 */
	protected function getQueryClausesString()
	{
		$widQueries = array();
		$excludedWikiIds = $this->service->getGlobalWithDefault( 'CrossWikiaSearchExcludedWikis', [] );
		$excludedWikiIds[] = $this->service->getWikiId();
		foreach ( $excludedWikiIds as $excludedWikiId ) {
			$widQueries[] = Utilities::valueForField( 'wid',  $excludedWikiId, array( 'negate' => true ) );
		}
		$queryClauses= array(
				'lang_s:'.$this->config->getLanguageCode()
		);

		$hub = $this->config->getHub();
		if (! empty( $hub ) ) {
		    $queryClauses[] = Utilities::valueForField( 'hub', $hub );
		}
		return sprintf( '%s', implode( ' AND ', $queryClauses ) );
	}

	/**
	 * Return a string of query fields based on configuration
	 * @todo since this gets repeated across OnWiki as well, this is an another indicator that we need additional class layers
	 * @return string
	 */
	protected function getQueryFieldsString() {
		$queryFieldsString = '';
		$qf = [ 'headline_txt' => 300, 'description' => 250, 'categories' => 50, 'articles' => 75, 'top_categories' => 150, 'top_articles' => 200, 'sitename_txt' => 500 ];
		foreach ( $qf as $field => $boost ) {
			$queryFieldsString .= sprintf( '%s^%s ', Utilities::field( $field ), $boost );
		}
		return trim( $queryFieldsString );
	}
	
}
<?php
/**
 * Class definition for Wikia\Search\QueryService\Select\OnWiki
 */
namespace Wikia\Search\QueryService\Select;
use \Wikia\Search\Utilities, \Solarium_Query_Select as Select;
/**
 * This class is responsible for the default behavior of search.
 * That is, searching for documents on a given wiki matching the provided term.
 * @author relwell
 * @package Search
 * @subpackage QueryService
 */
class OnWiki extends AbstractSelect
{
	/**
	 * Used for tracking
	 * @var string
	 */
	protected $searchType = 'intra';
	
	/**
	 * Boost functions for on-wiki search
	 * @var array
	 */
	protected $boostFunctions = array(
		'log(backlinks)'
	);
	
	/**
	 * Passes data from the config to the MW service to instantiate a match and store it in the config.
	 * @return Wikia\Search\Match\Article|null
	 */
	public function extractMatch() {
		$query = $this->config->getQuery()->getSanitizedQuery();
		$match = $this->service->getArticleMatchForTermAndNamespaces( $query, $this->config->getNamespaces() );
		if (! empty( $match ) ) {
			if ( $this->matchPassesFilters( $match ) ) {
				$this->config->setArticleMatch( $match );
			}
		}
		if ( $this->service->getGlobal( 'OnWikiSearchIncludesWikiMatch' ) ) {
			$domain = preg_replace(
				'/[^a-zA-Z]/',
				'',
				strtolower( $query ) 
				);
			$wikiMatch = $this->service->getWikiMatchByHost( $domain );
			if (! empty( $wikiMatch ) ) {
				$this->config->setWikiMatch( $wikiMatch );
			}
		}
		return $this->config->getMatch();
	}
	
	/**
	 * Here, we're checking for conditions that should preclude a match, given our current environment settings.
	 * We're using DeMorgan's theorem here. So write FOR the condition you're trying to filter out.
	 * @param \Wikia\Search\Match\Article $match
	 * @return boolean
	 */
	protected function matchPassesFilters( \Wikia\Search\Match\Article $match ) {
		$result = $match->getResult();
		return ! (
				( // We have a file that is video, but we only want images.
						$result['ns'] == NS_FILE
						&& 
						in_array( \Wikia\Search\Config::FILTER_IMAGE, $this->getConfig()->getPublicFilterKeys() )
						&&
						$this->getService()->pageIdIsVideoFile( $result['pageid'] )
				) 
				||
				( // We have a file that is not a video, but we only want videos.
						$result['ns'] == NS_FILE
						&& 
						in_array( \Wikia\Search\Config::FILTER_VIDEO, $this->getConfig()->getPublicFilterKeys() )
						&&
						!$this->getService()->pageIdIsVideoFile( $result['pageid'] )
				)
		);
	}
	
	/**
	 * Registers different components in Solarium. We also use this spot to update query fields for the video search child class.
	 * @param \Solarium_Query_Select $query
	 * @see \Wikia\Search\QueryService\Select\AbstractSelect::registerComponents()
	 */
	protected function registerComponents( Select $query ) {
		return $this->configureQueryFields()
		            ->registerQueryParams   ( $query )
		            ->registerHighlighting  ( $query )
		            ->registerFilterQueries ( $query )
		            ->registerSpellcheck    ( $query )
		            ->registerDismax        ( $query )
		;
	}
	
	/**
	 * Responsible for assigning a filter query to our push-to-top result to prevent duplicate results.
	 * @see \Wikia\Search\QueryService\Select\AbstractSelect::registerFilterQueryForMatch()
	 * @return OnWiki
	 */
	protected function registerFilterQueryForMatch() {
		if ( $this->config->hasArticleMatch() ) {
			$noPtt = Utilities::valueForField( 'id', $this->config->getArticleMatch()->getResult()->getVar( 'id' ), array( 'negate' => true ) ) ;
			$this->config->setFilterQuery( $noPtt, 'ptt' );
		}
		return $this;
	}
	
	/**
	 * Configures spellcheck per our desired settings
	 * @param Solarium_Query_Select $query
	 * @return OnWiki
	 */
	protected function registerSpellcheck( Select $query ) {
		if ( $this->service->getGlobal( 'WikiaSearchSpellcheckActivated' ) ) {
			$query->getSpellcheck()
			      ->setQuery( $this->config->getQuery()->getSanitizedQuery() )
			      ->setCollate( true )
			      ->setCount( self::SPELLING_RESULT_COUNT )
			      ->setMaxCollationTries( self::SPELLING_MAX_COLLATION_TRIES )
			      ->setMaxCollations( self::SPELLING_MAX_COLLATIONS )
			      ->setExtendedResults( true )
			      ->setCollateParam( 'fq', 'is_content:true AND wid:'.$this->config->getCityId() )
			      ->setOnlyMorePopular( true )
			      ->setCollateExtendedResults( true )
			;
		}
		return $this;
	}
	
	/**
	 * This is a hook called if we need to modify the basic query fields as a part the class's basic functionality.
	 * @return OnWiki
	 */
	protected function configureQueryFields() {
	    return $this;
	}
	
	/**
	 * Return a string of query fields based on configuration
	 * @return string
	 */
	protected function getQueryFieldsString() {
		$queryFieldsString = '';
		foreach ( $this->config->getQueryFieldsToBoosts()  as $field => $boost ) {
			$queryFieldsString .= sprintf( '%s^%s ', Utilities::field( $field ), $boost );
		}
		return trim( $queryFieldsString );
	}
	
	/**
	 * Require the wiki ID we're on, and that everything is in the provided namespaces
	 * @return string
	 */
	protected function getQueryClausesString() {
		$queryClauses = array( Utilities::valueForField( 'wid', $this->config->getCityId() ) );
		$nsQuery = '';
		foreach ( $this->config->getNamespaces() as $namespace ) {
			$nsQuery .= ( !empty( $nsQuery ) ? ' OR ' : '' ) . Utilities::valueForField( 'ns', $namespace );
		}
		$queryClauses[] = "({$nsQuery})";
		return sprintf( '(%s)', implode( ' AND ', $queryClauses ) );
	}
}
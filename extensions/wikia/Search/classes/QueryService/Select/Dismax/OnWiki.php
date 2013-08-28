<?php
/**
 * Class definition for Wikia\Search\QueryService\Select\Dismax\OnWiki
 */
namespace Wikia\Search\QueryService\Select\Dismax;
use \Wikia\Search\Utilities, \Solarium_Query_Select as Select;
/**
 * This class is responsible for the default behavior of search.
 * That is, searching for documents on a given wiki matching the provided term.
 * @author relwell
 * @package Search
 * @subpackage QueryService
 */
class OnWiki extends AbstractDismax
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
		$config = $this->getConfig();
		$service = $this->getService();
		$query = $config->getQuery()->getSanitizedQuery();
		$match = $service->getArticleMatchForTermAndNamespaces( $query, $config->getNamespaces() );
		if (! empty( $match ) ) {
			$config->setArticleMatch( $match );
		}
		if ( $service->getGlobal( 'OnWikiSearchIncludesWikiMatch' ) ) {
			$this->extractWikiMatch();
		}
		return $config->getMatch();
	}
	
	/**
	 * Registers different components in Solarium. We also use this spot to update query fields for the video search child class.
	 * @param \Solarium_Query_Select $query
	 */
	protected function registerNonDismaxComponents( Select $query ) {
		return $this->registerHighlighting  ( $query )
		            ->registerFilterQueries ( $query )
		            ->registerSpellcheck    ( $query )
		;
	}
	
	/**
	 * Responsible for assigning a filter query to our push-to-top result to prevent duplicate results.
	 * @see \Wikia\Search\QueryService\Select\AbstractSelect::registerFilterQueryForMatch()
	 * @return OnWiki
	 */
	protected function registerFilterQueryForMatch() {
		$config = $this->getConfig();
		if ( $config->hasArticleMatch() ) {
			$noPtt = Utilities::valueForField( 'id', $config->getArticleMatch()->getResult()->getVar( 'id' ), array( 'negate' => true ) ) ;
			$config->setFilterQuery( $noPtt, 'ptt' );
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
	
	/**
	 * Builds the string used with filter queries based on search config
	 * @return string
	 */
	protected function getFilterQueryString()
	{
		$namespaces = [];
		foreach ( $this->config->getNamespaces() as $ns ) {
			$namespaces[] = Utilities::valueForField( 'ns', $ns );
		}
		return implode( ' AND ', [ sprintf( '(%s)', implode( ' OR ', $namespaces ) ), Utilities::valueForField( 'wid', $this->config->getCityId() ) ] );
	}
}
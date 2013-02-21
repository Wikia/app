<?php
/**
 * Class definition for Wikia\Search\QueryService\Select\OnWiki
 */
namespace Wikia\Search\QueryService\Select;
use \Wikia\Search\Utilities, \Solarium_Query_Select;

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
		'log(views)^0.66', 
		'log(backlinks)'
	);
	
	/**
	 * @return Wikia\Search\Match\Article|null
	 */
	public function extractMatch() {
		$match = $this->interface->getArticleMatchForTermAndNamespaces( $this->config->getOriginalQuery(), $this->config->getNamespaces() );
		if (! empty( $match ) ) {
			$this->config->setArticleMatch( $match );
		}
		
		return $this->config->getMatch();
	}
	
	/**
	 * Registers different components in Solarium
	 * @see \Wikia\Search\QueryService\Select\AbstractSelect::registerComponents()
	 */
	protected function registerComponents( \Solarium_Query_Select $query ) {
		return $this->registerQueryParams   ( $query )
		            ->registerHighlighting  ( $query )
		            ->registerFilterQueries ( $query )
		            ->registerSpellcheck    ( $query )
		;
	}
	
	protected function registerFilterQueryForMatch() {
		if ( $this->config->hasArticleMatch() ) {
			$noPtt = Utilities::valueForField( 'id', $this->config->getArticleMatch()->getResult()->getVar( 'id' ), array( 'negate' => true ) ) ;
			$this->config->setFilterQuery( $noPtt, 'ptt' );
		} 
	}
	
	/**
	 * Configures spellcheck per our desired settings
	 * @param Solarium_Query_Select $query
	 * @return OnWiki
	 */
	protected function registerSpellcheck( Solarium_Query_Select $query ) {
		if ( $this->interface->getGlobal( 'WikiaSearchSpellcheckActivated' ) ) {
			$query->getSpellcheck()
			      ->setQuery( $this->config->getQueryNoQuotes( true ) )
			      ->setCollate( true )
			      ->setCount( self::SPELLING_RESULT_COUNT )
			      ->setMaxCollationTries( self::SPELLING_MAX_COLLATION_TRIES )
			      ->setMaxCollations( self::SPELLING_MAX_COLLATIONS )
			      ->setExtendedResults( true )
			      ->setCollateParam( 'fq', 'is_content:true AND wid:'.$this->config->getCityId() )
			      ->setOnlyMorePopular( true )
			      ->setDictionary( $this->interface->searchSupportsCurrentLanguage() ? $this->interface->getLanguageCode() : 'default'   )
			      ->setCollateExtendedResults( true )
			;
		}
		return $this;
	}
	
	/**
	 * This is a hook called if we need to modify the basic query fields as a part the class's basic functionality.
	 */
	protected function configureQueryFields(){}
	
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
	 * @see \Wikia\Search\QueryService\Select\AbstractSelect::getFormulatedQuery()
	 */
	protected function getFormulatedQuery() {
		return sprintf( '%s AND (%s)', $this->getQueryClausesString(), $this->getNestedQuery() );
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
	 * Returns the string used to build out a boost query with Solarium
	 * @return string
	 */
	protected function getBoostQueryString()
	{
		$queryNoQuotes = $this->config->getQueryNoQuotes( true );
		$boostQueries = array(
				Utilities::valueForField( 'html', $queryNoQuotes, array( 'boost'=>5, 'quote'=>'\"' ) ),
		        Utilities::valueForField( 'title', $queryNoQuotes, array( 'boost'=>10, 'quote'=>'\"' ) ),
		);
		return implode( ' ', $boostQueries );
	}
}
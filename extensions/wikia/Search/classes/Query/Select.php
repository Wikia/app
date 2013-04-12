<?php
/**
 * Class definition for Wikia\Search\Query\Select
 */
namespace Wikia\Search\Query;
use Wikia\Search\MediaWikiService, Wikia\Search\Utilities, Sanitizer, Solarium_Query_Helper;
/**
 * This class is responsible for abstracting the different ways we express queries.
 * @author relwell
 */
class Select
{
	/**
	 * The pristine value passed during construct with no alterations
	 * @var string
	 */
	protected $rawQuery;
	
	/**
	 * Any possible namespace prefix -- has to be an actual prefix, though.
	 * @var string
	 */
	protected $namespacePrefix;
	
	/**
	 * Keeps us from checking for namespace more than once.
	 * @var boolean
	 */
	protected $namespaceChecked = false;
	
	/**
	 * If we have a namespace query, then an int. Otherwise null.
	 * @var int
	 */
	protected $namespaceId;
	
	/**
	 * This is the query string *without* any namespace prefix.
	 * We use this for passing to Solr queries.
	 * @var string
	 */
	protected $strippedQuery;
	
	/**
	 * This is our original query with any XSS vulns and tags removed.
	 * @var unknown_type
	 */
	protected $sanitizedQuery;
	
	/**
	 * MediaWikiService, encapsulates MediaWiki logic
	 * @var Wikia\Search\MediaWikiService
	 */
	protected $service;
	
	/**
	 * Constructor method. Requires the original query string.
	 * Sets this value as protected attribute rawQuery.
	 * This is raw user input, so you should use a public accessor to get the right kind of query.
	 * @param string $queryString
	 */
	public function __construct( $queryString )
	{
		$this->rawQuery = $queryString;
	}
	
	/**
	 * Lazy-loads a sanitized version of the user input.
	 * @return string
	 */
	public function getSanitizedQuery() {
		if ( $this->sanitizedQuery == null ) {
			$this->sanitizedQuery = html_entity_decode( (new Sanitizer)->StripAllTags( $this->rawQuery ), \ENT_COMPAT, 'UTF-8');
		}
		return $this->sanitizedQuery;
	}
	
	/**
	 * Returns the value we use when querying Solr, with the appropriate special characters escaped.
	 * @return string
	 */
	public function getSolrQuery() {
		$query = $this->getSanitizedQuery();
		if (! $this->namespaceChecked ) {
			$this->initializeNamespaceData();
		}
		// we don't want the namespace prefix
		if ( $this->namespacePrefix !== null ) {
			$query = substr( $query, strlen( $this->namespacePrefix ) + 1 ); // prefix plus colon
		}
		
		// non-indexed number-string phrases issue workaround (RT #24790)
		$query = preg_replace( '/(\d+)([a-zA-Z]+)/i', '$1 $2', $query );
	
		// escape all lucene special characters: + - && || ! ( ) { } [ ] ^ " ~ * ? : \ (RT #25482)
		return (new Solarium_Query_Helper)->escapeTerm( $query,  ENT_COMPAT, 'UTF-8' );
	}
	
	/**
	 * Returns the query prepped to be shown in HTML
	 * @return string
	 */
	public function getQueryForHtml() {
		return htmlentities( $this->getSanitizedQuery(), ENT_COMPAT, 'UTF-8' );
	}
	
	/**
	 * Returns the namespace prefix string, if a legit prefix string.
	 * @return string
	 */
	public function getNamespacePrefix() {
		if (! $this->namespaceChecked ) {
			$this->initializeNamespaceData();
		}
		return $this->namespacePrefix;
	}
	
	/**
	 * Returns the integer value of a namespace constant correlating to the prefix string of a search query.
	 * @return int
	 */
	public function getNamespaceId() {
		if (! $this->namespaceChecked ) {
			$this->initializeNamespaceData();
		}
		return $this->namespaceId;
	}
	
	/**
	 * Says whether we have an actionable value for searching
	 * @return boolean
	 */
	public function hasTerms() {
		return strlen( trim( $this->getSanitizedQuery() ) ) > 0;
	} 
	
	/**
	 * This is factored out of getNamespaceId and getNamespacePrefix so we can just lazy load them for either.
	 * @return bool
	 */
	protected function initializeNamespaceData() {
		$query = $this->getSanitizedQuery();
		if ( (! $this->namespaceChecked ) && ( $this->namespacePrefix === null ) && strpos( $query, ':' ) !== false ) {
			$colonSploded = explode( ':', $query );
			$queryNamespace = $this->getService()->getNamespaceIdForString( $colonSploded[0] );
			if ( is_int( $queryNamespace ) && $queryNamespace > 0 ) {
				$this->namespaceId = $queryNamespace;
				$this->namespacePrefix = $colonSploded[0];
			}
		}
		$this->namespaceChecked = true;
		return true;
	}
	
	/**
	 * Accessor method, handles lazy-loaded DI
	 * @return MediaWikiService
	 */
	protected function getService() {
		if ( $this->service === null ) {
			$this->service = new MediaWikiService;
		}
		return $this->service;
	}
	
}
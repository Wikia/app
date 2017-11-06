<?php

namespace Wikia\Search\Services;

use Solarium_Result_Select;
use Wikia\Search\Query\Select;
use Wikia\Search\QueryService\Factory;
use WikiFactory;

class EntitySearchService extends AbstractSearchService {
	const WORDS_QUERY_LIMIT = 10;
	const WIKIA_URL_REGEXP = '~^(http(s?)://)(([^\.]+)\.wikia\.com)~';

	/** @var \Solarium_Client client */
	protected $client;
	protected $categories;
	protected $filters = [];
	protected $hosts;
	protected $hubs;
	protected $ids;
	protected $lang;
	protected $namespace;
	protected $quality;
	protected $rowLimit;
	protected $sorts;
	protected $urls;
	protected $wikiId;

	/**
	 * @var BlacklistFilter
	 */
	private $blacklist;

	public function getBlacklist() {
		if ( empty( $this->blacklist ) ) {
			$this->blacklist = new BlacklistFilter( $this->getCore() );
		}

		return $this->blacklist;
	}

	/**
	 * @param mixed $filters
	 */
	public function addFilters( array $filters ) {
		$this->filters = array_merge( $this->filters, $filters );
	}

	/**
	 * @param mixed $filters
	 */
	public function setFilters( $filters ) {
		$this->filters = $filters;
	}

	/**
	 * @return mixed
	 */
	public function getFilters() {
		return $this->filters;
	}

	/**
	 * @param mixed $rowLimit
	 */
	public function setRowLimit( $rowLimit ) {
		$this->rowLimit = $rowLimit;
	}

	/**
	 * @return mixed
	 */
	public function getRowLimit() {
		return $this->rowLimit;
	}

	/**
	 * @param mixed $sorts
	 */
	public function setSorts( $sorts ) {
		$this->sorts = $sorts;
	}

	/**
	 * @return mixed
	 */
	public function getSorts() {
		return $this->sorts;
	}

	/**
	 * @param mixed $host
	 */
	public function setHosts( $hosts ) {
		$this->hosts = $hosts;
	}

	/**
	 * @return mixed
	 */
	public function getHosts() {
		return $this->hosts;
	}

	/**
	 * @param mixed $categories
	 */
	public function setCategories( $categories ) {
		$this->categories = $categories;
	}

	/**
	 * @return mixed
	 */
	public function getCategories() {
		return $this->categories;
	}

	/**
	 * @param mixed $ids
	 */
	public function setIds( $ids ) {
		$this->ids = $ids;

		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getIds() {
		return $this->ids;
	}

	public function __construct( $client = null ) {
		$config = $this->getConfig();
		$core = $this->getCore();
		$this->blacklist = new BlacklistFilter( $core );
		if ( $core ) {
			$config['adapteroptions']['core'] = $core;
		}
		$this->client = ( $client !== null ) ? $client : new \Solarium_Client( $config );
	}


	public function query( $phrase ) {
		$select = $this->prepareQuery( $phrase );

		$response = $this->select( $select );
		$result = $this->consumeResponse( $response );

		return $result;
	}

	public function getLang() {
		return $this->lang;
	}

	public function setLang( $lang ) {
		$this->lang = $lang;

		return $this;
	}

	public function getQuality() {
		return $this->quality;
	}

	public function setQuality( $quality ) {
		$this->quality = $quality;

		return $this;
	}

	public function getWikiId() {
		return $this->wikiId;
	}

	public function setWikiId( $wikiId ) {
		$this->wikiId = $wikiId;

		return $this;
	}

	public function getNamespace() {
		return $this->namespace;
	}

	public function setNamespace( $namespace ) {
		$this->namespace = $namespace;
	}

	public function getHubs() {
		return $this->hubs;
	}

	public function setHubs( $hubs ) {
		$this->hubs = $hubs;
	}


	protected function prepareQuery( string $query ) {
		$select = $this->getSelect();

		return $select;
	}

	protected function getConfig() {
		return ( new Factory() )->getSolariumClientConfig();
	}

	protected function getCore() {
		return SearchCores::CORE_MAIN; //defaults to main
	}

	protected function getSelect() {
		return $this->client->createSelect();
	}

	protected function select( $select ) {
		return $this->client->select( $select );
	}

	protected function sanitizeQuery( $query ) {
		$select = new Select( $query );

		return $select->getSolrQuery( static::WORDS_QUERY_LIMIT );
	}

	protected function withLang( $field, $lang ) {
		return $field . '_' . $lang;
	}

	public function replaceHostUrl( $url ) {
		return WikiFactory::getLocalEnvURL( $url );
	}

}

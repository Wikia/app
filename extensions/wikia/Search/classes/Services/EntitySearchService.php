<?php

namespace Wikia\Search\Services;

use Solarium_Result_Select;
use Wikia\Search\Query\Select;
use Wikia\Search\QueryService\Factory;
use WikiFactory;

class EntitySearchService {
	const WORDS_QUERY_LIMIT = 10;
	const WIKIA_URL_REGEXP = '~^(http(s?)://)(([^\.]+)\.wikia\.com)~';
	const XWIKI_CORE = 'xwiki';

	protected $blacklistedWikiHosts = [];
	protected $blacklistedWikiIds = [];

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
	 * @param array $blacklistedWikiIds
	 */
	public function setBlacklistedWikiIds( $blacklistedWikiIds ) {
		$this->blacklistedWikiIds = $blacklistedWikiIds;
	}

	public function appendBlacklistedWikiId( $wid ) {
		if ( !in_array( $wid, $this->blacklistedWikiIds ) ) {
			$this->blacklistedWikiIds[] = $wid;
		}
	}

	public function getLicencedWikis() {
		$licencedService = new \LicensedWikisService();
		return array_keys($licencedService->getCommercialUseNotAllowedWikis());
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
		if ( $core ) {
			$config[ 'adapteroptions' ][ 'core' ] = $core;
		}
		$this->client = ( $client !== null ) ? $client : new \Solarium_Client( $config );
		$this->blacklistedWikiIds = array_unique( array_merge( $this->blacklistedWikiIds, $this->getLicencedWikis() ) );
	}

	public function getCoreFieldNames() {
		$core = $this->getCore();
		$core_opt = array( // main core is default
			'wikiId' 	=> 'wid',
			'wikiHost'	=> 'host'
		);
		switch ( $core ) {
			case static::XWIKI_CORE:
				$core_opt['wikiId'] = 'id';
				$core_opt['wikiHost'] = 'hostname_s';
			break;
		}
		return $core_opt;
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


	protected function prepareQuery( $query ) {
		$select = $this->getSelect();

		return $select;
	}

	/**
	 * @param Solarium_Result_Select $response Search response
	 * @return mixed
	 */
	protected function consumeResponse( $response ) {
		return $response;
	}

	protected function getConfig() {
		return ( new Factory() )->getSolariumClientConfig();
	}

	protected function getCore() {
		return false; //defaults to main
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
		global $wgStagingEnvironment, $wgDevelEnvironment;
		if ( $wgStagingEnvironment || $wgDevelEnvironment ) {
			return preg_replace_callback( self::WIKIA_URL_REGEXP, array( $this, 'replaceHost' ), $url );
		}
		return $url;
	}

	protected function replaceHost( $details ) {
		return $details[ 1 ] . WikiFactory::getCurrentStagingHost( $details[ 4 ], $details[ 3 ] );
	}

	/**
	 * Apply excluded wiki IDs and HOSTs.
	 * @param $select \Solarium_Query_Select
	 * @return \Solarium_Query_Select
	 */
	protected function applyBlackListedWikisQuery( $select ) {
		$coreFieldNames = $this->getCoreFieldNames();

		if ( !empty( $this->blacklistedWikiHosts ) ) {
			$excluded = [];
			foreach ( $this->blacklistedWikiHosts as $ex ) {
				$excluded[] = "-({$coreFieldNames['wikiHost']}:{$ex})";
			}
			$select->createFilterQuery( 'excl' )->setQuery( implode( ' AND ', $excluded ) );
		}

		$blacklistQuery = $this->getBlacklistedWikiIdsQuery();
		if ( !empty( $blacklistQuery ) ) {
			$select->createFilterQuery( "widblacklist" )->setQuery( $blacklistQuery );
		}
		return $select;
	}

	protected function getBlacklistedWikiIdsQuery() {
		$coreFieldNames = $this->getCoreFieldNames();

		if ( !empty( $this->blacklistedWikiIds ) ) {
			$excluded = [ ];
			foreach ( $this->blacklistedWikiIds as $wikiId ) {
				$excluded[] = "-({$coreFieldNames['wikiId']}:{$wikiId})";
			}
			return implode( ' AND ', $excluded );
		} else {
			return null;
		}
	}
}

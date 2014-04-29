<?php

namespace Wikia\Search\Services;

use Wikia\Search\Query\Select;
use Wikia\Search\QueryService\Factory;
use WikiFactory;

class EntitySearchService {
	const WORDS_QUERY_LIMIT = 10;
	const WIKIA_URL_REGEXP = '~^(http(s?)://)(([^\.]+)\.wikia\.com)~';

	/** @var \Solarium_Client client */
	private $client;
	private $lang;
	private $quality;
	private $wikiId;

	public function __construct( $client = null ) {
		$config = $this->getConfig();
		$core = $this->getCore();
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

	protected function prepareQuery( $phrase ) {
		$select = $this->getSelect();

		return $select;
	}

	protected function consumeResponse( $response ) {
		return $response;
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

	protected function getConfig() {
		return (new Factory())->getSolariumClientConfig();
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
		return $field.'_'.$lang;
	}

	protected function replaceHostUrl( $url ) {
		global $wgStagingEnvironment, $wgDevelEnvironment;
		if ( $wgStagingEnvironment || $wgDevelEnvironment ) {
			return preg_replace_callback( self::WIKIA_URL_REGEXP, array( $this, 'replaceHost' ), $url );
		}
		return $url;
	}

	protected function replaceHost( $details ) {
		return $details[ 1 ] . WikiFactory::getCurrentStagingHost( $details[ 4 ], $details[ 3 ] );
	}
}
<?php

namespace Wikia\Search\Services;

use Wikia\Search\Query\Select;
use Wikia\Search\QueryService\Factory;

class EntitySearchService {
	const WORDS_QUERY_LIMIT = 10;

	/** @var \Solarium_Client client */
	private $client;
	private $lang;
	private $quality;
	private $wikiId;

	public function __construct() {
		$config = $this->getConfig();
		$core = $this->getCore();
		if ( $core ) {
			$config['adapteroptions']['core'] = $core;
		}
		$this->client = new \Solarium_Client( $config );
	}

	public function query( $phrase ) {
		$select = $this->prepareQuery( $phrase );

		$response = $this->select( $select );
		$result = $this->consumeResponse( $response );

		return $result;
	}

	public function prepareQuery( $phrase ) {
		$select = $this->getSelect();

		return $select;
	}

	public function consumeResponse( $response ) {
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
}
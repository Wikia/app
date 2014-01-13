<?php

require_once( dirname( __FILE__ ) . '/../../Maintenance.php' );

class ArticleQualityIndexer extends Maintenance {

	const ARRAY_SIZE = 100;
	const SOLR_URL = 'http://search-s11:8983/solr/update';

	private $wikiId;
	private $client;
	private $curlClient;
	private $service;
	private $CONFIG = [
			'adapteroptions' => [
				'host' => 'search-s11',
				'port' => 8983,
				'path' => '/solr/',
				'core' => 'main'
			]
	];
	/**
	 * Do the actual work. All child classes will need to implement this
	 */
	public function execute() {
		if ( !isset( $_ENV['SERVER_ID'] ) ) {
			die( 1 );
		}
		$this->wikiId = $_ENV['SERVER_ID'];

		$ids = $this->getIds();
		$batches = array_chunk( $ids, self::ARRAY_SIZE );
		foreach( $batches as $key => $batch ) {
			echo "\nPrepare data for ids: ";
			$data = $this->prepareData( $batch );
			echo "\nData prepared!\n";
			$this->setInSolr( $data );
			echo "Data stored!";
		}
	}

	//[{ "id" : "831_72005", "article_quality_i" : {"set":25}}]
	protected function prepareData( $ids ) {
		$result = [];
		$qs = $this->getArticleService();
		foreach( $ids as $id ) {
			echo $id." ";
			$qs->setArticleById( $id );
			$result[] = [
				'id' => $this->wikiId.'_'.$id,
				'article_quality_i' => [ 'set' => $qs->getArticleQuality() ]
			];
		}
		return $result;
	}

	protected function setInSolr( $data ) {
		//curl http://search-s11:8983/solr/update -H 'Content-type:application/json' -d '[{ "id" : "831_72005", "article_quality_i" : {"set":25}}]'
		$json = json_encode( $data );
		$this->execCurlWithData( $json );
	}

	protected function getIds() {
		$ids = [];
		//get ids from solr index
		$client = $this->getSolrConnection();
		$select = $client->createSelect();
		$select->setFields( [ 'pageid' ] );
		$select->setQuery( '+(wid:'.$this->wikiId.') AND +(ns:0)' );

		$select->setRows( 1000000 );

		$result = $client->select( $select );
		$docs = $result->getDocuments();
		foreach( $docs as $doc ) {
			$ids[] = $doc->pageid;
		}
		return $ids;
	}

	/**
	 * @return ArticleQualityV1Service
	 */
	protected function getArticleService() {
		if ( !isset( $this->service ) ) {
			$this->service = new ArticleQualityV1Service();
		}
		return $this->service;
	}

	protected function getCurlConnection() {
		if ( !isset( $this->curlClient ) ) {
			$this->curlClient = curl_init( self::SOLR_URL );
			curl_setopt( $this->curlClient, CURLOPT_HTTPHEADER, [ 'Content-type:application/json' ] );
		}
		return $this->curlClient;
	}

	protected function execCurlWithData( $json ) {
		curl_setopt($this->getCurlConnection(), CURLOPT_POSTFIELDS, $json);
		curl_exec( $this->curlClient );
		curl_close( $this->curlClient );
		//reset connection
		unset( $this->curlClient );
	}

	protected function getSolrConnection() {
		if ( !isset( $this->client ) ) {
			$this->client = new Solarium_Client( $this->CONFIG );
		}
		return $this->client;
	}
}

$maintClass = 'ArticleQualityIndexer';
require( RUN_MAINTENANCE_IF_MAIN );

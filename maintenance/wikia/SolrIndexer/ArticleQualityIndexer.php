<?php

require_once( dirname( __FILE__ ) . '/../../Maintenance.php' );

class ArticleQualityIndexer extends Maintenance {

	const ARRAY_SIZE = 1000;

	private $wikiId;
	private $domain;
	private $client;
	private $curlClient;
	private $solrDomain;
	private $CONFIG = [
		'adapter' => 'Solarium_Client_Adapter_Curl',
		'adapteroptions' => [
			'host' => 'search-s11',
			'port' => 8983,
			'path' => '/solr/',
			'core' => 'main'
		]
	];

	private $ips = [
		'10.12.68.119',
		'10.12.68.113',
		'10.12.66.117',
		'10.12.62.121',
		'10.12.60.109',
		'10.12.68.115',
		'10.12.66.120',
		'10.12.68.112',
		'10.12.60.111',
		'10.12.60.101',
		'10.12.64.118',
		'10.12.68.114',
		'10.12.62.103',
		'10.12.66.101',
		'10.12.62.120',
		'10.12.66.124',
		'10.12.64.117',
		'10.12.66.114',
		'10.12.60.100',
		'10.12.64.119',
		'10.12.64.121',
		'10.12.66.116',
		'10.12.62.122',
		'10.12.66.122',
		'10.12.64.101',
		'10.12.64.123',
		'10.12.60.103',
		'10.12.64.116',
		'10.12.62.101',
		'10.12.62.123'
	];
	/**
	 * Do the actual work. All child classes will need to implement this
	 */
	public function execute() {
		if ( !isset( $_ENV['SERVER_ID'] ) ) {
			die( 1 );
		}
		$this->wikiId = $_ENV['SERVER_ID'];
		$this->domain = WikiFactory::getDomains( $this->wikiId )[0];

		if ( empty( $this->domain ) ) {
			die;
		}

		$ids = $this->getIds();
		$this->domain = ( isset( $this->solrDomain ) ) ? $this->solrDomain : $this->domain ;
		$batches = array_chunk( $ids, self::ARRAY_SIZE );
		$b = count( $batches );
		foreach( $batches as $key => $batch ) {
			echo "\nPrepare data for batch: $key out of $b\n";
			$data = $this->prepareData( $batch, $key + 1, $b );
			echo "\nData prepared!\n";
			$this->setInSolr( $data );
			echo "Data stored!";
		}
	}

	//[{ "id" : "831_72005", "article_quality_i" : {"set":25}}]
	protected function prepareData( $ids, $batch = 0, $total = 0 ) {
		$result = [];
		foreach( $ids as $key => $id ) {
			$start = microtime( true );
			$res = $this->getArticleQuality( $id );
			if ( isset( $res->exception ) || empty( $res ) ) {
				//if exception returned check production url
				$res = $this->getArticleQuality( $id, true );
			}
			echo '[' . $this->wikiId . ']' . $batch . " out of " . $total . " current: " . $key . " " . ( microtime( true ) - $start );
			if ( isset( $res->contents[0]->article_quality_i ) ) {
				$result[] = $res->contents[0];
			}
			echo "\n";
		}
		return $result;
	}

	protected function getArticleQuality( $id, $prod = false ) {
		$url = $this->getIP( $prod ) . '/wikia.php?controller=WikiaSearchIndexer&method=get&service=ArticleQuality&ids=' . $id;
              echo $this->domain . " :" . $url." ";
		$ch = curl_init( $url );
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
			'Host: '.$this->domain
		));
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		$res = curl_exec( $ch );
              echo $res."\n";
		curl_close( $ch );
		return json_decode( $res );
	}

	protected function getIP( $prod ) {
		return $prod ? $this->domain : $this->ips[rand(0,count($this->ips)-1)];
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
		$select->setFields( [ 'pageid', 'host' ] );
		$select->setQuery( '+(wid:'.$this->wikiId.') AND +(ns:0) AND -(article_quality_i:[0 TO *]) AND +(words:[10 TO *])' );

		$select->setRows( 1000000 );

		$result = $client->select( $select );
		$docs = $result->getDocuments();
		foreach( $docs as $doc ) {
			$ids[] = $doc->pageid;
			if ( !isset( $this->solrDomain ) ) {
				$this->solrDomain = $doc->host;
			}
		}
		return $ids;
	}


	protected function getCurlConnection() {
		if ( !isset( $this->curlClient ) ) {
			$this->curlClient = curl_init( $this->getMasterSolrUrl() );
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

	protected function getMasterSolrUrl() {
		return 'http://search-s11:8983/solr/update';
//              global $wgSolrMaster;
//              if ( isset( $wgSolrMaster ) ) {
//                      $url = 'http://' . $wgSolrMaster . ':8983/solr/update';
//                      return $url;
//              }
//              die(1);
	}
}

$maintClass = 'ArticleQualityIndexer';
require( RUN_MAINTENANCE_IF_MAIN );

<?php
/**
 * Created by adam
 * Date: 08.11.13
 */

require_once( dirname( __FILE__ ) . '/../../Maintenance.php' );
require_once( dirname( __FILE__ ) . '/../../../extensions/wikia/SolrHelper/SolrHelper.setup.php' );

class SuggestionsIndexer extends Maintenance {

	const SOLR_MAIN = 'main';
	const SOLR_SUGGEST = 'suggest';
	const SNIPPET_LENGTH = 100;
	const BATCH_SIZE = 500;

	protected $wikiId;
	protected $solrHelper;
	protected $profileNamedData = [];
	protected $profileData = [];
	protected $config = [
		self::SOLR_MAIN => [
			[
				'adapteroptions' => [
					'host' => 'search-s10',
					'port' => 8983,
					'path' => '/solr/',
					'core' => 'main'
				]
			],
			'wid',
			'pageid'
		],
		self::SOLR_SUGGEST => [
			[
				'adapteroptions' => [
					'host' => 'db-sds-s1',
					'port' => 8983,
					'path' => '/solr/',
					'core' => 'suggest'
				],
				'adapter' => 'Solarium_Client_Adapter_Curl'
			],
			'wikiId_i',
			'pageId_i'
		]
	];
	protected $solrFields = [
		'redirect_titles_mv_en',
		'title_en',
		'views',
		'html_en',
		'backlinks',
		'url',
		'pageid',
		'ns'
	];

	public function __construct() {
		parent::__construct();
		$this->addOption( 'range', 'Index articles in the given id range.', false, false, 'r' );
		$this->addOption( 'delete', 'Delete articles instead of index.', false, false, 'd' );
		$this->addOption( 'output', 'Change output server config with given value. Expected format: <host>:<port>/<path>/.../<core>', false, true, 'o' );
		$this->addOption( 'profile', 'Show execution times.', false, false, 'p' );
	}

	public function execute() {
		$this->startProfile( __METHOD__ );
		if ( $this->hasOption( 'output' ) ) {
			$values = parse_url( $this->getOption( 'output' ) );
			$pos = strrpos( $values[ 'path' ], '/' );
			$path = substr( $values[ 'path' ], 0, $pos + 1 );
			$core = substr( $values[ 'path' ], $pos + 1 );
			if ( !empty( $values[ 'host' ] ) && !empty( $values[ 'port' ] ) && $core !== false && $path && $core ) {
				$this->config[ self::SOLR_SUGGEST ][ 0 ][ 'adapteroptions' ] = [
					'host' => $values[ 'host' ],
					'port' => $values[ 'port' ],
					'path' => $path,
					'core' => $core
				];
			} else {
				$this->maybeHelp( true );
			}
		}
//		we need to get info from db if all wiki or range option, set up connection
		if ( empty( $this->mArgs ) || $this->hasOption( 'range' ) ) {
			$this->setDBConnection();
		}

		//set wikiId
		if ( !isset( $_ENV['SERVER_ID'] ) ) {
			die( 1 );
		}
		$this->wikiId = $_ENV['SERVER_ID'];

		if ( $this->hasOption( 'delete' ) ) {
			$ids = $this->getRanges();
			$this->deleteData( $ids );
			echo "Delete complete.\n";
			return;
		}

		$idsList = $this->getIDs();
		//do batches
		$batches = array_chunk( $idsList, self::BATCH_SIZE );

		//main loop
		foreach( $batches as $key => $batch ) {
			$this->profileData = [];
			$dataBatch = $this->getDataForBatch( $batch );
			$this->profileNamedData[ 'solrData' ][ $key ] = $this->profileData;

			$this->profileData = [];
			if( $this->pushData( $dataBatch ) ) {
				echo implode( ',', $batch )." ids updated correctly!\n";
			} else {
				echo implode( ',', $batch )." failed!\n";
			}
			$this->profileNamedData[ 'update' ][ $key ] = $this->profileData;
			$this->profileData = [];
		}
		echo "Update complete. Updated ".count( $idsList )." documents.\n";
		$this->endProfile( __METHOD__ );

		if ( $this->hasOption( 'profile' ) ) {
			echo "\n";
			print_r( $this->profileNamedData );
			echo "\n";
		}
	}

	protected function startProfile( $name = null ) {
		if ( $name !== null ) {
			$this->profileNamedData[ $name ] = microtime( true );
		} else {
			array_push( $this->profileData, microtime( true ) );
		}
	}

	protected function endProfile( $name = null ) {
		if ( $name !== null ) {
			$this->profileNamedData[ $name ] = microtime( true ) - $this->profileNamedData[ $name ];
			return $this->profileNamedData[ $name ];
		} else {
			$val = microtime( true ) - array_pop( $this->profileData );
			array_unshift( $this->profileData, $val );
			return $val;
		}
	}

	protected function getRanges() {
		if ( !empty( $this->mArgs ) ) {
			if ( $this->hasOption( 'range' ) ) {
				//get ids from given range
				return [ 'min' => min( $this->mArgs ), 'max' => max( $this->mArgs ) ];
			}
			//get only given ids
			return $this->mArgs;
		} else {
			//get all the ids range
			return [ 'min' => 0, 'max' => $this->getMaxIDFromDB() ];
		}
	}

	protected function deleteData( $ids ) {
		$this->startProfile( __METHOD__ );
		$client = $this->getSolrClient( self::SOLR_SUGGEST );
		if ( isset( $ids[ 'min' ] ) && isset( $ids[ 'max' ] ) ) {
			$client->deleteDocuments( $this->wikiId, $ids[ 'min' ], $ids[ 'max' ] );
		} else {
			$client->deleteDocuments( $this->wikiId, $ids );
		}
		$this->endProfile( __METHOD__ );
	}

	protected function pushData( $data ) {
		$this->startProfile();
		if ( empty( $data ) ) { return false; }
		$client = $this->getSolrClient( self::SOLR_SUGGEST );
		//remove old version, so if article was deleted it wont be indexed anymore
		$client->deleteDocuments( $this->wikiId, array_keys( $data ) );
		$status = $client->updateDocuments( $data );
		$this->endProfile();
		if ( $status === 0 ) {
			return true;
		}
		return false;
	}

	protected function getDataForBatch( $batch ) {
		//try solr
		$data = $this->getFromSolr( $batch );
		//get images and add to data
		$images = $this->getImages( $batch );
		foreach( $images as $id => $url ) {
			$data[ $id ][ 'thumbnail_url' ] = $url;
		}

		return $data;
	}

	protected function getFromSolr( $batch ) {
		$this->startProfile();
		$client = $this->getSolrClient( self::SOLR_MAIN );
		$solrData = $client->getByArticleId( $this->wikiId, $batch, $this->solrFields, $count );
		echo $count." found!\n";
		//acquire needed data
		$result = [];
		foreach( $solrData as $data ) {
			$id = $data['pageid'];
			$result[ $id ] = [
				'title_ngram' => $data[ 'title_en' ],
				'title_simple' => $data[ 'title_en' ],
				'title' => $data[ 'title_en' ],
				'title_prefix_suffix' => $data[ 'title_en' ],
				'views_i' => $data[ 'views' ],
				'abstract_en' => $this->cutSnippet( $data[ 'html_en' ] ),
				'namespace_i' => $data[ 'ns' ],
				'backlinks_i' => $data[ 'backlinks' ],
				'pageUrl_url' => parse_url( $data[ 'url' ], PHP_URL_PATH ),
				'pageId_i' => $data[ 'pageid' ],
				'wikiId_i' => $this->wikiId,
				'id' => $this->wikiId.'_'.$data[ 'pageid' ]
			];
			if ( !empty( $data[ 'redirect_titles_mv_en' ] ) ) {
				$result[ $id ]['redirects_ngram_mv'] = array_unique( $data[ 'redirect_titles_mv_en' ] );
			}
		}
		$this->endProfile();
		return $result;
	}

	protected function getImages( $batch ) {
		$is = $this->getImageServing( $batch );
		$images = $is->getImages(1);
		$result = [];
		foreach ( $images as $id => $im ) {
			if ( !empty(  $im[0]['url'] ) ) {
				$result[ $id ] = $im[0]['url'];
			}
		}
		return $result;
	}

	protected function cutSnippet( $text ) {
		if ( strlen( $text ) <= self::SNIPPET_LENGTH ) {
			return $text;
		}
		$words = explode( ' ', $text );
		$i = 0;
		$res = '';
		while( strlen( $res.' '.$words[$i] ) < self::SNIPPET_LENGTH ) {
			if ( $res === '' ) {
				$res = $words[ $i ];
			}
			$res .= ' '.$words[ $i ];
			$i++;
		}
		return $res.'...';
	}

	protected function getImageServing( $ids ) {
		return new ImageServing( $ids, 50, 50 );
	}

	/**
	 * @param $name
	 * @return \Wikia\SolrHelper\SolrHelper
	 */
	protected function getSolrClient( $name ) {
		if ( !isset( $this->solrHelper[ $name ] ) ) {
			list( $config, $wikiVar, $idVar ) = $this->config[ $name ];
			$this->solrHelper[ $name ] = new \Wikia\SolrHelper\SolrHelper( $config, $wikiVar, $idVar );
		}
		return $this->solrHelper[ $name ];
	}

	protected function getIDs() {
		if ( !empty( $this->mArgs ) ) {
			if ( $this->hasOption( 'range' ) ) {
				//get ids from given range
				return $this->getIDsRangeFromDB( min( $this->mArgs ), max( $this->mArgs ) );
			}
			//get only given ids
			return $this->mArgs;
		} else {
			//get all the ids
			return $this->getIDsFromDB();
		}
	}

	protected function setDBConnection() {
		$this->setDB( $this->getDB( DB_SLAVE ) );
	}

	protected function getIDsRangeFromDB( $low, $up ) {
		$this->startProfile( __METHOD__ );
		$dbr = $this->getDB( DB_SLAVE );
		//build query
		$res = $dbr->select(
			[ 'page' ],
			[ 'page_id' ],
			[ 'page_id >= '.$low, 'page_id <= '.$up, 'page_namespace = 0', 'page_is_redirect = 0' ],
			'SuggestionsIndexer::GetPageIDs'
		);
		$result = [];
		while( $row = $res->fetchRow() ) {
			$result[] = $row[ 'page_id' ];
		}
		$this->endProfile( __METHOD__ );
		return $result;
	}

	protected function getIDsFromDB() {
		$this->startProfile( __METHOD__ );
		$dbr = $this->getDB( DB_SLAVE );
		//build query
		$res = $dbr->select(
			[ 'page' ],
			[ 'page_id' ],
			[ 'page_namespace = 0', 'page_is_redirect = 0' ],
			'SuggestionsIndexer::GetAllPageIDs'
		);
		$result = [];
		while( $row = $res->fetchRow() ) {
			$result[] = $row[ 'page_id' ];
		}
		$this->endProfile( __METHOD__ );
		return $result;
	}

	protected function getMaxIDFromDB() {
		$this->startProfile( __METHOD__ );
		$dbr = $this->getDB( DB_SLAVE );
		//build query
		$res = $dbr->select(
			[ 'page' ],
			[ 'max(page_id)' ],
			'',
			'SuggestionsIndexer::GetMaxID'
		);
		$result = 0;
		while( $row = $res->fetchRow() ) {
			$result = $row[ 0 ];
		}
		$this->endProfile( __METHOD__ );
		return $result;
	}
}

$maintClass = 'SuggestionsIndexer';
require( RUN_MAINTENANCE_IF_MAIN );
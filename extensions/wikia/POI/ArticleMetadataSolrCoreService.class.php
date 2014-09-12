<?php
use Wikia\Search\QueryService\Factory;

class ArticleMetadataSolrCoreService {

	const CORE_NAME = 'article_metadata';

	const QUEST_ID = "quest_id_s";
	const ABILITY_ID = "ability_id_s";
	const FINGERPRINTS = "fingerprint_ids_mv_s";
	const MAP_REGION = "map_region_s";
	const ID = "id";
	const WID = "wid_i";

	/** @var \Solarium_Client client */
	protected $client = null;

	protected $allowed_fields = [
		self::QUEST_ID,
		self::ABILITY_ID,
		self::FINGERPRINTS,
		self::MAP_REGION,
		self::ID,
		self::WID
	];

	protected $solr_mapping = [
		ArticleMetadataModel::QUEST_ID => self::QUEST_ID,
		ArticleMetadataModel::ABILITY_ID => self::ABILITY_ID,
		ArticleMetadataModel::FINGERPRINTS => self::FINGERPRINTS,
		ArticleMetadataModel::MAP_REGION => self::MAP_REGION
	];

	protected function getConfig() {
		$config = ( new Factory() )->getSolariumClientConfig( true );
		$config[ 'adapteroptions' ][ 'core' ] = self::CORE_NAME;
		return $config;
	}

	protected function getCommitUrl() {
		$config = $this->getConfig();
		$url = "http://" . $config['adapteroptions']['host'];
		if ( !empty( $config['adapteroptions']['port'] ) ) {
			$url .= ":".$config['adapteroptions']['port'];
		}
		$url .= $config['adapteroptions']['path'];
		$url .= $config['adapteroptions']['core'];
		$url .= "/update?commit=true";
		return $url;
	}

	protected function prepareJsonDoc( $data ) {
		$output = [];
		foreach ( $data as $key => $val ) {
			if ( $key == 'id' ) {
				$output[$key] = $val;
			} else {
				$output[$key] = ['set'=>$val];
			}
		}
		return json_encode([$output]);
	}

	protected function sendData( $jsonFormattedData ) {
		/*
		 * We can't use Solarium Client for that.
		 * It doesn't support "updating" (only "replacing" allowed)
		 * @see: http://wiki.solarium-project.org/index.php/V2:Update_query
		 */
		$options = [];
		$options['headers'] = ['Content-type'=>'application/json'];
		$options['postData'] = $jsonFormattedData;
		$options['returnInstance'] = true;
		//TODO: temporary, as we need to wait for search-master proxy
		$options['noProxy'] = true; // we need to omit proxy in order to reach search-master
		$response = Http::request( "POST", $this->getCommitUrl(), $options );

		return $response;
	}

	protected function getClient() {
		$this->client = ( $this->client !== null ) ? $this->client : new \Solarium_Client(  $this->getConfig() );
		return $this->client;
	}

	public function convertToSolrFieldNames( $data, $ignoreErrors = false ) {
		$output = [];
		foreach ( $data as $key => $val ) {
			if ( in_array( $key, $this->allowed_fields ) ) {
				$output[ $key ] = $val;
			} else if ( isset( $this->solr_mapping[ $key ] ) ) {
				$output[ $this->solr_mapping[ $key ] ] = $val;
			} else if ( !$ignoreErrors ) {
				throw new NotValidPOIMetadataFieldException($key);
			}
		}
		return $output;
	}

	public function save( $data ) {
		$solrFormattedData = $this->convertToSolrFieldNames( $data );
		$json = $this->prepareJsonDoc( $solrFormattedData );
		return $this->sendData( $json );
	}
}
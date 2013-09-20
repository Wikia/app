<?php
/**
 * @author ADi
 * @author Jacek Jursza
 */
class StructuredDataAPIClient extends WikiaObject {
	const VOCABS_PATH = 'vocabs';
	const TEMPLATE_CACHE_TTL = 180;

	protected $baseUrl = null;
	protected $apiPath = null;
	protected $schemaPath = null;

	public function __construct( $baseUrl, $apiPath, $schemaPath ) {
		$this->baseUrl = $baseUrl;
		$this->apiPath = $apiPath;
		$this->schemaPath = $schemaPath;

		parent::__construct();
	}

	private $logfile = FALSE;

	/**
	 * Make sure the log file is open. Return true when logging is enabled
	 * @return bool
	 */
	private function initLog() {
		if ( $this->wg->StructuredDataConfig['debug'] ) {
			if ( !$this->logfile ) {
				$tempDir = wfTempDir();
				$this->logfile = fopen( $tempDir.'/structured_data.log', 'a+' );
			}
			return true;
		}
		return false;
	}

	/**
	 * Logs a single string - only when the log file is open
	 */
	private function log($text) {
		if ( $this->logfile ) {
			fwrite($this->logfile, date("Y-m-d H:i:s") . ': ' . $text . "\n");
			fflush($this->logfile);
		}
	}

	/**
	 * Closes the log file if it's open
	 */
	private function closeLog() {
		if ( $this->logfile ) {
			try { fclose($this->logfile); } catch(Exception $e) {};
			$this->logfile = FALSE;
		}
	}

	/**
	 * Call the specified url and return the answer
	 * @param bool $nocache - when set to true, try to bypass the caching layer
	 * @throws Exception
	 */
	protected function call( $url, $nocache = true, $method = null, $body = null ) {
		$httpRequest = new HTTP_Request();
		$httpRequest->setURL( $url );

		if ($this->initLog()) {
			$this->log('====================================');
			$m = array(HTTP_REQUEST_METHOD_DELETE => 'DELeting', HTTP_REQUEST_METHOD_POST => 'POSTing', HTTP_REQUEST_METHOD_PUT=>'PUTting');
			$m = array_key_exists($method, $m) ? $m[$method] : 'GETting';
			$b = $body ? ' with body ' . $body : '';
			$this->log($m . ' ' . $url . $b);
		}

		if ( $method ) $httpRequest->setMethod( $method );
		if ( $body ) $httpRequest->setBody( $body );
		if ( $nocache ) {
			$httpRequest->addHeader('Cache-Control', 'no-cache');
			$httpRequest->addHeader('If-Modified-Since', 'Sat, 29 Oct 1994 19:43:31 GMT'); // probably not needed
		}
		$httpRequest->addHeader( 'Accept', 'application/ld+json' );
		$httpRequest->sendRequest();

		try {
			$response = $httpRequest->getResponseBody();
			$this->log( 'Headers are ' . json_encode( $httpRequest->getResponseHeader() ) );
			$this->log( 'Response (' . $httpRequest->getResponseCode() .') is ' . $response);
			$decodedResponse = json_decode ( $response );
		} catch (Exception $e) {
			$this->log('Error: ' . $e);
			$this->closeLog();
			throw $e;
		}
		$this->closeLog();
		if ( empty($decodedResponse) && in_array( $httpRequest->getResponseCode(), array( 500, 501 ) ) ) {
			return '{"error":"Internal Server Error","message":""}';
		}
		return $response;
	}

	private function getApiPath() {
		return $this->baseUrl . $this->apiPath . $this->schemaPath . '/';
	}

	private function getVocabsPath() {
		return $this->baseUrl . $this->apiPath . self::VOCABS_PATH . '/';
	}

	private function isValidResponse($response) {
		if(!isset($response->error)) {
			return $response;
		}
		else {
			throw new WikiaException('SD API Error: ' . $response->error . ( !empty($response->message) ? ( ' - ' . $response->message ) : '' ) );
		}
	}

	/**
	 * Make a call to SDS to remove an object
	 * @param $id - sds objectd identifier
	 * @return SDS response in JSON format
	 */
	public function deleteObject( $id ) {
		$response = json_decode( $this->call( $this->getApiPath() . $id, true, HTTP_REQUEST_METHOD_DELETE ) );
		return $response;
	}

	public function saveObject( $id, $body ) {
		$response = json_decode( $this->call( $this->getApiPath() . $id, true, HTTP_REQUEST_METHOD_PUT, $body ) );
		return $response;
	}

	public function createObject( $body ) {
		$response = json_decode( $this->call( rtrim( $this->getApiPath(), '/' ), true, HTTP_REQUEST_METHOD_POST, $body ) );
		return $response;
	}

	public function getObject( $id ) {
		$response = json_decode( $this->call( $this->getApiPath() . $id ) );
		return $this->isValidResponse($response);
	}

	public function getObjectByURL( $url ) {
		$response = json_decode( $this->call( rtrim( $this->getApiPath(), '/' ) . '?schema_url=' . urlencode($url) ) );

		if(isset($response->{"@graph"})) {
			$object = array_shift( $response->{"@graph"} );
			if( !empty($object)) {
				return $object;
			}
		}
		throw new WikiaException('SD API Error: ' . $url . ' object not found');
	}

	public function getObjectByTypeAndName($type, $name) {
		$url = rtrim( $this->getApiPath(), '/' ) . '?withType=' . urlencode($type) . '&withProperty='.urlencode('schema:name').'&withValue=' .urlencode($name).'&cache=false';
		$response = json_decode( $this->call( $url ) );
		if(isset($response->{"@graph"})) {
			$object = array_shift( $response->{"@graph"} );
			if( !empty($object)) {
				return $object;
			}
		}
		throw new WikiaException('SD API Error: ' . $url . ' object not found');
	}

	public function getCollection( $type, $extraFields=array() ) {
		$rawResponse = $this->call( rtrim( $this->getApiPath(), '/' ) . '?withType=' . urlencode($type) . '&cache=false' );
		$response = json_decode( $rawResponse );
		$response = $this->isValidResponse($response);

		$collection = array();
		$i = 0;
		foreach ( $response->{"@graph"} as $obj ) {

			$collection[ $i ] = array(
						"id" => $obj->id,
						"url" => ( isset($obj->{"schema:url"}) ? $obj->{"schema:url"} : null ),
						"name" => ( isset($obj->{"schema:name"}) ? $obj->{"schema:name"} : null ),
						"type" => $obj->type
			);

			foreach ( $extraFields as $field ) {
				$collection[ $i ][ $field ] = isset( $obj->$field ) ?  $obj->$field : null;
			}
			$i++;
		}

		return $collection;
	}

	public function getTemplate( $objectType, $asJson = false ) {
		$templateUrl = $this->getVocabsPath() . str_replace(':', '/', $objectType) . '?template=true';
		$templateCacheKey = wfSharedMemcKey( __METHOD__, $templateUrl );

		$rawResponse = $this->wg->Memc->get( $templateCacheKey );
		if( empty( $rawResponse ) ) {
			$rawResponse = $this->call( $templateUrl, false );
			$response = json_decode( $rawResponse );
			if($this->isValidResponse($response)) {
				// cache only valid responses
				$this->wg->Memc->set( $templateCacheKey, $rawResponse, self::TEMPLATE_CACHE_TTL );
			}

		}
		else {
			$response = json_decode( $rawResponse );
		}

		return $asJson ? $rawResponse : $response;
	}

	public function getContext( $contextUrl, $relative = true ) {
		// @todo: fix when Gregg fixes template context url (right now it's a non-existing /contexts/cod.jsonld
		$contextUrl = str_replace('cod.jsonld', 'callofduty.jsonld', $contextUrl);
		$contextUrl = str_replace('schema.jsonld', 'callofduty.jsonld', $contextUrl);

		$response = json_decode( $this->call( ( $relative ? $this->baseUrl : '' ) . $contextUrl, false ) );
		return $this->isValidResponse($response);
	}

	public function getObjectDescription( $objectType, $asJson = false ) {
		$rawResponse = $this->call( $this->getVocabsPath() . str_replace(':', '/', $objectType), false );
		$response = json_decode( $rawResponse );

		return $asJson ? $rawResponse : $this->isValidResponse($response);
	}
}

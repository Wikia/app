<?php
/**
 * @author ADi
 * @author Jacek Jursza
 */
class StructuredDataAPIClient extends WikiaObject {
	const VOCABS_PATH = 'vocabs';
	const TEMPLATE_CACHE_TTL = 180;

	private $httpRequest = null;
	protected $baseUrl = null;
	protected $apiPath = null;
	protected $schemaPath = null;

	public function __construct( $baseUrl, $apiPath, $schemaPath ) {
		$this->baseUrl = $baseUrl;
		$this->apiPath = $apiPath;
		$this->schemaPath = $schemaPath;

		$this->httpRequest = new HTTP_Request();
		parent::__construct();
	}

	protected function call( $url, $method = null, $body = null ) {
		$this->httpRequest->setURL( $url );

		if ( $method ) $this->httpRequest->setMethod( $method );
		if ( $body ) $this->httpRequest->setBody( $body );

		$this->httpRequest->addHeader( 'Accept', 'application/ld+json' );
		$this->httpRequest->sendRequest();

		$decodedResponse = json_decode ( $this->httpRequest->getResponseBody() );
		if ( empty($decodedResponse) && in_array( $this->httpRequest->getResponseCode(), array( 500, 501 ) ) ) {
			return '{"error":"Internal Server Error","message":""}';
		}
		else {
			return $this->httpRequest->getResponseBody();
		}
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
		$response = json_decode( $this->call( $this->getApiPath() . $id, HTTP_REQUEST_METHOD_DELETE ) );
		return $response;
	}

	public function saveObject( $id, $body ) {
		$response = json_decode( $this->call( $this->getApiPath() . $id, HTTP_REQUEST_METHOD_PUT, $body ) );
		return $response;
	}

	public function createObject( $body ) {
		$response = json_decode( $this->call( rtrim( $this->getApiPath(), '/' ), HTTP_REQUEST_METHOD_POST, $body ) );
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
		$url = rtrim( $this->getApiPath(), '/' ) . '?withType=' . urlencode($type) . '&withProperty='.urlencode('schema:name').'&withValue=' .urlencode($name).'&cache=false&cb=' . time();
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
		$rawResponse = $this->call( rtrim( $this->getApiPath(), '/' ) . '?withType=' . urlencode($type) );
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
		$templateCacheKey = $this->wf->SharedMemcKey( __METHOD__, $templateUrl );

		$rawResponse = $this->wg->Memc->get( $templateCacheKey );
		if( empty( $rawResponse ) ) {
			$rawResponse = $this->call( $templateUrl );
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

		$response = json_decode( $this->call( ( $relative ? $this->baseUrl : '' ) . $contextUrl ) );
		return $this->isValidResponse($response);
	}

	public function getObjectDescription( $objectType, $asJson = false ) {
		$rawResponse = $this->call( $this->getVocabsPath() . str_replace(':', '/', $objectType) );
		$response = json_decode( $rawResponse );

		return $asJson ? $rawResponse : $this->isValidResponse($response);
	}
}

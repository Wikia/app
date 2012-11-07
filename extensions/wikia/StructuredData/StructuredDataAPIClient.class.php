<?php
/**
 * @author ADi
 * @author Jacek Jursza
 */
class StructuredDataAPIClient {
	const VOCABS_PATH = 'vocabs';

	private $httpRequest = null;
	protected $baseUrl = null;
	protected $apiPath = null;
	protected $schemaPath = null;

	public function __construct( $baseUrl, $apiPath, $schemaPath ) {
		$this->baseUrl = $baseUrl;
		$this->apiPath = $apiPath;
		$this->schemaPath = $schemaPath;

		$this->httpRequest = new HTTP_Request();
	}

	protected function call( $url, $method = null, $body = null ) {
		$this->httpRequest->setURL( $url );

		if ( $method ) $this->httpRequest->setMethod( $method );
		if ( $body ) $this->httpRequest->setBody( $body );

		$this->httpRequest->addHeader( 'Accept', 'application/ld+json' );
		$this->httpRequest->sendRequest();
		return $this->httpRequest->getResponseBody();
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
			throw new WikiaException('SD API Error: ' . $response->error . ' - ' . $response->message);
		}
	}

	public function saveObject( $id, $body ) {
		$response = json_decode( $this->call( $this->getApiPath() . $id, HTTP_REQUEST_METHOD_PUT, $body ) );
		return $this->isValidResponse($response);
	}

	public function createObject( $body ) {
		$response = json_decode( $this->call( rtrim( $this->getApiPath(), '/' ), HTTP_REQUEST_METHOD_POST, $body ) );
		return $this->isValidResponse($response);
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
		$url = rtrim( $this->getApiPath(), '/' ) . '?withType=' . urlencode($type) . '&withProperty='.urlencode('schema:name').'&withValue=' .urlencode($name);
		$response = json_decode( $this->call( $url ) );

		if(isset($response->{"@graph"})) {
			$object = array_shift( $response->{"@graph"} );
			if( !empty($object)) {
				return $object;
			}
		}
		throw new WikiaException('SD API Error: ' . $url . ' object not found');
	}

	public function getCollection( $type ) {
		$rawResponse = $this->call( rtrim( $this->getApiPath(), '/' ) . '?withType=' . urlencode($type) );
		$response = json_decode( $rawResponse );
		$collection = array();
		foreach ( $response->{"@graph"} as $obj ) {

			$collection[] = array(
						"id" => $obj->id,
						"url" => ( isset($obj->{"schema:url"}) ? $obj->{"schema:url"} : null ),
						"name" => $obj->{"schema:name"},
						"type" => $obj->type
			);
		}

		return $collection;
	}

	public function getTemplate( $objectType, $asJson = false ) {
		$rawResponse = $this->call(  $this->getVocabsPath() . str_replace(':', '/', $objectType) . '?template=true' );
		$response = json_decode( $rawResponse );

		return $asJson ? $rawResponse : $this->isValidResponse($response);
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

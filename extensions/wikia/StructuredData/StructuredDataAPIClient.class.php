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

	protected function call( $url ) {
		$this->httpRequest->setURL( $url );

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

	public function getObject( $id ) {
		$response = json_decode( $this->call( $this->getApiPath() . $id ) );
		return $this->isValidResponse($response);
	}

	public function getCollection( $type ) {
		$rawResponse = $this->call( rtrim( $this->getApiPath(), '/' ) . '?withType=' . urlencode($type) );
		$response = json_decode( $rawResponse );
		$collection = array();
		foreach ( $response->{"@graph"} as $obj ) {

			$collection[] = array(  "id" => $obj->id,
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
		$response = json_decode( $this->call( ( $relative ? $this->baseUrl : '' ) . $contextUrl ) );
		return $this->isValidResponse($response);
	}

	public function getObjectDescription( $objectType, $asJson = false ) {
		$rawResponse = $this->call( $this->getVocabsPath() . str_replace(':', '/', $objectType) );
		$response = json_decode( $rawResponse );

		return $asJson ? $rawResponse : $this->isValidResponse($response);
	}
}

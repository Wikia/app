<?php
/**
 * @author ADi
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

	public function getObject( $id ) {
		return $this->call( $this->getApiPath() . $id );
	}

	public function getCollection() {

	}

	public function getTemplate( $objectType ) {
		return $this->call(  $this->getVocabsPath() . str_replace(':', '/', $objectType) . '?template=true' );
	}

	public function getContext( $contextUrl, $relative = true ) {
		return $this->call( ( $relative ? $this->baseUrl : '' ) . $contextUrl );
	}
}

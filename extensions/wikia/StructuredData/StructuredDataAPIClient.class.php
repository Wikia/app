<?php
/**
 * @author ADi
 */
class StructuredDataAPIClient {

	private $httpRequest = null;
	protected $schemaName = null;
	protected $endpointUrl = null;

	public function __construct( $endpointUrl, $schemaName ) {
		$this->endpointUrl = $endpointUrl;
		$this->schemaName = $schemaName;

		$this->httpRequest = new HTTP_Request();
	}


	protected function call( $urlArgs ) {
		$this->httpRequest->setURL( $this->endpointUrl . $this->schemaName . '/' . $urlArgs );

		$this->httpRequest->addHeader( 'Accept', 'application/json');
		$this->httpRequest->sendRequest();

		return $this->httpRequest->getResponseBody();
	}

	public function getObject( $id ) {
		return $this->call( $id );
	}

	public function getCollection() {

	}


}

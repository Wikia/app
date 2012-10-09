<?php
/**
 * @author ADi
 */
class StructuredDataAPIClient {
	const VOCABS_PATH = 'vocabs';

	private $httpRequest = null;
	protected $schemaName = null;
	protected $endpointUrl = null;

	public function __construct( $endpointUrl, $schemaName ) {
		$this->endpointUrl = $endpointUrl;
		$this->schemaName = $schemaName;

		$this->httpRequest = new HTTP_Request();
	}

	protected function call( $urlArgs, $vocabs = false ) {
		//var_dump( $this->endpointUrl . ( $vocabs ? self::VOCABS_PATH : $this->schemaName ) . '/' . $urlArgs );
		$this->httpRequest->setURL( $this->endpointUrl . ( $vocabs ? self::VOCABS_PATH : $this->schemaName ) . '/' . $urlArgs );

		$this->httpRequest->addHeader( 'Accept', 'application/ld+json' );
		$this->httpRequest->sendRequest();

		return $this->httpRequest->getResponseBody();
	}

	public function getObject( $id ) {
		return $this->call( $id );
	}

	public function getCollection() {

	}

	public function getTemplate( $objectType ) {
		$rawJson = $this->call(  str_replace(':', '/', $objectType) . '?template=true', true );
		return $rawJson;
	}

}

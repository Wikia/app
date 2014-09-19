<?php

namespace Wikia\Search\Test\Services;

use Wikia\Search\Test\BaseTest;

abstract class SearchServiceBaseTest extends BaseTest {

	/**
	 * Return solarium mock
	 * @param Solarium_Query_Select $useRequest request object
	 * @param string $useResponse solr response
	 * @return \PHPUnit_Framework_MockObject_MockObject solarium mock
	 */
	public function useSolariumMock( $useRequest = null, $useResponse = null ) {
		$useRequest = ( $useRequest == null ) ? $this->getMockRequest() : $useRequest;
		$useResponse = ( $useResponse == null ) ? $this->getMockResponse() : $useResponse;
		$solariumMock = $this->getSolariumMock();
		$solariumMock->expects( $this->any() )
			->method( 'select' )
			->with( $useRequest )
			->will( $this->returnValue( $this->getResultMock( $useResponse ) ) );

		return $solariumMock;
	}

	/**
	 * Sets solr response body
	 * @return string Solr response body
	 */
	protected abstract function getMockResponse();

	/**
	 * Checks solarium request
	 * @return mixed
	 */
	protected function getMockRequest() {}

	protected function getSolariumMock() {
		$client = new \Solarium_Client();
		$mock = $this->getMockBuilder( '\Solarium_Client' )
			->getMock();

		$mock->expects( $this->any() )
			->method( 'createSelect' )
			->will( $this->returnValue( $client->createSelect() ) );

		return $mock;
	}

	protected function getResultMock( $responseBody ) {
		$client = new \Solarium_Client();
		$mock = new \Solarium_Result_Select(
			$client,
			$client->createSelect(),
			$this->getSolariumMainResponse( $responseBody )
		);

		return $mock;
	}

	protected function getSolariumMainResponse( $responseBody ) {
		//empty solr response
		$mock = new \Solarium_Client_Response(
			$responseBody,
			[ 'HTTP/1.1 200 OK' ]
		);
		return $mock;
	}
}
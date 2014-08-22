<?php

namespace Wikia\Search\Test\Services;

use Wikia\Search\Test\BaseTest;

abstract class SearchServiceBaseTest extends BaseTest {

	protected $solariumMock;

	/**
	 * Return solarium mock
	 * @param string $useResponse provide method name for mock response
	 * @return \PHPUnit_Framework_MockObject_MockObject solarium mock
	 */
	public function useSolariumMock( $useResponse = 'getSolariumMainResponse' ) {
		if ( !isset( $this->solariumMock ) ) {
			$this->solariumMock = $this->getSolariumMock();
			$this->solariumMock->expects( $this->any() )
				->method( 'select' )
				->will( $this->returnValue( $this->getResultMock( $useResponse ) ) );
		}

		return $this->solariumMock;
	}

	/**
	 * Sets solr response body
	 * @return string Solr response body
	 */
	protected abstract function getMockResponse();

	protected function getSolariumMock() {
		$client = new \Solarium_Client();
		$mock = $this->getMockBuilder( '\Solarium_Client' )
			->getMock();

		$mock->expects( $this->any() )
			->method( 'createSelect' )
			->will( $this->returnValue( $client->createSelect() ) );

		return $mock;
	}

	protected function getResultMock( $responseType ) {
		$client = new \Solarium_Client();
		$mock = new \Solarium_Result_Select(
			$client,
			$client->createSelect(),
			$this->{$responseType}()
		);

		return $mock;
	}

	protected function getSolariumMainResponse() {
		//empty solr response
		$mock = new \Solarium_Client_Response(
			$this->getMockResponse(),
			[ 'HTTP/1.1 200 OK' ]
		);
		return $mock;
	}
}
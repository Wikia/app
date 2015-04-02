<?php
use Wikia\Util\Consul\ConsulConfig;

class ConsulServiceTest extends PHPUnit_Framework_TestCase {

	public function testGetConsulServiceName() {

		$consulConfig = new ConsulConfig( "sjc", "testing", "testtag" );
		$this->assertTrue( $consulConfig->getConsulServiceName() == 'testtag.testing.service.sjc.consul' );
	}

	/**
	 * @param $doResolveResponse
	 * @dataProvider sampleDoResolveResponse
	 */
	public function testResolve( $doResolveResponse ) {

		$consulConfig = new ConsulConfig( "sjc", "infobox", "testing" );
		$consulService = $this->getMockBuilder( '\Wikia\Util\Consul\ConsulService' )
			->setConstructorArgs( [ $consulConfig ] )
			->setMethods( [ 'doResolve' ] )
			->getMock();

		$consulService->expects( $this->any() )
			->method( 'doResolve' )
			->will( $this->returnValue( $doResolveResponse ) );

		$resolved = $consulService->resolve();

		if ( empty( $doResolveResponse ) ) {
			$this->assertTrue( $resolved === false );
		} else {
			$this->assertTrue( $resolved[ 'host' ] == "test-host" );
			$this->assertTrue( $resolved[ 'port' ] == 123 );
		}
	}

	public function sampleDoResolveResponse() {
		return [ [ [ [ 'target' => 'test-host', 'port' => 123 ] ] ], [ [ ] ], [ false ], [ null ] ];
	}
}


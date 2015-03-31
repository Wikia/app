<?php
class ConsulServiceTest extends WikiaBaseTest {

	public function testGetConsulServiceName() {

		$mock = $this->getMockBuilder('ConsulService')->setMethods(['getResolvedRecords'])->getMock();

		$this->assertTrue( $mock->getConsulServiceName('testservice', 'testtag') == 'testtag.testservice.service.sjc.consul');
		$this->assertTrue( $mock->getConsulServiceName('testservice') == 'testservice.service.sjc.consul');

		$mock->setDataCenter(ConsulService::DATA_CENTER_RES);

		$this->assertTrue( $mock->getConsulServiceName('testservice') == 'testservice.service.res.consul');
	}

	public function testResolve() {

		$mock = $this->getMockBuilder('ConsulService')
				->setMethods(['getResolvedRecords'])
				->getMock();

		$mock->expects( $this->any() )
			->method('getResolvedRecords')
			->will( $this->returnValue(
				[ ['host' => 'test-host', 'port'=>123] ]
			));

		$resolved = $mock->resolve("xxx");
		$this->assertTrue( $resolved['host'] == "test-host" );
		$this->assertTrue( $resolved['port'] == 123 );
	}
}
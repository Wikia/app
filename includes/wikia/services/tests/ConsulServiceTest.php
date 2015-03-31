<?php
class ConsulServiceTest extends WikiaBaseTest {

	public function testGetConsulServiceName() {

		$mock = $this->getMockBuilder('ConsulService')
				->setMethods(['getResolvedRecords'])
				->setConstructorArgs(['testservice', 'testtag'])
				->getMock();
		$domainWithTag = $mock->getConsulServiceName();
		$this->assertTrue( $domainWithTag == 'testtag.testservice.service.sjc.consul');

		$mock->setServiceTag('');
		$domainWithoutTag = $mock->getConsulServiceName('testservice');
		$this->assertTrue( $domainWithoutTag == 'testservice.service.sjc.consul');

		$mock->setDataCenter(ConsulService::DATA_CENTER_RES);
		$domainWithDifferentDataCenter =  $mock->getConsulServiceName('testservice');
		$this->assertTrue( $domainWithDifferentDataCenter == 'testservice.service.res.consul');
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

		$resolved = $mock->resolve();
		$this->assertTrue( $resolved['host'] == "test-host" );
		$this->assertTrue( $resolved['port'] == 123 );
	}
}
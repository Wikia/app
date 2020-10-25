<?php
/**
 * Wikia\Consul\Client tests
 */

use Wikia\Consul\Client;

/**
 * @group Consul
 */
class ConsulClientTest extends WikiaBaseTest {

	function testGetConsulBaseUrlForDC() {
		$this->assertEquals( 'http://consul.service.sjc.consul.:8500', Client::getConsulBaseUrlForDC( 'sjc' ) );
		$this->assertEquals( 'http://consul.service.sjc-dev.consul.:8500', Client::getConsulBaseUrlForDC( 'sjc-dev' ) );
		$this->assertEquals( 'http://consul.service.res.consul.:8500', Client::getConsulBaseUrlForDC( 'res' ) );
	}

	function testIsConsulAddress() {
		$this->assertTrue( Client::isConsulAddress( 'slave.db-smw.service.consul' ) );
		$this->assertTrue( Client::isConsulAddress( 'master.db-a.service.consul' ) );
		$this->assertTrue( Client::isConsulAddress( 'geo-db-sharedb-master.query.consul' ) );
		$this->assertTrue( Client::isConsulAddress( 'geo-db-a-slave.query.consul.' ) );

		$this->assertFalse( Client::isConsulAddress( 'statsdb-s9' ) );
	}

	function testIsConsulServiceAddress() {
		$this->assertTrue( Client::isConsulServiceAddress( 'master.db-a.service.consul' ) );
		$this->assertTrue( Client::isConsulServiceAddress( 'slave.db-smw.service.consul' ) );
		$this->assertTrue( Client::isConsulServiceAddress( 'slave.db-smw.service.consul.' ) );

		$this->assertFalse( Client::isConsulServiceAddress( 'geo-db-sharedb-master.query.consul' ) );
		$this->assertFalse( Client::isConsulServiceAddress( 'geo-db-g-slave.query.consul' ) );
		$this->assertFalse( Client::isConsulServiceAddress( 'geo-db-a-slave.query.consul.' ) );

		$this->assertFalse( Client::isConsulServiceAddress( 'statsdb-s9' ) );
	}

	function testIsConsulQuery() {
		$this->assertTrue( Client::isConsulQuery( 'geo-db-sharedb-master.query.consul' ) );
		$this->assertTrue( Client::isConsulQuery( 'geo-db-g-slave.query.consul' ) );
		$this->assertTrue( Client::isConsulQuery( 'geo-db-a-slave.query.consul.' ) );

		$this->assertFalse( Client::isConsulQuery( 'slave.db-smw.service.consul' ) );
		$this->assertFalse( Client::isConsulQuery( 'slave.db-smw.service.consul.' ) );
		$this->assertFalse( Client::isConsulQuery( 'master.db-a.service.consul' ) );
		$this->assertFalse( Client::isConsulQuery( 'statsdb-s9' ) );
	}

	function testParseConsulQuery() {
		$this->assertEquals(
			'geo-db-sharedb-master',
			Client::parseConsulQuery( 'geo-db-sharedb-master.query.consul') );

		$this->assertFalse( Client::parseConsulQuery( 'slave.db-smw.service.consul') );
		$this->assertFalse( Client::parseConsulQuery( 'statsdb-s9') );
	}

	function testParseConsulServiceAddress() {
		$this->assertEquals(
			[ 'slave', 'db-smw' ],
			Client::parseConsulServiceAddress( 'slave.db-smw.service.consul') );

		$this->assertEquals(
			[ 'master', 'db-a' ],
			Client::parseConsulServiceAddress( 'master.db-a.service.consul') );

		$this->assertFalse( Client::parseConsulServiceAddress( 'geo-db-sharedb-master.query.consul') );
		$this->assertFalse( Client::parseConsulServiceAddress( 'statsdb-s9') );
	}
}

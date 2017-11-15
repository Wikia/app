<?php
/**
 * Wikia\Consul\Client tests
 */

use Wikia\Consul\Client;

class ConsulClientTest extends WikiaBaseTest {

	function testIsConsulAddress() {
		$this->assertTrue( Client::isConsulAddress( 'slave.db-smw.service.consul' ) );
		$this->assertTrue( Client::isConsulAddress( 'master.db-a.service.consul' ) );
		$this->assertTrue( Client::isConsulAddress( 'geo-db-sharedb-master.query.consul' ) );

		$this->assertFalse( Client::isConsulAddress( 'statsdb-s9' ) );
	}

	function testIsConsulQuery() {
		$this->assertTrue( Client::isConsulQuery( 'geo-db-sharedb-master.query.consul' ) );
		$this->assertTrue( Client::isConsulQuery( 'geo-db-g-slave.query.consul' ) );

		$this->assertFalse( Client::isConsulQuery( 'slave.db-smw.service.consul' ) );
		$this->assertFalse( Client::isConsulQuery( 'master.db-a.service.consul' ) );
		$this->assertFalse( Client::isConsulQuery( 'statsdb-s9' ) );
	}
}

<?php
/**
 * Wikia\Consul\Client tests
 */

use Wikia\Consul\Client;

class ConsulClientTest extends WikiaBaseTest {

	function testIsConsulAddress() {
		$this->assertTrue( Client::isConsulAddress( 'slave.db-smw.service.consul' ) );
		$this->assertTrue( Client::isConsulAddress( 'master.db-a.service.consul' ) );

		$this->assertFalse( Client::isConsulAddress( 'statsdb-s9' ) );
	}
}

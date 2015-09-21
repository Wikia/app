<?php
/**
 * Wikia\Consul\Catalog tests
 */

use Wikia\Consul\Catalog;

class CatalogCatalogTest extends WikiaBaseTest {

	function testIsConsulAddress() {
		$this->assertTrue( Catalog::isConsulAddress( 'slave.db-smw.service.consul' ) );
		$this->assertTrue( Catalog::isConsulAddress( 'master.db-a.service.consul' ) );

		$this->assertFalse( Catalog::isConsulAddress( 'statsdb-s9' ) );
	}
}

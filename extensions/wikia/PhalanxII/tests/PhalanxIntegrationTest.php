<?php

/**
 * @group Integration
 */
class PhalanxIntegrationTest extends WikiaDatabaseTest {

	protected function setUp() {
		parent::setUp();
		require_once __DIR__ . '/../Phalanx_setup.php';
		require_once __DIR__ . '/../PhalanxSpecial_setup.php';
	}

	protected function extraSchemaFiles() {
		yield __DIR__ . '/fixtures/phalanx_tables.sql';
	}

	public function testPhalanxStatsAndFilterEntryRemovedWhenFilterRemoved() {
		$this->mockGlobalVariable( 'wgUser', User::newFromId( 1 ) );

		$phalanx = Phalanx::newFromId( 1 );
		$phalanx->delete();

		$phalanxStatsPager = new PhalanxStatsPager( 1 );
		$this->assertEquals( 0, $phalanxStatsPager->getNumRows() );

		$phalanxReload = Phalanx::newFromId( 1 );
		$this->assertEmpty( $phalanxReload->data );

		$otherPhalanx = Phalanx::newFromId( 2 );
		$this->assertNotEmpty( $otherPhalanx->data );

		$phalanxStatsPager = new PhalanxStatsPager( 2 );
		$this->assertEquals( 1, $phalanxStatsPager->getNumRows() );
	}

	protected function getDataSet() {
		return $this->createYamlDataSet( __DIR__ . '/fixtures/phalanx.yaml' );
	}
}

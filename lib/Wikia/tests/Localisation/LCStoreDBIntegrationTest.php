<?php
namespace Wikia\Localisation;

/**
 * @group Integration
 */
class LCStoreDBIntegrationTest extends \WikiaDatabaseTest {

	public function testPersistData() {
		$lcStoreDb = new LCStoreDB( 'test-prefix' );

		$this->assertNull( $lcStoreDb->get( 'en', 'test-message' ) );
		$this->assertEquals( 'teszt', $lcStoreDb->get( 'hu', 'test-message' ) );

		$lcStoreDb->startWrite( 'en' );
		$lcStoreDb->set( 'test-message', 'testing' );
		$lcStoreDb->set( 'other-message', 'foo' );
		$lcStoreDb->finishWrite();

		$this->assertEquals( 'testing', $lcStoreDb->get( 'en', 'test-message' ) );
		$this->assertEquals( 'foo', $lcStoreDb->get( 'en', 'other-message' ) );

		$this->assertEquals( 'teszt', $lcStoreDb->get( 'hu', 'test-message' ) );
	}

	public function testOtherPrefixIsNotAffected() {
		$lcStoreDb = new LCStoreDB( 'test-prefix' );
		$otherStore = new LCStoreDB( 'other-prefix' );

		$this->assertNull( $lcStoreDb->get( 'en', 'test-message' ) );
		$this->assertEquals( 'test', $otherStore->get( 'en', 'test-message' ) );

		$lcStoreDb->startWrite( 'en' );
		$lcStoreDb->set( 'test-message', 'testing' );
		$lcStoreDb->finishWrite();

		$this->assertEquals( 'test', $otherStore->get( 'en', 'test-message' ) );
		$this->assertEquals( 'testing', $lcStoreDb->get( 'en', 'test-message' ) );
	}

	protected function getDataSet() {
		return $this->createYamlDataSet( __DIR__ . '/fixtures/lc_store.yaml' );
	}
}

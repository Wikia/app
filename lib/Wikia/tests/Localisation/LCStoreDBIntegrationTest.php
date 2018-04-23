<?php
namespace Wikia\Localisation;

/**
 * @group Integration
 */
class LCStoreDBIntegrationTest extends \WikiaDatabaseTest {

	/** @var \LCStore $lcStoreDb */
	private $lcStoreDb;

	protected function setUp() {
		parent::setUp();

		$this->lcStoreDb = new LCStoreDB( 'test-prefix' );
	}

	public function testPersistData() {
		$this->assertNull( $this->lcStoreDb->get( 'en', 'test-message' ) );
		$this->assertEquals( 'teszt', $this->lcStoreDb->get( 'hu', 'test-message' ) );

		$this->lcStoreDb->startWrite( 'en' );
		$this->lcStoreDb->set( 'test-message', 'testing' );
		$this->lcStoreDb->set( 'other-message', 'foo' );
		$this->lcStoreDb->finishWrite();

		$this->assertEquals( 'testing', $this->lcStoreDb->get( 'en', 'test-message' ) );
		$this->assertEquals( 'foo', $this->lcStoreDb->get( 'en', 'other-message' ) );

		$this->assertEquals( 'teszt', $this->lcStoreDb->get( 'hu', 'test-message' ) );
	}

	public function testCannotSetBeforeStartWrite() {
		$this->expectException( \MWException::class );

		$this->lcStoreDb->set( 'test-message', 'testing' );
	}

	public function testCannotWriteInvalidCode() {
		$this->expectException( \MWException::class );

		$this->lcStoreDb->startWrite( false );
	}

	protected function getDataSet() {
		return $this->createYamlDataSet( __DIR__ . '/fixtures/lc_store.yaml' );
	}
}

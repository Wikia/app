<?php
namespace Wikia\Localisation;

use PHPUnit\Framework\TestCase;

class CachedLCStoreDBTest extends TestCase {

	/** @var \LCStore|\PHPUnit_Framework_MockObject_MockObject $dbMock */
	private $dbMock;

	/** @var CachedLCStoreDB $lcStore */
	private $lcStore;

	protected function setUp() {
		parent::setUp();

		$this->dbMock = $this->createMock( LCStoreDB::class );
		$this->lcStore = new CachedLCStoreDB( new \HashBagOStuff(), $this->dbMock );
	}

	public function testPersistData() {
		$this->lcStore->startWrite( 'en' );
		$this->lcStore->set( 'test-message', 'foo' );
		$this->lcStore->finishWrite();

		$this->lcStore->startWrite( 'hu' );
		$this->lcStore->set( 'test-message', 'asd' );
		$this->lcStore->finishWrite();

		$this->assertEquals( 'asd', $this->lcStore->get( 'hu', 'test-message' ), 'After finishing write all messages should be cached for language' );
		$this->assertEquals( 'foo', $this->lcStore->get( 'en', 'test-message' ), 'After finishing write all messages should be cached for language' );

		$this->lcStore->startWrite( 'hu' );

		$this->assertEmpty( $this->lcStore->get( 'hu', 'test-message' ), 'Start of write should clear cache for language' );
		$this->assertEquals( 'foo', $this->lcStore->get( 'en', 'test-message' ), 'Start of write should not affect cache for other language' );

		$this->lcStore->finishWrite();
	}

	public function testCacheNull() {
		$this->dbMock->expects( $this->once() )
			->method( 'get' )
			->with( 'en', 'test-message' )
			->willReturn( null );

		$this->assertNull( $this->lcStore->get( 'en', 'test-message' ) );
		$this->assertNull( $this->lcStore->get( 'en', 'test-message' ) );
	}
}

<?php
namespace Wikia\Localisation;

use PHPUnit\Framework\TestCase;
use Psr\Log\NullLogger;

class FallbackCapableLCStoreTest extends TestCase {

	/** @var \LCStore|\PHPUnit_Framework_MockObject_MockObject $cacheMock */
	private $cacheMock;

	/** @var \LCStore|\PHPUnit_Framework_MockObject_MockObject $fallbackMock */
	private $fallbackMock;

	/** @var FallbackCapableLCStore $lcStore */
	private $lcStore;

	protected function setUp() {
		parent::setUp();

		$this->cacheMock = $this->getMockForAbstractClass( \LCStore::class );
		$this->fallbackMock = $this->getMockForAbstractClass( \LCStore::class );
		$this->lcStore = new FallbackCapableLCStore( $this->cacheMock, $this->fallbackMock );
		$this->lcStore->setLogger( new NullLogger() );
	}

	public function testPersistDataSuccess() {
		$this->fallbackMock->expects( $this->at( 0 ) )
			->method( 'startWrite' )
			->with( 'en' );
		$this->fallbackMock->expects( $this->at( 1 )  )
			->method( 'set' )
			->with( 'test-message', 'foo' );
		$this->fallbackMock->expects( $this->at( 2 ) )
			->method( 'finishWrite' );
		$this->fallbackMock->expects( $this->at( 3 ) )
			->method( 'startWrite' )
			->with( 'hu' );
		$this->fallbackMock->expects( $this->at( 4 )  )
			->method( 'set' )
			->with( 'test-message', 'asd' );
		$this->fallbackMock->expects( $this->at( 5 ) )
			->method( 'finishWrite' );

		$this->cacheMock->expects( $this->at( 0 ) )
			->method( 'startWrite' )
			->with( 'en' );
		$this->cacheMock->expects( $this->at( 1 )  )
			->method( 'set' )
			->with( 'test-message', 'foo' );
		$this->cacheMock->expects( $this->at( 2 ) )
			->method( 'finishWrite' );
		$this->cacheMock->expects( $this->at( 3 ) )
			->method( 'startWrite' )
			->with( 'hu' );
		$this->cacheMock->expects( $this->at( 4 )  )
			->method( 'set' )
			->with( 'test-message', 'asd' );
		$this->cacheMock->expects( $this->at( 5 ) )
			->method( 'finishWrite' );

		$this->lcStore->startWrite( 'en' );
		$this->lcStore->set( 'test-message', 'foo' );
		$this->lcStore->finishWrite();

		$this->lcStore->startWrite( 'hu' );
		$this->lcStore->set( 'test-message', 'asd' );
		$this->lcStore->finishWrite();
	}

	public function testDataSavedToFallbackStoreOnCacheError() {
		$this->fallbackMock->expects( $this->at( 0 ) )
			->method( 'startWrite' )
			->with( 'en' );
		$this->cacheMock->expects( $this->at( 0 ) )
			->method( 'startWrite' )
			->with( 'en' );

		$this->fallbackMock->expects( $this->once() )
			->method( 'set' )
			->with( 'test-message', 'foo' );
		$this->fallbackMock->expects( $this->once() )
			->method( 'finishWrite' );
		$this->cacheMock->expects( $this->once() )
			->method( 'set' )
			->with( 'test-message', 'foo' )
			->willThrowException( new \Exception() );
		$this->cacheMock->expects( $this->once() )
			->method( 'finishWrite' );

		$this->lcStore->startWrite( 'en' );
		$this->lcStore->set( 'test-message', 'foo' );
		$this->lcStore->finishWrite();
	}

	public function testCachesDataOnCacheMiss() {
		$this->cacheMock->expects( $this->once() )
			->method( 'get' )
			->with( 'en', 'test-message' )
			->willReturn( null );
		$this->fallbackMock->expects( $this->any() )
			->method( 'get' )
			->with( 'en', 'test-message' )
			->willReturn( 'foo' );

		$this->cacheMock->expects( $this->once() )
			->method( 'startWrite' )
			->with( 'en' );
		$this->cacheMock->expects( $this->once() )
			->method( 'set' )
			->with( 'test-message', 'foo' );
		$this->cacheMock->expects( $this->once() )
			->method( 'finishWrite' );

		$value = $this->lcStore->get( 'en', 'test-message' );

		$this->assertEquals( 'foo', $value );
	}

	public function testValueFromFallbackUsedOnCacheStoreException() {
		$this->cacheMock->expects( $this->once() )
			->method( 'get' )
			->with( 'en', 'test-message' )
			->willThrowException( new \Exception() );
		$this->fallbackMock->expects( $this->any() )
			->method( 'get' )
			->with( 'en', 'test-message' )
			->willReturn( 'foo' );

		$this->cacheMock->expects( $this->never() )
			->method( 'startWrite' );
		$this->cacheMock->expects( $this->never() )
			->method( 'set' )
			->with( $this->anything() );
		$this->cacheMock->expects( $this->never() )
			->method( 'finishWrite' );

		$value = $this->lcStore->get( 'en', 'test-message' );

		$this->assertEquals( 'foo', $value );
	}
}

<?php
namespace Wikia\SwiftSync;

use PHPUnit\Framework\TestCase;
use Wikia\Factory\ServiceFactory;

class HooksTest extends TestCase {

	/** @var SwiftSyncTaskProducer|\PHPUnit_Framework_MockObject_MockObject $swiftSyncTaskProducerMock */
	private $swiftSyncTaskProducerMock;

	protected function setUp() {
		parent::setUp();

		$this->swiftSyncTaskProducerMock = $this->createMock( SwiftSyncTaskProducer::class );

		ServiceFactory::instance()->swiftSyncFactory()->setSwiftSyncTaskProducer( $this->swiftSyncTaskProducerMock );
	}

	/**
	 * @dataProvider tempFileProvider
	 * @param string $path
	 */
	public function testShouldNotQueueTemporaryFileStoreOperation( string $path ) {
		$this->swiftSyncTaskProducerMock->expects( $this->never() )
			->method( $this->anything() );

		$params = [ 'op' => 'store', 'dst' => $path ];
		$status = \Status::newGood();

		$result = Hooks::doStoreInternal( $params, $status );

		$this->assertTrue( $result );
	}

	public function tempFileProvider() {
		yield [ 'mwstore://swift-backend/easternlight/zh-tw/images/3/35/Temp_file_1516192811' ];
		yield [ 'mwstore://swift-backend/starwars/images/4/14/Temp_file_323427658' ];
	}

	public function testShouldNotQueueFileStoreOperationIfStatusBad() {
		$this->swiftSyncTaskProducerMock->expects( $this->never() )
			->method( $this->anything() );

		$params = [ 'op' => 'store', 'dst' => 'mwstore://swift-backend/starwars/images/4/14/Test.png' ];
		$status = \Status::newFatal( 'error' );

		$result = Hooks::doStoreInternal( $params, $status );

		$this->assertTrue( $result );
	}

	/**
	 * @dataProvider validFileProvider
	 * @param string $path
	 */
	public function testShouldQueueNormalizedFileStoreOperationIfStatusGood( string $path ) {
		$this->swiftSyncTaskProducerMock->expects( $this->once() )
			->method( 'addOperation' )
			->with( [ 'op' => 'store', 'dst' => $path, 'src' => '' ] );

		$params = [ 'op' => 'store', 'dst' => $path ];
		$status = \Status::newGood();

		$result = Hooks::doStoreInternal( $params, $status );

		$this->assertTrue( $result );
	}

	public function validFileProvider() {
		yield [ 'mwstore://swift-backend/easternlight/zh-tw/images/3/35/Valid_file.jpg' ];
		yield [ 'mwstore://swift-backend/starwars/images/4/14/Good_image.png' ];
	}

	public function testShouldNotQueueFileCopyOperationIfStatusBad() {
		$this->swiftSyncTaskProducerMock->expects( $this->never() )
			->method( $this->anything() );

		$params = [
			'op' => 'store',
			'dst' => 'mwstore://swift-backend/starwars/images/4/14/Test.png',
			'src' => 'mwstore://swift-backend/starwars/images/4/12/Test2.png',
		];
		$status = \Status::newFatal( 'error' );

		$result = Hooks::doCopyInternal( $params, $status );

		$this->assertTrue( $result );
	}

	public function testShouldQueueFileCopyOperationIfStatusGood() {
		$this->swiftSyncTaskProducerMock->expects( $this->never() )
			->method( $this->anything() );

		$params = [
			'op' => 'store',
			'dst' => 'mwstore://swift-backend/starwars/images/4/14/Test.png',
			'src' => 'mwstore://swift-backend/starwars/images/4/12/Test2.png',
		];
		$status = \Status::newFatal( 'error' );

		$result = Hooks::doCopyInternal( $params, $status );

		$this->assertTrue( $result );
	}

	/**
	 * @dataProvider tempFileAndThumbProvider
	 * @param string $path
	 */
	public function testShouldNotQueueTemporaryFileOrThumbnailDeleteOperation( string $path ) {
		$this->swiftSyncTaskProducerMock->expects( $this->never() )
			->method( $this->anything() );

		$params = [ 'op' => 'delete', 'src' => $path ];
		$status = \Status::newGood();

		$result = Hooks::doDeleteInternal( $params, $status );

		$this->assertTrue( $result );
	}

	public function tempFileAndThumbProvider() {
		yield [ 'mwstore://swift-backend/easternlight/zh-tw/images/3/35/Temp_file_1516192811' ];
		yield [ 'mwstore://swift-backend/starwars/images/thumb/4/14/Thumbnail.jpg' ];
		yield [ 'mwstore://swift-backend/easternlight/zh-tw/images/thumb/3/35/Thumb.png' ];
		yield [ 'mwstore://swift-backend/starwars/images/4/14/Temp_file_323427658' ];
	}

	public function testShouldNotQueueFileDeleteOperationIfStatusBad() {
		$this->swiftSyncTaskProducerMock->expects( $this->never() )
			->method( $this->anything() );

		$params = [
			'op' => 'delete',
			'src' => 'mwstore://swift-backend/starwars/images/4/12/Test2.png',
		];
		$status = \Status::newFatal( 'error' );

		$result = Hooks::doDeleteInternal( $params, $status );

		$this->assertTrue( $result );
	}

	public function testShouldQueueFileDeleteOperationIfStatusGood() {
		$this->swiftSyncTaskProducerMock->expects( $this->once() )
			->method( 'addOperation' )
			->with( [
				'op' => 'delete',
				'dst' => 'mwstore://swift-backend/starwars/images/4/12/Test2.png',
				'src' => 'mwstore://swift-backend/starwars/images/4/12/Test2.png'
			] );

		$params = [
			'op' => 'delete',
			'src' => 'mwstore://swift-backend/starwars/images/4/12/Test2.png',
		];
		$status = \Status::newGood();

		$result = Hooks::doDeleteInternal( $params, $status );

		$this->assertTrue( $result );
	}

	public static function tearDownAfterClass() {
		parent::tearDownAfterClass();
		ServiceFactory::clearState();
	}
}

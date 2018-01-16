<?php

use PHPUnit\Framework\TestCase;

class CachedGlobalUsersServiceTest extends TestCase {
	/** @var PHPUnit_Framework_MockObject_MockObject|BagOStuff $cacheServiceSpy */
	private $cacheServiceSpy;
	/** @var PHPUnit_Framework_MockObject_MockObject|GlobalUsersService $globalUsersServiceMock */
	private $globalUsersServiceMock;

	/** @var GlobalUsersService $cachedGlobalUsersService */
	private $cachedGlobalUsersService;

	protected function setUp() {
		parent::setUp();
		require_once __DIR__ . '/../ListGlobalUsers.setup.php';

		$this->cacheServiceSpy = $this->getMockBuilder( HashBagOStuff::class )
			->enableProxyingToOriginalMethods()
			->getMock();

		$this->globalUsersServiceMock = $this->getMockBuilder( GlobalUsersService::class )->getMockForAbstractClass();

		$this->cachedGlobalUsersService =
			new CachedGlobalUsersService( $this->cacheServiceSpy, $this->globalUsersServiceMock );
	}

	public function testFreshResultFetchedOnCacheMissThenCached() {
		$example = [ 123 => 'Example' ];

		$this->cacheServiceSpy->expects( $this->exactly( 2 ) )
			->method( 'get' );

		$this->cacheServiceSpy->expects( $this->once() )
			->method( 'set' )
			->with( $this->anything(), $this->equalTo( $example ), CachedGlobalUsersService::CACHE_TTL );

		$this->globalUsersServiceMock->expects( $this->once() )
			->method( 'getGroupMembers' )
			->with( [ 'staff', 'vstf' ] )
			->willReturn( $example );

		$freshResult = $this->cachedGlobalUsersService->getGroupMembers( [ 'staff', 'vstf' ] );
		$cachedResult = $this->cachedGlobalUsersService->getGroupMembers( [ 'staff', 'vstf' ] );

		$this->assertEquals( $example, $freshResult );
		$this->assertEquals( $example, $cachedResult );
	}

	public function testEmptySetReturnedForEmptySetOfGroups() {
		$this->cacheServiceSpy->expects( $this->never() )
			->method( $this->anything() );
		$this->globalUsersServiceMock->expects( $this->never() )
			->method( $this->anything() );

		$resultSet = $this->cachedGlobalUsersService->getGroupMembers( [] );

		$this->assertEmpty( $resultSet );
	}
}

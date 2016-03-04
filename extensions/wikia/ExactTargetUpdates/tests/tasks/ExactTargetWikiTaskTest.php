<?php

class ExactTargetWikiTaskTest extends WikiaBaseTest {

	public function setUp() {
		$this->setupFile = __DIR__ . '/../../ExactTargetUpdates.setup.php';
		parent::setUp();
	}

	/**
	 * @expectedException \Wikia\Util\AssertionException
	 * @expectedExceptionMessage Wiki ID missing
	 */
	public function testShouldThrowExceptionWhenUpdatingWikiWithoutWikiId() {
		$clientMock = $this->prepareClientMock();
		$task = $this->getWikiTask($clientMock);

		$task->updateWiki( null, [ ] );
	}

	public function testShouldCallClientUpdateWikiMethod() {
		$clientMock = $this->prepareClientMock();
		$task = $this->getWikiTask($clientMock);

		$clientMock->expects( $this->once() )
			->method( 'updateWiki' );

		$this->assertEquals( 'OK', $task->updateWiki( 1, [ ] ) );
	}

	/**
	 * @expectedException \Wikia\Util\AssertionException
	 * @expectedExceptionMessage Wiki ID missing
	 */
	public function testShouldThrowExceptionWhenDeletingWikiWithoutWikiId() {
		$clientMock = $this->prepareClientMock();
		$task = $this->getWikiTask($clientMock);

		$task->deleteWiki( null );
	}

	public function testShouldCallClientMethodsOnUpdateWikiCategories() {
		$clientMock = $this->prepareClientMock();
		$task = $this->getWikiTask($clientMock);

		$clientMock->expects( $this->once() )
			->method( 'retrieveWikiCategories' )
			->willReturn( [ ] );
		$clientMock->expects( $this->once() )
			->method( 'deleteWikiCategoriesMapping' );
		$clientMock->expects( $this->once() )
			->method( 'updateWikiCategoriesMapping' );

		$this->assertEquals( 'OK', $task->updateWikiCategoriesMapping( 1 ) );
	}

	/**
	 * @expectedException \Wikia\Util\AssertionException
	 * @expectedExceptionMessage Wiki ID missing
	 */
	public function testShouldThrowExceptionWhenUpdatingWikiCategoriesWithoutWikiId() {
		$clientMock = $this->prepareClientMock();
		$task = $this->getWikiTask($clientMock);

		$task->updateWikiCategoriesMapping( null );
	}

	public function testShouldCallClientMethodsOnDeleteWiki() {
		$clientMock = $this->prepareClientMock();
		$task = $this->getWikiTask($clientMock);

		$clientMock->expects( $this->once() )
			->method( 'retrieveWikiCategories' )
			->willReturn( [ ] );
		$clientMock->expects( $this->once() )
			->method( 'deleteWikiCategoriesMapping' );
		$clientMock->expects( $this->once() )
			->method( 'deleteWiki' );

		$this->assertEquals( 'OK', $task->deleteWiki( 1 ) );
	}

	private function getWikiTask($client) {
		return new \Wikia\ExactTarget\ExactTargetWikiTask($client);
	}

	/**
	 * @return PHPUnit_Framework_MockObject_MockObject
	 */
	private function prepareClientMock() {
		$mockClient = $this->getMock( '\Wikia\ExactTarget\ExactTargetClient',
			[
				'updateWiki',
				'deleteWiki',
				'updateWikiCategoriesMapping',
				'retrieveWikiCategories',
				'deleteWikiCategoriesMapping'
			]
		);

		return $mockClient;
	}

}

<?php

class ExactTargetWikiTaskTest extends WikiaBaseTest {

	public function setUp() {
		$this->setupFile = __DIR__ . '/../../ExactTargetUpdates.setup.php';
		parent::setUp();
	}

	/**
	 * @expectedException \Wikia\Util\AssertionException
	 * @expectedExceptionMessage City ID missing
	 */
	public function testShouldThrowExceptionWhenUpdatingWikiWithoutCityId() {
		$clientMock = $this->prepareClientMock();
		$task = $this->getWikiTask($clientMock);

		$task->updateWiki( [ ] );
	}

	public function testShouldCallClientUpdateWikiMethodWithProperParams() {
		$clientMock = $this->prepareClientMock();
		$task = $this->getWikiTask($clientMock);

		$clientMock->expects( $this->once() )
			->method( 'updateWiki' );

		$task->updateWiki( [ 'city_id' => 1 ] );
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
				'updateWiki'
			]
		);

		return $mockClient;
	}

}

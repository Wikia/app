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

	public function testShouldCallClientUpdateWikiMethodWithProperParams() {
		$clientMock = $this->prepareClientMock();
		$task = $this->getWikiTask($clientMock);

		$clientMock->expects( $this->once() )
			->method( 'updateWiki' );

		$task->updateWiki( 1, [ ] );
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

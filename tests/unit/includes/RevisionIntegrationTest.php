<?php

/**
 * @group Integration
 */
class RevisionIntegrationTest extends WikiaDatabaseTest {

	/**
	 * @dataProvider provideRevisionsAndUserNames
	 *
	 * @param int $revisionId
	 * @param int $expectedUserId
	 * @param string $expectedUserName
	 */
	public function testGetUserTextUsesUserNameLookup( int $revisionId, int $expectedUserId, string $expectedUserName ) {
		$revision = Revision::newFromId( $revisionId );

		$this->assertInstanceOf( Revision::class, $revision );
		$this->assertEquals( $expectedUserId, $revision->getUser() );
		$this->assertEquals( $expectedUserName, $revision->getUserText() );
	}

	public function provideRevisionsAndUserNames() {
		yield [ 1, 1, 'TestUserOne' ];
		yield [ 2, 1, 'TestUserOne' ];
		yield [ 3, 0, '8.8.8.8' ];
	}

	/**
	 * @dataProvider provideDeletedRevisions
	 * @param int $revisionId
	 */
	public function testUserInfoIsNotShownToAllUsersWhenDeleted( int $revisionId ) {
		$revision = Revision::newFromId( $revisionId );

		$this->assertInstanceOf( Revision::class, $revision );
		$this->assertTrue( $revision->isDeleted( Revision::DELETED_USER ) );
		$this->assertEquals( 0, $revision->getUser() );
		$this->assertEmpty( $revision->getUserText() );
	}


	public function provideDeletedRevisions() {
		yield [ 4 ];
		yield [ 5 ];
		yield [ 6 ];
	}

	protected function getDataSet() {
		return $this->createYamlDataSet( __DIR__ . '/../../fixtures/revision.yaml' );
	}
}

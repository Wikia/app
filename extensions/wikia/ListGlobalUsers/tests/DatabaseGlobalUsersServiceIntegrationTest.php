<?php

/**
 * @group Integration
 */
class DatabaseGlobalUsersServiceIntegrationTest extends WikiaDatabaseTest {
	/** @var GlobalUsersService $dataBaseGlobalUsersService */
	private $dataBaseGlobalUsersService;

	protected function setUp() {
		parent::setUp();
		require_once __DIR__ . '/../ListGlobalUsers.setup.php';
		$this->dataBaseGlobalUsersService = new DatabaseGlobalUsersService();
	}

	public function testReturnsMappingOfGroupMemberUserIdsOrderedByName() {
		$resultMap = $this->dataBaseGlobalUsersService->getGroupMembers( [ 'soap', 'staff' ] );

		$this->assertCount( 2, $resultMap );
		$this->assertEquals( 'KossuthLajos', $resultMap[1]['name'] );
		$this->assertEquals( 'FerencJozsef', $resultMap[3]['name'] );

		$this->assertEquals( [ 'soap', 'staff' ], $resultMap[1]['groups'] );
		$this->assertEquals( [ 'soap' ], $resultMap[3]['groups'] );
	}

	public function testReturnsEmptyMapForEmptySetOfGroups() {
		$this->assertEmpty( $this->dataBaseGlobalUsersService->getGroupMembers( [] ) );
	}

	public function testReturnsEmptyMapForGroupsWithNoMembers() {
		$this->assertEmpty( $this->dataBaseGlobalUsersService->getGroupMembers( [ 'no-such-group' ] ) );
	}

	protected function getDataSet() {
		return $this->createYamlDataSet( __DIR__ . '/fixtures/database_global_users_service.yaml' );
	}
}

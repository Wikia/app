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
		$resultMap = $this->dataBaseGlobalUsersService->getGroupMembers( [ 'staff', 'vstf' ] );

		$this->assertCount( 2, $resultMap );
		$this->assertEquals( $resultMap[1], 'KossuthLajos' );
		$this->assertEquals( $resultMap[3], 'FerencJozsef' );

		$sortedMap = $resultMap;
		asort( $sortedMap );

		$this->assertEquals( $sortedMap, $resultMap );
	}

	public function testReturnsEmptyMapForEmptySetOfGroups() {
		$this->assertEmpty( $this->dataBaseGlobalUsersService->getGroupMembers( [] ) );
	}

	protected function getDataSet() {
		return $this->createYamlDataSet( __DIR__ . '/fixtures/database_global_users_service.yaml' );
	}
}

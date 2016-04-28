<?php

class ChatUserTest extends WikiaBaseTest {

	const MOCK_USER_ID = 142;
	const MOCK_WIKI_ID = 189;
	const MOCK_ADMIN_USER_ID = 289;

	private $userMock;


	protected function setUp() {
		$this->setupFile = __DIR__ . '/../Chat_setup.php';
		parent::setUp();
	}

	private function getUserMock() {
		if ( !$this->userMock ) {
			$this->userMock = $this->getMockBuilder( 'User' )
				->disableOriginalConstructor()
				->getMock();
			$this->userMock
				->expects( $this->any() )
				->method( 'getId' )
				->willReturn( self::MOCK_USER_ID );
		}

		return $this->userMock;
	}

	private function getChatUser() {
		return new ChatUser( $this->getUserMock(), self::MOCK_WIKI_ID );
	}

	private function mockDatabaseRow( $result ) {
		$databaseMock = $this->getDatabaseMock(['selectRow']);

		$databaseMock
			->expects( $result !== null ? $this->once() : $this->never() )
			->method( 'selectRow' )
			->willReturn( $result );

		$this->mockGlobalFunction( 'wfGetDB', $databaseMock );
	}

	private function mockMemcached( $readValue, $writeValue ) {
		$memcachedMock = $this->getMockBuilder( 'MemcachedPhpBagOStuff' )
			->disableOriginalConstructor()
			->getMock();

		$memcachedMock
			->expects( $readValue !== null ? $this->atLeastOnce() : $this->never() )
			->method( 'get' )
			->willReturn( $readValue );

		$memcachedMock
			->expects( $writeValue !== null ? $this->once() : $this->never() )
			->method( 'set' )
			->with( $this->anything(), $this->equalTo( $writeValue ) )
			->willReturn( null );

		$this->mockGlobalVariable( 'wgMemc', $memcachedMock );
	}


	public function testGetNonEmptyBanInfoFromDbAndStoreInCache() {
		$this->mockDatabaseRow( false );
		$this->mockMemcached( false, ChatUser::NO_BAN_MARKER );

		$chatUser = $this->getChatUser();
		$this->assertEquals( false, $chatUser->getBanInfo() );
	}

	public function testGetEmptyBanInfoFromDbAndStoreInCache() {
		$row = $this->getExampleBanInfo();

		$this->mockDatabaseRow( $row );
		$this->mockMemcached( false, $row );

		$chatUser = $this->getChatUser();
		$this->assertEquals( $row, $chatUser->getBanInfo() );
	}

	public function testGetNonEmptyBanInfoFromCache() {
		$this->mockDatabaseRow( null );
		$this->mockMemcached( ChatUser::NO_BAN_MARKER, null );

		$chatUser = $this->getChatUser();
		$this->assertEquals( false, $chatUser->getBanInfo() );
	}

	public function testGetEmptyBanInfoFromCache() {
		$row = $this->getExampleBanInfo();

		$this->mockDatabaseRow( null );
		$this->mockMemcached( $row, null );

		$chatUser = $this->getChatUser();
		$this->assertEquals( $row, $chatUser->getBanInfo() );
	}

	public function testGetExpiredBanInfoFromDb() {
		$row = $this->getExampleBanInfo( /* expired */
			true );

		$this->mockDatabaseRow( $row );
		$this->mockMemcached( false, ChatUser::NO_BAN_MARKER );

		$chatUser = $this->getChatUser();
		$this->assertEquals( false, $chatUser->getBanInfo() );
	}

	public function testGetExpiredBanInfoFromCache() {
		$row = $this->getExampleBanInfo( /* expired */
			true );

		$this->mockDatabaseRow( null );
		$this->mockMemcached( $row, null );

		$chatUser = $this->getChatUser();
		$this->assertEquals( false, $chatUser->getBanInfo() );
	}

	/**
	 * @return object
	 * @throws MWException
	 */
	private function getExampleBanInfo( $expired = false ) {
		return (object)[
			'cbu_wiki_id' => self::MOCK_WIKI_ID,
			'cbu_user_id' => self::MOCK_USER_ID,
			'cbu_admin_user_id' => self::MOCK_ADMIN_USER_ID,
			'end_date' => wfTimestamp( TS_DB, time() + ( !$expired ? 3600 : -3600 ) ),
			'reason' => 'test ban',
		];
	}

}
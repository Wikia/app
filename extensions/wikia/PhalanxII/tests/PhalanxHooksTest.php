<?php
class PhalanxHooksTest extends WikiaBaseTest {
	const VALID_USERNAME = 'WikiaUser';
	const VALID_EMAIL = 'moli@wikia-inc.com';

	const INVALID_USERNAME = '75.246.151.75';
	const INVALID_EMAIL = 'test@porn.com';

	/***
	 * setup tests
	 */
	public function setUp() {
		$this->setupFile =  dirname(__FILE__) . '/../Phalanx_setup.php';
		parent::setUp();
	}

	/* PhalanxUserBlock class */

	/* blockCheck method */
	/**
	 * @dataProvider phalanxUserBlockDataProvider
	 */
	public function testPhalanxUserBlockBlockCheck( $isAnon, $userName, $email, $block, $isOk, $result, $error_msg ) {		
		// User 
		$userMock = $this->getMock( 'User', array( 'isAnon', 'getName' ) ); 
		$userMock
			->expects( $this->any() )
			->method( 'isAnon' )
			->will( $this->returnValue( $isAnon ) );
		$userMock
			->expects( $this->any() )
			->method( 'getName' )
			->will( $this->returnValue( $userName ) );
		$this->mockClass('User', $userMock);

		$this->mockGlobalVariable('wgUser', $userMock);

		// PhalanxUserModel 
		$modelMock = $this->getMock( 'PhalanxUserModel', array('isOk', 'match', 'getUser'), array( $userMock ) );
		$modelMock
			->expects( $this->once() )
			->method( 'isOk' )
			->will( $this->returnValue( $isOk ) );
		
		$modelMock
			->expects( $this->any() )
			->method( 'match' )
			->will( $this->returnValue( $block ) );

		$modelMock
			->expects( $this->any() )
			->method('getUser')
			->will( $this->returnValue( $userMock ));	

		$this->proxyClass( 'PhalanxUserModel', $modelMock );
		$this->mockClass('PhalanxUserModel', $modelMock );

		$hook = new PhalanxUserBlock();
		$ret = (int) $hook->blockCheck( $userMock );

		$this->assertEquals( $result, $ret );
	}

	/* userCanSendEmail method */
	/**
	 * @dataProvider phalanxUserBlockDataProvider
	 */
	public function testPhalanxUserBlockUserCanSendEmail( $isAnon, $userName, $email, $block, $isOk, $result, $error_msg) {		
		// User 
		$userMock = $this->getMock( 'User', array( 'isAnon', 'getName' ) ); 
		$userMock
			->expects( $this->any() )
			->method( 'isAnon' )
			->will( $this->returnValue( $isAnon ) );
		$userMock
			->expects( $this->any() )
			->method( 'getName' )
			->will( $this->returnValue( $userName ) );
		$this->mockClass('User', $userMock);

		$this->mockGlobalVariable('wgUser', $userMock);

		// PhalanxUserModel 
		$modelMock = $this->getMock( 'PhalanxUserModel', array('isOk', 'match', 'getUser'), array( $userMock ) );
		$modelMock
			->expects( $this->once() )
			->method( 'isOk' )
			->will( $this->returnValue( $isOk ) );
		
		$modelMock
			->expects( $this->any() )
			->method( 'match' )
			->will( $this->returnValue( $block ) );

		$modelMock
			->expects( $this->any() )
			->method('getUser')
			->will( $this->returnValue( $userMock ));	

		$this->proxyClass( 'PhalanxUserModel', $modelMock );
		$this->mockClass('PhalanxUserModel', $modelMock );

		$hook = new PhalanxUserBlock();
		$canSend = true;
		$ret = (bool) $hook->userCanSendEmail( $userMock, $canSend );

		$this->assertTrue( $ret );
		$this->assertEquals( $result, $canSend );
	}
	
	/* abortNewAccount method */
	/**
	 * @dataProvider phalanxUserBlockDataProvider
	 */
	public function testPhalanxUserBlockUserAbortNewAccount( $isAnon, $userName, $email, $block, $isOk, $result, $error_msg ) {		
		// User 
		$userMock = $this->getMock( 'User', array( 'isAnon', 'getName', 'getEmail' ) ); 
		$userMock
			->expects( $this->any() )
			->method( 'isAnon' )
			->will( $this->returnValue( $isAnon ) );
		$userMock
			->expects( $this->any() )
			->method( 'getName' )
			->will( $this->returnValue( $userName ) );
		$userMock
			->expects( $this->any() )
			->method( 'getEmail' )
			->will( $this->returnValue( $email ) );
			
		$this->mockClass('User', $userMock);

		$this->mockGlobalVariable('wgUser', $userMock);

		// PhalanxUserModel 
		$modelMock = $this->getMock( 'PhalanxUserModel', array('match', 'getUser'), array( $userMock ) );
		
		$modelMock
			->expects( $this->any() )
			->method( 'match' )
			->will( $this->returnValue( $block ) );

		$modelMock
			->expects( $this->any() )
			->method('getUser')
			->will( $this->returnValue( $userMock ));	

		$this->proxyClass( 'PhalanxUserModel', $modelMock );
		$this->mockClass('PhalanxUserModel', $modelMock );

		$hook = new PhalanxUserBlock();
		$abortError = '';
		$ret = (int) $hook->abortNewAccount( $userMock, $abortError );

error_log ( "abortError = $abortError \n", 3, "/tmp/moli.log" );
		$this->assertEquals( $result, $ret );
		$this->assertEquals( $error_msg, $abortError );
	}
	
	/* data providers */
	public function phalanxUserBlockDataProvider() {
		/* valid user */
		$validUser = array(
			'isAnon'    => false,
			'getName'   => self::VALID_USERNAME,
			'email'		=> self::VALID_EMAIL,
			'block'     => 0,
			'isOk'      => 0,
			'result'    => 1,
			'error'		=> ''
		);

		/* invalid user */
		$invalidUser = array(
			'isAnon'    => true,
			'getName'   => self::INVALID_USERNAME,
			'email'		=> self::INVALID_EMAIL,
			'block'     => (object) array(
				'regex' => 0,
				'expires' => '',
				'text' => self::INVALID_USERNAME,
				'reason' => 'Test',
				'exact' => '',
				'caseSensitive' => '', 
				'id' => 4009,
				'language' => '', 
				'authorId' => 184532,
			),
			'isOk'      => 0,
			'result'    => 0,
			'error'		=> wfMsg( 'phalanx-user-block-new-account' )
		);

		/* invalid user */
		$invalidUserEmail = array(
			'isAnon'    => true,
			'getName'   => self::INVALID_USERNAME,
			'email'		=> self::INVALID_EMAIL,
			'block'     => (object) array(
				'regex' => 0,
				'expires' => '',
				'text' => self::INVALID_EMAIL,
				'reason' => 'Test Email',
				'exact' => '',
				'caseSensitive' => '', 
				'id' => 4010,
				'language' => '', 
				'authorId' => 184532,
			),
			'isOk'      => 0,
			'result'    => 0,
			'error'		=> wfMsg( 'phalanx-user-block-new-account' )
		);

		/* phalanxexempt */
		$okUser = array(                         
			'isAnon'    => false,
			'getName'   => self::VALID_USERNAME,
			'email'		=> self::VALID_EMAIL,
			'block'     => 0,
			'isOk'      => 1,
			'result'    => 1,
			'error'		=> ''
		);
	
		return array( $validUser, $invalidUser, $invalidUserEmail, $okUser );
	}
}

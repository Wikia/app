<?php
class PhalanxHooksTest extends WikiaBaseTest {
	const VALID_USERNAME = 'WikiaUser';
	const INVALID_USERNAME = '75.246.151.75';

	/**
	 * setup tests
	 */
	public function setUp() {
		$this->setupFile =  dirname(__FILE__) . '/../Phalanx_setup.php';
		parent::setUp();
	}

	/**
	 * @dataProvider phalanxUserBlockBlockCheckDataProvider
	 */
	public function testPhalanxUserBlockBlockCheck( $isAnon, $userName, $block, $isOk, $result ) {		
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
	
	public function phalanxUserBlockBlockCheckDataProvider() {
		/* valid user */
		$validUser = array(
			'isAnon'    => false,
			'getName'   => self::VALID_USERNAME,
			'block'     => 0,
			'isOk'      => 0,
			'result'    => 1
		);

		/* invalid user */
		$invalidUser = array(
			'isAnon'    => true,
			'getName'   => self::INVALID_USERNAME,
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
			'result'    => 0 
		);

		/* phalanxexempt */
		$okUser = array(                         
			'isAnon'    => false,
                        'getName'   => self::VALID_USERNAME,
                        'block'     => 0,
                        'isOk'      => 1,
                        'result'    => 1
		);
	
		return array( $validUser, $invalidUser, $okUser );
	}
}

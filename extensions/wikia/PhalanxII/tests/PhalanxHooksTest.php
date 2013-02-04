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
	 * @dataProvider testPhalanxUserBlock
	 */
	public function testPhalanxUserBlock( $isAnon, $userName, $block, $result ) {		
		// valid User Mock
		$userMock = $this->getMock( 'User', array( 'isAnon', 'getName' ) ); 
		$userMock
			->expects( $this->once() )
			->method( 'isAnon' )
			->will( $this->returnValue( $isAnon ) );
		$userMock
			->expects( $this->once() )
			->method( 'getName' )
			->will( $this->returnValue( $userName ) );
		
		$modelMock = $this->getMock( 'PhalanxUserModel', array('match') );
		$modelMock
			->expects( $this->once() )
			->method( 'match' )
			->will( $this->returnValue( $block ) );
		
		$this->proxyClass( 'PhalanxUserModel', $modelMock );
		
		$hook = new PhalanxUserBlock();
		$this->assertEquals( $result, $hook->blockCheck( $userMock ) );
	}
	
	public function phalanxUserBlockDataProvider() {
		/* valid user */
		$validUser = array(
			'isAnon'    => false,
			'getName'   => self::VALID_USERNAME,
			'block'     => 0,
			'result'    => true
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
			'result'    => true
		);
	
		return array( $validUser, $invalidUser );
	}
}

<?php

define( 'NS_UNITTEST', 5600 );
define( 'NS_UNITTEST_TALK', 5601 );

/**
 * @group Database
 */
class UserTest extends MediaWikiTestCase {
	protected $savedGroupPermissions, $savedRevokedPermissions;

	/**
	 * @var User
	 */
	protected $user;

	public function setUp() {
		parent::setUp();

		$this->setUpUser();
	}
	private function setUpUser() {
		$this->user = new User;
	}

	public function tearDown() {
		parent::tearDown();
	}

	/**
	 * @dataProvider provideUserNames
	 */
	public function testIsValidUserName( $username, $result, $message ) {
		$this->assertEquals( $this->user->isValidUserName( $username ), $result, $message );
	}

	public function provideUserNames() {
		return array(
			array( '', false, 'Empty string' ),
			array( ' ', false, 'Blank space' ),
			array( 'abcd', false, 'Starts with small letter' ),
			array( 'Ab/cd', false,  'Contains slash' ),
			array( 'Ab cd' , true, 'Whitespace' ),
			array( '192.168.1.1', false,  'IP' ),
			array( 'User:Abcd', false, 'Reserved Namespace' ),
			array( '12abcd232' , true  , 'Starts with Numbers' ),
			array( '?abcd' , true,  'Start with ? mark' ),
			array( '#abcd', false, 'Start with #' ),
			array( 'Abcdകഖഗഘ', true,  ' Mixed scripts' ),
			array( 'ജോസ്‌തോമസ്',  false, 'ZWNJ- Format control character' ),
			array( 'Ab　cd', false, ' Ideographic space' ),
		);
	}
}

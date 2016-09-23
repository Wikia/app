<?php

class PhalanxUserModelTest extends WikiaBaseTest {

	const USER_NAME = 'Foo_Bar';
	const IP = '1.2.3.4';
	const EMAIL = 'foo@bar.net';

	/***
	 * setup tests
	 */
	public function setUp() {
		$this->setupFile = __DIR__ . '/../Phalanx_setup.php';
		parent::setUp();
	}

	public function testGetText() {
		$user = $this->mockClassWithMethods( 'User', [
			'getName' => self::USER_NAME
		]);
		$this->mockGlobalVariable( 'wgRequest', $this->mockClassWithMethods( 'WebRequest', [
			'getIp' => self::IP
		]) );

		$model = new PhalanxUserModel( $user );
		$this->assertEquals( [ self::USER_NAME, self::IP ], $model->getText(), 'IP address should be passed to Phalanx' );

		# SUS-141: we're only checking if the user is blocked, but do not want to perform any action here
		$model = new PhalanxUserModel( $user );
		$model->setShouldLogInStats( false );
		$this->assertEquals( [ self::USER_NAME ], $model->getText(), 'IP address should not be passed to Phalanx' );

		# check email block
		$model = new PhalanxUserModel( $user );
		$model->setText( self::EMAIL );
		$this->assertEquals( self::EMAIL, $model->getText(), 'Email should be passed to Phalanx' );
	}
}

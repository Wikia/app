<?php

use Wikia\Service\Helios\ClientException;
use Wikia\DependencyInjection\Injector;

class UserPasswordTest extends WikiaBaseTest
{

	const TEST_USER_ID = 5;

	/** @var User */
	protected $testUser;

	protected static $currentInjector;

	public static function setUpBeforeClass() {
		self::$currentInjector = Injector::getInjector();
	}

	public function setUp() {
		parent::setUp();
		$this->testUser = User::newFromId( self::TEST_USER_ID );
	}

	public static function tearDownAfterClass() {
		Injector::setInjector( self::$currentInjector );
	}

	public function testShouldSetNewPassword() {
		$this->assertTrue( $this->testUser->setPassword( "ok" ) );
	}

	/**
	 * @expectedException PasswordError
	 * @expectedExceptionMessage There was either an authentication database error or you are not allowed to update your external account.
	 */
	public function testShouldNotSetEmptyPassword() {
		$this->assertTrue( $this->testUser->setPassword( "" ) );
	}

	/**
	 * @expectedException PasswordError
	 * @expectedExceptionMessage There was either an authentication database error or you are not allowed to update your external account.
	 */
	public function testShouldNotSetNewPasswordEqualToUsername() {
		$this->assertTrue( $this->testUser->setPassword( $this->testUser->getName() ) );
	}

	public function testShouldNotSetNewPasswordForBlockedUser() {
		$nameBkp = $this->testUser->getName();
		$this->testUser->setName( "Useruser" );
		$this->assertEquals( "password-login-forbidden", $this->testUser->getPasswordValidity( "Passpass" )->errors[0]->description );
		$this->testUser->setName( $nameBkp );
	}
}

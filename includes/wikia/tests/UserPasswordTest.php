<?php

use Wikia\Service\Helios\ClientException;
use Wikia\Service\Helios\HeliosClient;
use Wikia\DependencyInjection\Injector;

class UserPasswordTest extends WikiaBaseTest {

	const TEST_USER_ID = 4;

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
		$this->assertTrue( $this->testUser->setPassword( 'goodpassword123' ) );
	}

	public function testShouldDeletePassword() {
		$password = "fhsdakljhasfdhjjfdjh2345";
		$this->testUser->setPassword( $password );
		$this->assertTrue( $this->testUser->setPassword( null ) );
		$this->assertEquals(
			'401',
			Injector::getInjector()->get( HeliosClient::class )
				->login( $this->testUser->getName(), $password )[0]
		);
	}

	/**
	 * @expectedException PasswordError
	 * @expectedExceptionMessage Passwords must be at least $1 characters.
	 */
	public function testShouldNotSetEmptyPassword() {
		$this->assertTrue( $this->testUser->setPassword( '' ) );
	}

	/**
	 * @expectedException PasswordError
	 * @expectedExceptionMessage Your password must be different from your username.
	 */
	public function testShouldNotSetNewPasswordEqualToUsername() {
		$this->assertTrue( $this->testUser->setPassword( $this->testUser->getName() ) );
	}

	public function testShouldReturnPasswordIsTooShort() {
		$this->assertEquals( 'passwordtooshort', $this->testUser->getPasswordValidity( '' ) );
	}

	public function testShouldReturnOkay() {
		$this->assertTrue( $this->testUser->getPasswordValidity( 'abc' ) );
	}

	public function testRefuseToSetPasswordLikeUsername() {
		$this->testUser->setName( 'johnkrasinsky' );
		$this->assertEquals( 'password-name-match', $this->testUser->getPasswordValidity( 'johnKRasinsky' ) );
	}
}

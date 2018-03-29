<?php

/**
 * @group Integration
 */
class EmailConfirmationControllerIntegrationTest extends WikiaDatabaseTest {
	const VALID_EMAIL_TOKEN = 'jozsefattila';
	const VALID_EMAIL_TOKEN_USER_ID = 12;
	const EMAIL_TO_CONFIRM = 'jkowalski@example.com';
	const OTHER_USER_ID = 13;

	/** @var RequestContext $requestContext */
	private $requestContext;

	/** @var EmailConfirmationController $emailConfirmationController */
	private $emailConfirmationController;

	protected function setUp() {
		parent::setUp();

		$this->requestContext = new RequestContext();

		$this->emailConfirmationController = new EmailConfirmationController();
		$this->emailConfirmationController->setContext( $this->requestContext );
		$this->emailConfirmationController->setResponse( new WikiaResponse( WikiaResponse::FORMAT_INVALID ) );
	}

	public function testGetRequestIsRejected() {
		$this->requestContext->setRequest( new FauxRequest( [ 'token' => static::VALID_EMAIL_TOKEN ] ) );
		$this->requestContext->setUser( User::newFromId( static::VALID_EMAIL_TOKEN_USER_ID ) );

		$this->emailConfirmationController->postEmailConfirmation();

		$this->assertEquals( 405, $this->emailConfirmationController->getResponse()->getCode() );
		$this->assertEquals(
			WikiaResponse::FORMAT_JSON,
			$this->emailConfirmationController->getResponse()->getFormat()
		);

		$this->assertFalse(
			$this->requestContext->getUser()->isEmailConfirmed(),
			'User\'s email should not have been confirmed'
		);

		$this->assertTrue(
			$this->requestContext->getUser()->isEmailConfirmationPending(),
			'User\'s email confirmation should still be pending'
		);
	}

	public function testTokenParameterIsRequired() {
		$this->requestContext->setRequest( new FauxRequest( [], true ) );
		$this->requestContext->setUser( User::newFromId( static::VALID_EMAIL_TOKEN_USER_ID ) );

		$this->emailConfirmationController->postEmailConfirmation();

		$this->assertEquals( 400, $this->emailConfirmationController->getResponse()->getCode() );
		$this->assertEquals(
			WikiaResponse::FORMAT_JSON,
			$this->emailConfirmationController->getResponse()->getFormat()
		);

		$this->assertFalse(
			$this->requestContext->getUser()->isEmailConfirmed(),
			'User\'s email should not have been confirmed'
		);

		$this->assertTrue(
			$this->requestContext->getUser()->isEmailConfirmationPending(),
			'User\'s email confirmation should still be pending'
		);

		$this->assertEquals( static::EMAIL_TO_CONFIRM, $this->requestContext->getUser()->getNewEmail() );
		$this->assertEmpty( $this->requestContext->getUser()->getEmail() );
	}

	public function testTokenMustExist() {
		$this->requestContext->setRequest( new FauxRequest( [ 'token' => 'ojej123' ], true ) );
		$this->requestContext->setUser( User::newFromId( static::VALID_EMAIL_TOKEN_USER_ID ) );

		$this->emailConfirmationController->postEmailConfirmation();

		$this->assertEquals( 404, $this->emailConfirmationController->getResponse()->getCode() );
		$this->assertEquals(
			WikiaResponse::FORMAT_JSON,
			$this->emailConfirmationController->getResponse()->getFormat()
		);

		$this->assertFalse(
			$this->requestContext->getUser()->isEmailConfirmed(),
			'User\'s email should not have been confirmed'
		);

		$this->assertTrue(
			$this->requestContext->getUser()->isEmailConfirmationPending(),
			'User\'s email confirmation should still be pending'
		);

		$this->assertEquals( static::EMAIL_TO_CONFIRM, $this->requestContext->getUser()->getNewEmail() );
		$this->assertEmpty( $this->requestContext->getUser()->getEmail() );
	}

	public function testTokenMustBeValidForCurrentUser() {
		$this->requestContext->setRequest( new FauxRequest( [ 'token' => static::VALID_EMAIL_TOKEN ], true ) );
		$this->requestContext->setUser( User::newFromId( static::OTHER_USER_ID ) );

		$this->emailConfirmationController->postEmailConfirmation();

		$this->assertEquals( 401, $this->emailConfirmationController->getResponse()->getCode() );
		$this->assertEquals(
			WikiaResponse::FORMAT_JSON,
			$this->emailConfirmationController->getResponse()->getFormat()
		);
	}

	public function testEmailIsConfirmedWhenValidTokenPostedForUser() {
		$this->requestContext->setRequest( new FauxRequest( [ 'token' => static::VALID_EMAIL_TOKEN ], true ) );
		$this->requestContext->setUser( User::newFromId( static::VALID_EMAIL_TOKEN_USER_ID ) );

		$this->emailConfirmationController->postEmailConfirmation();

		$this->assertEquals( 200, $this->emailConfirmationController->getResponse()->getCode() );
		$this->assertEquals(
			WikiaResponse::FORMAT_JSON,
			$this->emailConfirmationController->getResponse()->getFormat()
		);

		$this->assertTrue(
			$this->requestContext->getUser()->isEmailConfirmed(),
			'User\'s email should have been confirmed'
		);

		$this->assertFalse(
			$this->requestContext->getUser()->isEmailConfirmationPending(),
			'User\'s email confirmation should no longer be pending'
		);

		$this->assertEmpty( $this->requestContext->getUser()->getNewEmail() );
		$this->assertEquals( static::EMAIL_TO_CONFIRM, $this->requestContext->getUser()->getEmail() );
	}

	protected function getDataSet() {
		return $this->createYamlDataSet( __DIR__ . '/fixtures/email_confirmation.yaml' );
	}
}

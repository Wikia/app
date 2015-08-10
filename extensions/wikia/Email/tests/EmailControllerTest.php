<?php

use Wikia\Util\GlobalStateWrapper;

class EmailController extends \Email\EmailController {
	public function assertValidFromAddress( $email ) {
		return parent::assertValidFromAddress( $email );
	}

	public function getSubject() {
	}
}

class EmailControllerTest extends WikiaBaseTest {
	function setUp() {
		$this->setupFile = __DIR__ . '/../Email.setup.php';
		parent::setUp();
	}

	function testAssertValidFromAddressInvalidEmail() {
		$this->setExpectedException( '\Email\Check', 'Invalid from address' );
		$obj = new EmailController;
		$obj->assertValidFromAddress( 'invalid email' );
	}

	function testAssertValidFromAddressValidEmail() {
		$obj = new EmailController;
		$this->assertTrue( $obj->assertValidFromAddress( 'valid@email.com' ) );
	}

	function testAssertCanAccessControllerSuccess() {
		$token = 'a-token';
		$request = new \WikiaRequest(array('token' => $token));
		$controller = new \Email\Controller\ForgotPasswordController();
		$controller->setRequest($request);

		$wrapper = new GlobalStateWrapper( [
			'wgTheSchwartzSecretToken' => $token
			] );

		$result = $wrapper->wrap( function() use ( $controller ) {
			return $controller->assertCanAccessController();
		});

		$this->assertTrue(!isset($result));
	}


	/**
	 *
	 * @@expectedException \Email\Fatal
	 */
	function testAssertCanAccessControllerFail() {
		$token = 'a-token';
		$request = new \WikiaRequest(array('token' => $token));
		$controller = new \Email\Controller\ForgotPasswordController();
		$controller->setRequest($request);

		$wrapper = new GlobalStateWrapper( [
			'wgTheSchwartzSecretToken' => 'something-different'
			] );

		$result = $wrapper->wrap( function() use ( $controller ) {
			return $controller->assertCanAccessController();
		});

		$this->assertTrue(!isset($result));
	}

}

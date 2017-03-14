<?php

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

	/**
	 * @expectedException \Email\Check
	 * @expectedExceptionMessage Invalid from address
	 */
	function testAssertValidFromAddressInvalidEmail() {
		$obj = new EmailController;
		$obj->assertValidFromAddress( 'invalid email' );
	}

	function testAssertValidFromAddressValidEmail() {
		$obj = new EmailController;
		$this->assertTrue( $obj->assertValidFromAddress( 'valid@email.com' ) );
	}

}

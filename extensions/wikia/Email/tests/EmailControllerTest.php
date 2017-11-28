<?php

use PHPUnit\Framework\TestCase;

class EmailControllerTest extends TestCase {

	protected function setUp() {
		parent::setUp();
		$this->markTestSkipped( 'This test is testing protected method' );
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

<?php

namespace ValueValidators\Tests;

use ValueValidators\DimensionValidator;

/**
 * @covers ValueValidators\DimensionValidator
 *
 * @group ValueValidators
 * @group DataValueExtensions
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class DimensionValidatorTest extends \PHPUnit_Framework_TestCase {

	/**
	 * @var DimensionValidator
	 */
	private $validator;

	public function setUp() {
		$this->validator = new DimensionValidator();
	}

	public function testWhenAutoIsNotAllowed_autoIsNotValid() {
		$this->validator->setAllowAuto( false );
		$this->assertIsNotValid( 'auto' );
	}

	private function assertIsNotValid( $value ) {
		$this->assertFalse( $this->validator->validate( $value )->isValid() );
	}

	public function testWhenAutoIsAllowed_autoIsValid() {
		$this->validator->setAllowAuto( true );
		$this->assertIsValid( 'auto' );
	}

	private function assertIsValid( $value ) {
		$this->assertTrue( $this->validator->validate( $value )->isValid() );
	}

	public function testUsingDefaultSettings_pxIsAllowed() {
		$this->assertIsValid( '100px' );
	}

	public function testUsingDefaultSettings_NoUnitIsAllowed() {
		$this->assertIsValid( '100' );
	}

	public function testGivenUpperBound_valueUnderIsValid() {
		$this->validator->setUpperBound( 100 );
		$this->assertIsValid( '99' );
	}

	public function testGivenUpperBound_valueEqualIsValid() {
		$this->validator->setUpperBound( 100 );
		$this->assertIsValid( '100' );
	}

	public function testGivenUpperBound_valueOverIsInvalid() {
		$this->validator->setUpperBound( 100 );
		$this->assertIsNotValid( '101' );
	}

	public function testUsingDefaultSettings_percentageIsNotValid() {
		$this->assertIsNotValid( '50%' );
	}

	public function testWhenPercentageInUnitList_percentageValid() {
		$this->validator->setAllowedUnits( array( 'px', '%' ) );
		$this->assertIsValid( '50%' );
	}

	public function testGivenLowerPercentageBound_valueOverIsValid() {
		$this->validator->setAllowedUnits( array( '%' ) );
		$this->validator->setMinPercentage( 50 );
		$this->assertIsValid( '51%' );
	}

	public function testGivenLowerPercentageBound_valueEqualIsValid() {
		$this->validator->setAllowedUnits( array( '%' ) );
		$this->validator->setMinPercentage( 50 );
		$this->assertIsValid( '50%' );
	}

	public function testGivenLowerPercentageBound_valueUnderIsNotValid() {
		$this->validator->setAllowedUnits( array( '%' ) );
		$this->validator->setMinPercentage( 50 );
		$this->assertIsNotValid( '49%' );
	}

	public function testInvalidValuesAreInvalid() {
		$this->assertIsNotValid( '' );
		$this->assertIsNotValid( 'a' );
		$this->assertIsNotValid( '1a' );
		$this->assertIsNotValid( '1px2' );
		$this->assertIsNotValid( 'a1px' );
	}

}

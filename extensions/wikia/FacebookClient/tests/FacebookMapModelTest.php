<?php

/**
 * FacebookMapModel test
 *
 * Testing the models non-static interface
 *
 * @category Wikia
 * @group Facebook
 */
class FacebookMapModelTest extends WikiaBaseTest {
	/**
	 * @dataProvider mappingIdProvider
	 */
	public function testCreateValid( $wikiaUserId, $facebookUserId ) {
		/** @var PHPUnit_Framework_MockObject_MockObject|FacebookMapModel $mockMap */
		$mockMap = $this->getMock( 'FacebookMapModel', [ 'saveToDatabase' ] );
		$mockMap->expects( $this->once() )
			->method( 'saveToDatabase' );

		$mockMap->relate( $wikiaUserId, $facebookUserId );

		$mockMap->save();
	}

	public function mappingIdProvider() {
		return [
			[ 123, 987 ]
		];
	}

	/**
	 * @dataProvider badIdProvider
	 * @expectedException FacebookMapModelInvalidDataException
	 */
	public function testCreateBadID( $wikiaUserId, $facebookUserId ) {
		/** @var PHPUnit_Framework_MockObject_MockObject|FacebookMapModel $mockMap */
		$mockMap = $this->getMock( 'FacebookMapModel', [ 'saveToDatabase' ] );
		$mockMap->expects( $this->never() )
			->method( 'saveToDatabase' );
		$mockMap->expects( $this->never() )
			->method( 'saveToCache' );

		$mockMap->relate( $wikiaUserId, $facebookUserId );
		$mockMap->save();
	}

	public function badIdProvider() {
		return [
			[ null, 987 ],
			[ 123, null ],
			[ 123, 0 ],
			[ 0, 0 ],
			[ '', '' ],
		];
	}
}

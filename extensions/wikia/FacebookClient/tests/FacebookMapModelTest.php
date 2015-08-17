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

	public function setUp() {
		// Don't get screwed if someone else doesn't clean up Memc
		F::app()->wg->Memc = wfGetMainCache();
	}

	public function tearDown() {
		// Don't screw anyone else
		F::app()->wg->Memc = wfGetMainCache();
	}

	/**
	 * @dataProvider mappingIdProvider
	 */
	public function testCreateValid( $wikiaUserId, $facebookUserId ) {
		/** @var PHPUnit_Framework_MockObject_MockObject|FacebookMapModel $mockMap */
		$mockMap = $this->getMock( 'FacebookMapModel', [ 'saveToDatabase' ] );
		$mockMap->expects( $this->once() )
			->method( 'saveToDatabase' );

		$mockMap->relate( $wikiaUserId, $facebookUserId );

		// Intercept the call to memcache's set and make sure its passed our object
		self::setupMockWriteCache( $mockMap );

		$mockMap->save();
	}

	public function mappingIdProvider() {
		return [
			[ 123, 987 ]
		];
	}

	protected function setupMockWriteCache( $object ) {

		// mock cache
		$mockCache = $this->getMock( 'stdClass', [ 'get', 'set', 'delete' ] );
		$mockCache->expects( $this->never() )
			->method( 'get' );
		$mockCache->expects( $this->exactly( 2 ) )
			->method( 'set' )
			->with( $this->anything(), $object );
		$mockCache->expects( $this->never() )
			->method( 'delete' );

		$this->mockGlobalVariable( 'wgMemc', $mockCache );
	}

	/**
	 * @dataProvider badIdProvider
	 * @expectedException FacebookMapModelInvalidDataException
	 */
	public function testCreateBadID( $wikiaUserId, $facebookUserId ) {
		self::setupMockUnusedCache();

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

	protected function setupMockUnusedCache() {

		// mock cache
		$mockCache = $this->getMock( 'stdClass', [ 'get', 'set', 'delete' ] );
		$mockCache->expects( $this->never() )
			->method( 'get' );
		$mockCache->expects( $this->never() )
			->method( 'set' );
		$mockCache->expects( $this->never() )
			->method( 'delete' );

		$this->mockGlobalVariable( 'wgMemc', $mockCache );
	}
}
<?php

/**
 * FacebookMapModelIntegrationTest
 *
 * Database and Memcache integration tests
 *
 * @category Wikia
 * @group UsingDB
 * @group Facebook
 * @group Broken
 */

class FacebookMapModelIntegrationTest extends WikiaBaseTest {

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
	public function testMemcachedWikiaCRUD( $wikiaUserId, $facebookUserId ) {
		/** @var PHPUnit_Framework_MockObject_MockObject|FacebookMapModel $mockMap */
		$mockMap = $this->getMock( 'FacebookMapModel', [ 'saveToDatabase' ] );
		$mockMap->expects( $this->once() )
			->method( 'saveToDatabase' );

		// CREATE
		$mockMap->relate( $wikiaUserId, $facebookUserId );
		$mockMap->save();

		// READ
		$this->assertTrue(
			FacebookMapModel::hasUserMapping( $wikiaUserId, $facebookUserId ),
			'Mapping does not exist'
		);

		$map = FacebookMapModel::lookupFromWikiaID( $wikiaUserId );
		$this->assertNotEmpty( $map, 'Object not found in memcache' );
		$this->assertEquals( $wikiaUserId, $map->getWikiaUserId(), 'Wikia user ID does not match' );
		$this->assertEquals( $facebookUserId, $map->getFacebookUserId(), 'Facebook user ID does not match' );

		// DELETE
		FacebookMapModel::deleteFromWikiaID( $wikiaUserId );
		$map = FacebookMapModel::lookupFromWikiaID( $wikiaUserId );
		$this->assertEmpty( $map, 'Object still found in memcache after delete' );
	}

	/**
	 * @dataProvider mappingIdProvider
	 */
	public function testMemcachedFacebookCRUD( $wikiaUserId, $facebookUserId ) {
		/** @var PHPUnit_Framework_MockObject_MockObject|FacebookMapModel $mockMap */
		$mockMap = $this->getMock( 'FacebookMapModel', [ 'saveToDatabase' ] );
		$mockMap->expects( $this->once() )
			->method( 'saveToDatabase' );

		// CREATE
		$mockMap->relate( $wikiaUserId, $facebookUserId );
		$mockMap->save();

		// READ
		$this->assertTrue(
			FacebookMapModel::hasUserMapping( $wikiaUserId, $facebookUserId ),
			'Mapping does not exist'
		);

		$map = FacebookMapModel::lookupFromFacebookID( $facebookUserId );
		$this->assertNotEmpty( $map, 'Object not found in memcache' );
		$this->assertEquals( $wikiaUserId, $map->getWikiaUserId(), 'Wikia user ID does not match' );
		$this->assertEquals( $facebookUserId, $map->getFacebookUserId(), 'Facebook user ID does not match' );

		// DELETE
		FacebookMapModel::deleteFromFacebookID( $facebookUserId );
		$map = FacebookMapModel::lookupFromFacebookID( $facebookUserId );
		$this->assertEmpty( $map, 'Object still found in memcache after delete' );
	}

	/**
	 * @dataProvider mappingIdProvider
	 */
	public function testDBWikiaCRUD( $wikiaUserId, $facebookUserId ) {
		self::setupMockCache();

		/** @var PHPUnit_Framework_MockObject_MockObject|FacebookMapModel $mockMap */
		$mockMap = $this->getMock( 'FacebookMapModel', [ 'saveToCache' ] );
		$mockMap->expects( $this->once() )
			->method( 'saveToCache' );

		// CREATE
		$mockMap->relate( $wikiaUserId, $facebookUserId );
		$mockMap->save();

		// READ
		$this->assertTrue(
			FacebookMapModel::hasUserMapping( $wikiaUserId, $facebookUserId ),
			'Mapping does not exist'
		);

		$map = FacebookMapModel::lookupFromWikiaID( $wikiaUserId );
		$this->assertNotEmpty( $map, 'Object not found in memcache' );
		$this->assertEquals( $wikiaUserId, $map->getWikiaUserId(), 'Wikia user ID does not match' );
		$this->assertEquals( $facebookUserId, $map->getFacebookUserId(), 'Facebook user ID does not match' );

		// DELETE
		FacebookMapModel::deleteFromWikiaID( $wikiaUserId );
		$map = FacebookMapModel::lookupFromWikiaID( $wikiaUserId );
		$this->assertEmpty( $map, 'Object still found in memcache after delete' );
	}

	/**
	 * @dataProvider mappingIdProvider
	 */
	public function testDBFacebookCRUD( $wikiaUserId, $facebookUserId ) {
		self::setupMockCache();

		/** @var PHPUnit_Framework_MockObject_MockObject|FacebookMapModel $mockMap */
		$mockMap = $this->getMock( 'FacebookMapModel', [ 'saveToCache' ] );
		$mockMap->expects( $this->once() )
			->method( 'saveToCache' );

		// CREATE
		$mockMap->relate( $wikiaUserId, $facebookUserId );
		$mockMap->save();

		// READ
		$this->assertTrue(
			FacebookMapModel::hasUserMapping( $wikiaUserId, $facebookUserId ),
			'Mapping does not exist'
		);

		$map = FacebookMapModel::lookupFromFacebookID( $facebookUserId );
		$this->assertNotEmpty( $map, 'Object not found in memcache' );
		$this->assertEquals( $wikiaUserId, $map->getWikiaUserId(), 'Wikia user ID does not match' );
		$this->assertEquals( $facebookUserId, $map->getFacebookUserId(), 'Facebook user ID does not match' );

		// DELETE
		FacebookMapModel::deleteFromFacebookID( $facebookUserId );
		$map = FacebookMapModel::lookupFromFacebookID( $facebookUserId );
		$this->assertEmpty( $map, 'Object still found in memcache after delete' );
	}

	protected function setupMockCache( ) {

		// mock cache
		$mockCache = $this->getMock( 'stdClass', [ 'get', 'set', 'delete' ] );
		$mockCache->expects( $this->any() )
			->method( 'get' )
			->willReturn( null );
		$mockCache->expects( $this->any() )
			->method( 'set' );
		$mockCache->expects( $this->any() )
			->method( 'delete' );

		$this->mockGlobalVariable( 'wgMemc', $mockCache );
	}

	public function mappingIdProvider() {
		return [
			[ 123, 987 ],
			[ 23910423, 1506379856279184 ],
		];
	}


}
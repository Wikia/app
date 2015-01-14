<?php

/**
 * Videos Module test
 *
 * @category Wikia
 * @group UsingDB
 * @group MediaFeatures
 */
class VideosModuleTest extends WikiaBaseTest {

	const TEST_CITY_ID = 79860;
	const USER_REGION = "US";
	protected static $videoBlacklist = [ 'Basic_Instinct_The_Leg_Cross', 'WWE_Divas_Undressed_(2002)_-_Trailer' ];

	public function setUp() {
		$this->setupFile = dirname(__FILE__) . '/../VideosModule.setup.php';
		parent::setUp();
	}

	/**
	 * Currently unused, but could be useful in the future so keeping it around.
	 */
	protected function setUpMockCache() {

		// mock cache
		$mock_cache = $this->getMock( 'stdClass', [ 'get', 'set', 'delete' ] );
		$mock_cache->expects( $this->any() )
					->method('get')
					->will( $this->returnValue( null ) );
		$mock_cache->expects( $this->any() )
					->method( 'set' );
		$mock_cache->expects( $this->any())
					->method( 'delete' );

		$this->mockGlobalVariable( 'wgMemc', $mock_cache );

		$this->mockGlobalVariable( 'wgCityId', self::TEST_CITY_ID );
	}

	public function testIsBlackListed() {
		$module = new VideosModule\Modules\Category( self::USER_REGION );

		// Mock the blacklist so that it doesn't depend on changes to the wgVideosModuleBlackList global
		$reflection = new ReflectionClass( $module );
		$blackListProp = $reflection->getProperty( 'blacklist' );
		$blackListProp->setAccessible( true );
		$blackListProp->setValue( $module, [ self::$videoBlacklist[0] ] );

		$blackListedVideo = [ 'title' => self::$videoBlacklist[0] ];
		$this->assertTrue( $module->isBlackListed( $blackListedVideo ) );

		$nonBlackListedVideo = [ 'title' => 'A_Very_Agreeable_Video' ];
		$this->assertFalse( $module->isBlackListed( $nonBlackListedVideo ) );
	}

	public function testIsRegionallyRestricted() {
		$module = new VideosModule\Modules\Category( self::USER_REGION );

		$videoWithRestrictionsEU = [ "regionalRestrictions" => "GB, DE" ];
		$videoWithRestrictionsNA = [ "regionalRestrictions" => "CA, US" ];
		$videoWithoutRestrictions = null;

		// Test that a video with regional restrictions and a user in a different region comes back as restricted
		$this->assertTrue( $module->isRegionallyRestricted( $videoWithRestrictionsEU ) );

		// Test that a video with regional restrictions and a user in one of those regions comes back as
		// not restricted
		$this->assertFalse( $module->isRegionallyRestricted( $videoWithRestrictionsNA ) );

		// Test that a video without any regional restrictions comes back as not restricted
		$this->assertFalse( $module->isRegionallyRestricted( $videoWithoutRestrictions ) );
	}

	/**
	 * Test that category names used by videos module are transformed properly
	 * into database names (underscores instead of spaces)
	 */
	public function testTransformCatNames() {
		$module = new VideosModule\Modules\Category( self::USER_REGION );

		$reflection = new ReflectionClass( $module );
		$tranformCatNames = $reflection->getMethod( 'transformCatNames' );
		$tranformCatNames->setAccessible( true );

		$categoryNames = [ "The Hobbit", "The Wiggles Movie" ];
		$databaseNames = [ "The_Hobbit", "The_Wiggles_Movie" ];

		// Test that names without underscores are transformed properly
		$result = $tranformCatNames->invoke( $module, $categoryNames );
		$this->assertEquals( $databaseNames[0], $result[0] );
		$this->assertEquals( $databaseNames[1], $result[1] );

		// Test that names with underscores are not affected
		$result = $tranformCatNames->invoke( $module, $databaseNames );
		$this->assertEquals( $databaseNames[0], $result[0] );
		$this->assertEquals( $databaseNames[1], $result[1] );
	}
}


<?php

/**
 * Class VideoPageToolAssetTest
 *
 * These tests expect to be run against a wiki that has the Video Page Tool extension enabled and, with that,
 * the appropriate DB tables.
 *
 * @group Integration
 */
class VideoPageToolAssetTest extends WikiaBaseTest {

	/** @var VideoPageToolProgram */
	protected $program;
	protected $programID;
	protected $origMemc;

	public function setUp() {

		$this->setupFile = dirname(__FILE__) . '/../VideoPageTool.setup.php';
		parent::setUp();

		$mock_user = $this->getMock( 'User', [ 'getId', 'getName' ]);
		$mock_user->expects( $this->any() )
			->method( 'getId' )
			->will( $this->returnValue( 123 ) );

		$mock_user->expects( $this->any() )
			->method( 'getName' )
			->will( $this->returnValue( 'Garthwebb' ) );

		$this->mockGlobalVariable('wgUser', $mock_user);

		$this->mockStaticMethod( 'User', 'newFromId', $mock_user );

		/*
		 * That's pretty bad, as we will return master db connection for all wfGetDB calls, even those for slave and
		 * dataware. But as for now mockGlobalFunction does not support PHPUnit's callbacks and returnValueArray
		 */
		$slaveDb = wfGetDB( DB_MASTER, [], 'video151' );
		$this->mockGlobalFunction('wfGetDB', $slaveDb);

		$language = 'en';
		$date = 158486400; // This is Jan 9th, 1975 a date suitably far in the past but doing well for its age thank you very much

		$this->program = VideoPageToolProgram::newProgram( $language, $date );
		// If a previous test faield and didn't clean itself up, clean up now.  This includes
		// deleting related assets and clearing their caches
		if ( $this->program->exists() ) {
			$cascade = true;
			$this->program->delete( $cascade );
			$this->program = VideoPageToolProgram::newProgram( $language, $date );
		}

		if ( empty($this->program) ) {
			throw new Exception("Failed to load program with lang=$language and date=$date");
		}

		// Save this program to get a program ID
		$status = $this->program->save();
		if ( !$status->isGood() ) {
			throw new Exception("Failed to save program with lang=$language and date=$date");
		}

		$this->programID = $this->program->getProgramId();
	}

	/**
	 * Create a memcached client that always returns false, e.g. nothing is cached
	 */
	protected function disableMemcached() {
		global $wgMemc;

		$this->origMemc = $wgMemc;

		$mock_cache = $this->getMock( 'stdClass', array( 'set', 'delete', 'get' ) );
		$mock_cache->expects( $this->any() )
			->method( 'set' );
		$mock_cache->expects( $this->any() )
			->method( 'delete' );
		$mock_cache->expects( $this->any() )
			->method( 'get' )
			->will( $this->returnValue( false ) );

		$this->mockGlobalVariable( 'wgMemc', $mock_cache );
	}

	protected function enableMemcached() {
		$this->mockGlobalVariable( 'wgMemc', $this->origMemc );
	}

	/**
	 * @dataProvider CRUDAssetData
	 */
	public function testCRUDAsset( $type, $order, $data ) {
		$section = $type::SECTION;

		/**
		 * Create and save the object
		 */

		// Check creation
		$asset = VideoPageToolAsset::newAsset( $this->programID, $section, $order );

		$this->assertInstanceOf( $type, $asset, "Failed to create new $type object" );

		$asset->setData( $data );

		global $wgUser;
		$asset->setUpdatedBy( $wgUser->getId() );

		$status = $asset->save();

		$this->assertTrue( $status->isGood(), 'Failed to save new $type object' );
		$this->assertInternalType( 'integer', $asset->getAssetId(), 'Result of getAssetId is not an integer' );
		$this->assertGreaterThan( 0, $asset->getAssetId(), 'Asset ID is not greater than zero');

		// Make sure we can get the program
		$program = $asset->getProgram();

		$this->assertTrue( $program instanceof VideoPageToolProgram, 'Did not get a program object back from getProgram' );

		/**
		 * Check loading the object from cache
		 */

		$memcLoadedAsset = VideoPageToolAsset::newAsset( $this->programID, $section, $order );
		$this->assertEquals( $asset->getAssetId(), $memcLoadedAsset->getAssetId(), "Not able to load saved asset" );

		// Check getters
		$this->assertEquals( $this->programID, $memcLoadedAsset->getProgramId(), 'Got wrong program ID' );
		$this->assertEquals( $section, $memcLoadedAsset->getSection(), 'Got wrong section name' );
		$this->assertEquals( $order, $memcLoadedAsset->getOrder(), 'Got wrong order number');

		// Check for default data
		$defaultAssetData = $memcLoadedAsset->getDefaultAssetData();
		$this->assertNotNull( $defaultAssetData, 'No default data present' );

		// Get the data
		$assetData = $memcLoadedAsset->getAssetData();

		// Note that $assetData will always be the classes default data since the test data
		// we're sending in does not name a valid video title
		$this->assertNotNull( $assetData, 'No asset data present' );

		// Check the asset data against what we saved
		foreach ( $data as $prop => $value ) {
			$this->assertObjectHasAttribute( $prop, $memcLoadedAsset );
			$this->assertAttributeEquals( $value, $prop, $memcLoadedAsset, "Attribute $prop has incorrect value" );
		}

		// Let slave catch up
		sleep(1);

		/**
		 * Check loading the object from database
		 */

		// Make sure memcache doesn't fulfill our request
		$this->disableMemcached();
		$dbLoadedAsset = VideoPageToolAsset::newAsset( $this->programID, $section, $order );
		$this->assertEquals( $asset->getAssetId(), $dbLoadedAsset->getAssetId(), "Not able to load saved asset" );

		// Check getters
		$this->assertEquals( $this->programID, $dbLoadedAsset->getProgramId(), 'Got wrong program ID' );
		$this->assertEquals( $section, $dbLoadedAsset->getSection(), 'Got wrong section name' );
		$this->assertEquals( $order, $dbLoadedAsset->getOrder(), 'Got wrong order number' );

		// Check for default data
		$defaultAssetData = $dbLoadedAsset->getDefaultAssetData();
		$this->assertNotNull( $defaultAssetData, 'No default data present' );

		// Get the data
		$assetData = $dbLoadedAsset->getAssetData();

		// Note that $assetData will always be the classes default data since the test data
		// we're sending in does not name a valid video title
		$this->assertNotNull( $assetData, 'No asset data present' );

		// Check the asset data against what we saved
		foreach ( $data as $prop => $value ) {
			$this->assertObjectHasAttribute( $prop, $dbLoadedAsset );
			$this->assertAttributeEquals( $value, $prop, $dbLoadedAsset, "Attribute $prop has incorrect value" );
		}

		// Check delete
		$this->enableMemcached();
		$status = $asset->delete();
		$this->assertTrue( $status->isGood(), 'Failed to delete new $type object' );

		$deletedAsset = VideoPageToolAsset::newAsset( $this->programID, $section, $order );
		$this->assertNull( $deletedAsset->getAssetId(), 'Unsuccessful delete' );
	}

	public function CRUDAssetData() {
		return [
			[ 'VideoPageToolAssetFeatured', 1,
				[
					'title'         => 'test_title',
					'displayTitle'  => 'Test Display Title',
					'description'   => 'This is a test description',
					'altThumbTitle' => 'Alternate Thumb Title',
				]
			],
			[ 'VideoPageToolAssetCategory', 2,
				[
					'categoryName' => 'test_category_name',
					'displayTitle' => 'Test Display Title',
				]
			],
		];
	}

	public function tearDown() {
		if ( !empty($this->program) ) {
			$this->program->delete();
		}
		parent::tearDown();
	}
}
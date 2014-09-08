<?php
/**
 * Class VideoThumbnailTest
 *
 * @group MediaFeatures
 */
class VideoThumbnailTest extends WikiaBaseTest {

	const TEST_CITY_ID = 79860;

	public function setUp() {
		$this->setupFile = dirname( __FILE__ ) . '/../VideoHandlers.setup.php';
		parent::setUp();
	}

	protected function setUpMock( $cache_value = false ) {
		$mock_cache = $this->getMock( 'stdClass', array( 'set', 'delete', 'get' ) );
		$mock_cache->expects( $this->any() )
					->method( 'set' );
		$mock_cache->expects( $this->any() )
					->method( 'delete' );
		$mock_cache->expects( $this->any() )
					->method( 'get' )
					->will( $this->returnValue( $cache_value ) );

		$this->mockGlobalVariable( 'wgMemc', $mock_cache );
		$this->mockGlobalVariable( 'wgCityId', self::TEST_CITY_ID );
	}

	/**
	 * @dataProvider durationDataProvider
	 */
	public function testDuration( $sec , $expResult ) {
		// setup
		$this->setUpMock();

		// test
		$responseData = WikiaFileHelper::formatDuration( $sec );

		$this->assertEquals( $expResult, $responseData );

	}

	public function durationDataProvider() {
		$sec1 = '';
		$expResult1 = '00:00';

		$sec2 = 0;
		$expResult2 = '00:00';

		$sec3 = 67;
		$expResult3 = '01:07';

		$sec4 = 3600;
		$expResult4 = '01:00:00';

		$sec5 = 5625;
		$expResult5 = '01:33:45';

		return array(
			array( $sec1, $expResult1 ),
			array( $sec2, $expResult2 ),
			array( $sec3, $expResult3 ),
			array( $sec4, $expResult4 ),
			array( $sec5, $expResult5 ),
		);
	}

}

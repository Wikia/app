<?php


class fakeResultGenerator {
	protected $dataId = 0;
	protected $limit = -1;

	public function __construct( $limit ) {
		$this->limit = $limit;
	}

	public function fetchObject() {
		if ( !$this->limit ) {
			return null;
		}

		if ( $this->limit > 0 ) {
			$this->limit--;
		}

		$row = new stdClass();
		$row->page_namespace = $this->dataId & 1;
		$row->page_title = "title_" . $this->dataId;
		$row->page_id = $this->dataId;
		$this->dataId++;

		return $row;
	}
}

class PopularArticlesModelTest extends WikiaBaseTest {
	protected static function getFn( $obj, $name ) {
		$class = new ReflectionClass(get_class( $obj ));
		$method = $class->getMethod( $name );
		$method->setAccessible( true );

		return function () use ( $obj, $method ) {
			$args = func_get_args();
			return $method->invokeArgs( $obj, $args );
		};
	}

	public function setUp() {
		$dir = dirname( __FILE__ ) . '/../../../';
		global $wgAutoloadClasses;
		$this->setupFile = $dir . 'HubRssFeed.setup.php';

		parent::setUp();
	}

	private function mockDbQuery( &$mockDb = null ) {
		$mockQueryResults = $this->getMock( "ResultWrapper", array( 'fetchObject' ), array(), '', false );

		$mockDb = $this->getDatabaseMock(array( 'query' ) );
		$mockDb->expects( $this->any() )->method( 'query' )->will( $this->returnValue( $mockQueryResults ) );

		$this->mockGlobalFunction( 'wfGetDb', $mockDb );

		return $mockQueryResults;
	}

	/*
	 * @covers PopularArticlesModel::getRecentlyEditedPageIds
	 */
	public function testRecentlyEditedPageIds_SkipMainPage() {
		$mock = $this->getMockBuilder( 'PopularArticlesModel' )
			->disableOriginalConstructor()
			->setMethods( [ '__construct', 'getRecentlyEditedPageResult' ] )
			->getMock();
		$mock->expects( $this->any() )
			->method( 'getRecentlyEditedPageResult' )
			->will( $this->returnValue( new fakeResultGenerator( 2 ) ) );

		$mockTitleMain = $this->getMockBuilder( 'Title' )
			->disableOriginalConstructor()
			->setMethods( [ '__construct', 'isMainPage' ] )
			->getMock();
		$mockTitleMain->expects( $this->any() )
			->method( 'isMainPage' )
			->will( $this->returnValue( true ) );

		$this->mockStaticMethod( 'Title', 'newFromText', $mockTitleMain );

		$fn = self::getFn( $mock, 'getRecentlyEditedPageIds' );
		$result = $fn( 0 );

		$this->assertEmpty( $result );
	}

	/*
	 * @covers PopularArticlesModel::getRecentlyEditedPageIds
	 */
	public function testRecentlyEditedPageIds_ReturnPageIds() {
		$mock = $this->getMockBuilder( 'PopularArticlesModel' )
			->disableOriginalConstructor()
			->setMethods( [ '__construct', 'getRecentlyEditedPageResult' ] )
			->getMock();
		$mock->expects( $this->any() )
			->method( 'getRecentlyEditedPageResult' )
			->will( $this->returnValue( new fakeResultGenerator( 2 ) ) );

		$mockTitleMain = $this->getMockBuilder( 'Title' )
			->disableOriginalConstructor()
			->setMethods( [ '__construct', 'isMainPage' ] )
			->getMock();
		$mockTitleMain->expects( $this->any() )
			->method( 'isMainPage' )
			->will( $this->returnValue( false ) );

		$this->mockStaticMethod( 'Title', 'newFromText', $mockTitleMain );

		$fn = self::getFn( $mock, 'getRecentlyEditedPageIds' );
		$result = $fn( 0 );

		$this->assertEquals( $result, [ 0, 1 ] );
	}

	/*
	 * @covers PopularArticlesModel::getPageViewsMap
	 */
	public function testGetPageView_ReturnsPageViewMap() {
		$row0 = new stdClass();
		$row0->article_id = 10;
		$row0->pageviews = 110;
		$row1 = new stdClass();
		$row1->article_id = 12;
		$row1->pageviews = 112;

		$mockResults = $this->mockDbQuery();
		$mockResults->expects( $this->at( 0 ) )->method( "fetchObject" )
			->will( $this->returnValue( $row0 ) );
		$mockResults->expects( $this->at( 1 ) )->method( "fetchObject" )
			->will( $this->returnValue( $row1 ) );

		$fn = self::getFn( new PopularArticlesModel(), 'getPageViewsMap' );
		$result = $fn( 0, [ 0 ] );
		$this->assertEquals( $result[10], 110 );
		$this->assertEquals( $result[12], 112 );
	}
}

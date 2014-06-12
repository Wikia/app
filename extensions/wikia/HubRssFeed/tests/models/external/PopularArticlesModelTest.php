<?php

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

		$mockDb = $this->getMock( 'DatabaseMysql', array( 'query' ) );
		$mockDb->expects( $this->any() )->method( 'query' )->will( $this->returnValue( $mockQueryResults ) );

		$this->mockGlobalFunction( 'wfGetDb', $mockDb );

		return $mockQueryResults;
	}

	private function fakeRecentlyEditedQueryRow( Title $title ) {
		$row = new stdClass();
		$row->page_namespace = $title->getNamespace();
		$row->page_title = $title->getBaseText();
		$row->page_id = $title->getArticleId();
		return $row;
	}

	/*
	 * @group UsingDB
	 * @covers PopularArticlesModel::getRecentlyEditedPageIds
	 */
	public function testRecentlyEditedPageIds_SkipMainPage() {
		$mainPage = Title::newMainPage();
		$mockDb = null;
		$mockResults = $this->mockDbQuery( $mockDb );
		$mockResults->expects( $this->at( 0 ) )->method( "fetchObject" )
			->will( $this->returnValue( $this->fakeRecentlyEditedQueryRow( $mainPage ) ) );

		$fn = self::getFn( new PopularArticlesModel(), 'getRecentlyEditedPageIds' );
		$result = $fn( 0, $mockDb );

		$this->assertEmpty( $result );
	}

	/*
	 * @group UsingDB
	 * @covers PopularArticlesModel::getRecentlyEditedPageIds
	 */
	public function testRecentlyEditedPageIds_ReturnPageIds() {
		$someTitle = Title::newFromText( "some title" );
		$row0 = $this->fakeRecentlyEditedQueryRow( $someTitle );
		$row1 = clone $row0;
		$row0->page_id = 0;
		$row1->page_id = 1;

		$mockResults = $this->mockDbQuery();
		$mockResults->expects( $this->at( 0 ) )->method( "fetchObject" )
			->will( $this->returnValue( $row0 ) );
		$mockResults->expects( $this->at( 1 ) )->method( "fetchObject" )
			->will( $this->returnValue( $row1 ) );

		$fn = self::getFn( new PopularArticlesModel(), 'getRecentlyEditedPageIds' );
		$result = $fn( 0 );

		$this->assertEquals( $result[0], 0 );
		$this->assertEquals( $result[1], 1 );
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

<?php
require_once dirname(__FILE__) . '/../WikiaLabs.setup.php';
wfLoadAllExtensions();

class WikiaLabsProjectTest extends WikiaBaseTest {
	const TEST_PROJECT_ID = 111;
	const TEST_PROJECT_NAME = 'Test Project';
	const TEST_PROJECT_DESC = 'Hello World!';
	const TEST_WIKI_ID = 177;
	const TEST_EXTENSION = 'HelloWorldExtension';
	const TEST_USER_ID1 = 1;
	const TEST_USER_ID2 = 2;
	const TEST_USERNAME = 'TestUser';
	const TEST_PASSWORD = 'TestPasswd';

	/**
	 * WikiaLabsProject object
	 * @var WikiaLabsProject
	 */
	protected $object = null;
	protected $dbMock = null;
	protected $cacheMock = null;
	protected $appMock = null;

	protected function setUp() {
		parent::setUp();

		$this->object = $this->getMock( 'WikiaLabsProject', array( 'getCache', 'getDb', 'getId', 'incrActivationsNum', 'decrActivationsNum', 'updateCachedEnables', 'updateCachedRating', 'setRating' ), array( F::build( 'App' ) ) );
		$this->dbMock = $this->getMock( 'DatabaseMysql' );
		$this->cacheMock = $this->getMock( 'MemCachedClientforWiki', array(), array(), '', false );
	}

	protected function tearDown() {
		parent::tearDown();

		F::unsetInstance('WikiaLabsProject');
	}

	protected function setUpMock() {
		$this->object->expects($this->any())
		  ->method( 'getCache' )
		  ->will( $this->returnValue( $this->cacheMock) );
		$this->object->expects($this->any())
		  ->method( 'getDb' )
		  ->will( $this->returnValue( $this->dbMock) );

		$this->object->setApp( F::app() );
	}

	protected function setUpWikiApiMock( $projectId ) {
		$botUsers = array(
			'staff' => array(
				'username' => self::TEST_USERNAME,
				'password' => self::TEST_PASSWORD
			)
		);

		$wikiApiMock = $this->getMock( 'WikiAPIClient', array( 'setExternalDataUrl', 'login', 'edit' ), array(), '', false );
		$wikiApiMock->expects( $this->once() )
		  ->method( 'setExternalDataUrl' )
		  ->with( $this->equalTo( WikiaLabsProject::EXTERNAL_DATA_URL ));
		$wikiApiMock->expects( $this->once() )
		  ->method( 'login' )
		  ->with( $this->equalTo( $botUsers['staff']['username'] ), $this->equalTo( $botUsers['staff']['password'] ) );
		$wikiApiMock->expects( $this->once() )
		  ->method( 'edit' )
		  ->with( $this->equalTo( 'MediaWiki:'.'wikialabs-projects-name-'.$projectId), $this->equalTo( self::TEST_PROJECT_NAME ) );

		$this->mockGlobalVariable( 'wgWikiaBotUsers', $botUsers );
		$this->mockGlobalVariable( 'wgDevelEnvironment', false );

		$this->mockClass( 'WikiAPIClient', $wikiApiMock );
		$this->mockApp();
	}

	public function testCreatingNewProject() {
		$projectId = 0;
		$this->object->expects($this->any())
		  ->method( 'getId' )
		  ->will( $this->returnValue($projectId) );

		$this->dbMock->expects($this->once())
		  ->method('insert');

		$this->dbMock->expects($this->once())
		  ->method('insertId');

		$this->setUpWikiApiMock($projectId);
		$this->setUpMock();

		$testData = array( 'foo' => true, 'bar' => 1, 'desc' => self::TEST_PROJECT_DESC );
		$releaseDate = strtotime( date('Y-m-d') );

		$this->object->setName( self::TEST_PROJECT_NAME );
		$this->object->setReleaseDate( $releaseDate );
		$this->object->setData( $testData );
		$this->object->setActive( true);
		$this->object->setGraduated( false );
		$this->object->update();

		$this->assertEquals( self::TEST_PROJECT_NAME, $this->object->getName() );
		$this->assertEquals( $releaseDate, $this->object->getReleaseDate() );
		$this->assertEquals( 0, $this->object->getActivationsNum() );
		$this->assertEquals( 0, $this->object->getRating() );
		$this->assertTrue( $this->object->isActive() );
		$this->assertFalse( $this->object->isGraduated() );

		$actualData = $this->object->getData();

		$this->assertEquals( $testData['foo'], $actualData['foo'] );
		$this->assertEquals( $testData['bar'], $actualData['bar'] );
		$this->assertEquals( $testData['desc'], $actualData['desc'] );
	}


	public function testUpdatingExistingProject() {
		$projectId = self::TEST_PROJECT_ID;
		$this->object->expects($this->any())
		  ->method( 'getId' )
		  ->will( $this->returnValue( $projectId ) );

		$this->dbMock->expects($this->once())
		  ->method('update');

		$this->setUpWikiApiMock( $projectId );
		$this->setUpMock();

		$testData = array( 'foo' => true, 'bar' => 1, 'desc' => self::TEST_PROJECT_DESC );

		$this->object->setName( self::TEST_PROJECT_NAME );
		$this->object->setData( $testData );
		$this->object->update();

		$this->assertEquals( self::TEST_PROJECT_ID, $this->object->getId() );
		$this->assertEquals( self::TEST_PROJECT_NAME, $this->object->getName() );
		$this->assertFalse( $this->object->isActive() );

		$actualData = $this->object->getData();

		$this->assertEquals( $testData['foo'], $actualData['foo'] );
		$this->assertEquals( $testData['bar'], $actualData['bar'] );
		$this->assertEquals( $testData['desc'], $actualData['desc'] );
	}


	public function gettingListOfProjectsDataProvider() {
		return array(
			array(
				array( 'name' => 'Test Name' ),
				array( 'wlpr_name' => 'Test Name' )
			),
			array(
				array( 'active' => true ),
				array( 'wlpr_is_active' => 'y' )
			),
			array(
				array( 'active' => false ),
				array( 'wlpr_is_active' => 'n' )
			),
			array(
				array( 'graduated' => true ),
				array( 'wlpr_is_graduated' => 'y' )
			),
			array(
				array( 'graduated' => false ),
				array( 'wlpr_is_graduated' => 'n' )
			)
		);
	}

	/**
	 * @dataProvider gettingListOfProjectsDataProvider
	 */
	public function testGettingListOfProjects( $refinements, $expectedWhereClause ) {
		$project1 = new stdClass();
		$project1->wlpr_id = 10;

		$project2 = new stdClass();
		$project2->wlpr_id = 20;

		$resMock = $this->getMock( 'ResultWrapper', array(), array(), '', false );

		$this->dbMock->expects($this->once())
		  ->method('select')
		  ->with( $this->anything(), $this->anything(), $this->equalTo($expectedWhereClause))
		  ->will( $this->returnValue( $resMock ) );
		$this->dbMock->expects($this->exactly(3))
		  ->method('fetchObject')
		  ->will( $this->onConsecutiveCalls( $project1, $project2, null ) );

		$this->setUpMock();

		F::setInstance( 'WikiaLabsProject', $project1 );

		$list = $this->object->getList( $refinements );

		$this->assertEquals( 2, count($list) );
		$this->assertEquals( $project1->wlpr_id, $list[0]->wlpr_id );
	}


	public function testEnablingProjectForWiki() {
		$this->object->expects($this->any())
		  ->method( 'getId' )
		  ->will( $this->returnValue( self::TEST_PROJECT_ID ) );
		$this->object->expects($this->once())
		  ->method( 'incrActivationsNum' );
		$this->object->expects($this->once())
		  ->method( 'updateCachedEnables' )
		  ->with( $this->equalTo( self::TEST_WIKI_ID ), $this->equalTo( true ) );

		$this->dbMock->expects($this->once())
		  ->method('insert')
		  ->with(
		    $this->equalTo('wikia_labs_project_wiki_link'),
		    $this->equalTo( array( 'wlpwli_wlpr_id' => self::TEST_PROJECT_ID, 'wlpwli_wiki_id' => self::TEST_WIKI_ID )),
		    $this->anything() );

		$this->setUpMock();

		$this->object->setEnabled( self::TEST_WIKI_ID );
	}

	public function testDisablingProjectForWiki() {
		$this->object->expects($this->any())
		  ->method( 'getId' )
		  ->will( $this->returnValue( self::TEST_PROJECT_ID ) );
		$this->object->expects($this->once())
		  ->method( 'decrActivationsNum' );
		$this->object->expects($this->once())
		  ->method( 'updateCachedEnables' )
		  ->with( $this->equalTo( self::TEST_WIKI_ID ), $this->equalTo( false ) );

		$this->dbMock->expects($this->once())
		  ->method('delete')
		  ->with(
		    $this->equalTo('wikia_labs_project_wiki_link'),
		    $this->equalTo( array( 'wlpwli_wlpr_id' => self::TEST_PROJECT_ID, 'wlpwli_wiki_id' => self::TEST_WIKI_ID )),
		    $this->anything() );

		$this->setUpMock();

			$this->object->setDisabled( self::TEST_WIKI_ID );
	}

	public function updateRatingDataProvider() {
		return array(
			array( 0, self::TEST_USER_ID1, 5 ),
			array( 1, self::TEST_USER_ID2, 2 )
		);
	}

	/**
	 * @dataProvider updateRatingDataProvider
	 */
	public function testUpdateRating( $ratingId, $testUser, $testRating ) {
		$this->object = $this->getMock( 'WikiaLabsProject', array( 'getCache', 'getDb', 'getId', 'incrActivationsNum', 'decrActivationsNum', 'updateCachedEnables', 'updateCachedRating', 'setRating', 'update' ), array( F::build( 'App' ) ) );

		$testRow = new stdClass;
		$testRow->wlpra_id = $ratingId;
		$testRow->rating = 10;

		$this->object->expects($this->atLeastOnce())
		  ->method( 'getId' )
		  ->will( $this->returnValue( self::TEST_PROJECT_ID ) );
		$this->object->expects($this->once())
		  ->method( 'updateCachedRating' )
		  ->with( $this->equalTo( $testUser ), $this->equalTo( $testRating ) );
		$this->object->expects($this->once())
		  ->method( 'setRating' )
		  ->with( $this->equalTo( $testRow->rating ) );

		if(!empty($ratingId)) {
			$this->dbMock->expects($this->once())
			  ->method('update');
		}
		else {
			$this->dbMock->expects($this->once())
			  ->method('insert');
		}

		$this->dbMock->expects($this->exactly(2))
		  ->method('selectRow')
		  ->with(
		    $this->equalTo('wikia_labs_project_rating'),
		    $this->anything(),
		    $this->anything(),
		    $this->anything() )
		  ->will( $this->returnValue( $testRow ));

		$this->setUpMock();

		$this->object->updateRating( $testUser, $testRating );
	}

}

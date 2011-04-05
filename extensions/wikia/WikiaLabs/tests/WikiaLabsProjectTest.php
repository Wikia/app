<?php
require_once dirname(__FILE__) . '/../WikiaLabs.setup.php';
wfLoadAllExtensions();

class WikiaLabsProjectTest extends PHPUnit_Framework_TestCase {
	const TEST_PROJECT_NAME = 'Test Project';
	const TEST_PROJECT_DESC = 'Hello World!';
	const TEST_WIKI_ID = 177;
	const TEST_EXTENSION = 'HelloWorldExtension';
	const TEST_USER_ID1 = 1;
	const TEST_USER_ID2 = 2;

	/**
	 * WikiaLabsProject object
	 * @var WikiaLabsProject
	 */
	protected $object = null;
	protected $cacheMock = null;
	protected $loops = 1;


	protected function verifyMockObjects() {
	}

	protected function setUp() {
		$this->object = F::build( 'WikiaLabsProject' );
	}

	protected function setUpMock( $useCache ) {
		$this->loops = 4;
		if( !$useCache ) {
			$this->cacheMock = $this->getMock( 'MemCachedClientforWiki', array(), array(), '', false );

			$this->object = $this->getMock( 'WikiaLabsProject', array( 'getCache' ), array( F::build( 'App' ) ) );
			$this->object->expects($this->any())
				->method( 'getCache' )
				->will( $this->returnValue( $this->cacheMock) );
			$this->loops = 1;
		}
	}

	protected function tearDown() {
		$this->object->delete();
		parent::verifyMockObjects();
	}

	public function cacheDataProvider() {
		return array(
			array( true ),
			array( false )
		);
	}

	/**
	 * @dataProvider cacheDataProvider
	 */
	public function testCreatingNewProject( $useCache ) {
		$this->setUpMock( $useCache );

		for( $i = 0; $i < $this->loops; $i++ ) {
			$this->assertInstanceOf( 'WikiaLabsProject', $this->object );

			$testData = array( 'foo' => true, 'bar' => 1, 'desc' => self::TEST_PROJECT_DESC );
			$releaseDate = strtotime( date('Y-m-d') );

			$this->object->setName( self::TEST_PROJECT_NAME );
			$this->object->setReleaseDate( $releaseDate );
			$this->object->setData( $testData );
			$this->object->setActive( true);
			$this->object->setGraduated( false );
			$this->object->update();

			$this->assertGreaterThan( 0, $this->object->getId() );
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
	}

	/**
	 * @dataProvider cacheDataProvider
	 */
	public function testUpdatingExistingProject( $useCache ) {
		$this->setUpMock( $useCache );

		for( $i = 0; $i < $this->loops; $i++ ) {
			$this->assertInstanceOf( 'WikiaLabsProject', $this->object );

			$testData = array( 'foo' => true, 'bar' => 1, 'desc' => self::TEST_PROJECT_DESC );

			$this->object->setName( self::TEST_PROJECT_NAME );
			$this->object->setData( $testData );
			$this->object->update();

			$this->assertEquals( self::TEST_PROJECT_NAME, $this->object->getName() );
			$this->assertFalse( $this->object->isActive() );

			$object = F::build( 'WikiaLabsProject', array( 'id' => $this->object->getId() ) );
			$object->setActive( true );
			$object->incrActivationsNum();
			$object->setExtension( self::TEST_EXTENSION );
			$object->update();

			unset($object);

			$object = F::build( 'WikiaLabsProject', array( 'id' => $this->object->getId() ) );

			$this->assertEquals( self::TEST_PROJECT_NAME, $object->getName() );
			$this->assertTrue( $object->isActive() );
			$this->assertEquals( date('Y-m-d'), date('Y-m-d', $object->getReleaseDate()) );
			$this->assertEquals( self::TEST_EXTENSION, $object->getExtension() );
			$this->assertEquals( 1, $object->getActivationsNum() );

			$actualData = $object->getData();

			$this->assertEquals( $testData['foo'], $actualData['foo'] );
			$this->assertEquals( $testData['bar'], $actualData['bar'] );
			$this->assertEquals( $testData['desc'], $actualData['desc'] );

			$object->delete();
		}
	}

	/**
	 * @dataProvider cacheDataProvider
	 */
	public function testGettingListOfProjects( $useCache ) {
		$this->setUpMock( $useCache );
		$testName = self::TEST_PROJECT_NAME . __METHOD__;

		// hack: cleanup db first
		$app = F::build('App');
		$app->runFunction( 'wfGetDB', DB_MASTER, array(), $app->getGlobal( 'wgExternalDatawareDB' ) )->query( "DELETE FROM wikia_labs_project WHERE wlpr_name='" . $testName . "'" );

		$project1 = F::build( 'WikiaLabsProject' );
		$project1->setName( $testName );
		$project1->setActive(true);
		$project1->setGraduated(true);
		$project1->update();

		$project2 = F::build( 'WikiaLabsProject' );
		$project2->setName( $testName );
		$project2->setActive(false);
		$project2->setGraduated(true);
		$project2->update();

		$list = $this->object->getList( array( 'active' => true, 'name' => $testName ) );

		$this->assertEquals( 1, count($list) );
		$this->assertEquals( $project1->getId(), $list[0]->getId() );
		$this->assertEquals( $project1->getName(), $list[0]->getName() );
		unset($list);

		$list = $this->object->getList( array( 'active' => false, 'name' => $testName ) );

		$this->assertEquals( 1, count($list) );
		$this->assertEquals( $project2->getId(), $list[0]->getId() );
		$this->assertEquals( $project2->getName(), $list[0]->getName() );
		unset($list);

		$list = $this->object->getList( array( 'graduated' => true, 'name' => $testName ) );

		$this->assertEquals( 2, count($list) );

		$project1->delete();
		$project2->delete();
	}

	/**
	 * @dataProvider cacheDataProvider
	 */
	public function testEnablingAndDisablingForWiki( $useCache ) {
		$this->setUpMock( $useCache );

		for( $i = 0; $i < $this->loops; $i++ ) {
			$this->object->setName( self::TEST_PROJECT_NAME );
			$this->object->update();

			$this->assertFalse( $this->object->isEnabled( self::TEST_WIKI_ID ) );
			$this->assertEquals(0, $this->object->getActivationsNum());

			$this->object->setEnabled( self::TEST_WIKI_ID );
			$this->assertTrue( $this->object->isEnabled( self::TEST_WIKI_ID ) );
			$this->assertEquals(1, $this->object->getActivationsNum());

			$this->object->setDisabled( self::TEST_WIKI_ID );
			$this->assertFalse( $this->object->isEnabled( self::TEST_WIKI_ID ) );
			$this->assertEquals(0, $this->object->getActivationsNum());
		}
	}

	/**
	* @dataProvider cacheDataProvider
	*/
	public function testUpdateRating( $useCache ) {
		$this->setUpMock( $useCache );

		for( $i = 0; $i < $this->loops; $i++ ) {
			$this->object->update();

			$testRating1 = 5;
			$testRating2 = 2;

			$this->object->updateRating( self::TEST_USER_ID1, $testRating1 );
			$this->object->updateRating( self::TEST_USER_ID2, $testRating2 );

			$this->assertEquals( 2, $this->object->getRating() );
			$this->assertEquals( $testRating1, $this->object->getRatingByUser( self::TEST_USER_ID1 ) );
			$this->assertEquals( $testRating2, $this->object->getRatingByUser( self::TEST_USER_ID2 ) );

			$this->object->updateRating( self::TEST_USER_ID2, $testRating1 );

			$this->assertEquals( 2, $this->object->getRating() );
			$this->assertEquals( $testRating1, $this->object->getRatingByUser( self::TEST_USER_ID1, DB_MASTER ) );
			$this->assertEquals( $testRating1, $this->object->getRatingByUser( self::TEST_USER_ID2, DB_MASTER ) );
		}
	}

}

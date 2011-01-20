<?php
require_once dirname(__FILE__) . '/../WikiaLabs.setup.php';
wfLoadAllExtensions();

class WikiaLabsProjectTest extends PHPUnit_Framework_TestCase {
	const TEST_PROJECT_NAME = 'Test Project';
	const TEST_PROJECT_DESC = 'Hello World!';
	const TEST_WIKI_ID = 177;
	const TEST_EXTENSION = 'HelloWorldExtension';

	/**
	 * WikiaLabsProject object
	 * @var WikiaLabsProject
	 */
	protected $object = null;

	protected function setUp() {
		$this->object = WF::build( 'WikiaLabsProject' );
	}

	protected function tearDown() {
		$this->object->delete();
	}

	public function testCreatingNewProject() {
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

	public function testUpdatingExistingProject() {
		$this->assertInstanceOf( 'WikiaLabsProject', $this->object );

		$testData = array( 'foo' => true, 'bar' => 1, 'desc' => self::TEST_PROJECT_DESC );

		$this->object->setName( self::TEST_PROJECT_NAME );
		$this->object->setData( $testData );
		$this->object->update();

		$this->assertEquals( self::TEST_PROJECT_NAME, $this->object->getName() );
		$this->assertFalse( $this->object->isActive() );

		$object = WF::build( 'WikiaLabsProject', array( 'id' => $this->object->getId() ) );
		$object->setActive( true );
		$object->incrActivationsNum();
		$object->setExtension( self::TEST_EXTENSION );
		$object->update();

		unset($object);

		$object = WF::build( 'WikiaLabsProject', array( 'id' => $this->object->getId() ) );
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

	public function testGettingListOfProjects() {
		$testName = self::TEST_PROJECT_NAME . __METHOD__;

		$project1 = WF::build( 'WikiaLabsProject' );
		$project1->setName( $testName );
		$project1->setActive(true);
		$project1->setGraduated(true);
		$project1->update();

		$project2 = WF::build( 'WikiaLabsProject' );
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

	public function testEnablingAndDisablingForWiki() {
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
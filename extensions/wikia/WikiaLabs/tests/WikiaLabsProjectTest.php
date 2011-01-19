<?php
require_once dirname(__FILE__) . '/../WikiaLabs.setup.php';

class WikiaLabsProjectTest extends PHPUnit_Framework_TestCase {
	const TEST_PROJECT_NAME = 'Test Project';
	const TEST_PROJECT_DESC = 'Hello World!';

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

		$this->object->setName( self::TEST_PROJECT_NAME );
		$this->object->update();

		$this->assertEquals( self::TEST_PROJECT_NAME, $this->object->getName() );
		$this->assertFalse( $this->object->isActive() );

		$object = WF::build( 'WikiaLabsProject', array( 'id' => $this->object->getId() ) );
		$object->setActive( true );
		$object->incrActivationsNum();
		$object->update();

		unset($object);

		$object = WF::build( 'WikiaLabsProject', array( 'id' => $this->object->getId() ) );
		$this->assertEquals( self::TEST_PROJECT_NAME, $object->getName() );
		$this->assertTrue( $object->isActive() );
		$this->assertEquals( 1, $object->getActivationsNum() );

		$object->delete();
	}

}
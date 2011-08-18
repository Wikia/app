<?php
require_once dirname(__FILE__) . '/../WikiaLabs.setup.php';
wfLoadAllExtensions();

class WikiaLabsTest extends PHPUnit_Framework_TestCase {
	const RAIL_MODULES_NUM = 3;
	const TEST_USER_ID = 1;
	const TEST_USER_EMAIL = 'foo@bar.com';
	const TEST_CITY_ID = 177;

	/**
	 * WikiaLabs class object
	 * @var WikiaLabs
	 */
	protected $object = null;
	protected $app = null;


	protected function setUp() {
		$this->object = F::build( 'WikiaLabs' );
		$this->app = F::build( 'App' );
	}

	protected function tearDown() {
		F::setInstance( 'App', $this->app );
		F::unsetInstance( 'WikiaLabsProject' );
		F::unsetInstance( 'LogPage' );
	}

	protected function getUserMock(  ) {
		$user = $this->getMock( 'User' );
		$user->expects( $this->atLeastOnce() )
		     ->method( 'isAllowed' )
		     ->with( $this->equalTo( 'wikialabsuser' ))
		     ->will( $this->returnValue( true ));

		return $user;
	}

	public function testOnGetRailModuleSpecialPageList() {

		$title = $this->getMock( 'Title' );
		$title->expects( $this->once() )
		     ->method( 'isSpecial' )
		     ->with( $this->equalTo( 'WikiaLabs' ) )
		     ->will( $this->returnValue( true ) );

		$app = $this->getMock( 'WikiaApp', array( 'getGlobal' ) );
		$app->expects( $this->at(2) )
		    ->method( 'getGlobal' )
		    ->with( $this->equalTo( 'wgTitle' ) )
		    ->will( $this->returnValue( $title ) );

		F::setInstance( 'App', $app );

		$moduleList = array();

		$this->object = F::build( 'WikiaLabs' );
		$this->object->onGetRailModuleSpecialPageList( $moduleList );

		$this->assertTrue( is_array( $moduleList ) );
		$this->assertEquals(self::RAIL_MODULES_NUM, count( $moduleList ));
	}

	public function testGettingOfProjectModal() {
		$tmpl = $this->getMock( 'EasyTemplate', array( 'render' ), array( 'foobar' ) );
		$tmpl->expects( $this->once() )
		     ->method( 'render' )
		     ->with( $this->equalTo( WikiaLabs::TEMPLATE_NAME_ADDPROJECT ) );

		$project = $this->getMock( 'WikiaLabsProject', array(), array( $this->app ) );
		$project->expects( $this->once() )
		        ->method( 'getData' );
		$project->expects( $this->once() )
		        ->method( 'getStatusDict' );
		$project->expects( $this->once() )
		        ->method( 'getExtensionsDict' );

		F::setInstance( 'EasyTemplate', $tmpl );
		F::setInstance( 'WikiaLabsProject', $project );

		$object = $this->getMock( 'WikiaLabs', array( 'getFogbugzAreas') );
		$object->expects( $this->once() )
		       ->method( 'getFogbugzAreas' );

		$object->setUser( $this->getUserMock() );
		$object->getProjectModal();
	}

	public function savingFeedbackDataProvider() {
		return array(
			array( 0, 1, 7, 'AtLeast10CharLongMsg', false ), // invalid projectId
			array( 1, 1, 7, 'AtLeast10CharLongMsg', true ),
			array( 0, 0, 0, 'TooShort', false ), // all wrong
			array( 1, 2, 7, 'AtLeast10CharLongMsg', true ),
			array( 1, 10, 7, 'AtLeast10CharLongMsg', false ), // rating > max
			array( 1, 0, 7, 'AtLeast10CharLongMsg', false ), // rating < min
			array( 1, 1, 8, 'AtLeast10CharLongMsg', false ), // feedback category > max
			array( 1, 1, 3, 'AtLeast10CharLongMsg', false ) // feedback category < min
		);
	}

	/**
	 * @dataProvider savingFeedbackDataProvider
	 */
	public function testSavingFeedback( $projectId, $rating, $category, $message, $statusOk ) {
		$project = $this->getMock( 'WikiaLabsProject', array(), array( $this->app ) );
		if($statusOk) {
			$project->expects( $this->once() )
			        ->method( 'updateRating' )
			        ->with( $this->equalTo( self::TEST_USER_ID ), $this->equalTo( $rating ) );
		}

		F::setInstance( 'WikiaLabsProject', $project );

		$user = $this->getUserMock();
		$user->expects( $this->any() )
		     ->method( 'getId' )
		     ->will( $this->returnValue( self::TEST_USER_ID ) );

		if($statusOk) {
			$user->expects( $this->once() )
			     ->method( 'getEmail' )
			     ->will( $this->returnValue( self::TEST_USER_EMAIL ) );
		}

		$object = $this->getMock( 'WikiaLabs', array( 'saveFeedbackInFogbugz', 'checkSpam') );
		if($statusOk) {
			$object->expects( $this->once() )
			       ->method( 'saveFeedbackInFogbugz' )
			       ->with( $this->equalTo( $project ), $this->equalTo( $message ), $this->equalTo( self::TEST_USER_EMAIL ) );
		}
			$object->expects( $this->any() )
			       ->method( 'checkSpam' )
			       ->will($this->returnValue(true));
		
		$result = $object->saveFeedback( $projectId, $user, $rating, $category, $message );

		$this->assertEquals( ( $statusOk ? WikiaLabs::STATUS_OK : WikiaLabs::STATUS_ERROR ), $result['status'], 'wrong saveFeedback status returned' );
		$this->assertTrue( is_array( $result ) );
	}

	public function savingProjectDataProvider() {
		return array(
			array( true ),
			array( false )
		);
	}

	/**
	 * @dataProvider savingProjectDataProvider
	 * @param unknown_type $validationOk
	 */
	public function testSavingProject( $validationOk ) {
		$projectData = array(
			'id' => 1,
			'name' => 'fooname',
		 'area' => 'fooarea',
			'enablewarning' => true,
			'graduates' => true,
			'description' => 'foodesc',
			'link' => 'foolink',
			'prjscreen' => 'fooscreen',
			'warning' => 'foowarn',
			'enablewarning' => 'enablefoowarn',
			'status' => 1,
			'extension' => 'fooextension'
		);

		$validator = $this->getMock( 'WikiaValidatorsSet' );
		$validator->expects( $this->once() )
		          ->method( 'isValid' )
		          ->will( $this->returnValue( $validationOk ));
		if( !$validationOk ) {
			$validator->expects( $this->once() )
			          ->method( 'getErrors' )
			          ->will( $this->returnValue( array( array( 'err1' => new WikiaValidationError('foo', 'bar') ) ) ) );
		}
		else {
			$project = $this->getMock( 'WikiaLabsProject', array(), array( $this->app ) );
			$project->expects( $this->once() )
			        ->method( 'setName' )
			        ->with( $this->equalTo( $projectData['name'] ) );
			$project->expects( $this->once() )
			        ->method( 'setFogbugzProject' )
			        ->with( $this->equalTo( $projectData['area'] ) );
			$project->expects( $this->once() )
			        ->method( 'setData' );
			$project->expects( $this->once() )
			        ->method( 'setGraduated' )
			        ->with( $this->equalTo( $projectData['graduates'] ) );
			$project->expects( $this->once() )
			        ->method( 'setActive' )
			        ->with( $this->equalTo( true ));
			$project->expects( $this->once() )
			        ->method( 'setStatus' )
			        ->with( $this->equalTo( $projectData['status'] ) );
			$project->expects( $this->once() )
			        ->method( 'setExtension' )
			        ->with( $this->equalTo( $projectData['extension'] ) );
			$project->expects( $this->once() )
			        ->method( 'update' );

			F::setInstance( 'WikiaLabsProject', $project );
		}

		$object = $this->getMock( 'WikiaLabs', array( 'validateProjectForm', 'getImageUrl' ) );
		$object->expects( $this->once() )
		       ->method( 'validateProjectForm' )
		       ->with( $this->equalTo( $projectData ) )
		       ->will( $this->returnValue( $validator ) );

		if( $validationOk ) {
			$object->expects( $this->once() )
			       ->method( 'getImageUrl' )
			       ->with( $this->equalTo( $projectData['prjscreen'] ) )
			       ->will( $this->returnValue( 'http://foo.url' ) );
		}

		$user = $this->getMock( 'User' );
		$user->expects( $this->once() )
		     ->method( 'isAllowed' )
		     ->with( $this->equalTo( 'wikialabsadmin' ))
		     ->will( $this->returnValue( true ));

		$object->setUser( $user );
		$result = $object->saveProject( $projectData );

		$this->assertEquals( ( $validationOk ? WikiaLabs::STATUS_OK : WikiaLabs::STATUS_ERROR ), $result['status'] );
		$this->assertTrue( is_array( $result ) );
	}

	public function switchingProjectDataProvider() {
		return array(
			array( 1, true ),
			array( 1, false ),
			array( 0, true ),
			array( 1, false )
		);
	}

	/**
	 * @dataProvider switchingProjectDataProvider
	 */
	public function testSwitchingProject( $projectId, $onOff ) {
		$extension = "fooextension";

		$app = $this->getMock( 'WikiaApp', array( 'runFunction' ) );
		if( !empty( $projectId ) ) {
			$app->expects( $this->once() )
			    ->method( 'runFunction' );
			/*
			$app->expects( $this->once() )
			    ->method( 'runFunction' )
			    ->with(
			       $this->equalTo( 'WikiFactory::setVarByName' ),
			       $this->equalTo( $extension ),
			       $this->equalTo( self::TEST_CITY_ID ),
			       $this->equalTo( !empty($onOff) ),
			       $this->equalTo( 'WikiaLabs' )
			     );
			*/
		}

		F::setInstance( 'App', $app );

		$project = $this->getMock( 'WikiaLabsProject', array(), array( $this->app ) );
		$project->expects( $this->once() )
		        ->method( 'getId' )
		        ->will( $this->returnValue( $projectId ));

		if( !empty( $projectId ) ) {
			$log = $this->getMock( 'LogPage', array(), array(), '', false );
			$log->expects( $this->once() )
			    ->method( 'addEntry' );

			F::setInstance( 'LogPage', $log );

			$project->expects( $this->atLeastOnce() )
			        ->method( 'getName' )
			        ->will( $this->returnValue( $extension ) );
		}

		F::setInstance( 'WikiaLabsProject', $project );

		$this->object = F::build( 'WikiaLabs' );
		$this->object->setUser( $this->getUserMock() );
		$this->object->switchProject( self::TEST_CITY_ID, $projectId, $onOff );
	}
}

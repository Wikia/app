<?php
require_once dirname(__FILE__) . '/../FounderProgressBar.setup.php';
wfLoadAllExtensions();

class FounderProgressBarTest extends PHPUnit_Framework_TestCase {
        const TEST_DATA = 1;
        const TEST_CITY_ID = 79860;

        /**
         * FounderProgressBarTest class object
         * @var FounderProgressBarTest
         */
        protected $object = null;
        protected $app = null;

        protected function setUp() {
			
			// Mock response using $this->getValCallBack()
			$mockR = $this->getMock('WikiaResponse', array('getVal'), array('raw'));
			$mockR->expects( $this->any() )
					->method ('getVal')
					->will( $this->returnCallback (array($this, "getValCallback")));
			
			$mock = $this->getMock('FounderProgressBarController', array('sendSelfRequest'));
			$mock->expects( $this->any() )
				->method( 'sendSelfRequest' )
				->will(  $this->returnValue( $mockR ) );

			F::setInstance("FounderProgressBarController", $mock);			
			
			$this->object = F::build( 'FounderProgressBarController' );
			$this->app = F::build( 'App' );
			$this->task_id = 0;
			
        }
		
		
		/**
		 * @dataProvider taskCompleteDataProvider
		 */
		
		public function testTaskComplete($task_id) {
						
			$this->task_id = $task_id;
			$response = $this->app->sendRequest('FounderProgressBar', 'isTaskComplete', array('task_id' => $task_id));
			$task_data = $this->getTaskData();
			$this->assertEquals($response->getVal('task_completed'), $task_data[$task_id]['task_completed']);
		}
		
		// Test task completed with 0 and 1
		public function taskCompleteDataProvider() {
			return array(
				array(10),
				array(20)
				);
		}
		
		public function testShortTaskList() {
			$response = $this->app->sendRequest('FounderProgressBar', 'getShortTaskList');
			
			$response_data = $response->getVal('list');
			// Test data has one non-skipped non-completed task
			$this->assertEquals(count($response_data), 1);

			$first_element = array_pop($response_data);
			$this->assertEquals($first_element['task_completed'], 0);
			$this->assertEquals($first_element['task_skipped'], 0);			
		}
		
		public function getValCallback($param) {

			$task_id = $this->task_id;
			$task_data = $this->getTaskData();
			
			switch ($param) {
				case "list": return $task_data;
				case "task_id": return $task_id;
				case "task_completed": return ($task_data[$task_id]['task_completed']);
			}

			return null;
		}
		
		public function getTaskData() {
			
			$task_data = array ( 
				10 => array (
				'task_id' => 10,
				'task_count' => 10,
				'task_completed' => 0,
				'task_skipped' => 0,
				'task_timestamp' => '21 hours ago',
				'task_label' => 'Uncompleted task',
				'task_action' => 'Uncompleted task'), 
				20 => array (
				'task_id' => 20,
				'task_count' => 20,
				'task_completed' => 1,
				'task_skipped' => 0,
				'task_timestamp' => '21 hours ago',
				'task_label' => 'Completed Task',
				'task_action' => 'Completed Task'),
				30 => array (
				'task_id' => 30,
				'task_count' => 1,
				'task_completed' => 0,
				'task_skipped' => 1,
				'task_timestamp' => '24 hours ago',
				'task_label' => 'Skipped Task',
				'task_action' => 'Skipped Task'),
				);

			return $task_data;
		}
}

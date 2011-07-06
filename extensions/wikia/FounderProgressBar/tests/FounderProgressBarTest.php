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
		protected $mock_db = null;

        protected function setUp() {
			global $wgCityId;
			
			$this->wgCityId = $wgCityId;
			
			// Mock response using $this->getValCallBack()
			$mockR = $this->getMock('WikiaResponse', array('getVal'), array('raw'));
			$mockR->expects( $this->any() )
					->method ('getVal')
					->will( $this->returnCallback (array($this, "getValCallback")));
			
			$mock_result = $this->getMock('ResultWrapper', array(), array(), '', false);
			
			$this->mock_db = $this->getMock('DatabaseMysql', array('select', 'query', 'update', 'commit', 'fetchObject', 'fetchRow'));
			$this->mock_db->expects($this->any())
							->method('select')
							->will($this->returnValue($mock_result));
			$this->mock_db->expects($this->any())
							->method('query');
			$this->mock_db->expects($this->any())
							->method('update');
			$this->mock_db->expects($this->any())
							->method('commit');
			
			$cache = $this->getMock('stdClass', array('get', 'set', 'delete'));
			$cache->expects($this->any())
					->method('get')
					->will($this->returnValue(null));
			$cache->expects($this->any())
					->method('set');
			$cache->expects($this->any())
					->method('delete');
			
			$mock = $this->getMock('FounderProgressBarController', array('sendSelfRequest', 'getDb', 'getMCache'));
			$mock->expects( $this->any() )
					->method( 'sendSelfRequest' )
					->will(  $this->returnValue( $mockR ) );
			$mock->expects($this->any())
					->method('getDb' )
					->will($this->returnValue($this->mock_db));
			$mock->expects($this->any())
					->method('getMCache')
					->will($this->returnValue($cache));
			
			F::setInstance("FounderProgressBarController", $mock);			
			
			$this->object = F::build( 'FounderProgressBarController' );
			$this->app = F::build( 'App' );
			$this->task_id = 0;
			
        }

		protected function tearDown() {
			global $wgCityId;
			
			$wgCityId = $this->wgCityId;
			F::unsetInstance('FounderProgressBarController');
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

		public function testLongTaskList() {
			global $wgCityId;
			
			$wgCityId = self::TEST_CITY_ID;
			
			$fetch_obj1 = array(
				'task_id' => '10',
				'task_count' => '1',
				'task_completed' => '0',
				'task_skipped' => '0',
			);
			$result_fetchObj1 = self::arrayToStdClass($fetch_obj1);
			$result_fetchObj1->task_timestamp = '2011-06-28 01:25:23';

			$fetch_obj2 = array(
				'task_id' => '120',
				'task_count' => '6',
				'task_completed' => '1',
				'task_skipped' => '0',
			);
			$result_fetchObj2 = self::arrayToStdClass($fetch_obj2);
			$result_fetchObj2->task_timestamp = '2011-06-24 01:39:17';

			$fetch_obj3 = array(	// skipped task
				'task_id' => '50',
				'task_count' => '2',
				'task_completed' => '0',
				'task_skipped' => '1',
			);
			$result_fetchObj3 = self::arrayToStdClass($fetch_obj3);
			$result_fetchObj3->task_timestamp = '2011-06-25 01:39:17';

			$fetch_obj4 = array(
				'task_id' => '70',
				'task_count' => '1',
				'task_completed' => '1',
				'task_skipped' => '0',
			);
			$result_fetchObj4 = self::arrayToStdClass($fetch_obj4);
			$result_fetchObj4->task_timestamp = '2011-06-26 01:39:17';
			
			$fetch_obj5 = array(	// bonus task
				'task_id' => '510',
				'task_count' => '10',
				'task_completed' => '1',
				'task_skipped' => '0',
			);
			$result_fetchObj5 = self::arrayToStdClass($fetch_obj5);
			$result_fetchObj5->task_timestamp = '2011-06-29 01:39:17';
		
			$fetch_obj6 = array(	// bonus task
				'task_id' => '530',
				'task_count' => '1',
				'task_completed' => '0',
				'task_skipped' => '0',
			);
			$result_fetchObj6 = self::arrayToStdClass($fetch_obj6);
			$result_fetchObj6->task_timestamp = '2011-06-30 02:39:17';
		
			$fetch_obj7 = array(	// skipped task
				'task_id' => '90',
				'task_count' => '20',
				'task_completed' => '1',
				'task_skipped' => '1',
			);
			$result_fetchObj7 = self::arrayToStdClass($fetch_obj7);
			$result_fetchObj7->task_timestamp = '2011-06-27 01:39:17';

			$this->mock_db->expects($this->exactly(8))
							->method('fetchObject')
							->will($this->onConsecutiveCalls($result_fetchObj1, $result_fetchObj2, $result_fetchObj3, $result_fetchObj5, $result_fetchObj6, $result_fetchObj7, $result_fetchObj4, null));
			
			$response = $this->app->sendRequest('FounderProgressBar', 'getLongTaskList');
			
			$response_data = $response->getVal('list');
			$first_element = array_pop($response_data);
			$this->assertEquals($first_element['task_id'], $fetch_obj4['task_id']);
			$this->assertEquals($first_element['task_completed'], $fetch_obj4['task_completed']);
			$this->assertEquals($first_element['task_count'], $fetch_obj4['task_count']);
			$this->assertEquals($first_element['task_skipped'], $fetch_obj4['task_skipped']);
			
			$response_data = $response->getVal('data');
			$this->assertEquals($response_data['tasks_completed'], 4);
			$this->assertEquals($response_data['tasks_skipped'], 2);
			$this->assertEquals($response_data['total_tasks'], 5);
			$this->assertEquals($response_data['completion_percent'], 57);
		}
		
		/**
		 * @dataProvider doTaskDataProvider
		 */
		public function testDoTask($task_id, $result, $sql_result) {
			global $wgCityId;
			
			$wgCityId = self::TEST_CITY_ID;
			$this->task_id = $task_id;
			
			$this->mock_db->expects($this->any())
							->method('fetchRow')
							->will($this->returnValue($sql_result));
			
			$response = $this->app->sendRequest('FounderProgressBar', 'doTask', array('task_id' => $this->task_id));

			if (is_array($sql_result)) {				
				$response_data = $response->getVal('actions_completed');
				$expect = $sql_result['task_count'];
				$this->assertEquals($response_data, $expect);
				
				$response_data = $response->getVal('actions_remaining');
				$expect = 10-$sql_result['task_count'];	// counters = 10 for task_id 10
				$this->assertEquals($response_data, $expect);				
			}
			
			$response_data = $response->getVal('result');
			$this->assertEquals($response_data, $result);
		}
		
		// @brief data provider for testDoTask()
		public function doTaskDataProvider() {
			$input1 = array(
							'task_id' => '10',
							'task_count' => '7',
						);

			$input2 = array(
							'task_id' => '10',
							'task_count' => '10',
						);
			
			$input3 = array(
							'task_id' => '10',
							'task_count' => '15',
						);
			
			return array(
						array(5,'error', null),		// invalid task_id - task id not found
						array(20, 'error', null),	// task completed
						array(10, 'error', null),	// invalid task_id - no data in db
						array(10, 'OK', $input1),	// success - task count < counters
						array(10, 'task_completed', $input2),	// success - task count = counters
						array(10, 'task_completed', $input3)	// success - task count > counters
					);
		}
		
		/**
		 * @dataProvider skipTaskDataProvider
		 */
		public function testskipTask($task_id, $task_skipped, $result, $extra_task) {
			global $wgCityId;
			
			$wgCityId = self::TEST_CITY_ID;
			$this->task_id = $task_id;
			$this->extra_task_data = $extra_task;
			$req = array(
				'task_id' => $this->task_id,
				'task_skipped' => $task_skipped,
			);
					
			$response = $this->app->sendRequest('FounderProgressBar', 'skipTask', $req);
			
			$response_data = $response->getVal('result');
			$this->assertEquals($response_data, $result);
		}

		public function skipTaskDataProvider() {
			$extra_task1 = array();
			$extra_task2 = array(
								530 => array (
									'task_id' => 530,
									'task_count' => 1,
									'task_completed' => 0,
									'task_skipped' => 0,
									'task_timestamp' => '5 hours ago',
									'task_label' => 'Uncompleted Bonus task',
									'task_action' => 'Uncompleted Bonus task'),
							);
		return array(
						array(10, 1, 'OK', $extra_task1),
						array(20, 1, 'OK', $extra_task2)
					);
		}

		public function getValCallback($param) {

			$task_id = $this->task_id;
			$task_data = $this->getTaskData();
			if (isset($this->extra_task_data))
				$task_data = $task_data + $this->extra_task_data;
			
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
		
		public static function arrayToStdClass($arr) {
			$result = new stdClass();
			foreach($arr as $key => $value) {
				$result->$key = $value;
			}
			return $result;
		} 
}

<?php
class FounderProgressBarTest extends WikiaBaseTest {
        const TEST_DATA = 1;
        const TEST_CITY_ID = 79860;

        /**
         * FounderProgressBarTest class object
         * @var FounderProgressBarTest
         */
        protected $object = null;
		protected $mock_db = null;

        protected function setUp() {
			global $wgCityId;
			
			$this->wgCityId = $wgCityId;
			
			$this->setupFile = dirname(__FILE__) . '/../FounderProgressBar.setup.php';
			parent::setUp();
			
			// Mock response using $this->getValCallBack()
			$mockR = $this->getMock('WikiaResponse', array('getVal'), array('raw'));
			$mockR->expects( $this->any() )
					->method ('getVal')
					->will( $this->returnCallback (array($this, "getValCallback")));
			
			$mock_result = $this->getMock('ResultWrapper', array(), array(), '', false);
			
			$this->mock_db = $this->getDatabaseMock(array('select', 'query', 'update', 'commit', 'fetchObject', 'fetchRow'));
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
					->will($this->returnCallback(function() {
						return $this->mock_db;
					}));
			$mock->expects($this->any())
					->method('getMCache')
					->will($this->returnValue($cache));

			$this->mockClass("FounderProgressBarController", $mock);

			$this->task_id = 0;
        }

		protected function tearDown() {
			global $wgCityId;
			
			$wgCityId = $this->wgCityId;
			parent::tearDown();
		}

		/**
		 * @group Slow
		 * @slowExecutionTime 0.01265 ms
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

		/**
		 * @group Slow
		 * @slowExecutionTime 0.02318 ms
		 * @dataProvider longTaskListDataProvider
		 */
		public function testLongTaskList($fetch_obj, $exp_list, $exp_data) {
			global $wgCityId;
			
			$wgCityId = self::TEST_CITY_ID;
			
			$fetchObj = array();
			foreach($fetch_obj as $obj) {
				$tmp = self::arrayToStdClass($obj);
				$tmp->task_timestamp = '2011-06-28 01:25:23';
				$fetchObj[] = $tmp;
			}
			
			$required_obj = 8;
			for ($i=count($fetchObj); $i<$required_obj; $i++) {
				$fetchObj[] = null;
			}
			
			$this->mock_db->expects($this->any())
							->method('fetchObject')
							->will($this->onConsecutiveCalls($fetchObj[0], $fetchObj[1], $fetchObj[2], $fetchObj[3], $fetchObj[4], $fetchObj[5], $fetchObj[6], null));
			
			$response = $this->app->sendRequest('FounderProgressBar', 'getLongTaskList');
			
			$response_data = $response->getVal('list');
			$first_element = array_pop($response_data);
			$this->assertEquals($first_element['task_id'], $exp_list['task_id']);
			$this->assertEquals($first_element['task_completed'], $exp_list['task_completed']);
			$this->assertEquals($first_element['task_count'], $exp_list['task_count']);
			$this->assertEquals($first_element['task_skipped'], $exp_list['task_skipped']);
			
			$response_data = $response->getVal('data');
			//$this->assertEquals($response_data['tasks_completed'], $exp_data['tasks_completed']);
			//$this->assertEquals($response_data['tasks_skipped'], $exp_data['tasks_skipped']);
			//$this->assertEquals($response_data['total_tasks'], $exp_data['total_tasks']);
			//$this->assertEquals($response_data['completion_percent'], $exp_data['completion_percent']);
			$this->assertEquals($response_data, $exp_data);
		}
		
		public function longTaskListDataProvider() {
			$fetch_obj1 = array(	// uncompleted
				'task_id' => '10',
				'task_count' => '1',
				'task_completed' => '0',
				'task_skipped' => '0',
			);
			$fetch_obj2 = array(	// completed
				'task_id' => '120',
				'task_count' => '6',
				'task_completed' => '1',
				'task_skipped' => '0',
			);
			$fetch_obj3 = array(	// skipped task + uncompleted
				'task_id' => '50',
				'task_count' => '2',
				'task_completed' => '0',
				'task_skipped' => '1',
			);
			$fetch_obj4 = array(	// completed
				'task_id' => '70',
				'task_count' => '1',
				'task_completed' => '1',
				'task_skipped' => '0',
			);
			$fetch_obj5 = array(	// bonus task + completed
				'task_id' => '510',
				'task_count' => '10',
				'task_completed' => '1',
				'task_skipped' => '0',
			);
			$fetch_obj6 = array(	// bonus task + uncompleted
				'task_id' => '520',
				'task_count' => '1',
				'task_completed' => '0',
				'task_skipped' => '0',
			);
			$fetch_obj7 = array(	// skipped task + completed
				'task_id' => '90',
				'task_count' => '20',
				'task_completed' => '1',
				'task_skipped' => '1',
			);
			$fetch_obj8 = array(	// bonus task + completed (2nd round)
				'task_id' => '510',
				'task_count' => '0',
				'task_completed' => '2',
				'task_skipped' => '0',
			);
			$fetch_obj9 = array(	// bonus task + uncompleted (2nd round)
				'task_id' => '520',
				'task_count' => '5',
				'task_completed' => '1',
				'task_skipped' => '0',
			);
			
			$input1 = array($fetch_obj1, $fetch_obj2, $fetch_obj3, $fetch_obj5, $fetch_obj6, $fetch_obj7, $fetch_obj4);
			$exp_data1 = array(
				'tasks_completed' => 4,
				'tasks_skipped' => 2,
				'total_tasks' => 5,
				'completion_percent' => 80,
			);

			$input2 = array($fetch_obj1, $fetch_obj2, $fetch_obj3, $fetch_obj5, $fetch_obj7, $fetch_obj4);
			
			$input3 = array($fetch_obj1);
			$exp_data3 = array(
				'tasks_completed' => 0,
				'tasks_skipped' => 0,
				'total_tasks' => 1,
				'completion_percent' => 0,
			);
			
			$input4 = array($fetch_obj1, $fetch_obj2);
			$exp_data4 = array(
				'tasks_completed' => 1,
				'tasks_skipped' => 0,
				'total_tasks' => 2,
				'completion_percent' => 50,
			);
			
			$input5 = array($fetch_obj1, $fetch_obj3);
			$exp_data5 = array(
				'tasks_completed' => 0,
				'tasks_skipped' => 1,
				'total_tasks' => 2,
				'completion_percent' => 0,
			);
			
			$input6 = array($fetch_obj1, $fetch_obj7);
			$exp_data6 = array(
				'tasks_completed' => 1,
				'tasks_skipped' => 1,
				'total_tasks' => 2,
				'completion_percent' => 50,
			);
			
			$input7 = array($fetch_obj3, $fetch_obj7);
			$exp_data7 = array(
				'tasks_completed' => 1,
				'tasks_skipped' => 2,
				'total_tasks' => 2,
				'completion_percent' => 50,
			);
			
			$input8 = array_merge($input4, $input7);
			$exp_data8 = array(
				'tasks_completed' => 2,
				'tasks_skipped' => 2,
				'total_tasks' => 4,
				'completion_percent' => 50,
			);
			
			$input9 = array($fetch_obj1, $fetch_obj2, $fetch_obj3, $fetch_obj6, $fetch_obj7);
			
			$input10 = array($fetch_obj3);
			$exp_data10 = array(
				'tasks_completed' => 0,
				'tasks_skipped' => 1,
				'total_tasks' => 1,
				'completion_percent' => 0,
			);
			
			$input11 = array($fetch_obj3, $fetch_obj6);
			
			$input12 = array($fetch_obj3, $fetch_obj5, $fetch_obj6);
			$exp_data12 = array(
				'tasks_completed' => 1,
				'tasks_skipped' => 1,
				'total_tasks' => 1,
				'completion_percent' => 100,
			);
			
			$input13 = array($fetch_obj3, $fetch_obj5, $fetch_obj6, $fetch_obj7);
			$exp_data13 = array(
				'tasks_completed' => 2,
				'tasks_skipped' => 2,
				'total_tasks' => 2,
				'completion_percent' => 100,
			);

			$input14 = array($fetch_obj2, $fetch_obj5, $fetch_obj6);
			$exp_data14 = array(
				'tasks_completed' => 2,
				'tasks_skipped' => 0,
				'total_tasks' => 1,
				'completion_percent' => 100,
			);

			$input15 = array($fetch_obj1, $fetch_obj3, $fetch_obj9);
			$exp_data15 = array(
				'tasks_completed' => 1,
				'tasks_skipped' => 1,
				'total_tasks' => 2,
				'completion_percent' => 50,
			);

			$input16 = array($fetch_obj1, $fetch_obj3, $fetch_obj8, $fetch_obj9);
			$exp_data16 = array(
				'tasks_completed' => 3,
				'tasks_skipped' => 1,
				'total_tasks' => 2,
				'completion_percent' => 100,
			);
			
			for($task_id = 10; $task_id <= 60; $task_id+=10) {
				$input17[$task_id] = array(
					'task_id' => "$task_id",
					'task_count' => '0',
					'task_completed' => '0',
					'task_skipped' => '1',
				);
			}
			$input17[510] = $fetch_obj8;
			$input17[510]['task_completed'] = '10';
			$input17[510]['task_count'] = '5';
			$exp_data17 = array(
				'tasks_completed' => 10,
				'tasks_skipped' => 6,
				'total_tasks' => 6,
				'completion_percent' => 100,
			);

			return array(
						array($input1, $fetch_obj4, $exp_data1),	// all tasks: completed/uncompleted, regular/skipped/bonus
						array($input2, $fetch_obj4, $exp_data1),	// 2 regular (completed/uncompleted) + 2 skipped (completed/uncompleted) + 1 bonus (competed)
						array($input3, $fetch_obj1, $exp_data3),	// 1 regular (uncompleted)
						array($input4, $fetch_obj2, $exp_data4),	// 2 regular (completed/uncompleted)
						array($input5, $fetch_obj3, $exp_data5),	// 1 regular (uncompleted) + 1 skipped (uncompleted)
						array($input6, $fetch_obj7, $exp_data6),	// 1 regular (uncompleted) + 1 skipped (completed)
						array($input7, $fetch_obj7, $exp_data7),	// 2 skipped (completed/uncompleted)
						array($input8, $fetch_obj7, $exp_data8),	// 2 regular (completed/uncompleted) + 2 skipped (completed/uncompleted)
						array($input9, $fetch_obj7, $exp_data8),	// 2 regular (completed/uncompleted) + 2 skipped (completed/uncompleted) + 1 bonus (uncompleted)
						array($input10, $fetch_obj3, $exp_data10),	// 1 skipped (uncompleted)
						array($input11, $fetch_obj6, $exp_data10),	// 1 skipped (uncompleted) + 1 bonus (uncompleted)
						array($input13, $fetch_obj7, $exp_data13),	// 2 skipped (completed/uncompleted) + 2 bonus (completed/uncompleted)
						array($input14, $fetch_obj6, $exp_data14),	// 1 regular (completed) + 2 bonus (completed/uncompleted)
						array($input15, $fetch_obj9, $exp_data15),	// 1 regular (uncompleted) + 1 skipped (uncompleted) + 1 bonus [2nd round] (uncompleted)
						array($input16, $fetch_obj9, $exp_data16),	// 1 regular (uncompleted) + 1 skipped (uncompleted) + 2 bonus [2nd round] (completed/uncompleted)
						array($input17, $input17[510], $exp_data17),	// 6 skipped + 1 bonus [10nd round] (uncompleted)
					);
		}
		
		/**
		 * @dataProvider doTaskDataProvider
		 */
		public function testDoTask($case) {
			global $wgCityId;
			
			$wgCityId = self::TEST_CITY_ID;
			$this->task_id = $case['task_id'];
			$sql_result = $case['sql_result'];
			if (array_key_exists('extra_task',$case))
				$this->extra_task_data = $case['extra_task'];
			
			$this->mock_db->expects($this->any())
							->method('fetchRow')
							->will($this->returnValue($sql_result));
			
			$response = $this->app->sendRequest('FounderProgressBar', 'doTask', array('task_id' => $this->task_id));

			if ($sql_result) {
				$response_data = $response->getVal('actions_completed');
				$expect = $sql_result['task_count'];
				$this->assertEquals($response_data, $expect,'actions_completed');

				/*
				//
				$response_data = $response->getVal('actions_remaining');
				$expect = $this->object->counters[$this->task_id]-$sql_result['task_count'];	// counters = 10 for task_id 10
				$this->assertEquals($response_data, $expect,'actions_remaining');
				*/
			}
			
			$response_data = $response->getVal('result');
			$this->assertEquals($response_data, $case['exp_result'],'result');
			
			if(array_key_exists('error', $case)) {
				$response_data = $response->getVal('error');
				$this->assertEquals($response_data, $case['exp_error'],'error');
			}
		}
		
		// @brief data provider for testDoTask()
		public function doTaskDataProvider() {
			$case1 = array(
							'task_id' => '5',
							'sql_result' => null,
							'exp_result' => 'error',
							'exp_error' => 'invalid task_id',
						);
			
			$case2 = array(
							'task_id' => '20',
							'sql_result' => null,
							'exp_result' => 'error',
							'exp_error' => 'task_completed',
						);
			
			$case3 = array(
							'task_id' => '10',
							'sql_result' => null,
							'exp_result' => 'error',
							'exp_error' => 'invalid task_id',
						);
			
			$case4 = array(
							'task_id' => '10',
							'sql_result' => array('task_id' => '10', 'task_count' => '7'),
							'exp_result' => 'OK',
						);

			$case5 = array(
							'task_id' => '10',
							'sql_result' => array('task_id' => '10', 'task_count' => '10'),
							'exp_result' => 'task_completed',
						);
			
			$case6 = array(
							'task_id' => '10',
							'sql_result' => array('task_id' => '10', 'task_count' => '15'),
							'exp_result' => 'task_completed',
						);
			
			$extra_task = array(
								510 => array (
									'task_id' => '510',
									'task_count' => '5',
									'task_completed' => '0',
									'task_skipped' => '0',
									'task_timestamp' => '5 hours ago',
									'task_label' => 'Uncompleted Bonus task',
									'task_action' => 'Uncompleted Bonus task'),
							);
			
			$case7 = array(
							'task_id' => '510',
							'sql_result' => array('task_id' => '510', 'task_count' => '9'),
							'exp_result' => 'OK',
							'extra_task' => $extra_task,
						);
			
			$case8 = array(
							'task_id' => '510',
							'sql_result' => array('task_id' => '510', 'task_count' => '10'),
							'exp_result' => 'task_completed',
							'extra_task' => $extra_task,
						);
			
			$case9 = array(
							'task_id' => '510',
							'sql_result' => array('task_id' => '510', 'task_count' => '9'),
							'exp_result' => 'OK',
							'extra_task' => $extra_task,
						);
			$case9['extra_task'][510]['task_completed'] = '1';
			
			$case10 = array(
							'task_id' => '510',
							'sql_result' => array('task_id' => '510', 'task_count' => '10'),
							'exp_result' => 'task_completed',
							'extra_task' => $extra_task,
						);
			$case10['extra_task'][510]['task_completed'] = '1';
			
			return array(
						array($case1),	// invalid task_id - task id not found
						array($case2),	// task completed (task_completed = 1)
						array($case3),	// invalid task_id - no data in db
						array($case4),	// success - task count < counters
						array($case5),	// success - task count = counters
						array($case6),	// success - task count > counters
						array($case7),	// success - bonus task count < counters
						array($case8),	// success - bonus task count = counters
						array($case9),	// success - bonus task count < counters (task_completed = 1)
						array($case10),	// success - bonus task count = counters (task_completed = 1)
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
								520 => array (
									'task_id' => '520',
									'task_count' => '1',
									'task_completed' => '0',
									'task_skipped' => '0',
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
				'task_id' => '10',
				'task_count' => '10',
				'task_completed' => '0',
				'task_skipped' => '0',
				'task_timestamp' => '21 hours ago',
				'task_label' => 'Uncompleted task',
				'task_action' => 'Uncompleted task'), 
				20 => array (
				'task_id' => '20',
				'task_count' => '20',
				'task_completed' => '1',
				'task_skipped' => '0',
				'task_timestamp' => '21 hours ago',
				'task_label' => 'Completed Task',
				'task_action' => 'Completed Task'),
				30 => array (
				'task_id' => '30',
				'task_count' => '1',
				'task_completed' => '0',
				'task_skipped' => '1',
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

<?php
	class AdminDashboardTest extends WikiaBaseTest {

		public function setUp() {
			$this->setupFile = dirname(__FILE__) . '/../AdminDashboard.setup.php';
			parent::setUp();
		}

		const TEST_CITY_ID = 79860;
		protected static $list = array('pageviews', 'edits', 'photos');

		protected function setupGetStatsMock($cache_value, $fetch_obj) {
			$mock_cache = $this->getMock('stdClass', array('get', 'set', 'delete'));
			$mock_cache->expects($this->any())
						->method('get')
						->will($this->returnValue($cache_value));
			$mock_cache->expects($this->any())
						->method('set');
			$mock_cache->expects($this->any())
						->method('delete');

			if (!is_null($fetch_obj))
				$this->setMockDb($fetch_obj);

			$this->mockGlobalVariable('wgCityId', self::TEST_CITY_ID);
			$this->mockGlobalVariable('wgMemc', $mock_cache, 0);

			$this->mockGlobalFunction('wfMemcKey', null);
		}

		protected function setMockDb($fetch_obj) {
			$mock_result = $this->getMock('ResultWrapper', array('fetchObject'), array(), '', false);
			$mock_result->expects($this->any())
				->method('fetchObject')
				->will($this->onConsecutiveCalls($fetch_obj[0], $fetch_obj[1], $fetch_obj[2], $fetch_obj[3], $fetch_obj[4], $fetch_obj[5], $fetch_obj[6], $fetch_obj[7], $fetch_obj[8], $fetch_obj[9], $fetch_obj[10], $fetch_obj[11], $fetch_obj[12], $fetch_obj[13], $fetch_obj[14]));

			$mock_db = $this->getDatabaseMock(['query', 'mysqlRealEscapeString']);
			$mock_db->expects($this->any())
					->method('query')
					->will($this->returnValue($mock_result));

			$this->getGlobalFunctionMock( 'wfGetDB' )
				->expects( $this->exactly( 3 ) )
				->method( 'wfGetDB' )
				->will( $this->returnValue( $mock_db ) );

			$this->mockGlobalVariable('wgStatsDB', '', 2);
		}

		/**
		 * @group Slow
		 * @slowExecutionTime 0.03352 ms
		 * @dataProvider getStatsDataProvider
		 */
		public function testGetStats($cache_value, $expected_daily, $expected_total, $fetch_obj=null) {
			$this->setupGetStatsMock($cache_value, $fetch_obj);

			$response = $this->app->sendRequest('QuickStats', 'getStats');

			$response_data = $response->getVal('stats');
			$this->assertEquals($expected_daily, $response_data);

			$response_data = $response->getVal('totals');
			$this->assertEquals($expected_total, $response_data);
		}

		public function getStatsDataProvider() {
			$raw = array (
				7 => array (
					'pageviews' => 11,
					'edits' => 13,
					'photos' => 0,
				),
				6 => array (
					'pageviews' => 90,
					'edits' => 0,
					'photos' => 0,
				),
				5 => array (
					'pageviews' => 115,
					'edits' => 16,
					'photos' => 0,
				),
			);

			// case #1
			for ($i = -7 ; $i < -4 ; $i++) {
				$date = date('Y-m-d', strtotime("$i day"));
				$key = abs($i);
				$daily[$date] = $raw[$key];
			}
			$total = array (
				'totals' => array (
					'pageviews' => 216,
					'edits' => 29,
					'photos' => 0,
				),
			);

			// case #2
			$daily2 = array();
			self::patchZeroStats($daily2);
			$total2 = array(
				'pageviews' => 0,
				'edits' => 0,
				'photos' => 0,
			);
			$fetch_obj2 = array();
			self::patchNull($fetch_obj2);

			// case #3
			$daily3 = $daily;
			$total3 = $total['totals'];
			foreach(self::$list as $l) {
				foreach ($daily3 as $key => $value) {
					$fetch_obj3[] = self::getFetchObjResult($l, $value[$l], $key);
				}
				if ($l != 'pageviews') {
					$fetch_obj3[] = self::getFetchObjResult($l, $total3[$l]);
				}
				$fetch_obj3[] = null;
			}
			self::patchNull($fetch_obj3);
			self::patchZeroStats($daily3);

			// case #4
			$date4 = date('Y-m-d', strtotime("-4 day"));
			$daily4[$date4] = array('pageviews' => 55);
			$total4 = array(
				'pageviews' => 55,
				'edits' => 0,
				'photos' => 0,
			);
			$fetch_obj4[] = self::getFetchObjResult('pageviews', $daily4[$date4]['pageviews'], $date4);
			self::patchNull($fetch_obj4);
			self::patchZeroStats($daily4);

			// case #5
			$date5 = date('Y-m-d', strtotime("-2 day"));
			$daily5[$date5] = array('edits' => 12);
			$total5 = array(
				'pageviews' => 0,
				'edits' => 12,
				'photos' => 0,
			);
			$fetch_obj5[] = null;	// pageviews
			$fetch_obj5[] = self::getFetchObjResult('edits', $daily5[$date5]['edits'], $date5);
			$fetch_obj5[] = self::getFetchObjResult('edits', $total5['edits']);
			self::patchNull($fetch_obj5);
			self::patchZeroStats($daily5);

			// case #6
			$date6 = date('Y-m-d', strtotime("-6 day"));
			$daily6[$date6] = array('photos' => 3);
			$total6 = array(
				'pageviews' => 0,
				'edits' => 0,
				'photos' => 3,
			);
			$fetch_obj6[] = null;	// pageviews
			$fetch_obj6[] = null;	// edits
			$fetch_obj6[] = self::getFetchObjResult('photos', $daily6[$date6]['photos'], $date6);
			$fetch_obj6[] = self::getFetchObjResult('photos', $total6['photos']);
			self::patchNull($fetch_obj6);
			self::patchZeroStats($daily6);

			// case #7
			$daily7[$date4] = array('pageviews' => 55);
			$daily7[$date5] = array('edits' => 12);
			$daily7[$date6] = array('photos' => 3);
			$total7 = array(
				'pageviews' => 55,
				'edits' => 12,
				'photos' => 3,
			);
			$fetch_obj7[] = self::getFetchObjResult('pageviews', $daily7[$date4]['pageviews'], $date4);
			$fetch_obj7[] = null;	// pageviews
			$fetch_obj7[] = self::getFetchObjResult('edits', $daily7[$date5]['edits'], $date5);
			$fetch_obj7[] = self::getFetchObjResult('edits', $total7['edits']);
			$fetch_obj7[] = null;	// edits
			$fetch_obj7[] = self::getFetchObjResult('photos', $daily7[$date6]['photos'], $date6);
			$fetch_obj7[] = self::getFetchObjResult('photos', $total7['photos']);
			self::patchNull($fetch_obj7);
			self::patchZeroStats($daily7);

			return array(
				array($daily+$total, $daily, array_pop($total)),	// cache value
				array(null, $daily2, $total2, $fetch_obj2),			// cache = null, page_views = edits = photo = empty
				array(null, $daily3, $total3, $fetch_obj3),			// cache = null, page_views,edits,photo != empty (same date)
				array(null, $daily4, $total4, $fetch_obj4),			// cache = null, page_views != empty, edits = empty , photo = empty
				array(null, $daily5, $total5, $fetch_obj5),			// cache = null, page_views = empty, edits != empty , photo = empty
				array(null, $daily6, $total6, $fetch_obj6),			// cache = null, page_views = empty, edits = empty , photo != empty
				array(null, $daily7, $total7, $fetch_obj7),			// cache = null, page_views,edits,photo != empty (different date)
			);
		}

		protected static function patchNull(&$data) {
			$max = 15;
			$remains = $max-count($data);
			for($i=0; $i<$remains; $i++) {
				$data[] = null;
			}
		}

		protected static function patchZeroStats(&$data) {
			for ($i = -7 ; $i < 0 ; $i++) {
				$date = date('Y-m-d', strtotime("$i day"));
				foreach(self::$list as $l) {
					if(!isset($data[$date][$l]))
						$data[$date][$l] = 0;
				}
			}
		}

		/**
		 * @dataProvider shortenNumberDecoratorDataProvider
		 * @group UsingDB
		 */
		public function testShortenNumberDecorator($number,$expected) {
			$result = QuickStatsController::shortenNumberDecorator($number);
			$this->assertEquals($expected, $result);
		}

		public function shortenNumberDecoratorDataProvider() {
				return array(
					array(1234,'1,234'), // note: this only works for EN
					array(56000,'56K'),
					array(56710,'56.7K'),
					array(56756,'56.8K'),
					array(56900,'56.9K'),
					array(56990,'57K'),
					array(123456789,'123.5M')
				);
		}

		protected static function getFetchObjResult($key, $cnt, $date=null) {
			$obj = new stdClass();
			$obj->date = $date;
			$obj->cnt = $cnt;

			return $obj;
		}

	}

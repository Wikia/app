<?php

	class WikiFeaturesTest extends WikiaBaseTest {
		const TEST_CITY_ID = 79860;

		protected $wgWikicitiesReadOnly_org = null;
		protected $wgWikiFeatures_org = null;
		protected $release_date_org = null;

		public function setUp() {
			$this->setupFile = __DIR__ . '/../WikiFeatures.setup.php';
			parent::setUp();
		}

		protected function setUpMock($cache_value=null) {
			if(is_null($cache_value)) {
				$mock_cache = $this->getMock('stdClass', array('get', 'set', 'delete'));
			} else {
				$mock_cache = $this->getMock('stdClass', array('get', 'set', 'delete'));
				$mock_cache->expects($this->any())
							->method('get')
							->will($this->returnValue($cache_value));
				$mock_cache->expects($this->any())
							->method('set');
			}
			$mock_cache->expects($this->any())
						->method('delete');

			$this->mockGlobalVariable('wgMemc', $mock_cache);
			$this->mockGlobalVariable('wgCityId', self::TEST_CITY_ID);
		}

		protected function setUpToggleFeature($is_allow) {
			global $wgWikicitiesReadOnly;

			$this->wgWikicitiesReadOnly_org = $wgWikicitiesReadOnly;
			$wgWikicitiesReadOnly = true;

			$mock_log = $this->getMock('LogPage', array('addEntry'), array(), '', false);
			$mock_log->expects($this->any())
						->method('addEntry');
			$this->mockClass('LogPage', $mock_log);

			$mock_user = $this->getMock('User', array('isAllowed'));
			$mock_user->expects($this->any())
						->method('isAllowed')
						->will($this->returnValue($is_allow));

			$this->mockGlobalVariable('wgUser', $mock_user);

		}

		protected function tearDownToggleFeature() {
			global $wgWikicitiesReadOnly;

			$wgWikicitiesReadOnly = $this->wgWikicitiesReadOnly_org;
		}

		protected function setUpGetFeature($feature_type, $wg_wiki_features) {
			global $wgWikiFeatures;

			$this->wgWikiFeatures_org = $wgWikiFeatures;
			$wgWikiFeatures = $wg_wiki_features;
			$this->release_date_org = WikiFeaturesHelper::$release_date;

			if(isset($wg_wiki_features[$feature_type])) {
				foreach ($wg_wiki_features[$feature_type] as $feature) {
					$this->mockGlobalVariable($feature, true);
				}
			}
		}

		protected function tearDownGetFeature() {
			global $wgWikiFeatures;

			$wgWikiFeatures = $this->wgWikiFeatures_org;
			WikiFeaturesHelper::$release_date = $this->release_date_org;
		}

		/**
		 * @group Slow
		 * @slowExecutionTime 0.01386 ms
		 * @dataProvider toggleFeatureDataProvider
		 */
		public function testToggleFeature($is_allow, $feature, $enabled, $exp_result, $exp_error) {
			$this->setUpToggleFeature($is_allow);
			$this->setUpMock();

			$response = $this->app->sendRequest('WikiFeaturesSpecial', 'toggleFeature', array('feature' => $feature, 'enabled' => $enabled));

			$response_data = $response->getVal('result');
			$this->assertEquals($exp_result, $response_data);

			$response_data = $response->getVal('error');
			$this->assertEquals($exp_error, $response_data);

			$this->tearDownToggleFeature();
		}

		public function toggleFeatureDataProvider() {
			return array(
				array(false, null, null,'error', wfMsg('wikifeatures-error-permission', null)),								// permission denied
				array(true, null, null,'error', wfMsg('wikifeatures-error-invalid-parameter', null)),							// missing params - not pass $feature and $enabled
				array(true, null, 0,'error', wfMsg('wikifeatures-error-invalid-parameter', null)),							// missing params - not pass $feature
				array(true, 'wgEnableAchievementsExt', null,'error', wfMsg('wikifeatures-error-invalid-parameter', 'wgEnableAchievementsExt')),	// missing params - not pass $enabled
				array(true, 'wgEnableAchievements', 'true','error', wfMsg('wikifeatures-error-invalid-parameter', 'wgEnableAchievements')),		// invalid params - $feature not found
				array(true, 'wgEnableWikiaLabsExt', 'true','error', wfMsg('wikifeatures-error-invalid-parameter', 'wgEnableWikiaLabsExt')),		// invalid params - $feature not allowed
				array(true, 123, 0,'error', wfMsg('wikifeatures-error-invalid-parameter', 123)),								// invalid params - $feature is integer
				array(true, 'wgEnableAchievementsExt', 1,'error', wfMsg('wikifeatures-error-invalid-parameter', 'wgEnableAchievementsExt')),		// invalid params - $enabled > 1
				array(true, 'wgEnableAchievementsExt', -3,'error', wfMsg('wikifeatures-error-invalid-parameter', 'wgEnableAchievementsExt')),		// invalid params - $enabled is negative
				array(true, 'wgEnableAchievementsExt', 'test','error', wfMsg('wikifeatures-error-invalid-parameter', 'wgEnableAchievementsExt')),	// invalid params - $enabled is string
				array(true, 'wgEnableAchievementsExt', '0','error', wfMsg('wikifeatures-error-invalid-parameter', 'wgEnableAchievementsExt')),		// invalid params - $enabled is string

				array(true, 'wgEnableAchievementsExt', 'true','ok', null),	// enable feature
				array(true, 'wgEnableAchievementsExt', 'false','ok', null),	// disable feature
			);
		}

		/**
		 * @dataProvider getFeatureNormalDataProvider
		 */
		public function testGetFeatureNormal($wg_wiki_features, $exp_result) {
			$this->setUpGetFeature('normal', $wg_wiki_features);
			$this->setUpMock();

			$helper = new WikiFeaturesHelper();
			$response = $helper->getFeatureNormal();
			$this->assertEquals($exp_result, $response);

			$this->tearDownGetFeature();
		}

		public function getFeatureNormalDataProvider() {
			$wiki_features3 = array(
				'labs' => array('wgEnableChat'),
			);
			$wiki_features4 = array(
				'normal' => array('wgEnableAchievementsExt','wgEnableChat')
			);
			$exp4 = array (
				array ('name' => 'wgEnableAchievementsExt', 'enabled' => true, 'imageExtension' => '.png' ),
				array ('name' => 'wgEnableChat', 'enabled' => true, 'imageExtension' => '.png' ),
			);
			$wiki_features5 = array_merge($wiki_features3, $wiki_features4);

			return array(
				array(null, array()),				// invalid wgWikiFeatures - null
				array(array(), array()),			// invalid wgWikiFeatures - array()
				array($wiki_features3, array()),	// invalid wgWikiFeatures - key does not exist

				array($wiki_features4, $exp4),
				array($wiki_features5, $exp4),		// return only normal
			);
		}

		/**
		 * @dataProvider getFeatureLabsDataProvider
		 */
		public function testGetFeatureLabs($wg_wiki_features, $exp_result, $cache_value=null, $release_date=array()) {
			$this->setUpGetFeature('labs', $wg_wiki_features);
			$this->setUpMock($cache_value);

			$helper = new WikiFeaturesHelper();
			WikiFeaturesHelper::$release_date = $release_date;
			$response = $helper->getFeatureLabs();

			$actual_features = [];

			foreach($response as $actual_feature) {
				$actual_features [$actual_feature['name']] = true;
			}
			foreach($exp_result as $feature) {
				$this->assertArrayHasKey($feature['name'], $actual_features);
			}

			$this->tearDownGetFeature();
		}

		public function getFeatureLabsDataProvider() {
			$wiki_features3 = array(
				'normal' => array('wgEnableAchievementsExt','wgEnablePageLayoutBuilder')
			);
			$wiki_features4 = array(
				'labs' => array('wgEnableChat'),
			);
			$exp4 = array (
				array ('name' => 'wgEnableChat', 'enabled' => true, 'new' => false, 'active' => 500, 'imageExtension' => '.png' ),
			);
			$cache_value4 = '500';
			$wiki_features5 = array_merge($wiki_features3, $wiki_features4);
			$cache_value5 = 500;

			$release_date6 = array('wgEnableChat' => 'abc');
			$release_date7 = array('wgEnableChat' => '');
			$release_date8 = array('wgEnableChat' => '123');
			$release_date9 = array('wgEnableChat' => date('Y-m-d', strtotime('-15 days')));
			$release_date10 = array('wgEnableChat' => date('Y-m-d', strtotime('-14 days')));
			$release_date11 = array('wgEnableChat' => date('Y-m-d', strtotime('-13 days')));
			$release_date12 = array('wgEnableChat' => date('Y-m-d', strtotime('now')));
			$release_date13 = array('wgEnableChat' => date('Y-m-d', strtotime('+20 days')));

			$exp10 = array (
				array ('name' => 'wgEnableChat', 'enabled' => true, 'new' => true, 'active' => 500, 'imageExtension' => '.png' ),
			);

			return array(
				array(null, array()),				// invalid wgWikiFeatures - null
				array(array(), array()),			// invalid wgWikiFeatures - array()
				array($wiki_features3, array()),	// invalid wgWikiFeatures - key does not exist

				array($wiki_features4, $exp4, $cache_value4),
				array($wiki_features5, $exp4, $cache_value5),		// return only labs

				array($wiki_features4, $exp4, $cache_value4, $release_date6),	// invalid release date
				array($wiki_features4, $exp4, $cache_value4, $release_date7),	// invalid release date
				array($wiki_features4, $exp4, $cache_value4, $release_date8),	// invalid release date
				array($wiki_features4, $exp4, $cache_value4, $release_date9),	// invalid release date - release date > 15 days
				array($wiki_features4, $exp10, $cache_value4, $release_date10),	// release date = 14 days
				array($wiki_features4, $exp10, $cache_value4, $release_date11),	// release date < 14 days
				array($wiki_features4, $exp10, $cache_value4, $release_date12),	// release date < 14 days
				array($wiki_features4, $exp10, $cache_value4, $release_date13),	// release date -> future
			);
		}

		/**
		 * check release date for all Labs Features
		 *
		 * @group Broken
		 *
		 * fb#21148
		 * These tests doesn't have too much sense IMHO.
		 * They're checking static fields of class which is being tested
		 * with our configuration which is different on production
		 * and on devboxes. Any other idea what else except removing
		 * these tests we can do? @author nAndy
		 */
		public function testLabsFeaturesReleaseDate() {
			global $wgWikiFeatures;

			$exp_result = array_values($wgWikiFeatures['labs']);
			sort($exp_result);
			$response = array_keys(WikiFeaturesHelper::$release_date);
			sort($response);
			$this->assertEquals($exp_result, $response);
		}

		/**
		 * check feedback id for all Labs Features
		 *
		 * @group Broken
		 *
		 * fb#21148
		 * These tests doesn't have too much sense IMHO.
		 * They're checking static fields of class which is being tested
		 * with our configuration which is different on production
		 * and on devboxes. Any other idea what else except removing
		 * these tests we can do? @author nAndy
		 */
		public function testLabsFeaturesFeedbackId() {
			global $wgWikiFeatures;

			$exp_result = true;
			$labs_features = array_values($wgWikiFeatures['labs']);
			$feedback_ids = array_keys(WikiFeaturesHelper::$feedbackAreaIDs);
			foreach($labs_features as $feature) {
				$response = in_array($feature, $feedback_ids);
				$this->assertEquals($exp_result, $response);
			}
		}
	}

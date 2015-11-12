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

	protected function setUpMock( $cacheValue = null ) {
		$mockCache = $this->getMock( 'BagOStuff', [ 'get', 'set', 'delete' ] );
		if ( !is_null( $cacheValue ) ) {
			$mockCache->expects( $this->any() )
						->method( 'get' )
						->will($this->returnValue( $cacheValue ) );
			$mockCache->expects( $this->any() )
						->method( 'set' );
		}
		$mockCache->expects( $this->any() )
					->method( 'delete' );

		$this->mockGlobalVariable( 'wgMemc', $mockCache );
		$this->mockGlobalVariable( 'wgCityId', self::TEST_CITY_ID );
	}

	protected function setUpToggleFeature( $isAllowed, $token ) {
		global $wgWikicitiesReadOnly;

		$this->wgWikicitiesReadOnly_org = $wgWikicitiesReadOnly;
		$wgWikicitiesReadOnly = true;

		$mockLog = $this->getMock( 'LogPage', [ 'addEntry' ], [], '', false );
		$mockLog->expects( $this->any() )
					->method( 'addEntry' );
		$this->mockClass( 'LogPage', $mockLog );

		$mockUser = $this->getMock( 'User', [ 'isAllowed', 'getEditToken' ] );
		$mockUser->expects( $this->any() )
					->method( 'isAllowed' )
					->will( $this->returnValue( $isAllowed ) );
		$mockUser->expects( $this->any() )
					->method( 'getEditToken' )
					->will($this->returnValue( $token ) );

		$this->mockGlobalVariable( 'wgUser', $mockUser );
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
	public function testToggleFeature( $isAllowed, $wasPosted, $token, $params, $expResult, $expError ) {
		$this->setUpToggleFeature( $isAllowed, $token );
		$this->setUpMock();

		if ( $expError !== null ) {
			// Just return the key as the content
			$wfMessageMock = $this->getGlobalFunctionMock( 'wfMessage' );
			$wfMessageMock->expects( $this->any() )
				->method( 'wfMessage' )
				->will( $this->returnCallback( function () {
						$params = func_get_args();
						$messageKey = '';
						if ( !empty( $params ) ) {
							$messageKey = $params[0];
						}
						$messageMock = $this->getMock( 'Message', [ 'escaped' ], [ $messageKey ] );
						$messageMock->expects( $this->any() )
							->method( 'escaped' )
							->will( $this->returnValue( $messageKey ) );

						return $messageMock;
					} )
				);
		}

		$requestMock = $this->getMock( 'WikiaRequest', [ 'wasPosted' ], [ $params ] );
		$requestMock->expects( $this->once() )
			->method( 'wasPosted' )
			->will( $this->returnValue( $wasPosted ) );

		$response = new WikiaResponse( 'json', $requestMock );

		$wikiFeaturesSpecialMock = new WikiFeaturesSpecialController();

		$wikiFeaturesSpecialMock->setRequest( $requestMock );
		$wikiFeaturesSpecialMock->setResponse( $response );

		$wikiFeaturesSpecialMock->toggleFeature();

		$response = $wikiFeaturesSpecialMock->getResponse();

		$responseData = $response->getVal( 'result' );
		$this->assertEquals( $expResult, $responseData );

		$responseData = $response->getVal( 'error' );
		$this->assertEquals( $expError, $responseData );

		$this->tearDownToggleFeature();
	}

	public function toggleFeatureDataProvider() {
		return [
			[ false, true, '1234', [ 'feature' => null, 'enabled' => null, 'token' => '1234' ], 'error', 'wikifeatures-error-permission' ],								// permission denied
			[ true, true, '1234', [ 'feature' => null, 'enabled' => null, 'token' => '1234' ], 'error', 'wikifeatures-error-invalid-parameter' ],							// missing params - not pass $feature and $enabled
			[ true, true, '1234', [ 'feature' => null, 'enabled' => 0, 'token' => '1234' ], 'error', 'wikifeatures-error-invalid-parameter' ],							// missing params - not pass $feature
			[ true, true, '1234', [ 'feature' => 'wgEnableAchievementsExt', 'enabled' => null, 'token' => '1234' ], 'error', 'wikifeatures-error-invalid-parameter' ],	// missing params - not pass $enabled
			[ true, true, '1234', [ 'feature' => 'wgEnableAchievements', 'enabled' => 'true', 'token' => '1234' ], 'error', 'wikifeatures-error-invalid-parameter' ],		// invalid params - $feature not found
			[ true, true, '1234', [ 'feature' => 'wgEnableWikiaLabsExt', 'enabled' => 'true', 'token' => '1234' ], 'error', 'wikifeatures-error-invalid-parameter' ],		// invalid params - $feature not allowed
			[ true, true, '1234', [ 'feature' => 123, 'enabled' => 0, 'token' => '1234' ], 'error', 'wikifeatures-error-invalid-parameter' ],								// invalid params - $feature is integer
			[ true, true, '1234', [ 'feature' => 'wgEnableAchievementsExt', 'enabled' => 1, 'token' => '1234' ], 'error', 'wikifeatures-error-invalid-parameter' ],		// invalid params - $enabled > 1
			[ true, true, '1234', [ 'feature' => 'wgEnableAchievementsExt', 'enabled' => -3, 'token' => '1234' ], 'error', 'wikifeatures-error-invalid-parameter' ],		// invalid params - $enabled is negative
			[ true, true, '1234', [ 'feature' => 'wgEnableAchievementsExt', 'enabled' => 'test', 'token' => '1234' ], 'error', 'wikifeatures-error-invalid-parameter' ],	// invalid params - $enabled is string
			[ true, true, '1234', [ 'feature' => 'wgEnableAchievementsExt', 'enabled' => '0', 'token' => '1234' ], 'error', 'wikifeatures-error-invalid-parameter' ],		// invalid params - $enabled is string

			[ true, true, '1234', [ 'feature' => 'wgEnableAchievementsExt', 'enabled' => 'true', 'token' => '1234' ], 'ok', null ],	// enable feature
			[ true, true, '1234', [ 'feature' => 'wgEnableAchievementsExt', 'enabled' => 'false', 'token' => '1234' ], 'ok', null ],	// disable feature

			[ true, true, '1234', [ 'feature' => 'wgEnableAchievementsExt', 'enabled' => 'false', 'token' => '4321' ], 'error', 'sessionfailure' ],
			[ true, false, '1234', [ 'feature' => 'wgEnableAchievementsExt', 'enabled' => 'false', 'token' => '4321' ], 'error', 'sessionfailure' ],
			[ true, false, '1234', [ 'feature' => 'wgEnableAchievementsExt', 'enabled' => 'false', 'token' => '1234' ], 'error', 'sessionfailure' ],
		];
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

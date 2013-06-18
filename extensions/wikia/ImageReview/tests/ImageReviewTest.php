<?php

class ImageReviewTest extends WikiaBaseTest {
	private $fakeUrl = 'http://fake.wikia.com/wiki/Special:ImageReview';
	private $fakeCorrectImages = array('img1', 'img2', 'img3');
	private $fakeWrongImages = array('img', 'img', 'img');
	private $fakeTimestamp = 123;
	private $fakeUserTs = 123;

	public function setUp() {
		$this->setupFile = __DIR__ . '/../ImageReview.setup.php';
		parent::setUp();
	}

	public function testImageReviewSpecialControllerIndexCorrect() {
		$this->setStubsForImageReviewSpecialControllerTests(false);

		$response = $this->app->sendRequest('ImageReviewSpecialController', 'index', array());
		$imagesList = $response->getVal('imageList');

		$this->assertInternalType('array', $imagesList);
		$this->assertEquals($this->fakeCorrectImages, $imagesList);
	}

	public function testImageReviewSpecialControllerIndexError() {
		$this->setStubsForImageReviewSpecialControllerTests(true);

		$response = $this->app->sendRequest('ImageReviewSpecialController', 'index', array());
		$imagesList = $response->getVal('imageList');

		$this->assertInternalType('array', $imagesList);
		$this->assertEquals($this->fakeWrongImages, $imagesList);
	}

	private function setStubsForImageReviewSpecialControllerTests($error) {
		//our test have all needed rights ;)
		$specialPageStub = $this->getMock('SpecialPage', array('userCanExecute'));
		$specialPageStub->expects($this->any())->method('userCanExecute')->will($this->returnValue(true));
		$this->mockClass('SpecialPage', $specialPageStub);

		//to prevent fatal error
		$wgTitleStub = $this->getMock('Title', array('getFullUrl'));
		$wgTitleStub->expects($this->any())->method('getFullUrl')->will($this->returnValue($this->fakeUrl));
		$this->mockGlobalVariable('wgTitle', $wgTitleStub);

		//not to stop ImageSpecialController() 'cause ts parameter not given
		$wgRequestStub = $this->getMock('Request', array('getVal', 'wasPosted'));
		$wgRequestStub->expects($this->any())->method('getVal')->will($this->returnValue($this->fakeTimestamp));
		$wgRequestStub->expects($this->any())->method('wasPosted')->will($this->returnValue(false));
		$this->mockGlobalVariable('wgRequest', $wgRequestStub);

		if( !$error ) {
			$memcTs = $this->fakeUserTs + 1;

			$imageReviewHelperStub = $this->getMock('ImageReviewHelper', array('refetchImageListByTimestamp'));
			$imageReviewHelperStub
				->expects($this->once())
				->method('refetchImageListByTimestamp')
				->will($this->returnValue($this->fakeCorrectImages));
		} else {
			$memcTs = $this->fakeUserTs - 1;

			$imageReviewHelperStub = $this->getMock('ImageReviewHelper', array('getImageList'));
			$imageReviewHelperStub
				->expects($this->once())
				->method('getImageList')
				->will($this->returnValue($this->fakeWrongImages));
		}
		$this->mockClass('ImageReviewHelper', $imageReviewHelperStub);

		$wgMemcStub = $this->getMock('wgMemc', array('get', 'set', 'add'));
		$wgMemcStub->expects($this->any())->method('get')->will($this->returnValue($memcTs));
		$this->mockGlobalVariable('wgMemc', $wgMemcStub);

		// disable both methods in WikiaResponse
		$this->getMethodMock( 'WikiaResponse', 'addAsset' )
			->expects( $this->any() )
			->method( 'addAsset' );
		$this->getMethodMock( 'WikiaResponse', 'sendHeader' )
			->expects( $this->any() )
			->method( 'sendHeader' );
	}

	/**
	 * @dataProvider imageReviewHelperGetOrderDataProvider
	 */
	public function testImageReviewHelperGetOrder($order, $expected) {
		$getOrderMethod = new ReflectionMethod(
			'ImageReviewHelper', 'getOrder'
		);
		$getOrderMethod->setAccessible(true);

		$this->assertEquals($expected, $getOrderMethod->invoke((new ImageReviewHelper), $order));
	}

	public function imageReviewHelperGetOrderDataProvider() {
		return array(
			array('', 'last_edited desc'),
			array('whatever', 'last_edited desc'),
			array(ImageReviewHelper::ORDER_LATEST, 'last_edited desc'),
			array(ImageReviewHelper::ORDER_PRIORITY_LATEST, 'priority desc, last_edited desc'),
			array(ImageReviewHelper::ORDER_OLDEST, 'last_edited asc'),
		);
	}
}

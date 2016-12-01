<?php
/**
 * Class ImageReviewTest
 *
 * @group MediaFeatures
 */
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

	/**
	 * @group Slow
	 * @slowExecutionTime 0.07902 ms
	 */
	public function testImageReviewSpecialControllerIndexError() {
		$this->setStubsForImageReviewSpecialControllerTests( true );

		$response = $this->app->sendRequest(
			'ImageReviewSpecialController',
			'index',
			[ 'ts' => $this->fakeUserTs ]
		);

		$imagesList = $response->getVal( 'imageList' );
		$this->assertInternalType( 'array', $imagesList );
		$this->assertEquals( $this->fakeWrongImages, $imagesList );
	}

	private function setStubsForImageReviewSpecialControllerTests() {
		//our test have all needed rights ;)
		$specialPageStub = $this->getMock('SpecialPage', array('userCanExecute'));
		$specialPageStub->expects($this->any())->method('userCanExecute')->will($this->returnValue(true));
		$this->mockClass('SpecialPage', $specialPageStub);

		//to prevent fatal error
		$wgTitleStub = $this->getMock('Title', array('getFullUrl'));
		$wgTitleStub->expects($this->any())->method('getFullUrl')->will($this->returnValue($this->fakeUrl));
		$this->mockGlobalVariable('wgTitle', $wgTitleStub);

		//not to stop ImageSpecialController() 'cause ts parameter not given
		$wgRequestStub = $this->getMock('Request', array('getVal', 'wasPosted', 'getIP'));
		$wgRequestStub->expects($this->any())->method('getVal')->will($this->returnValue($this->fakeTimestamp));
		$wgRequestStub->expects($this->any())->method('getIP')->will($this->returnValue('127.0.0.1'));
		$wgRequestStub->expects($this->any())->method('wasPosted')->will($this->returnValue(false));
		$this->mockGlobalVariable('wgRequest', $wgRequestStub);

		$imageReviewHelperStub = $this->getMock('ImageListGetter', array('getImageList'), [$this->fakeUserTs, -1, 1]);
		$imageReviewHelperStub
			->expects($this->once())
			->method('getImageList')
			->will($this->returnValue($this->fakeWrongImages));

		$this->mockClass('ImageListGetter', $imageReviewHelperStub);

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
		// Give user the correct privs
		$userMock =  $this->getMock('User', ['isAllowed']);
		$userMock->expects($this->any())->method('isAllowed')->will($this->returnValue(true));

		$getOrderMethod = new ReflectionMethod(
			'ImageReviewOrderGetter', 'getOrder'
		);
		$getOrderMethod->setAccessible(true);

		$this->assertEquals($expected, $getOrderMethod->invoke((new ImageReviewOrderGetter($user, $order)), $userMock, $order));
	}

	public function imageReviewHelperGetOrderDataProvider() {
		return array(
			array(ImageReviewOrderGetter::LATEST, 'last_edited desc'),
			array(ImageReviewOrderGetter::PRIORITY_LATEST, 'priority desc, last_edited desc'),
			array(ImageReviewOrderGetter::OLDEST, 'last_edited asc'),
		);
	}
}

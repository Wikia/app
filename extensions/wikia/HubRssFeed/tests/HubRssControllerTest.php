<?php
/**
 * Created by JetBrains PhpStorm.
 * User: suchy
 * Date: 07.10.13
 * Time: 10:19
 * To change this template use File | Settings | File Templates.
 */


class HubRssControllerTest extends WikiaBaseTest {

	public function setUp() {
		$dir = dirname( __FILE__ ) . '/../';
		/*require_once $dir . '../WikiaHubsServices/models/MarketingToolboxModel.class.php';*/
		$this->setupFile = $dir . 'HubRssFeed.setup.php';

		parent::setUp();
	}


	public function testConstruct()
	{
		$mock = $this->getMockBuilder('HubRssFeedSpecialController')
				->setMethods(['notfound'])
				->getMock();

		$refl = new \ReflectionObject($mock);
		$prop = $refl->getProperty('currentTitle');
		$prop->setAccessible(true);

		$val = $prop->getValue($mock);
		$this->assertInstanceOf('Title',$val);

	}

	public function testNotFound()
	{
		$mock = $this->getMockBuilder('HubRssFeedSpecialController')
			->disableOriginalConstructor()
			->setMethods(['__construct','setVal'])
			->getMock();

		$mock->expects($this->once())
			->method('setVal')
			->with('links',['abc/Xyz']);

		$mockTitle = $this->getMockBuilder('Title')
					->disableOriginalConstructor()
					->setMethods(['getFullUrl'])
					->getMock();

		$mockTitle->expects($this->any())
					->method('getFullUrl')
					->will($this->returnValue('abc'));

		$mock->currentTitle = $mockTitle;

		$mock->hubs = ['xyz'=>'...'];

		$mock->notfound();

	}



	public function testIndex(){
		$mock = $this->getMockBuilder('HubRssFeedSpecialController')
			->disableOriginalConstructor()
			->setMethods(['notfound','setVal'])
			->getMock();


		$mock->expects($this->once())
			->method('notfound');


		$mockRequest = $this->getMockBuilder('WikiaRequest')
			->setMethods(['getParams'])
			->disableOriginalConstructor()
		->getMock();

		$mockRequest->expects($this->at(0))
				->method('getParams')
				->will($this->returnValue(['pars'=>'AbC']));

		$mockRequest->expects($this->at(1))
			->method('getParams')
			->will($this->returnValue(['pars'=>'XyZ']));


		$mock->request = $mockRequest;
		$mock->hubs = ['abc'=>'desc_abc'];

		var_dump($mockRequest->getParams());
		var_dump($mockRequest->getParams());


	}


}
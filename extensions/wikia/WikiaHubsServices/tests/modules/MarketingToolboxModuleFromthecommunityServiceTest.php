<?php
include( dirname(__FILE__) . '/../../../SpecialMarketingToolbox/validators/WikiaValidatorToolboxUrl.class.php' );
include( dirname(__FILE__) . '/../../../SpecialMarketingToolbox/validators/WikiaValidatorUsersUrl.class.php' );

class MarketingToolboxModuleFromthecommunityServiceTest extends WikiaBaseTest {
	/**
	 * (non-PHPdoc)
	 * @see WikiaBaseTest::setUp()
	 */
	public function setUp() {
		$this->setupFile = dirname(__FILE__) . '/../../WikiaHubsServices.setup.php';
		parent::setUp();
	}

	public static function getProtectedMethod($className, $name) {
		$class = new ReflectionClass($className);
		$method = $class->getMethod($name);
		$method->setAccessible(true);
		return $method;
	}

	/**
	 * @dataProvider getValidatorDataProvider
	 */
	public function testGetValidator($index, $fieldName, $validatorClass, $ownValidatorClass) {

		$method = self::getProtectedMethod('MarketingToolboxModuleFromthecommunityService', 'getValidator');
		$obj = new MarketingToolboxModuleFromthecommunityService('en', 1, 1);
		$validator = $method->invokeArgs($obj, array($index, $fieldName));

		$this->assertInstanceOf($validatorClass, $validator);

		// check if own validator is expected Class
		if (!empty($ownValidatorClass)) {
			$ownValidatorMethod = self::getProtectedMethod('WikiaValidatorDependent', 'getOption');
			$this->assertInstanceOf($ownValidatorClass, $ownValidatorMethod->invokeArgs($validator, array('ownValidator')));
		}

	}

	/**
	 * @dataProvider getJsValidatorDataProvider
	 */
	public function testGetJsValidator($index, $fieldName, $validationString) {
		$method = self::getProtectedMethod('MarketingToolboxModuleFromthecommunityService', 'getJsValidator');
		$obj = new MarketingToolboxModuleFromthecommunityService('en', 1, 1);
		$validationString = $method->invokeArgs($obj, array($index, $fieldName));

		$this->assertEquals($validationString, $validationString);
	}


	public function getValidatorDataProvider() {
		return array(
			array(1, 'photo', 'WikiaValidatorFileTitle', null),
			array(2, 'photo', 'WikiaValidatorDependent', 'WikiaValidatorFileTitle'),
			array(1, 'title', 'WikiaValidatorString', null),
			array(5, 'title', 'WikiaValidatorDependent', 'WikiaValidatorString'),
			array(1, 'url', 'WikiaValidatorUrl', null),
			array(4, 'url', 'WikiaValidatorDependent', 'WikiaValidatorUrl'),
			array(1, 'usersUrl', 'WikiaValidatorUsersUrl', null),
			array(4, 'usersUrl', 'WikiaValidatorDependent', 'WikiaValidatorUsersUrl'),
		);
	}

	public function getJsValidatorDataProvider() {
		return array(
			array(1, 'photo', 'required'),
			array(1, 'title', 'required'),
			array(1, 'url', 'required wikiaUrl'),
			array(1, 'quote', 'required'),
			array(1, 'usersUrl', 'required wikiaUrl'),
			array(2, 'photo', "{required: '#MarketingToolboxtitle2:filled,#MarketingToolboxusersUrl2:filled,#MarketingToolboxquote2:filled,#MarketingToolboxurl2:filled'}"),
			array(2, 'title', "{required: '#MarketingToolboxphoto2:filled,#MarketingToolboxusersUrl2:filled,#MarketingToolboxquote2:filled,#MarketingToolboxurl2:filled'}"),
			array(2, 'url', "{required: '#MarketingToolboxphoto2:filled,#MarketingToolboxtitle2:filled,#MarketingToolboxusersUrl2:filled,#MarketingToolboxquote2:filled'} wikiaUrl"),
			array(2, 'quote', "{required: '#MarketingToolboxphoto2:filled,#MarketingToolboxtitle2:filled,#MarketingToolboxusersUrl2:filled,#MarketingToolboxurl2:filled'}"),
			array(2, 'usersUrl', "{required: '#MarketingToolboxphoto2:filled,#MarketingToolboxtitle2:filled,#MarketingToolboxquote2:filled,#MarketingToolboxurl2:filled'} wikiaUrl"),
			array(5, 'quote', "{required: '#MarketingToolboxphoto5:filled,#MarketingToolboxtitle5:filled,#MarketingToolboxusersUrl5:filled,#MarketingToolboxurl5:filled'}"),
		);
	}

	/**
	 * @dataProvider getStructuredDataDataProvider
	 */
	public function testGetStructuredData($inputData, $expectedData) {
		$boxesCount = $inputData['boxesCount'];
		
		$modelMock = $this->getMock(
			'MarketingToolboxFromthecommunityModel',
			array('getBoxesCount')
		);
		$modelMock->expects($this->once())
			->method('getBoxesCount')
			->will($this->returnValue($boxesCount));
		
		$moduleMock = $this->getMock(
			'MarketingToolboxModuleFromthecommunityService',
			array('getImageInfo', 'getModel'),
			array('en', 1, 1)
		);
		$moduleMock->expects($this->any())
			->method('getModel')
			->will($this->returnValue($modelMock));
		
		$moduleMockedDataMap = array();
		for( $i = 1; $i <= $boxesCount; $i++ ) {
			if( isset($inputData['photo' . $i]) ) {
				$moduleMockedDataMap[] =  array(
					$inputData['photo' . $i],
					0,
					(object) array(
						'url' => $expectedData['entries'][$i - 1]['imageUrl'],
						'title' => $expectedData['entries'][$i - 1]['imageAlt']
					)
				);
			}
		}
		
		$moduleMock->expects($this->any())
			->method('getImageInfo')
			->will($this->returnValueMap($moduleMockedDataMap));
		
		$structuredData = $moduleMock->getStructuredData($inputData);
		$this->assertEquals($expectedData, $structuredData);
	}

	public function getStructuredDataDataProvider() {
		$out = array();

		$inputData = array(
			'boxesCount' => 1,
			'photo1' => 'First SLS Roadster.jpg',
			'title1' => 'Rabbids land',
			'usersUrl1' => 'http://www.assassinscreed.wikia.com/wiki/User:Master_Sima_Yi',
			'quote1' => 'Just a simple description. Visit <a href="nandytest.wikia.com/">nAndy wiki</a> to order some food!',
			'url1' => 'http://www.wikia.com',
			'wikiUrl1' => 'assassinscreed.wikia.com',
			'UserName1' => 'Master Sima Yi',
		);

		$expectedData = array(
			'entries' => array(
				array(
					'articleTitle' => 'Rabbids land',
					'articleUrl' => 'http://www.wikia.com',
					'imageAlt' => 'First SLS Roadster.jpg',
					'imageUrl' => 'http://example.com/First_SLS_Roadster.jpg',
					'userName' => 'Master Sima Yi',
					'userUrl' => 'http://www.assassinscreed.wikia.com/wiki/User:Master_Sima_Yi',
					'wikiUrl' => 'assassinscreed.wikia.com',
					'quote' => 'Just a simple description. Visit <a href="nandytest.wikia.com/">nAndy wiki</a> to order some food!',
					'photoName' => 'First SLS Roadster.jpg',
				),
			)
		);

		$out[] = array($inputData, $expectedData);

		$inputData = array(
			'boxesCount' => 2,
			'photo1' => 'First SLS Roadster.jpg',
			'title1' => 'Rabbids land',
			'usersUrl1' => 'http://www.assassinscreed.wikia.com/wiki/User:Master_Sima_Yi',
			'quote1' => 'Just a simple description. Visit <a href="nandytest.wikia.com/">nAndy wiki</a> to order some food!',
			'url1' => 'http://www.wikia.com',
			'wikiUrl1' => 'assassinscreed.wikia.com',
			'UserName1' => 'Master Sima Yi',
			'photo2' => 'FakeImage.png',
			'title2' => 'Kotleciarnia',
			'usersUrl2' => 'http://www.nandytest.wikia.com/wiki/User:Andrzej_Łukaszewski',
			'quote2' => 'Pure awesomeness...',
			'url2' => 'http://www.nandytest.wikia.com',
			'wikiUrl2' => 'nandytest.wikia.com',
			'UserName2' => 'Andrzej Łukaszewski',
		);

		$expectedData = array(
			'entries' => array(
				array(
					'articleTitle' => 'Rabbids land',
					'articleUrl' => 'http://www.wikia.com',
					'imageAlt' => 'First SLS Roadster.jpg',
					'imageUrl' => 'http://example.com/First_SLS_Roadster.jpg',
					'userName' => 'Master Sima Yi',
					'userUrl' => 'http://www.assassinscreed.wikia.com/wiki/User:Master_Sima_Yi',
					'wikiUrl' => 'assassinscreed.wikia.com',
					'quote' => 'Just a simple description. Visit <a href="nandytest.wikia.com/">nAndy wiki</a> to order some food!',
				),
				array(
					'articleTitle' => 'Kotleciarnia',
					'articleUrl' => 'http://www.nandytest.wikia.com',
					'imageAlt' => 'FakeImage.png',
					'imageUrl' => 'http://example.com/FakeImage.png',
					'userName' => 'Andrzej Łukaszewski',
					'userUrl' => 'http://www.nandytest.wikia.com/wiki/User:Andrzej_Łukaszewski',
					'wikiUrl' => 'nandytest.wikia.com',
					'quote' => 'Pure awesomeness...',
					'photoName' => 'FakeImage.png'
				),
			)
		);

		$out[] = array($inputData, $expectedData);

		$inputData = array(
			'boxesCount' => 2,
			'title1' => 'Rabbids land',
			'usersUrl1' => 'http://www.assassinscreed.wikia.com/wiki/User:Master_Sima_Yi',
			'quote1' => 'Just a simple description. Visit <a href="nandytest.wikia.com/">nAndy wiki</a> to order some food!',
			'url1' => 'http://www.wikia.com',
			'wikiUrl1' => 'assassinscreed.wikia.com',
			'UserName1' => 'Master Sima Yi',
			'photo2' => 'FakeImage.png',
			'title2' => 'Kotleciarnia',
			'usersUrl2' => 'http://www.nandytest.wikia.com/wiki/User:Andrzej_Łukaszewski',
			'quote2' => 'Pure awesomeness...',
			'url2' => 'http://www.nandytest.wikia.com',
			'wikiUrl2' => 'nandytest.wikia.com',
			'UserName2' => 'Andrzej Łukaszewski',
		);

		$expectedData = array(
			'entries' => array(
				array(
					'articleTitle' => 'Rabbids land',
					'articleUrl' => 'http://www.wikia.com',
					'imageAlt' => null,
					'imageUrl' => null,
					'userName' => 'Master Sima Yi',
					'userUrl' => 'http://www.assassinscreed.wikia.com/wiki/User:Master_Sima_Yi',
					'wikiUrl' => 'assassinscreed.wikia.com',
					'quote' => 'Just a simple description. Visit <a href="nandytest.wikia.com/">nAndy wiki</a> to order some food!',
					'photoName' => null,
				),
				array(
					'articleTitle' => 'Kotleciarnia',
					'articleUrl' => 'http://www.nandytest.wikia.com',
					'imageAlt' => 'FakeImage.png',
					'imageUrl' => 'http://example.com/FakeImage.png',
					'userName' => 'Andrzej Łukaszewski',
					'userUrl' => 'http://www.nandytest.wikia.com/wiki/User:Andrzej_Łukaszewski',
					'wikiUrl' => 'nandytest.wikia.com',
					'quote' => 'Pure awesomeness...',
					'photoName' => 'FakeImage.png',
				),
			)
		);

		$out[] = array($inputData, $expectedData);

		return $out;
	}
}

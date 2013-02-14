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
}
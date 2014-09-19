<?php

class WikiaValidatorUsersUrlTest extends PHPUnit_Framework_TestCase {

	/* @var $validator WikiaValidatorUsersUrlTest */
	private $validator;

	protected function setUp () {
		$this->validator = $this->getMock('WikiaValidatorUsersUrl', array('getUserNameFromUrl'));
	}

	/**
	 * @dataProvider urlsDataProvider
	 */
	public function testUrls ($url, $userName, $isValid) {
		$this->validator
			->expects($this->any())
			->method('getUserNameFromUrl')
			// TODO uncoment line below after we update phpunit: https://github.com/sgronblo/phpunit-mock-objects/commit/c9810f6437b60571b046cfedca1f5a20d2493582
			//->with($this->equalTo($url))
			->will($this->returnValue($userName));

		$result = $this->validator->isValid($url);
		$this->assertEquals($isValid, $result);
	}

	public function urlsDataProvider () {
		return array(
			array('http://community.wikia.com/wiki/User:Kvas_damian', 'Kvas damian', true),
			array('http://community.wikia.com/wiki/User:Kvas_dian', false, false),
			array('http://wikia.xxx/wiki/User:Kvas_damian', 'Kvas damian', false),
			array('http://x/wiki/User:Kvas_damian', 'Kvas damian', false),
			array('http://community.wikia.com/wiki/Kvas_damian', false, false),
			array('http://muppet.wikia.com/wiki/User:Kvas_damian', 'Kvas damian', true),
		);
	}
}

<?php

use PHPUnit\Framework\TestCase;

class WikiaValidatorUsersUrlTest extends TestCase {

	/* @var $validator WikiaValidatorUsersUrlTest */
	private $validator;

	protected function setUp () {
		$this->validator = $this->getMockBuilder( WikiaValidatorUsersUrl::class )
			->setMethods( [ 'getUserNameFromUrl' ] )
			->getMock();
	}

	/**
	 * @dataProvider urlsDataProvider
	 */
	public function testUrls ($url, $userName, $isValid) {
		$this->validator
			->expects($this->any())
			->method('getUserNameFromUrl')
			->with($this->equalTo($url))
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

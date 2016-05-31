<?php

class AdEngine2ResourceTest extends WikiaBaseTest {

	public function setUp() {
		global $IP;
		$this->mockGlobalVariable('wgResourceModules', []);

		$this->setupFile = "$IP/extensions/wikia/AdEngine/AdEngine2.setup.php";
		parent::setUp();
	}

	public function testResourceKeyForSpecificDate() {
		$date = new \DateTime('2016-05-15');
		$expectedHash = 'eeb4dda012af5c26148a3161740415e2';

		$this->assertEquals($expectedHash, AdEngine2Resource::getKey('extension.name', $date));
	}

	public function testResourceKeyForDifferentDate() {
		$date = new \DateTime('2014-10-20');
		$expectedHash = '4da40389627d0a5baf3287963bc1e1ad';

		$this->assertEquals($expectedHash, AdEngine2Resource::getKey('extension.name', $date));
	}

	public function testRegisteredResource() {
		global $wgResourceModules;
		$extensionName = 'ext.foo';
		$className = 'FooClass';
		$keys = $this->getKeysForExtension($extensionName);

		AdEngine2Resource::register($extensionName, $className);

		$this->assertSame($keys, array_keys($wgResourceModules));
		foreach ($keys as $key) {
			$this->assertEquals($wgResourceModules[$key]['class'], $className);
		}
	}

	private function getKeysForExtension($name) {
		return [
			md5((new \DateTime('yesterday'))->format(AdEngine2Resource::RESOURCE_DATE_FORMAT) . $name),
			md5((new \DateTime('now'))->format(AdEngine2Resource::RESOURCE_DATE_FORMAT) . $name),
			md5((new \DateTime('tomorrow'))->format(AdEngine2Resource::RESOURCE_DATE_FORMAT) . $name)
		];
	}

}

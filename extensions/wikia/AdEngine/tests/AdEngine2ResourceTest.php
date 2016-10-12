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

		var_dump($keys);
		var_dump(array_keys($wgResourceModules));

		$this->assertSame($keys, array_keys($wgResourceModules));
		foreach ($keys as $key) {
			$this->assertEquals($wgResourceModules[$key]['class'], $className);
		}
	}

	private function getKeysForExtension($name) {
		return [
			AdEngine2Resource::getKey($name, new \DateTime('-2 day')),
			AdEngine2Resource::getKey($name, new \DateTime('yesterday')),
			AdEngine2Resource::getKey($name, new \DateTime('now')),
			AdEngine2Resource::getKey($name, new \DateTime('tomorrow'))
		];
	}

}

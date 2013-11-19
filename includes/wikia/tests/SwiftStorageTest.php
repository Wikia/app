<?php

/**
 * Set of unit tests for SwiftStorage class
 *
 * @author macbre
 *
 * @category Wikia
 * @group Integration
 */
class SwiftStorageTest extends WikiaBaseTest {

	const CITY_ID = 123;
	const CONTAINER = '123test123';

	public function setUp() {
		parent::setUp();
		$this->mockStaticMethod('WikiFactory', 'getVarValueByName', 'http://images.wikia.com/poznan/pl/images');
	}

	public function testNewFromWikiGetUrl() {
		$swift = \Wikia\SwiftStorage::newFromWiki(self::CITY_ID);
		$this->assertStringEndsWith('/poznan/pl/images/foo.jpg', $swift->getUrl('foo.jpg'));
	}

	public function testNewFromContainerGetUrl() {
		$swift = \Wikia\SwiftStorage::newFromContainer(self::CONTAINER);
		$this->assertStringEndsWith('/' . self::CONTAINER . '/foo.jpg', $swift->getUrl('foo.jpg'));

		$swift = \Wikia\SwiftStorage::newFromContainer(self::CONTAINER, '/foo/bar/test/');
		$this->assertStringEndsWith('/' . self::CONTAINER . '/foo/bar/test/foo.jpg', $swift->getUrl('foo.jpg'));
	}

	public function testStoreAndRemove() {
		global $IP;
		$swift = \Wikia\SwiftStorage::newFromContainer(self::CONTAINER);

		// upload the file
		$localFile = "{$IP}/skins/oasis/images/sprite.png";
		$remoteFile = sprintf('Test_%s.png', time());

		$this->assertFalse($swift->exists($remoteFile), 'File should not exist before the upload');
		$res = $swift->store($localFile, $remoteFile, [], 'image/png');

		$this->assertTrue($res->isOK(), 'Upload should be done');

		// check the uploaded file
		$url = $swift->getUrl($remoteFile);
		$this->assertStringEndsWith('/' . self::CONTAINER . '/' . $remoteFile, $url);

		$this->assertTrue(Http::get($url, 'default', ['noProxy' => true]) !== false, 'Uploaded image should return HTTP 200 - ' . $url);
		$this->assertTrue($swift->exists($remoteFile), 'File should exist');

		// npw remove the file
		$res = $swift->remove($remoteFile);
		$this->assertTrue($res->isOK(), 'Delete should be done');

		$this->assertTrue(Http::get($url, 'default', ['noProxy' => true]) === false, 'Removed image should return HTTP 404 - ' . $url);
		$this->assertFalse($swift->exists($remoteFile), 'File should not exist after the delete');
	}
}

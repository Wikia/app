<?php
/**
 * Integration test for file uploads and removals
 *
 * @group Integration
 * @author macbre
 */
class ImagesServiceUploadTest extends WikiaBaseTest {

	const URL = 'http://upload.wikimedia.org/wikipedia/commons/d/d9/Eldfell%2C_Helgafell_and_the_fissure.jpg';
	const FILENAME = 'Test-$1.jpg';

	private $origUser;
	private $fileName;

	protected function setUp() {
		global $wgUser;
		parent::setUp();

		$this->origUser = $wgUser;
		$wgUser = User::newFromName('WikiaBot');

		$this->fileName = str_replace('$1', time(), self::FILENAME);
		wfDebug(__METHOD__ . " - {$this->fileName}\n");
	}

	function testUploadAndRemove() {
		// upload an image
		$res = ImagesService::uploadImageFromUrl(self::URL, (object) [
			'name' => $this->fileName,
			'comment' => __CLASS__,
			'description' => __CLASS__
		]);

		$this->assertTrue($res['status'], 'Upload should end up successfully');
		$this->assertInternalType('integer', $res['page_id'], 'Page ID should be returned');

		// verify that it's accessible via HTTP
		$info = ImagesService::getImageOriginalUrl($this->app->wg->CityId, $res['page_id']);

		$this->assertInternalType('string', $info['src'], 'Image URL should be returned');
		$this->assertTrue(Http::get($info['src']) !== false, 'Uploaded image should return HTTP 200');

		// now, remove it...
		/* @var LocalFile $file */
		$file = wfFindFile($this->fileName);
		$this->assertInstanceOf('LocalFile', $file);

		$status = $file->delete('Test cleanup');
		$this->assertTrue($status->isOK());

		// verify that removed image is not accessible via HTTP
		$this->assertFalse(Http::get($info['src']), 'Removed image should return HTTP 404');
	}

	protected function tearDown() {
		global $wgUser;
		parent::tearDown();

		// restore $wgUser
		$wgUser = $this->origUser;
	}
}

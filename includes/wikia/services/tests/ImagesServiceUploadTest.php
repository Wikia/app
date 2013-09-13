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
	private $hash;

	protected function setUp() {
		global $wgUser;
		parent::setUp();

		$this->origUser = $wgUser;
		$wgUser = User::newFromName('WikiaBot');

		$this->fileName = str_replace('$1', time(), self::FILENAME);
		$this->hash = md5($this->fileName);
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

		$info = ImagesService::getImageOriginalUrl($this->app->wg->CityId, $res['page_id']);
		$this->assertInternalType('string', $info['src'], 'Image URL should be returned');

		// check the path - /firefly/images/9/93/Test-1378975563.jpg
		$this->assertStringEndsWith(
			sprintf('/%s/images/%s/%s/%s', $this->app->wg->DBname, $this->hash{0}, $this->hash{0}.$this->hash{1}, $this->fileName),
			$info['src'],
			'Path should contain a valid hash'
		);

		// verify that it's accessible via HTTP
		$this->assertTrue(Http::get($info['src']) !== false, 'Uploaded image should return HTTP 200 - ' . $info['src']);

		// check thumbnail
		$thumb = ImagesService::getImageSrc($this->app->wg->CityId, $res['page_id'], 120);
		$this->assertInternalType('string', $thumb['src'], 'Thumbnail URL should be returned');

		// check the path - /firefly/images/thumb/5/53/Test-1378979336.jpg/120px-0%2C451%2C0%2C294-Test-1378979336.jpg
		$this->assertContains(
			sprintf('/%s/images/thumb/%s/%s/%s/120px-', $this->app->wg->DBname, $this->hash{0}, $this->hash{0}.$this->hash{1}, $this->fileName),
			$thumb['src'],
			'Path should contain a valid hash'
		);

		$this->assertStringEndsWith(
			$this->fileName,
			$thumb['src'],
			'Path should end with file name'
		);

		$this->assertTrue(Http::get($thumb['src']) !== false, 'Thumbnail should return HTTP 200 - ' . $thumb['src']);

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

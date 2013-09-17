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
	}

	// check the path - /firefly/images/9/93/Test-1378975563.jpg
	private function checkImage(LocalFile $image) {
		$hash = md5($image->getName());
		$url = $image->getUrl();

		$this->assertStringEndsWith(
			sprintf('/%s/images/%s/%s/%s', $this->app->wg->DBname, $hash{0}, $hash{0}.$hash{1}, $image->getName()),
			$url,
			'Path should contain a valid hash'
		);

		// verify that it's accessible via HTTP
		$this->assertTrue(Http::get($url, 'default', ['noProxy' => true]) !== false, 'Uploaded image should return HTTP 200 - ' . $url);
	}

	// check the path - /firefly/images/thumb/5/53/Test-1378979336.jpg/120px-0%2C451%2C0%2C294-Test-1378979336.jpg
	private function checkThumbnail(LocalFile $image) {
		$hash = md5($image->getName());
		$thumb = $image->createThumb(120);

		$this->assertContains(
			sprintf('/%s/images/thumb/%s/%s/%s/120px-', $this->app->wg->DBname, $hash{0}, $hash{0}.$hash{1}, $image->getName()),
			$thumb,
			'Path should contain a valid hash'
		);

		$this->assertStringEndsWith(
			$image->getName(),
			$thumb,
			'Path should end with file name'
		);

		# TODO: thumbnailer doesn't work currently
		#$this->assertTrue(Http::get($thumb, 'default', ['noProxy' => true]) !== false, 'Thumbnail should return HTTP 200 - ' . $thumb);
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

		/* @var LocalFile $file */
		$file = wfFindFile($this->fileName);
		$this->assertInstanceOf('LocalFile', $file);
		$image = $file->getUrl();

		$this->checkImage($file);
		$this->checkThumbnail($file);

		// now, remove it...
		$status = $file->delete('Test cleanup');
		$this->assertTrue($status->isOK(), 'Deleting failed');

		// verify that removed image is not accessible via HTTP
		$this->assertTrue(Http::get($image, 'default', ['noProxy' => true]) === false, 'Removed image should return HTTP 404 - ' . $image);
	}

	protected function tearDown() {
		global $wgUser;
		parent::tearDown();

		// restore $wgUser
		$wgUser = $this->origUser;
	}
}

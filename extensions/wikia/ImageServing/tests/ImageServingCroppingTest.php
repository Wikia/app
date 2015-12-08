<?php
/**
 * @author macbre
 * @group Integration
 * @group MediaFeatures
 * @group ImageServing
 */
class ImageServingCroppingTest extends WikiaBaseTest {

	const FILE_NAME = 'Wiki-wordmark.png';

	private $tmpFile;

	public function setUp() {
		$this->setupFile =  __DIR__ . '/../imageServing.setup.php';
		parent::setUp();

		$this->mockGlobalVariable('wgEnableVignette', true);
		$this->mockGlobalVariable('wgUploadPath', 'http://images.wikia.com/firefly/images');
	}

	public function testCropping() {
		// requested crop size is 50 x 50
		$im = new ImageServing(null, 50);
		$file = wfFindFile(self::FILE_NAME);

		// pass dimensions of full size image
		$cropUrl = $im->getUrl($file, $file->getWidth(), $file->getHeight());

		$this->assertContains('/firefly/images/8/89/Wiki-wordmark.png/revision/latest/', $cropUrl);
		$this->assertContains('/width/50/', $cropUrl);

		// verify crop response
		$res = Http::get($cropUrl, 'default', ['noProxy' => true]);
		$this->assertTrue($res !== false, "<{$cropUrl}> should return HTTP 200");

		// verify crop size
		$this->tmpFile = tempnam( wfTempDir(), 'img' );
		file_put_contents($this->tmpFile, $res);

		list($tmpWidth, $tmpHeight) = getimagesize($this->tmpFile);

		$this->assertEquals(50, $tmpWidth, 'expected crop width not matched - ' . $cropUrl);
		$this->assertEquals(49, $tmpHeight, 'expected crop height not matched - ' . $cropUrl);
	}

	public function tearDown() {
		if (!empty($this->tmpFile)) {
			unlink($this->tmpFile);
		}

		parent::tearDown();
	}

}

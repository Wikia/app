<?php
/**
 * @author macbre
 * @group MediaFeatures
 * @group ImageServing
 * @group Infrastructure
 */
class ImageServingCroppingTest extends WikiaBaseTest {

	const FILE_NAME = 'Wiki-wordmark.png';

	public function setUp() {
		$this->setupFile =  __DIR__ . '/../imageServing.setup.php';
		parent::setUp();

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

		// Vignette response is tested by https://github.com/Wikia/vignette/blob/1890639494dba37dafed7b9df2bc4cfd30f5f34b/test/vignette/http/integration_test.clj
	}

}

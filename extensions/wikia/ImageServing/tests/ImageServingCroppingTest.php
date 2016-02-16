<?php
/**
 * @author macbre
 * @group Integration
 * @group MediaFeatures
 * @group ImageServing
 */
class ImageServingCroppingTest extends WikiaBaseTest {

	const FILE_NAME = 'Wiki-wordmark.png';

	public function setUp() {
		$this->setupFile =  __DIR__ . '/../imageServing.setup.php';
		parent::setUp();

		$this->mockGlobalVariable('wgEnableVignette', true);
	}

	public function testCroppingPath() {
		// requested crop size is 50 x 50
		$im = new ImageServing(null, 50);
		$file = wfFindFile(self::FILE_NAME);

		// pass dimensions of full size image
		$cropUrl = $im->getUrl($file, $file->getWidth(), $file->getHeight());

		$this->assertContains(sprintf('/firefly/images/8/89/%s/revision/latest/', self::FILE_NAME), $cropUrl);
		$this->assertContains('/width/50/', $cropUrl);
	}

}

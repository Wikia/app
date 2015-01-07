<?php
class VignetteRequestTest extends WikiaBaseTest {
	private $vignetteUrl = 'http://vignette.wikia-dev.com';

	public function testSetThumbnailFormat() {
		$this->mockGlobalVariable('wgVignetteUrl', $this->vignetteUrl);
		$this->assertEquals(
			VignetteRequest::setThumbnailFormat("{$this->vignetteUrl}/tests/images/a/ab/SomeFile.jpg/revision/latest/scale-to-width/100?cb=12345", ImagesService::EXT_PNG),
			"{$this->vignetteUrl}/tests/images/a/ab/SomeFile.jpg/revision/latest/scale-to-width/100?cb=12345&format=png"
		);

		$this->assertEquals(
			VignetteRequest::setThumbnailFormat("{$this->vignetteUrl}/tests/images/a/ab/SomeFile.jpg/revision/latest/scale-to-width/100", ".png"),
			"{$this->vignetteUrl}/tests/images/a/ab/SomeFile.jpg/revision/latest/scale-to-width/100?format=png"
		);
	}

	public function testGetImageFilename() {
		$this->mockGlobalVariable('wgVignetteUrl', $this->vignetteUrl);
		$this->assertEquals(
			VignetteRequest::getImageFilename("{$this->vignetteUrl}/tests/images/a/ab/SomeFile.jpg/revision/latest/scale-to-width/100?cb=12345"),
			"SomeFile.jpg"
		);

		$this->assertEquals(
			VignetteRequest::getImageFilename("{$this->vignetteUrl}/tests/images/a/ab/SomeFile.jpg/revision/latest?cb=12345"),
			"SomeFile.jpg"
		);
	}

	/**
	 * @expectedException InvalidArgumentException
	 */
	public function testBadUrl() {
		$this->mockGlobalVariable('wgVignetteUrl', $this->vignetteUrl);
		VignetteRequest::fromUrl("http://google.com/search");
	}

	/**
	 * @expectedException InvalidArgumentException
	 */
	public function testBadThumbnailDefinition() {
		$this->mockGlobalVariable('wgVignetteUrl', $this->vignetteUrl);
		VignetteRequest::fromUrl("{$this->vignetteUrl}/tests/images/a/ab/SomeFile.jpg/revision/latest/thumbnail/width/100/height");
	}
}

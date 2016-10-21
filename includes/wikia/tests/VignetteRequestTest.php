<?php

use Wikia\Vignette\UrlConfig;
use Wikia\Vignette\UrlGenerator;

/**
 * @group Vignette
 */
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

		# the old thumb URL format
		$this->assertEquals(
			VignetteRequest::getImageFilename("{$this->vignetteUrl}/civilization/images/4/4a/Foo.png"),
			null
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

	/**
	 * @param string $vignetteResult
	 * @param string $legacyDefinition
	 * @dataProvider legacyThumbDefinitions
	 */
	public function testApplyLegacyThumbDefinition($vignetteResult, $legacyDefinition) {
		$this->mockGlobalVariable('wgVignetteUrl', $this->vignetteUrl);

		$baseUrl = "{$this->vignetteUrl}/tests/images/a/ab/filename.jpg/revision/latest";
		$generator = VignetteRequest::fromConfigMap([
			'relative-path' => 'a/ab/filename.jpg',
			'bucket' => 'tests',
			'timestamp' => '123',
			'domain-shard-count' => 2,
		]);
		$actual = VignetteRequest::applyLegacyThumbDefinition($generator, $legacyDefinition)->url();

		$this->assertEquals("{$baseUrl}/{$vignetteResult}", $actual);
	}

	public function legacyThumbDefinitions() {
		return [
			[
				'scale-to-width-down/400?cb=123&format=webp',
				'400px-filename.jpg.webp'
			],
			[
				'fixed-aspect-ratio/width/200/height/100?cb=123&format=jpg',
				'200x100-filename.jpg'
			],
			[
				'zoom-crop/width/50/height/75?cb=123&format=png',
				'50x75x10-filename.jpg.png'
			],
			[
				'window-crop/width/50/x-offset/10/y-offset/20/window-width/40/window-height/60?cb=123&format=jpg',
				'50px-10,50,20,80-filename.jpg'
			],
			[
				'window-crop-fixed/width/50/height/100/x-offset/10/y-offset/20/window-width/40/window-height/60?cb=123&format=jpg',
				'50x100-10,50,20,80-filename.jpg'
			],
			[
				'window-crop/width/50/x-offset/-10/y-offset/-20/window-width/60/window-height/100?cb=123&format=jpg',
				'50px--10,50,-20,80-filename.jpg'
			],
		];
	}

	/**
	 * @param string $url
	 * @param bool $expected
	 * @dataProvider isVignetteUrlDataProvider
	 */
	public function testIsVignetteUrl($url, $expected) {
		$this->mockGlobalVariable('wgVignetteUrl', $this->vignetteUrl);

		$this->assertEquals($expected, VignetteRequest::isVignetteUrl($url));
	}

	public function isVignetteUrlDataProvider() {
		return [
			[
				# thumb
				$this->vignetteUrl . '/nordycka/images/f/f2/Saksunardalur.jpg/revision/latest/scale-to-width-down/300?cb=20150113215859&path-prefix=pl',
				true
			],
			[
				# original
				$this->vignetteUrl . '/nordycka/images/f/f2/Saksunardalur.jpg/revision/latest?cb=20150113215859&path-prefix=pl',
				true
			],
			[
				# the old thumb URL format will still be treated as a Vignette URL
				$this->vignetteUrl . '/civilization/images/4/4a/Dromon_%28Civ5%29.png',
				true
			],
			[
				# not an URL at all
				"<img src=\"{$this->vignetteUrl}/nordycka/images/f/f2/Saksunardalur.jpg/revision/latest?cb=20150113215859&path-prefix=pl\" />",
				false
			],
		];
	}
}

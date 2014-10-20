<?php

namespace Wikia\Tests\WikiaSkin;

class DummySkin extends \WikiaSkin {

	protected $strictAssetUrlCheck = false;

}

/**
 * A set of unit tests for WikiaSkin class
 *
 * @author macbre
 */
class WikiaSkinTest extends \WikiaBaseTest {

	private function mockOutputPage(Array $styles) {
		$links = '';
		foreach ($styles as $style) {
			$links .= \Html::linkedStyle($style);
		}

		$this->mockGlobalVariable('wgOut', $this->mockClassWithMethods('OutputPage', [
			'buildCssLinks' => $links
		]));
	}

	/**
	 * Test for WikiaSkin::getStylesWithCombinedSASS
	 *
	 */
	public function testGetStylesWithCombinedSASS() {
		$cssFiles = [
			'/ext/123/style.css',
			'/ext/456/style.scss', # this one should be combined with files from $sassFiles
			'/ext/789/style.css',
		];
		$sassFiles = [
			'foo/bar/style.scss',
			'foo/awesome/style.scss',
		];

		$this->mockOutputPage($cssFiles);

		$skin = new DummySkin();
		$combinedStyles = $skin->getStylesWithCombinedSASS($sassFiles);

		$this->assertEquals(3, substr_count($combinedStyles, '<link rel="stylesheet"'), 'There should be three CSS/SASS requests made - ' . $combinedStyles);
		$this->assertEquals(1, substr_count($combinedStyles, '/sasses/'), 'Concatenated SASS files should be requested with a single request - ' . $combinedStyles);
		$this->assertEquals(2, substr_count($combinedStyles, '<link rel="stylesheet" href="/ext/'), 'CSS files should still be loaded separately - ' . $combinedStyles);

		foreach(array_merge($cssFiles, $sassFiles) as $style) {
			$this->assertContains($style, $combinedStyles, 'Each CSS/SASS should be requested - ' . $combinedStyles);
		}
	}

}

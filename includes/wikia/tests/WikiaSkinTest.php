<?php

namespace Wikia\Tests\WikiaSkin;

class DummySkin extends \WikiaSkin {

	protected $strictAssetUrlCheck = false;

	/**
	 * Do not call SkinAfterBottomScripts hook
	 *
	 * @return String
	 */
	function bottomScripts() {
		return $this->getOutput()->getBottomScripts();
	}

}

/**
 * A set of unit tests for WikiaSkin class
 *
 * @author macbre
 */
class WikiaSkinTest extends \WikiaBaseTest {

	private function mockOutputPageWithStyles(Array $styles) {
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

		$this->mockOutputPageWithStyles($cssFiles);

		$skin = new DummySkin();
		$combinedStyles = $skin->getStylesWithCombinedSASS($sassFiles);

		$this->assertEquals(4, substr_count($combinedStyles, '<link rel="stylesheet"'), 'There should be four CSS/SASS requests made - ' . $combinedStyles);
		$this->assertEquals(2, substr_count($combinedStyles, '/sasses/'), 'Concatenated SASS files should be requested with a two requests - ' . $combinedStyles);
		$this->assertEquals(2, substr_count($combinedStyles, '<link rel="stylesheet" href="/ext/'), 'CSS files should still be loaded separately - ' . $combinedStyles);

		foreach(array_merge($cssFiles, $sassFiles) as $style) {
			$this->assertContains($style, $combinedStyles, 'Each CSS/SASS should be requested - ' . $combinedStyles);
		}
	}

	/**
	 * Test for WikiaSkin::getScriptsWithCombinedGroups
	 */
	public function testGetScriptsWithCombinedGroups() {
		global $wgStyleVersion, $wgCdnRootUrl;
		$cb = $wgStyleVersion;

		$inlineScripts = [
			'var inlineScript = true;',
		];
		$groups = [
			'tracker_js',
			'oasis_jquery',
		];
		$singleAssets = [
			'/extensions/wikia/Foo/js/bar.js',
		];

		$skin = new DummySkin();
		$out = $skin->getOutput();

		// add the stuff the output
		foreach($inlineScripts as $item) {
			$out->addScript(\Html::inlineScript($item));
		}
		foreach($groups as $item) {
			\Wikia::addAssetsToOutput($item);
		}
		foreach($singleAssets as $item) {
			\Wikia::addAssetsToOutput($item);
		}

		$jsGroups = ['jquery'];

		$combinedScripts = $skin->getScriptsWithCombinedGroups($jsGroups);

		// assert that single AM groups are not requested
		foreach($groups as $item) {
			$this->assertNotContains("/__am/{$cb}/group/-/{$item}", $combinedScripts, "'{$item}' group should not be loaded separately");
		}

		// assert that single static files are still requested
		foreach($singleAssets as $item) {
			$this->assertContains("/{$item}", $combinedScripts, "'{$item}' asset should still be loaded separately");
		}

		// assert that inline scripts are still there
		foreach($inlineScripts as $item) {
			$this->assertContains(\Html::inlineScript($item), $combinedScripts, "Inline scripts should be kept");
		}

		// assert that combined AM groups <script> tag is the first one
		$items = join(',', array_merge(['jquery'], $groups));
		$this->assertStringStartsWith("<script src='{$wgCdnRootUrl}/__am/{$cb}/groups/-/{$items}", $combinedScripts, "'{$items}' groups should be loaded in a single request");

		// $jsGroups should be updated with the full list of combined groups
		$this->assertEquals($jsGroups, array_merge(['jquery'], $groups), '$jsGroups should contain the list of combined groups');
	}

	/**
	 * Test for WikiaSkin::getStylesWithCombinedSASS
	 */
	public function testCrossoriginAttributeSet() {
		global $wgCrossoriginScssFile;
		$wgCrossoriginScssFile = 'foo/bar/crossorigin.scss';
		$sassFiles = [
			'foo/bar/crossorigin.scss',
			'foo/bar/dummy.scss',
		];
		$this->mockOutputPageWithStyles([]);
		$skin = new DummySkin();

		$combinedStyles = $skin->getStylesWithCombinedSASS($sassFiles);

		$this->assertEquals(1, substr_count($combinedStyles, "crossorigin=\"anonymous\""));
	}

	/**
	 * Test for WikiaSkin::getStylesWithCombinedSASS
	 */
	public function testCrossoriginAttributeUnset() {
		global $wgCrossoriginScssFile;
		$wgCrossoriginScssFile = 'foo/bar/crossorigin.scss';
		$sassFiles = [
			'foo/bar/not/crossorigin.scss',
			'foo/bar/dummy.scss',
		];
		$this->mockOutputPageWithStyles([]);
		$skin = new DummySkin();

		$combinedStyles = $skin->getStylesWithCombinedSASS($sassFiles);

		$this->assertEquals(0, substr_count($combinedStyles, "crossorigin=\"anonymous\""));
	}
}

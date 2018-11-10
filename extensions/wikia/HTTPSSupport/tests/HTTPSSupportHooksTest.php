<?php
use PHPUnit\Framework\TestCase;

class HTTPSSupportHooksTest extends TestCase {

	protected function setUp() {
		parent::setUp();
		require_once __DIR__ . '/../HTTPSSupportHooks.class.php';
	}

	/**
	 * @param string $style
	 * @param string $languagePath
	 * @param boolean $expectedResult
	 *
	 * @dataProvider onBeforeResourceLoaderCSSMinifierDataProvider
	 */
	public function testOnBeforeResourceLoaderCSSMinifier( $style, $languagePath, $expectedResult ) {
		global $wgScriptPath;

		$originalWgScriptPath = $wgScriptPath;
		$wgScriptPath = $languagePath;

		HTTPSSupportHooks::onBeforeResourceLoaderCSSMinifier( $style );
		$this->assertEquals( $expectedResult, $style );

		$wgScriptPath = $originalWgScriptPath;
	}

	public function onBeforeResourceLoaderCSSMinifierDataProvider() {
		return [
			[
				'@import "/load.php?articles=Mediawiki:Test.css&only=styles&mode=articles";',
				'/pl',
				'@import "/pl/load.php?articles=Mediawiki:Test.css&only=styles&mode=articles";',
			],
			[
				"@import '/load.php?articles=Mediawiki:Test.css&only=styles&mode=articles';",
				'/pl',
				"@import '/pl/load.php?articles=Mediawiki:Test.css&only=styles&mode=articles';",
			],
			[
				'@import url("/load.php?articles=Mediawiki:Test.css&only=styles&mode=articles")',
				'/pl',
				'@import url("/pl/load.php?articles=Mediawiki:Test.css&only=styles&mode=articles")',
			],
			[
				'@import "/Mediawiki:Test.css?ctype=text/css&action=raw";',
				'/pl',
				'@import "/pl/Mediawiki:Test.css?ctype=text/css&action=raw";',
			],
			[
				'@import url("/MediaWiki:Test.css?ctype=text/css&action=raw");',
				'/pl',
				'@import url("/pl/MediaWiki:Test.css?ctype=text/css&action=raw");',
			],
			[
				'@import "/index.php?title=MediaWiki:Test.css&action=raw&ctype=text/css";',
				'/pl',
				'@import "/pl/index.php?title=MediaWiki:Test.css&action=raw&ctype=text/css";',
			],
			[
				'@import url("/index.php?title=MediaWiki:Test.css&action=raw&ctype=text/css");',
				'/pl',
				'@import url("/pl/index.php?title=MediaWiki:Test.css&action=raw&ctype=text/css");',
			],
			[
				'@import url("/index.php?title=MediaWiki:Test.css&action=raw&ctype=text/css");',
				'',
				'@import url("/index.php?title=MediaWiki:Test.css&action=raw&ctype=text/css");',
			],
			[
				'@import "/load.php?articles=Mediawiki:Test.css&only=styles&mode=articles";@import url(\'/index.php?title=MediaWiki:Test.css&action=raw&ctype=text/css\');',
				'/pl',
				'@import "/pl/load.php?articles=Mediawiki:Test.css&only=styles&mode=articles";@import url(\'/pl/index.php?title=MediaWiki:Test.css&action=raw&ctype=text/css\');',
			],
			[
				'@import "/load.php?articles=Mediawiki:Test.css&only=styles&mode=articles";@import url("/index.php?title=MediaWiki:Test.css&action=raw&ctype=text/css");',
				'/pl',
				'@import "/pl/load.php?articles=Mediawiki:Test.css&only=styles&mode=articles";@import url("/pl/index.php?title=MediaWiki:Test.css&action=raw&ctype=text/css");',
			],
			[
				'@import url("/index.php?title=MediaWiki:Test.css&action=raw&ctype=text/css");@import "/load.php?articles=Mediawiki:Test.css&only=styles&mode=articles";',
				'/pl',
				'@import url("/pl/index.php?title=MediaWiki:Test.css&action=raw&ctype=text/css");@import "/pl/load.php?articles=Mediawiki:Test.css&only=styles&mode=articles";',
			]
		];
	}
}

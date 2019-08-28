<?php
use PHPUnit\Framework\TestCase;

class HTTPSSupportHooksTest extends TestCase {
	use MockGlobalVariableTrait;
	use MockEnvironmentTrait;

	const MOCK_DEV_NAME = 'mockdevname';

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
	/**
	 * @param string $url
	 * @param string $environment
	 * @param string $expectedResult
	 *
	 * @dataProvider onLinkerMakeExternalLinkDataProvider
	 */
	public function testOnLinkerMakeExternalLink( $url, $environment, $expectedResult ) {

		$exampleString = '';
		$exampleBool = false;
		$exampleArray = [];

		$this->mockEnvironment( $environment );
		HTTPSSupportHooks::onLinkerMakeExternalLink( $url, $exampleString, $exampleBool, $exampleArray );
		$this->unsetGlobals();
		$this->assertEquals( $expectedResult, $url );

	}

	public function onLinkerMakeExternalLinkDataProvider() {
		yield [
			'http://www.example.com',
			WIKIA_ENV_PROD,
			'http://www.example.com',
		];
		yield [
			'https://www.example.com' ,
			WIKIA_ENV_PROD,
			'https://www.example.com',
		];
		yield [
			'http://www.example.com/www.fandom.com/abc' ,
			WIKIA_ENV_PROD,
			'http://www.example.com/www.fandom.com/abc',
		];
		yield [
			'https://www.example.com/www.fandom.com/abc' ,
			WIKIA_ENV_PROD,
			'https://www.example.com/www.fandom.com/abc',
		];
		yield [
			'http://ja.starwars.wikia.com/wiki/Yoda?key=value',
			WIKIA_ENV_PROD,
			'http://ja.starwars.wikia.com/wiki/Yoda?key=value',
		];
		yield [
			'http://starwars.wikia.com/wiki/Yoda?key=value',
			WIKIA_ENV_PROD,
			'https://starwars.wikia.com/wiki/Yoda?key=value',
		];
		yield [
			'http://starwars.fandom.com/wiki/Yoda?key=value',
			WIKIA_ENV_PROD,
			'https://starwars.fandom.com/wiki/Yoda?key=value',
		];
		yield [
			'http://starwars.verify.fandom.com/wiki/Yoda?key=value',
			WIKIA_ENV_VERIFY,
			'https://starwars.verify.fandom.com/wiki/Yoda?key=value',
		];
		yield [
			'http://starwars.preview.fandom.com/wiki/Yoda?key=value',
			WIKIA_ENV_PREVIEW,
			'https://starwars.preview.fandom.com/wiki/Yoda?key=value',
		];
		yield [
			'http://starwars.preview.wikia.com/wiki/Yoda?key=value',
			WIKIA_ENV_PREVIEW,
			'https://starwars.preview.wikia.com/wiki/Yoda?key=value',
		];
		yield [
			'http://ja.starwars.preview.fandom.com/wiki/Yoda?key=value',
			WIKIA_ENV_PREVIEW,
			'http://ja.starwars.preview.fandom.com/wiki/Yoda?key=value',
		];
		yield [
			'http://ja.starwars.preview.wikia.com/wiki/Yoda?key=value',
			WIKIA_ENV_PREVIEW,
			'http://ja.starwars.preview.wikia.com/wiki/Yoda?key=value',
		];
		yield [
			'http://starwars.sandbox-s1.fandom.com/wiki/Yoda?key=value' ,
			WIKIA_ENV_SANDBOX,
			'https://starwars.sandbox-s1.fandom.com/wiki/Yoda?key=value',
		];
		yield [
			'http://starwars.mockdevname.fandom-dev.pl/wiki/Yoda?key=value',
			WIKIA_ENV_DEV,
			'https://starwars.mockdevname.fandom-dev.pl/wiki/Yoda?key=value',
		];
		yield [
			'http://starwars.mockdevname.fandom-dev.us/wiki/Yoda?key=value',
			WIKIA_ENV_DEV,
			'https://starwars.mockdevname.fandom-dev.us/wiki/Yoda?key=value',
		];
		yield [
			'http://starwars.mockdevname.wikia-dev.pl/wiki/Yoda?key=value',
			WIKIA_ENV_DEV,
			'https://starwars.mockdevname.wikia-dev.pl/wiki/Yoda?key=value',
		];
		yield [
			'http://starwars.mockdevname.wikia-dev.us/wiki/Yoda?key=value',
			WIKIA_ENV_DEV,
			'https://starwars.mockdevname.wikia-dev.us/wiki/Yoda?key=value',
		];
		yield [
			'http://ja.starwars.mockdevname.wikia-dev.us/wiki/Yoda?key=value',
			WIKIA_ENV_DEV,
			'http://ja.starwars.mockdevname.wikia-dev.us/wiki/Yoda?key=value',
		];
	}
}

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
		HTTPSSupportHooks::onLinkerMakeExternalLink($url,$exampleString , $exampleBool, $exampleArray);
		$this->assertEquals( $expectedResult, $url );

	}

	public function onLinkerMakeExternalLinkDataProvider() {
		return [
			[
				'$url' => 'http://www.example.com',
				'$environment' => WIKIA_ENV_PROD,
				'$expectedResult' => 'http://www.example.com',
			],
			[
				'$url' => 'https://www.example.com' ,
				'$environment' => WIKIA_ENV_PROD,
				'$expectedResult' => 'https://www.example.com',
			],
			[
				'$url' => 'http://ja.starwars.wikia.com/wiki/Yoda?key=value',
				'$environment' => WIKIA_ENV_PROD,
				'$expectedResult' => 'http://ja.starwars.wikia.com/wiki/Yoda?key=value',
			],
			[
				'$url' => 'http://starwars.wikia.com/wiki/Yoda?key=value',
				'$environment' => WIKIA_ENV_PROD,
				'$expectedResult' => 'https://starwars.wikia.com/wiki/Yoda?key=value',
			],
			[
				'$url' => 'http://starwars.fandom.com/wiki/Yoda?key=value',
				'$environment' => WIKIA_ENV_PROD,
				'$expectedResult' => 'https://starwars.fandom.com/wiki/Yoda?key=value',
			],
			[
				'$url' => 'http://starwars.verify.fandom.com/wiki/Yoda?key=value',
				'$environment' => WIKIA_ENV_VERIFY,
				'$expectedResult' => 'https://starwars.verify.fandom.com/wiki/Yoda?key=value',
			],
			[
				'$url' => 'http://starwars.preview.fandom.com/wiki/Yoda?key=value',
				'$environment' => WIKIA_ENV_PREVIEW,
				'$expectedResult' => 'https://starwars.preview.fandom.com/wiki/Yoda?key=value',
			],
			[
				'$url' => 'http://starwars.preview.wikia.com/wiki/Yoda?key=value',
				'$environment' => WIKIA_ENV_PREVIEW,
				'$expectedResult' => 'https://starwars.preview.wikia.com/wiki/Yoda?key=value',
			],
			[
				'$url' => 'http://ja.starwars.preview.fandom.com/wiki/Yoda?key=value',
				'$environment' => WIKIA_ENV_PREVIEW,
				'$expectedResult' => 'https://ja.starwars.preview.fandom.com/wiki/Yoda?key=value',
			],
			[
				'$url' => 'http://ja.starwars.preview.wikia.com/wiki/Yoda?key=value',
				'$environment' => WIKIA_ENV_PREVIEW,
				'$expectedResult' => 'http://ja.starwars.preview.wikia.com/wiki/Yoda?key=value',
			],
			[
				'$url' => 'http://starwars.sandbox-s2.fandom.com/wiki/Yoda?key=value' ,
				'$environment' => WIKIA_ENV_SANDBOX,
				'$expectedResult' => 'https://starwars.sandbox-s2.fandom.com/wiki/Yoda?key=value',
			],
			[
				'$url' => 'http://starwars.mockdevname.fandom-dev.com/wiki/Yoda?key=value',
				'$environment' => WIKIA_ENV_DEV,
				'$expectedResult' => 'https://starwars.mockdevname.fandom-dev.com/wiki/Yoda?key=value',
			],
			[
				'$url' => 'http://starwars.mockdevname.wikia-dev.com/wiki/Yoda?key=value',
				'$environment' => WIKIA_ENV_DEV,
				'$expectedResult' => 'https://starwars.mockdevname.wikia-dev.com/wiki/Yoda?key=value',
			],
			[
				'$url' => 'http://ja.starwars.mockdevname.wikia-dev.com/wiki/Yoda?key=value',
				'$environment' => WIKIA_ENV_DEV,
				'$expectedResult' => 'https://ja.starwars.mockdevname.wikia-dev.com/wiki/Yoda?key=value',
			],
		];
	}
}

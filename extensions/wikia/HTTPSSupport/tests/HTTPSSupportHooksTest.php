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

	public function testOnLinkerMakeExternalLink() {

		$exampleString = '';
		$exampleBool = false;
		$exampleArray = [];

		#Should not be upgraded to HTTPS

		#external URL
		$url = 'http://www.example.com';
		$expectedResult = 'http://www.example.com';
		HTTPSSupportHooks::onLinkerMakeExternalLink($url,$exampleString , $exampleBool, $exampleArray);
		$this->assertEquals( $expectedResult, $url );

		#multiple subdomain wikia.com
		$url = 'http://ja.starwars.wikia.com';
		$expectedResult = 'http://ja.starwars.wikia.com';
		HTTPSSupportHooks::onLinkerMakeExternalLink($url,$exampleString , $exampleBool, $exampleArray);
		$this->assertEquals( $expectedResult, $url );


		#Should be upgraded to HTTPS

		#single subdomain wikia.com
		$url = 'http://starwars.wikia.com';
		$expectedResult = 'https://starwars.wikia.com';
		HTTPSSupportHooks::onLinkerMakeExternalLink($url,$exampleString , $exampleBool, $exampleArray);
		$this->assertEquals( $expectedResult, $url );

		#wikia.org
		$url = 'http://starwars.wikia.com';
		$expectedResult = 'https://starwars.wikia.com';
		HTTPSSupportHooks::onLinkerMakeExternalLink($url,$exampleString , $exampleBool, $exampleArray);
		$this->assertEquals( $expectedResult, $url );

		#fandom.com
		$url = 'http://starwars.fandom.com';
		$expectedResult = 'https://starwars.fandom.com';
		HTTPSSupportHooks::onLinkerMakeExternalLink($url,$exampleString , $exampleBool, $exampleArray);
		$this->assertEquals( $expectedResult, $url );

		#verify.fandom.com
		$url = 'http://starwars.verify.fandom.com';
		$expectedResult = 'https://starwars.verify.fandom.com';
		HTTPSSupportHooks::onLinkerMakeExternalLink($url,$exampleString , $exampleBool, $exampleArray);
		$this->assertEquals( $expectedResult, $url );

		#preview.fandom.com
		$url = 'http://starwars.preview.fandom.com';
		$expectedResult = 'https://starwars.preview.fandom.com';
		HTTPSSupportHooks::onLinkerMakeExternalLink($url,$exampleString , $exampleBool, $exampleArray);
		$this->assertEquals( $expectedResult, $url );

		#sandbox-s2.fandom.com
		$url = 'http://starwars.sandbox-s2.fandom.com';
		$expectedResult = 'https://starwars.sandbox-s2.fandom.com';
		HTTPSSupportHooks::onLinkerMakeExternalLink($url,$exampleString , $exampleBool, $exampleArray);
		$this->assertEquals( $expectedResult, $url );

		#fandom-dev.com
		$url = 'http://starwars.devname.fandom-dev.com';
		$expectedResult = 'https://starwars.devname.fandom-dev.com';
		HTTPSSupportHooks::onLinkerMakeExternalLink($url,$exampleString , $exampleBool, $exampleArray);
		$this->assertEquals( $expectedResult, $url );

		#wikia-dev.com
		$url = 'http://starwars.devname.fandom-dev.com';
		$expectedResult = 'https://starwars.devname.fandom-dev.com';
		HTTPSSupportHooks::onLinkerMakeExternalLink($url,$exampleString , $exampleBool, $exampleArray);
		$this->assertEquals( $expectedResult, $url );

	}

}

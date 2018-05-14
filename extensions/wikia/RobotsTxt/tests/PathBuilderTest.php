<?php

use Wikia\RobotsTxt\PathBuilder;

class PathBuilderTest extends WikiaBaseTest {

	public function setUp() {
		global $IP;
		$this->setupFile = "$IP/extensions/wikia/RobotsTxt/RobotsTxt.setup.php";
		parent::setUp();
	}

	/**
	 * Test buildPathsForPage
	 *
	 * @covers PathBuilder::testBuildPathsForPage
	 */
	public function testBuildPathsForPage() {
		$pathBuilder = new PathBuilder();

		$this->assertEquals(
			[
				'/wiki/Test123',
				'/*?*title=Test123',
				'/index.php/Test123',
			],
			$pathBuilder->buildPathsForPage( 'Test123' )
		);

		$this->assertEquals(
			[ '/wiki/Test123' ],
			$pathBuilder->buildPathsForPage( 'Test123', true )
		);
	}

	/**
	 * Test buildPath method
	 *
	 * @covers PathBuilder::buildPath
	 */
	public function testBuildPath() {
		$pathBuilder = new PathBuilder();
		$this->assertEquals(
			'/wiki/Test123',
			$pathBuilder->buildPath( '/wiki/Test123' )
		);
	}

	/**
	 * Test partial URL encoding in testBuildPaths for non-English alphabet and special characters
	 *
	 * @covers PathBuilder::testBuildPaths
	 */
	public function testBuildPathsNonEnglish() {
		$pathBuilder = new PathBuilder();

		$this->assertEquals(
			[ '/wiki/%C4%85%C5%9B%C4%87' ],
			$pathBuilder->buildPathsForPage( 'ąść', true )
		);

		$this->assertEquals(
			[ '/wiki/%E3%82%B5%E3%82%A4%E3%83%88%E3%83%9E%E3%83%83%E3%83%97' ],
			$pathBuilder->buildPathsForPage( 'サイトマップ', true )
		);

		$this->assertEquals(
			[ '/wiki/*/*%5E%25$' ],
			$pathBuilder->buildPathsForPage( '*/*^%$', true )
		);
	}

	/**
	 * Test buildPathsForNamespace
	 *
	 * @covers PathBuilder::buildPathsForNamespace
	 */
	public function testBuildPathsForNamespace() {
		$pathBuilder = new PathBuilder();

		$this->assertEquals(
			[
				'/wiki/File:',
				'/*?*title=File:',
				'/index.php/File:',
			],
			$pathBuilder->buildPathsForNamespace( NS_FILE )
		);

		$this->assertEquals(
			[ '/wiki/File:' ],
			$pathBuilder->buildPathsForNamespace( NS_FILE, true )
		);
	}

	/**
	 * Test buildPathsForNamespace in non-English language
	 *
	 * @covers PathBuilder::buildPathsForNamespace
	 */
	public function testBuildPathsForNamespaceInternational() {
		$this->mockGlobalVariable( 'wgContLang', Language::factory( 'de' ) );
		$pathBuilder = new PathBuilder();

		$this->assertEquals(
			[
				'/wiki/Datei:',
				'/*?*title=Datei:',
				'/index.php/Datei:',
				'/wiki/File:',
				'/*?*title=File:',
				'/index.php/File:',
			],
			$pathBuilder->buildPathsForNamespace( NS_FILE )
		);

		$this->assertEquals(
			[
				'/wiki/Datei:',
				'/wiki/File:',
			],
			$pathBuilder->buildPathsForNamespace( NS_FILE, true )
		);
	}

	/**
	 * Test buildPathsForSpecialPage
	 *
	 * @covers PathBuilder::buildPathsForSpecialPage
	 */
	public function testBuildPathsForSpecialPage() {
		$pathBuilder = new PathBuilder();
		$this->assertEquals(
			[
				'/wiki/Special:Random',
				'/*?*title=Special:Random',
				'/index.php/Special:Random',
				'/wiki/Special:RandomPage',
				'/*?*title=Special:RandomPage',
				'/index.php/Special:RandomPage',
			],
			$pathBuilder->buildPathsForSpecialPage( 'Randompage' )
		);
		$this->assertEquals(
			[
				'/wiki/Special:Random',
				'/wiki/Special:RandomPage',
			],
			$pathBuilder->buildPathsForSpecialPage( 'Randompage', true )
		);

	}

	/**
	 * Test buildPathsForSpecialPage in non-English language
	 *
	 * @covers PathBuilder::buildPathsForSpecialPage
	 */
	public function testAllowSpecialPageInternational() {
		$this->mockGlobalVariable( 'wgContLang', Language::factory( 'de' ) );
		$pathBuilder = new PathBuilder();

		$this->assertEquals( [
			'/wiki/Spezial:Zuf%C3%A4llige_Seite',
			'/*?*title=Spezial:Zuf%C3%A4llige_Seite',
			'/index.php/Spezial:Zuf%C3%A4llige_Seite',
			'/wiki/Spezial:Random',
			'/*?*title=Spezial:Random',
			'/index.php/Spezial:Random',
			'/wiki/Spezial:RandomPage',
			'/*?*title=Spezial:RandomPage',
			'/index.php/Spezial:RandomPage',
			'/wiki/Special:Zuf%C3%A4llige_Seite',
			'/*?*title=Special:Zuf%C3%A4llige_Seite',
			'/index.php/Special:Zuf%C3%A4llige_Seite',
			'/wiki/Special:Random',
			'/*?*title=Special:Random',
			'/index.php/Special:Random',
			'/wiki/Special:RandomPage',
			'/*?*title=Special:RandomPage',
			'/index.php/Special:RandomPage',
		], $pathBuilder->buildPathsForSpecialPage( 'Randompage' ) );

		$this->assertEquals( [
			'/wiki/Spezial:Zuf%C3%A4llige_Seite',
			'/wiki/Spezial:Random',
			'/wiki/Spezial:RandomPage',
			'/wiki/Special:Zuf%C3%A4llige_Seite',
			'/wiki/Special:Random',
			'/wiki/Special:RandomPage',
		], $pathBuilder->buildPathsForSpecialPage( 'Randompage', true ) );
	}

	/**
	 * Test buildPathForParam
	 *
	 * @covers PathBuilder::buildPathsForParam
	 */
	public function testBuildPathForParam() {
		$pathBuilder = new PathBuilder();

		$this->assertEquals( [
			'/*?someparam=',
			'/*?*&someparam=',
		], $pathBuilder->buildPathsForParam( 'someparam' ) );

	}

	/**
	 * Test language path wikis
	 */
	public function testLanguagePathWikis() {
		$this->mockGlobalVariable( 'wgScriptPath', '/de' );
		$this->mockGlobalVariable( 'wgArticlePath', '/de/wiki/$1' );
		$pathBuilder = new PathBuilder();

		$this->assertEquals(
			'/de/wiki/Test123',
			$pathBuilder->buildPath( '/wiki/Test123' )
		);

		$this->assertEquals(
			[ '/de/wiki/Test123' ],
			$pathBuilder->buildPathsForPage( 'Test123', true )
		);

		$this->assertEquals(
			[
				'/de/wiki/Test123',
				'/de/*?*title=Test123',
				'/de/index.php/Test123',
			],
			$pathBuilder->buildPathsForPage( 'Test123' )
		);

		$this->assertEquals(
			[ '/de/wiki/File:' ],
			$pathBuilder->buildPathsForNamespace( NS_FILE, true )
		);

		$this->assertEquals(
			[
				'/de/wiki/Special:Random',
				'/de/*?*title=Special:Random',
				'/de/index.php/Special:Random',
				'/de/wiki/Special:RandomPage',
				'/de/*?*title=Special:RandomPage',
				'/de/index.php/Special:RandomPage',
			],
			$pathBuilder->buildPathsForSpecialPage( 'Randompage' )
		);

		$this->assertEquals( [
			'/de/*?someparam=',
			'/de/*?*&someparam=',
		], $pathBuilder->buildPathsForParam( 'someparam' ) );
	}
}

<?php

use Wikia\RobotsTxt\PathBuilder;

class PathBuilderTest extends WikiaBaseTest {

	public function setUp() {
		global $IP;
		$this->setupFile = "$IP/extensions/wikia/RobotsTxt/RobotsTxt.setup.php";
		parent::setUp();
	}

	/**
	 * Test testBuildPaths
	 *
	 * @covers PathBuilder::testBuildPaths
	 */
	public function testBuildPaths() {
		$pathBuilder = new PathBuilder();

		$this->assertEquals(
			[
				'/wiki/Test123',
				'/*?*title=Test123',
				'/index.php/Test123',
			],
			$pathBuilder->buildPaths( 'Test123' )
		);

		$this->assertEquals(
			[ '/wiki/Test123' ],
			$pathBuilder->buildPaths( 'Test123', true )
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
			$pathBuilder->buildPaths( 'ąść', true )
		);

		$this->assertEquals(
			[ '/wiki/%E3%82%B5%E3%82%A4%E3%83%88%E3%83%9E%E3%83%83%E3%83%97' ],
			$pathBuilder->buildPaths( 'サイトマップ', true )
		);

		$this->assertEquals(
			[ '/wiki/*/*%5E%25$' ],
			$pathBuilder->buildPaths( '*/*^%$', true )
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
}

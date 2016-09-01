<?php

/**
 * @group Maintenance
 */
class RemoveImapTagsTests extends WikiaBaseTest {

	public function setUp() {
		$this->setupFile = __DIR__ . '/../WikiaMaps/removeImapTags.php';
		parent::setUp();
	}

	public function testHasImapTag() {
		$testCases = [
			[
				pageContent => "<imap map-id=\"1\"></imap>",
				expectedResult => true,
				mapId => 1
			],
			[
				pageContent => "<imap blah=\"blah\" map-id=\"2\" ></imap>",
				expectedResult => true,
				mapId => 2
			],
			[
				pageContent => "<imap map-id='3'/>",
				expectedResult => true,
				mapId => 3
			],
			[
				pageContent => "<imap map-id=\"4\"/>",
				expectedResult => true,
				mapId => 4
			],
			[
				pageContent => "<imap map-id='5' />",
				expectedResult => true,
				mapId => 5
			],
			[
				pageContent => "<imap map-id='6' blah='blah' />",
				expectedResult => true,
				mapId => 6
			],
			[
				pageContent => "<imap blah='blah' map-id='7' />",
				expectedResult => true,
				mapId => 7
			],
			[
				pageContent => "<imap map-id='8'>",
				expectedResult => false
			],
			[
				pageContent => "<imap map-id=\"9\" >",
				expectedResult => false
			],
			[
				pageContent => "<imap map-id=\"10\" ></imap >",
				expectedResult => false
			],
			[
				pageContent => "<imap map-id=\"11\" ></ imap> ",
				expectedResult => false
			],
			[
				pageContent => "<imap map-id=\"12\" ><imap> ",
				expectedResult => false
			],
			[
				pageContent => "<imap map-id=\"13\"><imap>",
				expectedResult => false
			],
			[
				pageContent => "<imap id=\"14\"></imap>",
				expectedResult => false
			],
			[
				pageContent => "<imap></imap>",
				expectedResult => false
			],
		];

		foreach( $testCases as $testCase ) {
			$this->newArcicleMock( $testCase[ 'pageContent' ]);

			$removeImapTags = new RemoveImapTags();

			$foundTags = [];
			$foundTagsMapIds = [];
			$actualResult = $removeImapTags->hasImapTag( $dummyArticleId, $foundTags, $foundTagsMapIds );

			if ($testCase['expectedResult']) {
				$this->assertEquals( $testCase['pageContent'], $foundTags[0] );
				$this->assertEquals( $testCase['mapId'], $foundTagsMapIds[0] );
				$this->assertTrue( $actualResult );
			} else {
				$this->assertFalse( $actualResult );
			}

		}

	}

	public function testHasImapTags() {
		$this->newArcicleMock(
			"<imap map-id=\"1\"></imap> This map is valid\n" .
			"<imap> This map is invalid\n" .
			"<h1>Article Content</h1>\n" .
			"<imap map-id='2'></imap> This map is valid"
		);

		$removeImapTags = new RemoveImapTags();

		$foundTags = [];
		$foundTagsMapIds = [];
		$actualResult = $removeImapTags->hasImapTag( $dummyArticleId, $foundTags, $foundTagsMapIds );

		$this->assertEquals( ["<imap map-id=\"1\"></imap>", "<imap map-id='2'></imap>"], $foundTags );
		$this->assertEquals( [1, 2], $foundTagsMapIds );
		$this->assertTrue( $actualResult );
	}

	private function newArcicleMock( $articleContent ) {
		$articleMock = $this->getMock( 'Article', ['getID', 'getContent'], [], '', false );
		$articleMock->expects( $this->any() )
			->method( 'getContent' )
			->will( $this->returnValue( $articleContent ) );
		$articleMock->expects( $this->any() )
			->method( 'getID' )
			->will( $this->returnValue( 42 ) );

		$this->getStaticMethodMock( 'Article', 'newFromID' )
			->expects( $this->any() )
			->method( 'newFromID' )
			->will( $this->returnValue( $articleMock ) );
	}

}

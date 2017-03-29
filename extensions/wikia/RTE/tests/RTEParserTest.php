<?php
use PHPUnit\Framework\TestCase;

class RTEParserTest extends TestCase {
	/**
	 * @dataProvider contextSensitiveEdgeCasesDataProvider
	 * @param string $wikiText
	 * @param bool $shouldContainEdgeCases
	 */
	public function testContextSensitiveEdgeCases( $wikiText, $shouldContainEdgeCases ) {
		RTE::$edgeCases = [];
		$parser = new RTEParser();
		$title = Title::makeTitle( NS_MAIN, 'TEST' );
		$opts = new ParserOptions();

		$parser->parse( $wikiText, $title, $opts );

		$hasActualEdgeCase = RTE::edgeCasesFound();
		$actualEdgeCaseType = RTE::getEdgeCaseType();

		if ( $shouldContainEdgeCases ) {
			$expectedEdgeCaseType = strtolower( RTE::CONTEXT_SENSITIVE_TOKEN_FOLLOWING_HTML_TAG );
			$this->assertTrue($hasActualEdgeCase, 'Input contains an edge case that should have been found.' );
			$this->assertEquals( $expectedEdgeCaseType, $actualEdgeCaseType, 'Edge case was registered as incorrect type.' );
		} else {
			$this->assertFalse( $hasActualEdgeCase, 'Input does not contain edge case but bogus one was found.' );
		}
	}

	public function contextSensitiveEdgeCasesDataProvider(): array {
		$path =__DIR__ . '/sources';
		$dir = new DirectoryIterator( $path );
		$sources = new CallbackFilterIterator( $dir, function ( $fileName ) {
			return strpos( $fileName, 'RTEParserTest_contextSensitiveEdgeCases_' ) === 0;
		} );
		$data = [];

		foreach ( $sources as $sourceFile ) {
			$data[] = [
				file_get_contents( "$path/$sourceFile" ),
				strpos( $sourceFile, 'hasEdgeCase' ) !== false
			];
		}

		return $data;
	}
}
